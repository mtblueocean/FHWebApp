<?php

namespace FitHabit;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Cashier\Billable;

class User extends Authenticatable
{
    use Notifiable;
    use Billable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [];
    public $primaryKey = 'id';
    protected $fillable = ['name', 'email', 'password', 'user_age', 'user_sex', 'user_measurement', 'user_startweight', 'user_startfat', 'user_height', 'user_weight', 'user_fat', 'user_fatpercent', 'user_goalweight', 'user_waist', 'user_profileprogress', 'user_birthday', 'user_bioinfo', 'user_status', 'user_firstlogin', 'user_profilepicurl', 'user_startdate', 'user_type', 'user_lastlogin'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $dates = ['trial_ends_at', 'subscription_ends_at'];

    public function stripeDetails()
    {
        return $this->hasOne('FitHabit\StripeAccounts');
    }

    public function userfathistory()
    {
        return $this->hasMany('FitHabit\Userbodyfat', 'userid', 'id');
    }

    public function userweighthistory()
    {
        return $this->hasMany('FitHabit\Userweight', 'userid', 'id');
    }

    public function userpurchasedprogram()
    {
        return $this->hasMany('FitHabit\UserProgram', 'userprogram_userid', 'id');
    }
}
