<?php

namespace App\Http\Controllers;

use App\Company;
use App\CompanyIntroImage;
use App\CompanyMember;
use App\CompanyOfficeImage;
use App\Job;
use App\Tag;
use Illuminate\Http\UploadedFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class  CompanyController extends Controller
{
    public function __construct(){
        $this->middleware('auth:company');
    }

    public function index() {
    	$user = auth('company')->user();

    	$company = Company::query()->with(['introImages','members','city.country','officeImages','tags','jobs.job_title', 'jobs.job_sector', 'jobs.job_hours',
			'jobs.education_level','jobs.education_field','jobs.job_salary','jobs.job_career_level'])->find($user->company_id);

    	return $this->success($company);
	}


	public function companyJobs(Request $request){
        $user = auth('company')->user();



        $jobs = Job::query()->with(['job_title','job_sector','job_hours','education_level','education_field','job_salary','job_career_level'])->where('company_id',$user->company_id);


        if($request->get('search')){

            $search = $request->get('search');
            $jobs->whereHas('job_title',function($query) use ($search){
                $query->where('title','like','%'.$search.'%');
            });

        }

        return $this->success($jobs->orderBy('id','desc')->paginate(10));

    }
	public function analytics() {
        $company = auth('company')->user()->company;
        $jobs_viewed = 0;
        $jobs_matched = 0;

        $job_posts = $company->jobs()->count();

        foreach($company->jobs as $job) {
            $jobs_viewed+=$job->matches()->where("viewed",1)->count();
            $jobs_matched+=$job->matches()->count();
        }

        return $this->success([
            'job_posts'=>$job_posts,
            'job_viewed'=>$jobs_viewed,
            'job_matched'=>$jobs_matched
        ]);
    }

	public function jobCandidates() {
    	$company_user = auth('company')->user();
    	$jobs = $company_user->company->jobs()->with('matches.user','job_title')->get();
    	return $this->success($jobs);
	}

	public function alerts() {
		$company_user = auth('company')->user();
		$alerts = $company_user->company->alerts()->with(["user",'job.job_title'])->orderBy("id","desc")->get();
		$new_length = $company_user->company->alerts()->where("read",0)->count();

		return $this->success(['list'=>$alerts,'new_length'=>$new_length]);
	}

	public function readAlerts() {
        $company_user = auth('company')->user();
        $company_user->company->alerts()->update(['read'=>1]);

        return $this->success(true);
    }

    public function update(Request $request){

            $validator = $this->validator($request->all());
            if($validator->fails()){
                return $this->failure($validator->errors());
            }

            $company = auth('company')->user()->company;

            $all = $request->only('company_name','email','phone_number','city_id','address_1','address_2','facebook_url',
				'linkedin_url','twitter_url','google_plus_url', 'company_website','about_company');
            $company->update($all);

            if($request->hasFile("intro_images")) {
				$this->saveIntroImages($request->file("intro_images"), $company);
			}

			if($request->has("delete_members")) {
				$this->deleteMembers($request->get("delete_members"), $company);
			}

			if($request->hasFile("office_images")) {
				$this->saveOfficeImages($request->file("office_images"),$company);
			}
			if($request->has("delete_office_images")) {
				$this->deleteOfficeImages($request->get("delete_office_images"),$company);
			}

			if($request->has("member_names")) {
				$this->saveMembers($request,$company);
			}

			if($request->hasFile("profile_image")) {
				$this->saveProfileImage($request->file("profile_image"),$company);
			}

			$this->saveKeywords($request->get("keywords"),$company);



            // todo email user if company info is not detailed
            return $this->success(trans('default.operations.success'));

    }

    private function saveKeywords($keywords, Company $company) {
    	$keywords = array_filter(array_map(function($kw) {return trim($kw);}, explode(",", $keywords)),function($kw){
    		return !empty($kw);
		});
    	$tags = Tag::query()->whereIn("name", $keywords)->get()->toArray();

    	$tag_ids = [];

    	$tags_found = array_map(function($tag) use(&$tag_ids) {
    		$tag_ids[] = $tag["id"];
    		return strtolower($tag["name"]);
		},$tags);

    	foreach($keywords as $kw) {
    		if(!in_array(strtolower($kw), $tags_found)) {
    			$tag = Tag::create([
    				'name'=>$kw
				]);
    			$tag_ids[] = $tag->id;
			}
		}

		$company->tags()->sync($tag_ids);
	}

    private function saveIntroImages($images, Company $company) {
    	if(!is_array($images)) $images = [$images];

    	$companyImages = [];
    	/**
		 * @var $image UploadedFile
    	 */
    	foreach($images as $image) {
    		$fileName = time()."_".urlencode($image->getClientOriginalName());
    		$image->move(Storage::disk('public')->path('company_images'), $fileName);
    		$companyImages[] = new CompanyIntroImage([
    			'image_url'=>"company_images/".$fileName
			]);
		}

		$company->introImages()->each(function (CompanyIntroImage $img) {
			Storage::disk('public')->delete($img->image_url);
			$img->delete();
		});
		$company->introImages()->saveMany($companyImages);

	}

	private function saveProfileImage(UploadedFile $file, Company $company) {
    	$new_name = time()."_".str_replace(" ","_",$file->getClientOriginalName());
    	$file->move(Storage::disk('public')->path('company_images'),$new_name);
    	if(Storage::disk('public')->exists($company->profile_image))
    		Storage::disk('public')->delete($company->profile_image);

    	$company->update(['profile_image'=>'company_images/'.$new_name]);
	}

    private function saveOfficeImages($images, Company $company) {
    	if(!is_array($images)) $images = [$images];

		$officeImages = [];
    	/**
		 * @var $image UploadedFile
    	 */
    	foreach($images as $image) {
    		$fileName = time()."_".urlencode($image->getClientOriginalName());
    		$image->move(Storage::disk('public')->path('company_images'), $fileName);
			$officeImages[] = new CompanyOfficeImage([
    			'image'=>"company_images/".$fileName
			]);
		}

		$company->officeImages()->saveMany($officeImages);
	}

	private function deleteMembers($members,Company $company) {
    	CompanyMember::query()->whereIn("id",$members)->where("company_id",$company->id)->each(function(CompanyMember $member){
    		Storage::disk('public')->delete($member->image);
    		$member->delete();
		});
	}

	private function deleteOfficeImages($images, Company $company) {
    	CompanyOfficeImage::query()->whereIn("id",$images)->where("company_id",$company->id)->each(function(CompanyOfficeImage $officeImage){
    		Storage::disk('public')->delete($officeImage->image);
			$officeImage->delete();
		});
	}

	private function saveMembers(Request $request, Company $company) {
    	$member_names = $request->get("member_names");
    	$member_positions = $request->get("member_positions");
    	$member_about = $request->get('member_about');
		$member_images = $request->file("member_images");
    	$member_videos = $request->file("member_videos");
    	$company_members = [];

    	foreach($member_names as $index => $member_name) {

    		/**
			 * @var $member_image UploadedFile
    		 */
    		$member_image = $member_images[$index];
    		$image_name = time()."_".urlencode($member_image->getClientOriginalName());
    		$member_image->move(Storage::disk('public')->path("company_images"),$image_name);

    		if($member_videos[$index]) {
				/**
				 * @var $member_video UploadedFile
				 */
    			$member_video = $member_videos[$index];
				$video_name = time()."_".urlencode($member_video->getClientOriginalName());
				$member_video->move(Storage::disk('public')->path("company_videos"),$video_name);
			}

			$company_members[] = new CompanyMember([
				'name'=>$member_name,
				'position'=>$member_positions[$index],
				'about'=>$member_about[$index],
				'image'=>"company_images/".$image_name,
				'video'=>isset($video_name) ? "company_videos/".$video_name : ""
			]);

		}

		$company->members()->saveMany($company_members);
	}

    protected function validator(array $data)
    {
    	$rules = [
			'company_name'=>'required',
			'email'=>'required',
			'phone_number'=>'required',
			'company_id_number'=>'required',
			'city_id'=>'required',
			'address_1'=>'required',
			'about_company'=>'required',
			'intro_images'=>'array|max:2',
			'intro_images.*'=>'required|image',
			'member_names'=>'array',
			'member_names.*'=>'required',
			'member_positions'=>'array',
			'member_positions.*'=>'required',
			'member_images'=>'array',
			'member_images.*'=>'required|image',
			'member_videos'=>'array',
			'office_images'=>'array|max:8',
			'office_images.*'=>'required|image'
		];
        return \Validator::make($data, $rules);
    }
}
