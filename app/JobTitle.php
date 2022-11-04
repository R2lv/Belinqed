<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class JobTitle extends Model
{


    protected $appends = ['title'];

    public function getTitleAttribute(){
        return $this->{'title_'.app()->getLocale()};
    }


}
