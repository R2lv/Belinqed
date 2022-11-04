<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class EducationField extends Model
{


    protected $appends = ['name'];

    public function getNameAttribute(){
        return $this->{'name_'.app()->getLocale()};
    }


}
