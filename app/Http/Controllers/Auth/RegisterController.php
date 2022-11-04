<?php

namespace App\Http\Controllers\Auth;

use App\Company;
use App\CompanyUser;
use App\Events\UserRegistered;
use App\Mail\EmailValidationMail;
use App\Resume;
use App\User;
use App\Http\Controllers\Controller;
use App\UserToken;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Validation\Rule;


class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

//    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/dashboard';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }


    public function showRegistrationForm()
    {
        return redirect('/?action=signup');
//        return view('auth.register');
//        return $this->success('/registration');
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|string|max:255',
            'surname' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'city_id' => 'required|numeric|exists:cities,id',
            'mobile_number' => 'required|numeric',
            'personal_id' => 'required|max:11',
            'gender'=>['required',Rule::in(['male','female'])],
            'birthday'=>'required|date|before:18 years ago'
        ]);
    }

    protected function validatorCompany(array $data)
    {
        return Validator::make($data, [
            'company_name' => 'required|string|max:255',
			'company_id_number' => 'required|max:11',
            'company_email' => 'required|email|unique:companies,email',
            'company_phone_number' => 'required|numeric',
			'company_city_id' => 'required|numeric|exists:cities,id',
			'company_address_1' => 'required|string',
			'user_name'=>'required|string',
			'user_lastname'=>'required|string',
			'user_phone_number'=>'required|numeric',
			'user_email'=>'required|email',
			'password'=>'required|string|min:6|confirmed',
        ]);
    }

	/**
	 * Create a new user instance after a valid registration.
	 *
	 * @param Request $request
	 * @return \App\User
	 */
    protected function create(Request $request)
    {
        if($request->get('company')){
        	return $this->createCompany($request);
        }

        /**
         * @var User $user
         * */

        $data = $request->all();
        $user =  User::query()->create([
            'name' => $data['name'],
            'surname' => $data['surname'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'mobile_number' => $data['mobile_number'],
            'personal_id' => $data['personal_id'],
            'gender' => $data['gender'],
            'birthday' => $data['birthday'],
			'city_id' => $data['city_id']
        ]);

		$resume = new Resume();

		$user->resume()->save($resume);

        return $user;
    }

    private function createCompany(Request $request) {
    	/**
    	 * @var Company $company
    	 * */
    	$company = Company::query()->create([
    		'company_name'=>$request->get("company_name"),
    		'city_id'=>$request->get('company_city_id'),
    		'email'=>$request->get('company_email'),
    		'address_1'=>$request->get('company_address_1'),
    		'address_2'=>$request->get('company_address_2'),
    		'company_id_number'=>$request->get('company_id_number'),
    		'phone_number'=>$request->get('company_phone_number'),
    		'about_company'=>$request->get('company_about'),
		]);

    	$user = new CompanyUser([
    		'name'=>$request->get("user_name"),
			'lastname'=>$request->get("user_lastname"),
			'email'=>$request->get("user_email"),
			'phone_number'=>$request->get("user_phone_number"),
			'password'=>bcrypt($request->get("password"))
		]);

    	$company->users()->save($user);

    	return $user;
	}

    public function register(Request $request)
    {
//    	return 1;
        $validator = !!$request->get("company") ? $this->validatorCompany($request->all()) : $this->validator($request->all());

        if($validator->fails()){
            return $this->failure($validator->errors());
        }

		event(new UserRegistered($user = $this->create($request)));

        if($request->get("company")) {
//			auth('company')->login($user); // todo uncomment
//			$this->sendVerificationEmail($user->email, 'company'); // todo uncomment for live and delete bottom line 172
			$this->sendVerificationEmail("gio_s79@hotmail.com", 'company');
		} else {
//			auth()->login($user); // todo uncomment
//			$this->sendVerificationEmail($user->email, 'normal'); // todo uncomment for live and delete bottom line 175
			$this->sendVerificationEmail("gio_s79@hotmail.com", 'normal');
		}

        return $this->success([
            'message' => [
                'title'=>trans('messages.title'),
                'text'=>trans('messages.email_was_sent')
            ],
            'isCompany' => !!$request->get("company")
        ]);

    }

    public function sendVerificationEmail($email, $type) {

    	$query = $type == 'normal' ? User::query() : CompanyUser::query();

    	$user = $query->where("email", $email)->first();

		$userToken = UserToken::query()->create([
			'user_id'=>$user->id,
			'token'=>str_random(11),
			'type'=>'email',
			'user_type'=>$type
		]);

		Mail::to($user->email)->send(new EmailValidationMail($user,$userToken));

	}
}
