<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Feature extends Model
{
    protected $fillable = ['icon','title_en','title_ka','description_en','description_ka'];

    protected $appends = ['title','description'];

    public function getTitleAttribute(){
        return $this->{'title_'.app()->getLocale()};
    }

    public function getDescriptionAttribute(){
        return $this->{'description_'.app()->getLocale()};
    }

}
