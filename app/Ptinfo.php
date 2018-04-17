<?php

namespace FitHabit;

use Illuminate\Database\Eloquent\Model;

class Ptinfo extends Model
{
    //
    protected $primaryKey = 'pt_id';

    protected $fillable = [
        'pt_userid',
        'pt_firstname',
        'pt_lastname',
        'pt_cardnumber',
        'pt_expireYear',
        'pt_expireMonth',
        'pt_securitycode',
        'pt_country',
        'pt_state',
        'pt_address',
        'pt_address1',
        'pt_city',
        'pt_postalcode',
        'pt_phonenumber',
        'pt_contactname',
        'pt_contactaddress',
        'pt_contactcity',
        'pt_contactcountry',
        'pt_contactstate',
        'pt_membership',
        'pt_startdate',
    ];

    protected $hidden = [

    ];
}
