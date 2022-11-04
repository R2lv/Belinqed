<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Transaction extends Model
{
    protected $fillable = [
        'trans_id','company_package_id','price','description','company_id','completed'
    ];

    public function company() {
        return $this->belongsTo(Company::class);
    }

    public function companyPackage() {
        return $this->belongsTo(CompanyPackage::class, 'company_package_id');
    }
}
