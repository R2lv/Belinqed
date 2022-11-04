<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class WorkingPlace extends Model
{
    protected $fillable = [
    	'name', 'lat', 'lng', 'radius','resume_id'
	];
}
