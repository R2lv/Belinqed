<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    //

    protected $fillable = [
        'country_id','title_en','title_ka'
    ];

    protected $appends = ['title'];

    public function getTitleAttribute(){
        return $this->{'title_'.app()->getLocale()};
    }

    public function country(){
        return $this->belongsTo(Country::class);
    }

    protected $hidden = ['title_en','title_ka','created_at','updated_at'];
}
