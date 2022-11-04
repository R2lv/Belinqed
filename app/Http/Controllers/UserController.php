<?php

namespace App\Http\Controllers;

use App\Company;
use App\Job;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;


class UserController extends Controller
{
    public function __construct(){

        $this->middleware('auth');

    }

    public function index(){

        $userData = User::query()
			->select('id','city_id','name','surname','email','personal_id','mobile_number','email_verified','mobile_verified','profile_picture_url','banned','gender','birthday','profile_viewed')
			->with('city.country','resume')
			->find(auth()->user()->id);
        if($userData){
            return $this->success($userData);
        }
        return $this->permissionDenied();
    }

    public function alerts() {
    	$user = auth()->user();

    	$alerts = $user->alerts()->with(['company','job.job_title'])->orderBy("id","desc")->get();
    	$alerts_length = $user->alerts()->where("read",0)->orderBy("id","desc")->count();

    	return $this->success(['list'=>$alerts,'new_length'=>$alerts_length]);
	}

	public function readAlerts() {
        $user = auth()->user();
        $user->alerts()->update(['read'=>1]);
        return $this->success(true);
    }

    public function update(Request $request) {
    	$validator = \Validator::make($request->all(), [
    		'name'=>'required',
    		'surname'=>'required',
    		'personal_id'=>'required',
    		'email'=>'required|email',
			'mobile_number'=>'required',
			'city_id'=>'required|exists:cities,id',
			'birthday'=>'required',
			'password'=>'required',
			'new_password'=>'confirmed',
			'new_password_confirmation'=>'required_with:new_password',
			'profile_image'=>'image|max:6000'
		]);


    	if($validator->passes()) {

			$user = User::query()->find(auth()->user()->id);

			$isFullyEditable = !($user->resume_accepted || $user->resume_submitted);

			if(!Hash::check($request->get("password"),$user->password)) {
				return $this->failure([
					'password'=>['Your current password is not correct']
				]);
			}

			$all = $request->only('email','mobile_number','city_id');

			if($isFullyEditable) {
				$all = array_merge($all, $request->only('name','surname','personal_id','birthday','gender'));
			}

    		if($request->hasFile("profile_image")) {
    			$all['profile_picture_url'] = $this->updateProfilePicture($user, $request->file("profile_image"));
//    			dd($all['profile_picture_url']);

			}

    		if($request->has("new_password")) {
    			$all['password'] = bcrypt($request->get("new_password"));
			}

			return $this->success($user->update($all));


		} else {
    		return $this->failure($validator->errors());
		}

	}

	private function updateProfilePicture($user, UploadedFile $file) {
    	if($user->profile_picture_url) {
    		Storage::disk('public')->delete($user->profile_picture_url);
		}

		$filename = time()."_".str_random(10).".".$file->getClientOriginalExtension();
		$file->storeAs('',$filename,['disk'=>'public']);

		return $filename;
	}
}
