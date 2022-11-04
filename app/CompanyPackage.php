<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class CompanyPackage extends Model
{
    protected $table = "company_package";

    protected $fillable = [
        'name_en','name_ka', 'vacancies', 'candidates', 'days_active', 'price', 'currency', 'company_id','paid'
    ];

    protected $appends = ['name'];

    public function getNameAttribute(){
        return $this->{'name_'.app()->getLocale()};
    }

}
