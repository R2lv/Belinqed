<?php

namespace App\Http\Controllers;

use App\Company;
use App\CompanyUser;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;


class CompanyUserController extends Controller
{
    public function __construct(){

        $this->middleware('auth:company');

    }

    public function index(){

        $userData = CompanyUser::query()
			->select('id','name','lastname','email','phone_number','email_verified')
			->find(auth('company')->user()->id);
        if($userData){
            return $this->success($userData);
        }
        return $this->permissionDenied();
    }

    public function update(Request $request) {
    	$validator = \Validator::make($request->all(), [
    		'name'=>'required',
    		'lastname'=>'required',
    		'email'=>'required|email',
			'phone_number'=>'required'
		]);


    	if($validator->passes()) {

			$user = CompanyUser::query()->find(auth('company')->user()->id);
			if(!Hash::check($request->get("password"),$user->password)) {
				return $this->failure([
					'password'=>['Your current password is not correct']
				]);
			}

			$all = $request->only('name','lastname','phone_number','email');

    		if($request->has("new_password")) {
    			$all['password'] = bcrypt($request->get("new_password"));
			}

			return $this->success($user->update($all));


		} else {
    		return $this->failure($validator->errors());
		}

	}
}
