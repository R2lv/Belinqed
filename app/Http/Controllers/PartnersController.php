<?php

namespace App\Http\Controllers;

use App\Partner;
use Illuminate\Http\Request;

class PartnersController extends Controller
{
    public function index(){
        return $this->success(Partner::query()->orderBy('order','asc')->get());
    }
}
