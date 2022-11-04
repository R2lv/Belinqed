<?php

namespace App\Jobs;

use App\Job;
use App\Resume;
use App\User;
use App\UserAlert;
use App\WorkingPlace;
use Illuminate\Bus\Queueable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Log;

class ProcessNewMatching implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $newJob;

    public function __construct(Job $newJob)
    {
        $this->newJob = $newJob;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {

        // we are storing the jobs which should be matched to the database and are calling them here to add new matches

        \Log::info('New matching attempt of the job id '.$this->newJob->id);


        $job = Job::query()->with('job_salary')->find($this->newJob->id);


        $matchedIds = [];
        if ($job->matches()){
            foreach ($job->matches as $match) {
                $matchedIds[$match->id] = $match->id;
            }
        }

        /* required info to control company is capable of charge*/
        $company = $this->newJob->company;
        $package = $company->package;



        $places = WorkingPlace::query()->selectRaw("resume_id, (
			6371 * acos (
			cos ( radians({$job->job_location_lat}) )
			* cos( radians( working_places.lat ) )
			* cos( radians( lng ) - radians({$job->job_location_lng}) )
			+ sin ( radians({$job->job_location_lat}) )
			* sin( radians( lat ) )
			)
		  ) AS distance, radius"
        )
            ->having("radius",  ">=", "distance")->orderBy("distance","ASC")->get()->toArray();

        foreach ($places as $key => $val){
            if (key_exists($val["resume_id"],$matchedIds)){
                unset($places[$key]);
            }
        }
        $places = array_unique(array_map(function($wp) {
            return $wp["resume_id"];
        },$places));



        $software_ids = array_map(function($c){return $c["software_id"];},$job->software_knowledge->toArray());
        $employment_type_ids = array_map(function($c){return $c["id"];},$job->job_employment_types->toArray());
        $driver_license_ids = array_map(function($c){return $c["id"];},$job->job_driver_licenses->toArray());

        $resumes = Resume::query()
            ->with(['education','employment_types','job_titles','job_sectors','job_hours','software_knowledge','languages','job_salary'])

            ->whereIn("id", $places)
            ->where("looking_for_job",1)
            ->whereHas("job_salary",function($query) use ($job){
                $query->where('min','<',$job->job_salary->max);
            })
            ->whereHas("education", function(Builder $query) use ($job) {
                $query->where("education_field_id", $job->education_field_id)
                    ->where("education_level_id", '>=', $job->education_level_id);
            })
            ->whereHas("job_sectors", function (Builder $query) use($job) {
                $query->where("job_sectors.id", $job->job_sector_id);
            })
            ->whereHas("job_titles", function (Builder $query) use($job) {
                $query->where("job_titles.id", $job->job_title_id);
            })
            ->where("work_experience", ">=", $job->minimum_experience)
            ->whereHas("job_hours", function (Builder $query) use($job) {
                $query->where("job_hours.id", $job->job_hour_id);
            })
            ->whereHas("employment_types", function (Builder $query) use($job,$employment_type_ids) {
                $query->whereIn("employment_types.id", $employment_type_ids);
            })
            ->where("available_from_id", $job->available_from_id)

            ->whereHas("software_knowledge", function (Builder $query) use($job,$software_ids) {
                $query->whereIn("resume_software.software_id", $software_ids);
            })
            ->whereHas("languages", function (Builder $query) use($job,$software_ids) {

                $query->where(function(Builder $query) use($job) {
                    foreach($job->job_languages as $lang) {
                        $query->orWhere(function(Builder $q) use($lang) {
                            $q->where("languages.id", $lang->id)
                                ->where("resume_languages.level_speaking", ">=", $lang->pivot->level_speaking)
                                ->where("resume_languages.level_writing", ">=", $lang->pivot->level_writing);
                        });
                    }
                });

            })
            ->whereHas("driver_licenses", function (Builder $query) use($job,$driver_license_ids) {
                $query->whereIn("driver_licenses.id", $driver_license_ids);
            });


        $resumes_count = $resumes->get()->count();

        $resumes = $resumes->get()->toArray();
        if($package->candidates - $resumes_count < 0) {
            $resumes = array_splice($resumes, $package->candidates);


            foreach ($resumes as $resume) {

                $user = User::query()->with('alerts')->where('id',$resume['user_id'])->first();

                $userAlert = new UserAlert([
                    'title_en' => "Job Matches",
                    'title_ka' => "დამთხვევა",
                    'text_en' => "Your resume has one new matche",
                    'text_ka' => "თქვენს რეზიუმეს აქვს ერთი ახალი დამთხვევა",
                    'user_id' => $resume['user_id'],
                    'job_id' => $job->id,
                    'company_id' => $company->id,
                    'url' => "/job/{$job->id}/public"
                ]);

                $user->alerts()->save($userAlert);

            }




            $ids = array_map(function ($resume) {
                return $resume["id"];
            }, $resumes);
            $job->matches()->sync($ids);

        }



        // if job matches passed the limits of the package, stop next matching attempts
        if (count($job->matches) >= $package->candidates){
            $job->matching_active = 0;
            $job->save();
        }


        $matches_length = count($job->matches);

        $companyAlert = new CompanyAlert([
            'title_en' => "Job Matches",
            'title_ka' => "დამთხვევა",
            'text_en' => "Your job {$job->job_position} has {$matches_length} matches",
            'text_ka' => "სამსახურს {$job->job_position} აქვს {$matches_length} დამთხვევა",
            'type' => 'job_matches',
            'job_id' => $job->id,
            'url' => "/job/{$job->id}"
        ]);


    }
}
