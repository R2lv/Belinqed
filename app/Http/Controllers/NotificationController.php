<?php

namespace App\Http\Controllers;

use App\CompanyUser;
use App\User;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
	public function __construct() {
		$this->middleware('auth:web,company');
	}

	public function show() {
		return $this->success($this->collect());
	}

	public function showCompany() {
		return $this->success($this->collectCompany());
	}

	private function collect() {
    	$user = User::query()->find(auth()->user()->id);
    	$notifications = [];


		if(!($user->resume_submitted && $user->resume_accepted)) {
			$notifications[] = 'submit_resume';
		} else if (!$user->resume_submitted) {
			$notifications[] = 'waiting_to_accept_resume';
		} else if($user->resume_rejected) {
			$notifications[] = 'resume_rejected';
		}

    	if(!$user->email_verified) {
    		$notifications[] = 'verify_email';
		}

		if(!$user->mobile_verified) {
    		$notifications[] = 'verify_mobile';
		}
		return $notifications;
	}

	private function collectCompany() {
		$user = CompanyUser::query()->find(auth('company')->user()->id);

		if(!$user->email_verified) {
			$notifications[] = 'verify_email';
		}

		return [];
	}
}
