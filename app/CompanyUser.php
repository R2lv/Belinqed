<?php

namespace App;

use App\Notifications\CompanyResetPasswordNotification;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class CompanyUser extends Authenticatable
{

    use Notifiable;

	protected $fillable = [
		'company_id', 'name', 'lastname', 'email', 'phone_number', 'email_verified', 'password'
	];

	protected $hidden = [
		'password', 'remember_token'
	];

	public function company() {
		return $this->belongsTo(Company::class, "company_id");
	}

	public function sendPasswordResetNotification($token)
    {
        $this->notify(new CompanyResetPasswordNotification($token));
    }
}
