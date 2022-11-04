<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    //
    protected $fillable = ['company_name','profile_image', 'city_id','email','address_1','address_2','company_id_number','about_company','company_website','logo_url','facebook_url','linkedin_url','twitter_url','google_plus_url','about_company','balance','verified','phone_number'];

    protected $appends = ['keywords','matched'];

    public function users(){
        return $this->hasMany(CompanyUser::class, 'company_id');
    }

    public function introImages() {
    	return $this->hasMany(CompanyIntroImage::class, 'company_id');
	}

    public function officeImages() {
    	return $this->hasMany(CompanyOfficeImage::class, 'company_id');
	}

	public function members() {
    	return $this->hasMany(CompanyMember::class, 'company_id');
	}

	public function city() {
    	return $this->belongsTo(City::class);
	}

	public function tags() {
    	return $this->belongsToMany(Tag::class,"company_tag","company_id","tag_id");
	}

	public function getKeywordsAttribute() {
    	return implode(", ", array_map(function($tag){return $tag["name"];},$this->tags->toArray()));
	}

	public function jobs() {
    	return $this->hasMany(Job::class, 'company_id')->orderBy('id','desc');
	}

	public function getMatchedAttribute(){
        $count = 0;
        foreach ( $this->jobs()->get() as $job) {
            $count += count($job->matches);
        }

        return $count;
    }

	public function alerts() {
    	return $this->hasMany(CompanyAlert::class);
	}

	public function package() {
        return $this->hasOne(CompanyPackage::class, "company_id", "id")->where("paid",1)->latest();
    }

	public function packages() {
        return $this->hasMany(CompanyPackage::class, "company_id", "id");
    }

    public function transactions() {
        return $this->hasMany(Transaction::class);
    }
}
