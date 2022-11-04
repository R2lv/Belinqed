<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Job extends Model
{
    protected $table = "bl_jobs";
    protected $fillable = [
    	'job_title_id','job_sector_id','job_location','job_location_lat','job_location_lng','minimum_experience','job_position','job_description','job_hour_id',
		'education_level_id','education_field_id','education_start_date','education_end_date','education_graduated','job_salary_id','company_id','available','expiration_date','matching_active','available_from_id','job_career_level_id','draft'
	];

    public function available_from() {
		return $this->belongsTo(AvailableFromTime::class, "available_from_id");
	}

    public function job_title() {
    	return $this->belongsTo(JobTitle::class);
	}

	public function job_sector() {
    	return $this->belongsTo(JobSector::class);
	}

	public function job_hours() {
    	return $this->belongsTo(JobHour::class,"job_hour_id");
	}

	public function education_field() {
    	return $this->belongsTo(EducationField::class);
	}

	public function education_level() {
    	return $this->belongsTo(EducationLevel::class);
	}

	public function job_salary() {
    	return $this->belongsTo(JobSalary::class);
	}

	public function job_career_level() {
    	return $this->belongsTo(CareerLevel::class, "job_career_level_id");
	}

	public function job_competencies() {
    	return $this->belongsToMany(Competency::class, "job_competencies")->withPivot("level");
	}

	public function software_knowledge() {
    	return $this->hasMany(JobSoftware::class);
	}

	public function job_languages() {
    	return $this->belongsToMany(Language::class, "job_languages")->withPivot('level_speaking','level_writing');
	}

	public function job_driver_licenses() {
    	return $this->belongsToMany(DriverLicense::class, "job_driver_licenses");
	}

	public function job_employment_types() {
    	return $this->belongsToMany(EmploymentType::class, "job_employment_types");
	}

	public function company() {
    	return $this->belongsTo(Company::class);
	}

	public function matches() {
    	return $this->belongsToMany(Resume::class, "matches", "job_id", "resume_id")->withPivot('accepted_by_company','accepted_by_user','requested_short_video','short_video_url','company_reject_reason','user_reject_reason');
	}
}