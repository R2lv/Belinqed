<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class EducationLevel extends Model
{

    protected $appends = ['name'];

    public function getNameAttribute(){
        return $this->{'name_'.app()->getLocale()};
    }

}
