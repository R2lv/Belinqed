<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Tag extends Model
{
	protected $fillable = [
		'name'
	];
    public function companies() {
    	return $this->belongsToMany(Company::class, "company_tag", "tag_id", "company_id");
	}
}
