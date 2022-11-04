<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class ResumeEducation extends Model
{
	protected $fillable = [
		'institution_name','education_field_id', 'education_level_id','start_date','end_date','completed'
	];

	public function education_level() {
		return $this->belongsTo(EducationLevel::class);
	}

	public function education_field() {
		return $this->belongsTo(EducationField::class);
	}
}
