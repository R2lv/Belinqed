<?php

namespace App;

use App\ResumeDocument;
use Illuminate\Database\Eloquent\Model;

class Resume extends Model {
	protected $fillable = [
		'about', 'education_type_id', 'education_field_id', 'education_text', 'hobbies', 'characteristics', 'user_id', 'current_employer', 'current_job_title_id', 'current_sector_id', 'career_level_id', 'available_from_id', 'looking_for_job', 'job_salary_id', 'video_url', 'work_experience', 'current_career_level_id'
	];

	public function user() {
		return $this->belongsTo(User::class);
	}

	public function job_hours() {
		return $this->belongsToMany(JobHour::class, 'resume_job_hours');
	}

	public function job_sectors() {
		return $this->belongsToMany(JobSector::class, 'resume_job_sectors');
	}

	public function job_titles() {
		return $this->belongsToMany(JobTitle::class, 'resume_job_titles');
	}

	public function languages() {
		return $this->belongsToMany(Language::class, "resume_languages")->withPivot("level_speaking",'level_writing');
	}

	public function software_knowledge() {
		return $this->hasMany(ResumeSoftware::class);
	}

	public function employment_types() {
		return $this->belongsToMany(EmploymentType::class, "resume_employment_types");
	}

	public function current_employment_types() {
		return $this->belongsToMany(EmploymentType::class, "resume_current_employment_types");
	}

	public function driver_licenses() {
		return $this->belongsToMany(DriverLicense::class, "resume_driver_licenses");
	}

	public function competencies() {
		return $this->belongsToMany(Competency::class, "resume_competencies")->withPivot("level");
	}

	public function education_fields() {
		return $this->belongsTo(EducationField::class);
	}

	public function education_type() {
		return $this->belongsTo(EducationType::class);
	}

	public function current_sector() {
		return $this->belongsTo(JobSector::class, 'current_sector_id');
	}

	public function current_career_level() {
		return $this->belongsTo(CareerLevel::class, 'current_career_level_id');
	}

	public function career_level() {
		return $this->belongsTo(CareerLevel::class, 'career_level_id');
	}

	public function available_from() {
		return $this->belongsTo(AvailableFromTime::class, "available_from_id");
	}

	public function job_salary() {
		return $this->belongsTo(JobSalary::class, "job_salary_id");
	}

	public function working_places() {
		return $this->hasMany(WorkingPlace::class);
	}

	public function documents() {
		return $this->hasMany(ResumeDocument::class);
	}

	public function employment_history() {
		return $this->hasMany(EmploymentHistory::class);
	}

	public function education() {
		return $this->hasMany(ResumeEducation::class);
	}

	public function current_job() {
		return $this->belongsTo(JobTitle::class, 'current_job_title_id');
	}

	public function current_job_sector() {
		return $this->belongsTo(JobSector::class, 'current_sector_id');
	}

	public function matches() {
		return $this->belongsToMany(Job::class, "matches", "resume_id", "job_id")
			->withPivot('accepted_by_company','accepted_by_user','requested_short_video','short_video_url','company_reject_reason','user_reject_reason');
	}

}