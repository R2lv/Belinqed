<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class ResumeDocument extends Model
{
	protected $fillable = [
		'url', 'resume_id', 'name', 'type'
	];

	public function resume() {
		return $this->belongsTo(Resume::class);
	}
}
