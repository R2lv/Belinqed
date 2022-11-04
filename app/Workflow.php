<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Workflow extends Model
{
    protected $fillable = ['icon','title','description'];


    protected $appends = ['title','description'];

    public function getTitleAttribute(){
        return $this->{'title_'.app()->getLocale()};
    }

    public function getDescriptionAttribute(){
        return $this->{'description_'.app()->getLocale()};
    }

}
