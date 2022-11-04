<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;

class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    protected function sendResetResponse($response) {
        return $this->success(trans($response));
    }

    protected function sendResetFailedResponse(Request $request, $response) {
        return $this->failure(trans($response));
    }

    public function validate(Request $request, array $rules, array $messages = [], array $customAttributes = []) {
        $validator = \Validator::make($request->all(), $rules);

        if($validator->fails()) {
            response()->json($this->failure($validator->errors()->first()))->send();
            exit;
        }
    }


    public function broker() {
        return request()->get("is_company") ? \Password::broker('company_users') : \Password::broker();
    }

    protected function guard() {
        return request()->get("is_company") ? auth()->guard('company') : auth()->guard();
    }

}
