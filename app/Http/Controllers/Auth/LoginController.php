<?php

namespace App\Http\Controllers\Auth;

use App\CompanyUser;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
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
        $this->middleware('guest')->except('logout');
    }

    public function login(Request $request)
    {
        $this->validateLogin($request);

        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        if ($this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }

        if($request->get('email')){

            $email = $request->get('email');

            if($request->get('company_login')){
                $user_info = CompanyUser::query()->where('email',$email)->first();
            }else {
                $user_info = User::query()->where('email',$email)->first();
            }

            if($user_info) {

                if (!$user_info->email_verified) {
                    return $this->failure(['email' => ['Email is not verified']]);
                }
            }
        }


        if ($this->attemptLogin($request)) {


            return $this->sendLoginResponse($request);
        }



        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
        $this->incrementLoginAttempts($request);

        return $this->failure([$this->username()=>[trans('auth.failed')]]);
    }

    protected function guard() {
    	$company_login = !!\request()->get("company_login");
    	if($company_login) {
    		return auth('company');
		}

		return auth('web');
	}

	public function logout(Request $request)
    {
        $this->guard()->logout();

        $request->session()->invalidate();

        return $this->success('/');
    }

    protected function sendFailedLoginResponse(Request $request)
    {
        throw ValidationException::withMessages([
            $this->username() => [trans('auth.failed')],
        ]);
    }

    protected function sendLockoutResponse(Request $request)
    {
        $seconds = $this->limiter()->availableIn(
            $this->throttleKey($request)
        );

        return $this->failure(Lang::get('auth.throttle', ['seconds' => $seconds]));

    }

    protected function sendLoginResponse(Request $request)
    {
        $request->session()->regenerate();

        $this->clearLoginAttempts($request);

        return $this->success([
            'isCompany' => !!$request->get("company_login")
        ]);

    }

    public function showLoginForm()
    {
        return redirect('/?action=signin');
//        return view('auth.login');
//        return $this->success('/login'); // show login page
    }
}
