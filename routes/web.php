<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group(['prefix' => 'admin'], function () {
	Voyager::routes();
});


Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');

Route::group(['prefix' => 'data','middleware'=>'app'], function () {

    // Session Routes...
    Route::post('login', 'Auth\LoginController@login');
    Route::get('logout', 'Auth\LoginController@logout')->name('logout');

    Route::post('forgot','Auth\ForgotPasswordController@sendResetLinkEmail');
    Route::post("reset/{token}","Auth\ResetPasswordController@reset")->name("password.reset");

    // Registration Routes...
    Route::post('register', 'Auth\RegisterController@register');

    // user verification ...
    Route::get('/verify/{user}/{user_token}/{type}','Auth\VerificationController@store');


    // data requests for frontEnd

	/* ---- User ---- */
	Route::resource('user','UserController', [
    	'only'=>['index']
	]);

    Route::post("user/update", "UserController@update");
    Route::get("user/alerts", "UserController@alerts");
    Route::get("user/alerts/read", "UserController@readAlerts");

    /* ---- Resume ---- */
	Route::resource('resume','ResumeController', [
		'only'=>['index']
	]);
	Route::get('resume-data','ResumeController@getResumeData');
	Route::post("resume/update", "ResumeController@update");
	Route::post("resume/save-doc", "ResumeController@saveDoc");
	Route::get("resume/delete-doc/{doc_id}", "ResumeController@deleteDoc");

    Route::post('countries','CountryController@index');


    Route::resource('company','CompanyController', [
    	'only'=>['index','update']
	]);

    Route::get("company/jobs",'CompanyController@companyJobs');
    Route::get("company/alerts", 'CompanyController@alerts');
    Route::get("company/alerts/read", "CompanyController@readAlerts");
    Route::get("company/analytics", "CompanyController@analytics");



    Route::get("/my-matches", 'ResumeController@matches');


	/* ---- Company User ---- */
	Route::resource('company-user','CompanyUserController', [
		'only'=>['index']
	]);

	Route::post("company-user/update", "CompanyUserController@update");


	Route::resource('job','JobController', [
		'only'=>['store','index','show','update']
	]);

	Route::resource('blog','PostsController',[
        'only'=>['index','show']
    ]);

	Route::get('lastPosts','PostsController@lastPosts');
	Route::get('categories','PostsController@categories');

	Route::get("job/{id}/public", "JobController@showMatch");
	Route::get("job/{id}/rematch", 'JobController@findMatches');
    Route::post("job/{id}/publish", "JobController@startMatching");
    Route::get("job/{id}/copy", "JobController@copyJob");

//	Route::get("matches", 'JobController@findMatches');

	Route::get("job-candidates", 'CompanyController@jobCandidates');

    /* ---- Notifications ---- */
    Route::post("notifications", 'NotificationController@show');
    Route::post("notificationsCompany", 'NotificationController@showCompany');

    /* ---- match actions ----  */
	Route::get("match/resume/accept/{job_id}/{resume_id}", "MatchController@acceptByCompany");
	Route::post("match/resume/decline/{job_id}/{resume_id}", "MatchController@rejectByCompany");

	Route::get("match/job/accept/{job_id}/{resume_id}", "MatchController@acceptByUser");
	Route::post("match/job/decline/{job_id}/{resume_id}", "MatchController@rejectByUser");

	Route::post("match/resume/request-csv/{job_id}/{resume_id}", "MatchController@requestShortVideo");
	Route::post("match/resume/send-csv/{job_id}", "MatchController@sendShortVideo");

    Route::resource('resume','ResumeController', [
        'only'=>['store']
    ]);

    Route::get("resume/{resume_id}/{job_id}", "ResumeController@show");
    Route::get('locale','MainController@getLocale');
    Route::post('locale','MainController@setLocale');

    Route::get('home-stats','MainController@homeStats');
    Route::get('footer-info','MainController@footerInfo');

	Route::get("packages", "PackageController@index");
	Route::get("my-package", "PackageController@show");
	Route::get("package/{id}/buy", "PackageController@buy");

    Route::get('partners','PartnersController@index');
	Route::get('features','FeaturesController@index');
	Route::get('workflow','WorkflowController@index');

});

/* Payments */
Route::group([
    'prefix'=>'payment'
], function() {
    Route::post('vtb/success', "PaymentController@vtb_success");
    Route::post('vtb/fail', "PaymentController@vtb_fail");
});

Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::get('{url}', function () {
	return view('welcome');
})->name('home')->where('url', '.*');

Route::get('phpinfo', function() {
    phpinfo();
    exit;
});