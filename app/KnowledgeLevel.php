<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class KnowledgeLevel extends Model
{
    protected $appends = ['name'];

    public function getNameAttribute(){
        return $this->{'name_'.app()->getLocale()};
    }

}
