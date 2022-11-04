<?php

namespace App\Http\Controllers;

use App\Workflow;
use Illuminate\Http\Request;

class WorkflowController extends Controller
{
    public function index(){
        return $this->success(Workflow::query()->orderBy('order','asc')->get());
    }
}
