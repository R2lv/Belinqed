<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class CompanyAlert extends Model
{
    protected $fillable = [
    	'title_en','title_ka','text_en','text_ka','company_id','user_id','url','type','job_id'
	];

    protected $appends = [
        'title','text'
    ];

    public function company() {
    	return $this->belongsTo(Company::class);
	}

	public function user() {
    	return $this->belongsTo(User::class);
	}

	public function getTitleAttribute() {
        return $this->{'title_'.app()->getLocale()};
    }

    public function getTextAttribute() {
        return $this->{'text_'.app()->getLocale()};

    }

    public function job(){
        return $this->belongsTo(Job::class);
    }
}
