<?php

namespace App\Http\Controllers;

use App\CompanyAlert;
use App\Job;
use App\Match;
use App\Resume;
use App\UserAlert;
use Illuminate\Http\Request;

class MatchController extends Controller
{

	public function __construct() {
		$this->middleware('auth', [
			'only'=>[
				'acceptByUser','rejectByUser','sendShortVideo'
			]
		]);

		$this->middleware('auth:company', [
			'only'=>[
				'acceptByCompany','rejectByCompany','requestShortVideo'
			]
		]);
	}

	public function requestShortVideo(Request $request, $job_id, $resume_id) {
		$match = Match::query()
			->where("resume_id", $resume_id)
			->where("job_id", $job_id)
			->where("accepted_by_company", "!=", -1)
			->where("accepted_by_user", "!=", -1)
			->get();

		if($match->count()) {
			$match = $match[0];
			$company = auth('company')->user()->company;
			$user = Resume::query()->find($resume_id)->user;

			$match->update([
				'requested_short_video'=>1,
				'csv_questions'=>$request->get("csv_questions")
			]);


			$alert = new UserAlert([
				'title_en'=>"CSV Request",
				'title_ka'=>"ვიდეოს მოთხოვნა",
				'company_id'=>$company->id,
				'job_id'=>$job_id,
				'text_en'=>"{$company->company_name} requested you a CSV<br>Questions: {$request->get("csv_questions")}",
				'text_ka'=>"{$company->company_name} მოითხოვა CSV <br>კითხვები: {$request->get("csv_questions")}",
				'url'=>"/job/{$job_id}/public"
			]);
			$user->alerts()->save($alert);

			return $this->success(true);
		}

		return $this->failure("Match not found");
	}

	public function sendShortVideo(Request $request, $job_id) {
		$resume = auth()->user()->resume;
		$match = Match::query()
			->where("resume_id", $resume->id)
			->where("job_id", $job_id)
			->where("accepted_by_company", "!=", -1)
			->where("accepted_by_user", "!=", -1)
			->where("requested_short_video", 1)
			->get();

		if($match->count()) {
			$match = $match[0];
			$user = auth()->user();
			$company = Job::query()->find($job_id)->company;

			$file = $request->file("video");
			$file_name = time()."_".$file->getClientOriginalName();
			$file->move(\Storage::disk('public')->path('csv_videos'), $file_name);
			$match->update(['short_video_url' => "csv_videos/".$file_name]);


			$alert = new CompanyAlert([
				'title_en'=>"Request CSV",
				'title_ka'=>"ვიდეოს მოთხოვნა",
				'user_id'=>$user->id,
				'text_en'=>"{$user->name} {$user->surname} sent you a CSV.",
				'text_ka'=>"{$user->name} {$user->surname} ",
				'url'=>"/resume/{$resume->id}/{$job_id}"
			]);

			$company->alerts()->save($alert);

			return $this->success(true);
		}

		return $this->failure("Match not found");
	}

	public function acceptByCompany($job_id, $resume_id) {
		$match = Match::query()
			->where("resume_id", $resume_id)
			->where("job_id", $job_id)
			->where("accepted_by_company", "!=", -1)
			->where("accepted_by_user", "!=", -1)
			->get();

		if($match->count()) {
			$match = $match[0];
			$user = Resume::query()->find($resume_id)->user;
			$company = auth('company')->user()->company;

			$match->update([
				'accepted_by_company'=>1
			]);


			$alert = new UserAlert([
				'title_en'=>"Accept",
				'title_ka'=>"თანხმობა",
				'company_id'=>$company->id,
				'job_id'=>$job_id,
				'text_en'=>"{$company->company_name} ",
				'text_ka'=>"{$company->company_name} ",
				'url'=>"/job/{$job_id}/public"
			]);
			$user->alerts()->save($alert);

			return $this->success(true);
		}

		return $this->failure("Match not found");
	}


	public function acceptByUser($job_id, $resume_id) {
		$match = Match::query()
			->where("resume_id", $resume_id)
			->where("job_id", $job_id)
			->where("accepted_by_company", 1)
			->where("accepted_by_user", "!=", -1)
			->get();

		if($match->count()) {
			$match = $match[0];
			$user = auth()->user();
			$company = Job::query()->find($job_id)->company;

			$match->update([
				'accepted_by_user'=>1
			]);

			$alert = new CompanyAlert([
				'title_en'=>"Accept",
				'title_ka'=>"თანხმობა",
				'user_id'=>$user->id,
				'text_en'=>"{$user->name} {$user->surname} ",
				'text_ka'=>"{$user->name} {$user->surname}",
				'url'=>"/resume/{$resume_id}/{$job_id}"
			]);

			$company->alerts()->save($alert);

			return $this->success(true);
		}

		return $this->failure("Match not found");
	}

	public function rejectByCompany(Request $request, $job_id, $resume_id) {
		$match = Match::query()
			->where("resume_id", $resume_id)
			->where("job_id", $job_id)
			->where("accepted_by_company", "!=", 1)
			->where("accepted_by_user", "!=", -1)
			->get();

		if($match->count()) {
			$match = $match[0];
			$user = Resume::query()->find($resume_id)->user;
			$company = auth('company')->user()->company;
			$reason = $request->get("reason");

			$match->update([
				'accepted_by_company'=>-1,
				'company_reject_reason'=>$reason
			]);

			$reason = $reason ? "Reason: ".$reason : "";

			$alert = new UserAlert([
				'title_en'=>"Decline",
				'title_ka'=>"უარყო",
				'company_id'=>$company->id,
				'job_id'=>$job_id,
				'text_en'=>"{$company->company_name} <br>{$reason}",
				'text_ka'=>"{$company->company_name} უარყო .<br>{$reason}",
				'url'=>"/job/{$job_id}/public"
			]);

			$user->alerts()->save($alert);

			return $this->success(true);
		}

		return $this->failure("Match not found");
	}

	public function rejectByUser(Request $request, $job_id, $resume_id) {
		$match = Match::query()
			->where("resume_id", $resume_id)
			->where("job_id", $job_id)
			->where("accepted_by_company", 1)
			->where("accepted_by_user", "!=", 1)
			->get();

		if($match->count()) {
			$match = $match[0];
			$user = auth()->user();
			$company = Job::query()->find($job_id)->company;
			$reason = $request->get("reason");

			$match->update([
				'accepted_by_user'=>-1,
				'user_reject_reason'=>$reason
			]);



			$reason = $reason ? "Reason: ".$reason : "";

			$alert = new CompanyAlert([
				'title_en'=>"Decline",
				'title_ka'=>"უარყო",
				'user_id'=>$user->id,
				'text_en'=>"{$user->name} {$user->surname} declined your job invite.<br>{$reason}",
				'text_ka'=>"{$user->name} {$user->surname} უარი თქვა თქვენს მოწვევაზე.<br>{$reason}",
				'url'=>"/resume/{$resume_id}/{$job_id}"
			]);

			$company->alerts()->save($alert);

			return $this->success(true);
		}

		return $this->failure("Match not found");
	}
}
