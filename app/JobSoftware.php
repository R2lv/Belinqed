<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class JobSoftware extends Model
{
    protected $table = "job_software";

    protected $fillable = [
    	'job_id','software_id','knowledge_level_id','graduated'
	];

    public function software() {
    	return $this->hasOne(Software::class,"id","software_id");
	}

    public function knowledge() {
    	return $this->hasOne(KnowledgeLevel::class,"id","knowledge_level_id");
	}

//    public $timestamps = false;
}
