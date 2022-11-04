<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;
use Mockery\Generator\StringManipulation\Pass\Pass;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function broker()
    {
        return request()->get("is_company") ? \Password::broker('company_users') : \Password::broker();
    }

    protected function validateEmail(Request $request) {
        $validator = \Validator::make($request->all(), [
            'email'=>'required|email'
        ]);

        if($validator->fails()) {
            response()->json($this->failure($validator->errors()->first()))->send();
            exit;
        }
    }

    protected function sendResetLinkResponse($response) {
        return $this->success(trans($response));
    }

    protected function sendResetLinkFailedResponse(Request $request, $response) {
        return $this->failure(trans($response));
    }

}
