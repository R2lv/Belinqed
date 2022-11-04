<?php

namespace App\Http\Controllers;

use App\Feature;
use Illuminate\Http\Request;

class FeaturesController extends Controller
{
    public function index(){
        return $this->success(Feature::query()->orderBy('order','asc')->get());
    }
}
