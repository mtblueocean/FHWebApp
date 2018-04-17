<?php

namespace FitHabit\Http\Controllers\Auth;

use FitHabit\Ptinfo;
use FitHabit\User;
use FitHabit\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Redirect;

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

    use RegistersUsers;

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

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|max:255|unique:users',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:6|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */

    protected function create(array $data)
    {
        $purchaseProgramid = $data['purchaseProgramid'] ? $data['purchaseProgramid'] : 0;

        $usertypestr = $data['usertype'];
        $usertype = 0;
        if($usertypestr == "ptuser")
        {
            $usertype = 1;
        }

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'user_type' => $usertype,
            'password' => bcrypt($data['password']),
            'user_firstlogin' => 1,
            'purchaseProgramid' => $purchaseProgramid
        ]);
        if($usertype == 1)
        {
            $userdetail = Ptinfo::create([
                'pt_userid' => $user->id,
                'pt_firstname' => '',
                'pt_lastname' => '',
                'pt_cardnumber' => '',
                'pt_expireYear' => 0,
                'pt_expireMonth' => 0,
                'pt_securitycode' => '',
                'pt_country' => '',
                'pt_state' => '',
                'pt_address' => '',
                'pt_address1' => '',
                'pt_city' => '',
                'pt_postalcode' => '',
                'pt_phonenumber' => '',
                'pt_contactname' => '',
                'pt_contactaddress' => '',
                'pt_contactcity' => '',
                'pt_contactcountry' => '',
                'pt_contactstate' => '',
                'pt_membership' => '0',

            ]);
        }

        return $user;
    }

    function ptregisterIndex()
    {
        $usertypedata = [
            'usertype' => 'ptuser'
        ];
        return view('auth.ptregister', compact('usertypedata'));
    }
}
