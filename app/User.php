<?php

namespace App;

use App\Notifications\ResetPasswordNotification;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends \TCG\Voyager\Models\User
{
    use Notifiable;

    protected $fillable = [
        'name', 'surname', 'city_id', 'email', 'password','mobile_number','email_verified','mobile_verified','profile_picture_url','gender','birthday', 'personal_id', 'resume_submitted', 'resume_accepted', '	resume_rejected','profile_viewed'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function country(){
        return $this->belongsTo(Country::class);
    }

    public function city(){
        return $this->belongsTo(City::class);
    }

    public function resume(){
        return $this->hasOne(Resume::class);
    }

    public function alerts() {
    	return $this->hasMany(UserAlert::class);
	}

	public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPasswordNotification($token));
    }

}
