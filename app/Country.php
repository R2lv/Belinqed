<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    //
    protected $fillable = [
        'title_en','title_ka'
    ];

    protected $appends = ['title'];

    public function getTitleAttribute() {
        return $this->{'title_'.app()->getLocale()};
    }

    public function city(){
        return $this->hasMany(City::class);
    }

    protected $hidden = ['title_en','title_ka','created_at','updated_at'];
}
