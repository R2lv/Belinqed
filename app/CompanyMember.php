<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class CompanyMember extends Model {
	protected $table = "company_members";

	protected $fillable = [
		'name','position','image','video','company_id','about'
	];

	public function company() {
		return $this->hasOne(Company::class);
	}
}
