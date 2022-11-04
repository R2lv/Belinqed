<?php

namespace App\Http\Controllers;

use App\AvailableFromTime;
use App\CareerLevel;
use App\Competency;
use App\DriverLicense;
use App\EducationField;
use App\EducationLevel;
use App\EducationType;
use App\EmploymentHistory;
use App\EmploymentType;
use App\JobHour;
use App\JobSalary;
use App\JobSector;
use App\JobTitle;
use App\KnowledgeLevel;
use App\Language;
use App\Match;
use App\ResumeDocument;
use App\ResumeEducation;
use App\ResumeSoftware;
use App\Software;
use App\SoftwareKnowledge;
use App\User;
use App\UserAlert;
use App\WorkingPlace;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Validator;
use App\Resume;


class ResumeController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth',['except'=>['show','getResumeData']]);
    }

    public function index() {
    	/**
    	 * @var User $user
		 */
    	$user = auth()->user();

    	$resume = Resume::query()->with('job_salary','career_level','current_career_level','available_from','current_job', 'current_job_sector','job_titles', 'job_sectors', 'job_hours', 'languages', 'software_knowledge.software', 'software_knowledge.knowledge', 'employment_types', 'current_employment_types', 'driver_licenses', 'competencies', 'documents', 'working_places', 'employment_history.job_sector','employment_history.job_title','education.education_level','education.education_field')->where("user_id", $user->id)->first();

//    	dd($resume);
    	return $this->success($resume);
	}

	public function show($resume_id, $job_id) {

    	$match = Match::query()
			->where("resume_id", $resume_id)
			->where("job_id", $job_id)
			->with('job.job_title','resume.job_salary','resume.career_level','resume.current_career_level','resume.available_from','resume.current_job', 'resume.current_job_sector','resume.job_titles', 'resume.job_sectors', 'resume.job_hours', 'resume.languages', 'resume.software_knowledge.software', 'resume.software_knowledge.knowledge', 'resume.employment_types', 'resume.current_employment_types', 'resume.driver_licenses', 'resume.competencies', 'resume.documents', 'resume.working_places', 'resume.employment_history.job_sector','resume.employment_history.job_title','resume.education.education_level','resume.education.education_field','resume.user')
			->get();

        if(!$match->count()) return $this->failure("Match not found");
    	$match = $match[0];

    	$company_user = auth('company')->user();
    	if($company_user) {
    		$company = $company_user->company;
    		$alert = new UserAlert([
    			'company_id'=>$company->id,
				'title_en'=>"Resume View",
				'title_ka'=>"წაკითხვა",
				'job_id'=>$job_id,
				'text_en'=>$company->company_name,
				'text_ka'=>$company->company_name
			]);


            $match->resume->user->alerts()->save($alert);
            $match->resume->user()->update(['profile_viewed'=> $match->resume->user->profile_viewed + 1]);

		}

    	return $this->success($match);
	}


	public function matches() {
    	return $this->success(auth()->user()->resume->matches()->with('job_title','company')->orderBy('id','DESC')->get());
	}

    protected function validator(array $data)
    {
        return Validator::make($data, [
//            'about'=>"required",
            'looking_for_job'=>'required|in:0,1',
            'job_salary_id'=>'required_if:looking_for_job,1|exists:job_salaries,id',
            'work_experience'=>'required_if:looking_for_job,1|numeric',
            'career_level_id'=>'required_if:looking_for_job,1|exists:career_levels,id',
//            'characteristics'=>'required',
//            'hobbies'=>'required',
            'competencies'=>'required|json',
            'competencies.*.id'=>'required|exists:competencies|id',
            'competencies.*.pivot.level'=>'required|numeric',
//            'driver_licenses'=>'array',
//            'driver.licenses.*'=>'numeric',
//            'job_hours'=>'required_if:looking_for_job,1|array',
//            'job_hours.*'=>'exists:job_hours,id',
//            'employment_types'=>'required_if:looking_for_job,1|array',
//            'employment_types.*'=>'exists:employment_types,id'
        ]);
    }

    protected function create(array $data)
    {
        $user = auth()->user();
        return Resume::query()->create([
            'user_id' => $user->id,
            'name' => $user->name,
            'surname' => $user->surname,
            'email' => $user->email,
            'city_id' => $user->city_id,
            'mobile_number' => $user->mobile_number,
            'pcid' => $user->pcid,
            'gender'=> $user->gender,
            'birthday'=> $user->birthday,
            'material_status'=> $data['material_status'],
            'address_1'=> $data['address_1'],
            'address_2'=> $data['address_2'],
            'profession_id' => $data['profession_id'],
            'driving_license'=> $data['driving_license'],
            'personal_qualities_en'=> $data['personal_qualities_en'],
            'personal_qualities_ka'=> $data['personal_qualities_ka'],
            'info_letter_en'=> $data['info_letter_en'],
            'info_letter_ka'=> $data['info_letter_ka'],
            'pdf'=> $data['pdf'],
            'video'=> $data['video']
        ]);
    }

    public function update(Request $request) {

		$validator = $this->validator($request->all());
		if($validator->fails()){
			return $this->failure($validator->errors());
		}

		/* @var $resume Resume */
		$resume = auth()->user()->resume;

		$firstData = $request->only('about','hobbies','characteristics','current_employer','current_job_title_id','current_sector_id','current_career_level_id','career_level_id','available_from_id',
			'looking_for_job','job_salary_id','work_experience');

		$resume->update($firstData);

		$secondData = $this->getDecodedValuesFromRequest($request, 'competencies', 'driver_licenses', 'languages', 'employment_types', 'current_employment_types', 'job_hours', 'job_sectors', 'job_titles',
			'software_knowledge', 'working_places', 'employment_history', 'education', 'delete_doc_ids');

		/* sync competencies */
		$competencies = $this->transformToSync($secondData["competencies"], "id", "level");
		$resume->competencies()->sync($competencies);

		/* sync driver licenses */
		$resume->driver_licenses()->sync(array_values($secondData['driver_licenses']));

		/* sync languages */
		$languages = $this->transformToSync($secondData["languages"], "id", "level_speaking", "level_writing");
		$resume->languages()->sync($languages);

		/* looking for job details */
		if(!!$request->get("looking_for_job")) {
			$resume->job_titles()->sync(array_slice(array_values($secondData["job_titles"]),0,3));
			$resume->job_sectors()->sync(array_slice(array_values($secondData["job_sectors"]),0,3));
			$resume->job_hours()->sync(array_slice(array_values($secondData["job_hours"]),0,3));
			$resume->employment_types()->sync(array_slice(array_values($secondData["employment_types"]),0,3));
			$resume->current_employment_types()->sync(array_slice(array_values($secondData["current_employment_types"]),0,3));
		} else {
			$resume->job_titles()->sync([]);
			$resume->job_sectors()->sync([]);
			$resume->job_hours()->sync([]);
			$resume->employment_types()->sync([]);
			$resume->current_employment_types()->sync([]);
		}


		/* sync software */
		$software_knowledge = $this->getSoftwareKnowledgeList($secondData["software_knowledge"]);
//		dd($software_knowledge);
		$resume->software_knowledge()->delete();
		$resume->software_knowledge()->saveMany($software_knowledge);

		/* employment history details */
		$employment_history = $this->getEmploymentHistoryList($secondData["employment_history"]);
		$resume->employment_history()->delete();
		$resume->employment_history()->saveMany($employment_history);


		/* education details */
		$educations = $this->getEducationList($secondData["education"]);
		$resume->education()->delete();
		$resume->education()->saveMany($educations);

		/* sync my docs */

        /*
		if($request->hasFile("documents")) {
			$docs = $this->saveMyDocs($request->file("documents"), $request->get("document_names"));
			$resume->documents()->saveMany($docs);
		}
		*/

        /*
		if(is_array($secondData['delete_doc_ids'])) {
			$docs = $resume->documents()->whereIn("id", $secondData['delete_doc_ids']);
			$this->deleteDocs($docs->get());
		}
        */

		if($request->hasFile("video")) {
			$filename = $this->saveVideo($request->file("video"), $resume->user_id);
			$resume->update(['video_url'=>$filename]);
		}

		/* working places */
		$working_places = $this->getWorkingPlacesList($secondData["working_places"]);
		$resume->working_places()->delete();
		$resume->working_places()->saveMany($working_places);

		return $this->success(trans('defaults.operations.success'));
    }

    public function saveDoc(Request $request) {
        $file = $request->file("file");
        $filename = time()."_".auth()->user()->id.".".$file->getClientOriginalExtension();
        $type = $file->getClientOriginalExtension();
        $file->move(\Storage::disk('public')->path("/docs"),$filename);

        $doc = new ResumeDocument([
            'url'=>$filename,
            'name'=>$file->getClientOriginalName(),
            'type'=>$type
        ]);

        $resume = auth()->user()->resume;
        $resume->documents()->save($doc);

		return $this->success($doc);
	}

	public function deleteDoc($doc_id) {
        $doc = auth()->user()->resume->documents()->find($doc_id);
        if($doc) {
            $filename = $doc->url;
            \Storage::disk('public')->delete('/docs/' . $filename);
            $doc->delete();
            return $this->success(true);
        }

        return $this->failure("Document not found");

    }

	private function saveVideo(UploadedFile $file, $user_id) {
    	$fname = "video_".$user_id.".".$file->getClientOriginalExtension();

    	if(\Storage::disk('public')->exists("/videos/".$fname)) {
    		\Storage::disk('public')->delete("/videos/".$fname);
		}

    	$file->move(\Storage::disk('public')->path("/videos"), $fname);

    	return $fname;
	}

    private function getDecodedValuesFromRequest(Request $request, ...$list) {
    	$result = [];
    	foreach($list as $item) {
    		$result[$item] = json_decode($request->get($item), true);
		}

		return $result;
	}

	private function transformToSync(array $arr, $id="id", ...$pivots) {
    	$result = [];
    	foreach($arr as $value) {

            $r = [];
            foreach ($pivots as $pivot) {
                $r[$pivot] = isset($value["pivot"][$pivot]) ? $value["pivot"][$pivot] : NULL;
            }
            if(isset($value[$id])) {
                $result[$value[$id]] = $r;
            }
		}

		return $result;
	}

	private function getEmploymentHistoryList(array $arr) {
    	$result = [];
    	foreach($arr as $value) {
    		$result[] = new EmploymentHistory([
    			'title'=> isset($value["title"] ) && $value['title'] != '' ? $value["title"] : NULL,
				'job_sector_id'=>isset($value["job_sector_id"] ) && $value['job_sector_id'] != '' ? $value["job_sector_id"] : 0,
				'job_title_id'=>isset($value["job_title_id"] ) && $value['job_title_id'] != '' ? $value["job_title_id"] : NULL,
				'start_date'=>isset($value["start_date"] ) && $value['start_date'] != '' ? $value["start_date"] : NULL,
				'end_date'=>isset($value["end_date"] ) && $value['end_date'] != '' ? $value["end_date"] : NULL,
				'job_location'=>isset($value["job_location"] ) && $value['job_location'] != '' ? $value["job_location"] : NULL,
				'job_description'=>isset($value["job_description"] ) && $value['job_description'] != '' ? $value["job_description"] : NULL,
			]);
		}

		return $result;
	}
	private function getSoftwareKnowledgeList(array $arr) {
    	$result = [];
    	foreach($arr as $value) {

            $result[] = new ResumeSoftware([
                'software_id' => isset($value["software_id"]) ? $value["software_id"] : NULL,
                'knowledge_level_id' => isset($value["knowledge_level_id"]) ? $value["knowledge_level_id"] : NULL,
                'graduated' => isset($value["graduated"]) ? $value["graduated"] :NULL,
            ]);


		}

		return $result;
	}
	private function getWorkingPlacesList(array $arr) {
    	$result = [];
    	foreach($arr as $value) {
    		$result[] = new WorkingPlace($value);
		}

		return $result;
	}
	private function getEducationList(array $arr) {
    	$result = [];
    	foreach($arr as $value) {

    	    $ed_level = NULL;

    	    if(isset($value["education_level_id"],$value)) {
                $ed_level = $value["education_level_id"];
            }
    		$result[] = new ResumeEducation([
    		    'institution_name'=>$value['institution_name'],
				'education_field_id'=>isset($value["education_field_id"]) && $value["education_field_id"] != '' ? $value["education_field_id"] : NULL,
				'start_date'=>isset($value["start_date"]) && $value["start_date"] != '' ? $value["start_date"] : NULL,
				'end_date'=>isset($value["end_date"]) && $value["end_date"] != '' ? $value["end_date"] : NULL,
				'completed'=>isset($value["completed"]) && $value["completed"] != '' ? $value["completed"] : NULL,
				'education_level_id'=>$ed_level
			]);
		}

		return $result;
	}

    public function getResumeData() {

    	$jobTitles = JobTitle::query()->orderBy('title_'.app()->getLocale(),'asc')->get();
    	$jobSectors = JobSector::query()->orderBy('title_'.app()->getLocale(),'asc')->get();
    	$jobHours = JobHour::all();
    	$languages = Language::query()->orderBy('name_'.app()->getLocale(),'asc')->get();
    	$software = Software::query()->orderBy('name','asc')->get();
    	$employmentTypes = EmploymentType::query()->orderBy('name_'.app()->getLocale(),'asc')->get();
    	$driverLicenses = DriverLicense::all();
    	$competencies = Competency::query()->orderBy('name_'.app()->getLocale(),'asc')->get();

    	$jobSalaries = JobSalary::all();
    	$availableFromTimes = AvailableFromTime::all();
    	$careerLevels = CareerLevel::query()->orderBy('name_'.app()->getLocale(),'asc')->get();
		$educationLevels = EducationLevel::all();
		$knowledgeLevels = KnowledgeLevel::all();
    	$educationTypes = EducationType::all();
    	$educationFields = EducationField::query()->orderBy('name_'.app()->getLocale(),'asc')->get();

    	return $this->success([
    		'job_titles' => $jobTitles,
			'job_sectors' => $jobSectors,
			'job_hours' => $jobHours,
			'languages' => $languages,
			'software' => $software,
			'employment_types' => $employmentTypes,
			'driver_licenses' => $driverLicenses,
			'competencies' => $competencies,
			'job_salaries' => $jobSalaries,
			'available_from_times' => $availableFromTimes,
			'career_levels' => $careerLevels,
			'education_types' => $educationTypes,
			'education_fields' => $educationFields,
			'knowledge_levels' => $knowledgeLevels,
			'education_levels' => $educationLevels,
		]);

	}

}
