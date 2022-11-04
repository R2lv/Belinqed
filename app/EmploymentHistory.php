<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class EmploymentHistory extends Model
{
    protected $table = "employment_history";

    protected $fillable = [
    	'job_title_id', 'job_sector_id', 'job_location', 'job_description', 'start_date', 'end_date', 'title'
	];

	public function job_sector() {
		return $this->belongsTo(JobSector::class);
	}
	public function job_title() {
		return $this->belongsTo(JobTitle::class);
	}
}
