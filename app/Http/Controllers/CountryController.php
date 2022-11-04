<?php

namespace App\Http\Controllers;

use App\Country;
use Illuminate\Http\Request;

class CountryController extends Controller
{

    public function index()
    {
        $countries = Country::query()->with(['city' => function($query){
            $query->orderBy('title_'.app()->getLocale(),'ASC');
        }])->orderBy('title_'.app()->getLocale(),'ASC')->get();
        return $this->success($countries);
    }

}
