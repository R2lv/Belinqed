<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class SoftwareKnowledge extends Model
{
	protected $table = "software_knowledge";

	protected $appends = ['graduated'];


	public function getGraduatedAttribute(){
	    return (string)$this->graduated;
    }
}
