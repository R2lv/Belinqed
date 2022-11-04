<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function permissionDenied(){
        return [
            'success'=>false,
            'result'=>null,
            'error'=>trans('default.operations.permission_denied')
        ];
    }

    public function success($result){
        return [
            'success'=>true,
            'result'=>$result,
            'error'=>null
        ];
    }

    public function failure($result){
        return [
            'success'=>false,
            'result'=>null,
            'error'=>$result
        ];
    }
}
