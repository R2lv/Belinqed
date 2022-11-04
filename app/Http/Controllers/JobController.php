<?php

namespace App\Http\Controllers;

use App\Company;
use App\CompanyAlert;
use App\Job;
use App\JobSoftware;
use App\Match;
use App\Resume;
use App\ResumeSoftware;
use App\SoftwareKnowledge;
use App\UserAlert;
use App\WorkingPlace;
use Carbon\Carbon;
use App\User;
use Symfony\Component\Process\Process;
use function Aws\map;
use function foo\func;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class JobController extends Controller
{
	public function __construct() {
		$this->middleware("auth:company", ['except'=> ['showMatch']]);
	}

	public function copyJob($id) {
	    $company = auth('company')->user()->company;
	    $job = $company->jobs()->find($id);
	    if(!$job) {
	        return $this->failure("Job not found");
        }

        $newJob = new Job($job->toArray());

	    $newJob->draft = 1;


	    $competencies = $this->copy($job->job_competencies);
	    $languages = $this->copy($job->job_languages);
	    $driver_licenses = $this->copy($job->job_driver_licenses);
	    $employment_types = $this->copy($job->job_employment_types); // sync

        $software_knowledge = [];

        foreach($job->software_knowledge as $soft) {
            $software_knowledge[] = new JobSoftware($soft->toArray());
        }


        $newJob->save();
        $newJob->job_competencies()->sync($competencies);
        $newJob->job_languages()->sync($languages);
        $newJob->job_driver_licenses()->sync($driver_licenses);
        $newJob->job_employment_types()->sync($employment_types);
        $newJob->software_knowledge()->saveMany($software_knowledge);

        $newJob->load('job_title','job_sector','job_hours','job_salary','available_from','job_employment_types','job_career_level','matches.user','company','job_competencies', 'software_knowledge.software', 'software_knowledge.knowledge', 'job_languages', 'job_driver_licenses','education_field','education_level');

        return $this->success($newJob);

    }

    private function copy($data) {
	    $arr = [];
	    foreach($data as $item) {
	        $arr[$item->id] = $item->pivot->toArray();
	        unset($arr[$item->id]["job_id"]);
        }

	    return $arr;
    }

	public function store(Request $request) {
		$data = $request->only('job_title_id','job_sector_id','job_career_level_id','job_hour_id','job_description','education_level_id','education_field_id',
            'education_start_date','education_end_date','education_graduated',
			'job_location','job_location_lat','job_location_lng','minimum_experience','job_salary_id','available_from_id');

		$decodedData = $request->only('software_knowledge', 'competencies', 'languages', 'driver_licenses', 'employment_types');


		$validator = $this->validator($data);
		if(!$validator->passes()) {
			return $this->failure($validator->errors());
		}

		$job = new Job($data);
		/**
		 * @var Company $company
		 */
		$company = auth('company')->user()->company;
		$company->jobs()->save($job);


		/* sync competencies */
		$competencies = $this->transformToSync($decodedData["competencies"], "id", "level");
//		dd($competencies);
		$job->job_competencies()->sync($competencies);

		/* sync driver licenses */
		$job->job_driver_licenses()->sync(array_values($decodedData['driver_licenses']));

		/* sync employment types */
		$job->job_employment_types()->sync(array_slice(array_values($decodedData["employment_types"]),0,3));

		/* sync languages */
		$languages = $this->transformToSync($decodedData["languages"], "id", "level_speaking", "level_writing");
		$job->job_languages()->sync($languages);

		/* sync software */
		$software_knowledge = $this->getSoftwareKnowledgeList($decodedData["software_knowledge"]);
//		dd($software_knowledge);
		$job->software_knowledge()->delete();
		$job->software_knowledge()->saveMany($software_knowledge);

		/*
		$matches = $this->findMatches($job);
		$matches_length = count($matches);



		$company->alerts()->save($companyAlert);
		*/
		return $this->success("Job added successfully");
	}


	public function update(Request $request, $id) {

	    /* @var Job $job */
	    $job = auth('company')->user()->company->jobs->where("draft",1)->find($id);
	    if(!$job) {
	        return $this->failure('Job not found');
        }

		$data = $request->only('job_title_id','job_sector_id','job_career_level_id','job_hour_id','job_description','education_level_id','education_field_id',
			'job_location','job_location_lat','job_location_lng','minimum_experience','job_salary_id','available_from_id');

		$decodedData = $request->only('software_knowledge', 'competencies', 'languages', 'driver_licenses', 'employment_types');


		$validator = $this->validator($data);
		if(!$validator->passes()) {
			return $this->failure($validator->errors());
		}

		$job->update($data);


		/* sync competencies */
		$competencies = $this->transformToSync($decodedData["competencies"], "id", "level");
//		dd($competencies);
		$job->job_competencies()->sync($competencies);

		/* sync driver licenses */
		$job->job_driver_licenses()->sync(array_values($decodedData['driver_licenses']));

		/* sync employment types */
		$job->job_employment_types()->sync(array_slice(array_values($decodedData["employment_types"]),0,3));

		/* sync languages */
		$languages = $this->transformToSync($decodedData["languages"], "id", "level_speaking", "level_writing");
		$job->job_languages()->sync($languages);

		/* sync software */
		$software_knowledge = $this->getSoftwareKnowledgeList($decodedData["software_knowledge"]);
//		dd($software_knowledge);
		$job->software_knowledge()->delete();
		$job->software_knowledge()->saveMany($software_knowledge);

		/*
		$matches = $this->findMatches($job);
		$matches_length = count($matches);

		$companyAlert = new CompanyAlert([
			'title'=>"Job Matches",
			'text'=>"Your job {$job->job_position} has {$matches_length} matches",
			'type'=>'job_matches',
			'url'=>"/job/{$job->id}"
		]);

		$company->alerts()->save($companyAlert);
		*/
		return $this->success("Job edited successfully");
	}

	public function show($id) {
		$job = Job::query()->with('job_title','job_sector','job_hours','job_salary','available_from','job_employment_types','job_career_level','matches.user','company','job_competencies', 'software_knowledge.software', 'software_knowledge.knowledge', 'job_languages', 'job_driver_licenses','education_field','education_level')->find($id);

		$company_user = auth('company')->user();
		if($company_user) {
			$company_id = $company_user->company->id;
			if($job->company_id == $company_id) {
				return $this->success($job);
			}
		}

		$job_arr = $job->toArray();
		$job_arr["matches"] = false;

		$user = auth()->user();

		$alert = new CompanyAlert([
			'title_en'=>"Job View",
			'title_ka'=>"წაიკითხა",
			'text_en'=>auth()->user()->name." ".auth()->user()->surname,
			'text_ka'=>auth()->user()->name." ".auth()->user()->surname,
			'user_id'=>$user->id,
			'job_id' => $job->id,
			'url'=>'/resume/'.$user->resume->id."/".$job->id
		]);

		$job->company->alerts()->save($alert);

		return $this->success($job_arr);
	}

	public function startMatching($id) {
        /* @var Job $job */
        $company = auth('company')->user()->company;
        $job = $company->jobs->where("draft",1)->find($id);
        if(!$job) {
            return $this->failure(['text'=>"Job not found"]);
        }

        $package = $company->package;

        if($package && $package->vacancies > 0) {


            $job->update([
                'draft' => 0,
                'expiration_date'=> Carbon::now()->addDays($package->days_active),
                'matching_active' => 1
            ]);


            $matches = $this->findMatches($job);
            $matches_length = count($matches);

            $companyAlert = new CompanyAlert([
                'title_en' => "Job Matches",
                'title_ka' => "დამთხვევა",
                'text_en' => "Your job {$job->job_position} has {$matches_length} matches",
                'text_ka' => "სამსახურს {$job->job_position} აქვს {$matches_length} დამთხვევა",
                'type' => 'job_matches',
                'job_id' => $job->id,
                'url' => "/job/{$job->id}"
            ]);




            $job->company->alerts()->save($companyAlert);

            $package->update(['vacancies'=>$package->vacancies-1]);

            return $this->success("Matching started successfully, you have left {$package->vacancies} vacancies");
        }

        return $this->failure(['text'=>"You have 0 vacancies. please buy a package",'buy_package'=>true]);
    }

	public function showMatch($id) {
		$user = auth()->user();
		$resume = $user->resume;

		$match = Match::query()
			->where("resume_id", $resume->id)
			->where("job_id", $id)
			->with('job.job_title','job.job_sector','job.job_hours','job.job_salary','job.company','job.job_competencies', 'job.software_knowledge.software', 'job.software_knowledge.knowledge', 'job.job_languages', 'job.job_driver_licenses','job.education_field','job.education_level','job.available_from','job.job_career_level','job.job_employment_types')
			->get();

		if(!$match->count()) return $this->failure("Match not found");

		$match = $match[0];

		$match->update(['viewed'=>1]);

		$alert = new CompanyAlert([
			'title_en'=>"Job View",
			'title_ka'=>"წაიკითხა",
			'text_en'=>auth()->user()->name." ".auth()->user()->surname,
			'text_ka'=>auth()->user()->name." ".auth()->user()->surname,
			'user_id'=>$user->id,
            'job_id' => $id,
			'url'=>'/resume/'.$user->resume->id."/".$id
		]);

		$match->job->company->alerts()->save($alert);

		return $this->success($match);
	}

	/**
	 * @var Job $job
	 * @return Collection
	 */
	public function findMatches($job) {
	    if(! ($job instanceof Job)) {
			$job = Job::query()->with('job_salary')->find($job);
		}


        /* required info to control company is capable of charge*/
        $company = auth('company')->user()->company;
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



		$places = array_unique(array_map(function($wp) {
			return $wp["resume_id"];
		},$places));


//		$software_ids = array_map(function($c){return $c["software_id"];},$job->software_knowledge->toArray());
		$software_knowledge = array_map(function($c){return ["software_id"=>$c["software_id"], "knowledge_level_id"=>$c["knowledge_level_id"]];},$job->software_knowledge->toArray());
		$employment_type_ids = array_map(function($c){return $c["id"];},$job->job_employment_types->toArray());
		$driver_license_ids = array_map(function($c){return $c["id"];},$job->job_driver_licenses->toArray());

		$resumes = Resume::query()
			->with('education','employment_types','job_titles','job_sectors','job_hours','software_knowledge','languages','user')
			->whereIn("id", $places)
			->where("looking_for_job",1);
		if(setting('matching.job_salary')) {
            $resumes->whereHas("job_salary", function ($query) use ($job) {
                $query->where('min', '<', $job->job_salary->max);
            });
        }


		if (setting('matching.education')) {

            $resumes->whereHas("education", function(Builder $query) use ($job) {
                $query->where("education_field_id", $job->education_field_id);
                if (setting('matching.education_level')) {
                    $query->where("education_level_id", '>=', $job->education_level_id);
                }
            });

        }
		if (setting('matching.job_sector')) {
            $resumes->whereHas("job_sectors", function (Builder $query) use($job) {
                $query->where("job_sectors.id", $job->job_sector_id);
            });


        }


		if (setting('matching.job_title')) {

            $resumes->whereHas("job_titles", function (Builder $query) use($job) {
                $query->where("job_titles.id", $job->job_title_id);
            });

        }

		if (setting('matching.work_experience')) {
            $resumes->where("work_experience", ">=", $job->minimum_experience);
        }


		if (setting('matching.job_hours')) {
            $resumes->whereHas("job_hours", function (Builder $query) use($job) {
                $query->where("job_hours.id", $job->job_hour_id);
            });

        }


		if (setting('matching.employment_types')) {

            $resumes->whereHas("employment_types", function (Builder $query) use($job,$employment_type_ids) {
                $query->whereIn("employment_types.id", $employment_type_ids);
            });

        }

        if (setting('matching.available_from')) {
            $resumes->where("available_from_id", $job->available_from_id);

        }

        if (setting('matching.software_knowledge')) {
            if (setting('matching.software_knowledge_level')) {
                $resumes->where(function($query) use ($software_knowledge) {
                    foreach ($software_knowledge as $sk) {
                        $query->whereHas(function($q) use ($sk){
                            $q->where('resume_software.knowledge_level_id', $sk['knowledge_level_id'])
                                ->where('resume_software.softwere_id',$sk['software_id']);
                        });
                    }
                });

            } else {
                $resumes->whereHas("software_knowledge", function (Builder $query) use ($job, $software_knowledge) {
                    $query->whereIn("resume_software.software_id", array_map(function ($res) {
                        return $res['software_id'];
                    }, $software_knowledge));
                });
            }
        }

        if (setting('matching.language')) {
            $resumes->whereHas("languages", function (Builder $query) use($job) {

                $query->where(function(Builder $query) use($job) {
                    foreach($job->job_languages as $lang) {
                        $query->orWhere(function(Builder $q) use($lang) {
                            $q->where("languages.id", $lang->id);

                            if (setting('matching.language_speaking_level')) {
                                $q->where("resume_languages.level_speaking", ">=", $lang->pivot->level_speaking);

                            }

                            if (setting('matching.language_writing_level')) {
                                $q->where("resume_languages.level_writing", ">=", $lang->pivot->level_writing);
                            }

                        });
                    }
                });

            });
        }

        if (setting('matching.driver_license')) {
            $resumes->whereHas("driver_licenses", function (Builder $query) use($job,$driver_license_ids) {
                $query->whereIn("driver_licenses.id", $driver_license_ids);
            });

        }









/*

		foreach($job->job_languages as $lang) {
			$resumes->whereHas("languages", function(Builder $query) use($job, $lang) {
					$query->where("languages.id", $lang->id)
					->where("resume_languages.level_speaking", ">=",$lang->pivot->level_speaking)
					->where("resume_languages.level_writing", ">=",$lang->pivot->level_writing);
			});
		}*/


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




        }

        $ids = array_map(function ($resume) {
            return $resume["id"];
        }, $resumes);
        $job->matches()->sync($ids);


        // if job matches passed the limits of the package, stop next matching attempts
        if (count($job->matches) >= $package->candidates){
            $job->matching_active = 0;
            $job->save();
        }

        return $job->matches;
	}

	private function getSoftwareKnowledgeList(array $arr) {
		$result = [];
		foreach($arr as $value) {
			$result[] = new JobSoftware([
				'software_id'=>$value["software_id"],
				'knowledge_level_id'=>$value["knowledge_level_id"],
				'graduated'=>$value["graduated"]
			]);
		}

		return $result;
	}

	private function getDecodedValuesFromRequest(Request $request, ...$list) {
		$result = [];
		foreach($list as $item) {
			var_dump($request->get($item));
			$result[$item] = json_decode($request->get($item), true);
		}

		return $result;
	}

	private function transformToSync(array $arr, $id="id", ...$pivots) {
		$result = [];
		foreach($arr as $value) {
			$r = [];
			foreach($pivots as $pivot) {
				$r[$pivot] = $value["pivot"][$pivot];
			}
			$result[$value[$id]] = $r;
		}

		return $result;
	}

	public function validator($data) {
		return \Validator::make($data, [
			'job_title_id'=>'required|numeric|exists:job_titles,id',
			'job_sector_id'=>'required|numeric|exists:job_sectors,id',
			'job_career_level_id'=>'required|numeric|exists:career_levels,id',
			'job_hour_id'=>'required|numeric|exists:job_hours,id',
			'job_description'=>'required',
			'education_level_id'=>'required|numeric|exists:education_levels,id',
			'education_field_id'=>'required|numeric|exists:education_fields,id',
			'job_location'=>'required',
			'job_location_lat'=>'required|numeric',
			'job_location_lng'=>'required|numeric',
			'minimum_experience'=>'required|numeric',
			'job_salary_id'=>'required|numeric|exists:job_salaries,id'
		]);
	}
}
