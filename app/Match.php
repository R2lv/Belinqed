<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Match extends Model
{
	protected $fillable = [
		'job_id','resume_id','accepted_by_company','accepted_by_user','requested_short_video','short_video_url','company_reject_reason','user_reject_reason','csv_questions','viewed'
	];

    public function resume() {
    	return $this->belongsTo(Resume::class);
	}

	public function job() {
    	return $this->belongsTo(Job::class);
	}
}
