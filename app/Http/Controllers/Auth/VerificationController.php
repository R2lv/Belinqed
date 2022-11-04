<?php

namespace App\Http\Controllers\Auth;

use App\CompanyUser;
use App\Events\UserVerified;
use Illuminate\Http\Request;
use App\User;
use App\UserToken;
use App\Http\Controllers\Controller;

class VerificationController extends Controller
{
    public function __construct(){

        $this->middleware('auth',['except'=>['store']]);

    }
    // todo ask is there any time limit to verify via email?
    public function store($user_id, $token, $type) {

    	$user = $type == 'normal' ? User::query()->find($user_id) : CompanyUser::query()->find($user_id);

        if($user->email_verified){
            return $this->failure(trans('messages.email_verification.failure'));
        }
        $userToken = UserToken::query()
			->where('user_id',$user->id)
			->where('token',$token)
			->where('type','email')
			->where('status',0)
			->where('user_type',$type)
			->orderBy('id','desc')
			->first();
        if ($userToken){
            $user->update(['email_verified'=>1]);
            $userToken->update(['status'=>1]);

            event(new UserVerified($user));
            return $this->success(trans('messages.email_verification.success'));
        }else{
            return $this->permissionDenied();
        }
    }

}
