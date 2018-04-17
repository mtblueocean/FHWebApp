<?php

namespace FitHabit\Http\Controllers;

use FitHabit\Ptinfo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use FitHabit\User;
use Stripe\Stripe;
use Stripe\Subscription;
use FitHabit\StripeAccounts;
use Illuminate\Support\Facades\Hash;

class AccountController extends Controller
{
    //
    public function __construct()
    {
        Stripe::setApiKey($this->stripeSecureKey);
        $this->middleware('auth');

        parent::__construct();
    }


    public function changePassword(Request $request)
    {
        $user = Auth::user();
        $curPassword = $request->curPassword;
        $newPassword = $request->newPassword;

        if (Hash::check($curPassword, $user->password)) {
            $user_id = $user->id;
            $obj_user = User::find($user_id)->first();
            $obj_user->password = Hash::make($newPassword);
            $obj_user->save();

            return response()->json(["result"=>true]);
        }
        else
        {
            return response()->json(["result"=>false]);
        }
    }

    function changebilling(Request $request)
    {
        $userid = Auth::user()->id;
        $user = User::where('id', $userid)->first();
        $stripeToken = $request['stripeToken'];

        if($user->subscribed('plan1'))
        {
            $user->updateCard($stripeToken);
        }
        else if($user->subscribed('plan2'))
        {
            $user->updateCard($stripeToken);
        }

        $firstname = $request['firstname'];
        $lastname = $request['lastname'];
        $cardnumber = $request['cardnumber'];
        $expiremonth = $request['expiremonth'];
        $expireyear = $request['expireyear'];
        $securitycode = $request['securitycode'];
        $country = $request['country'];
        $state = $request['state'];
        $address1 = $request['address1'];
        $address2 = $request['address2'];
        $city = $request['city'];
        $postalcode = $request['postalcode'];
        $phonenumber = $request['phonenumber'];

        $billinginfo = Ptinfo::where('pt_userid', $userid)->first();

        $billinginfo->pt_firstname = $firstname;
        $billinginfo->pt_lastname = $lastname;
        $billinginfo->pt_cardnumber = $cardnumber;
        $billinginfo->pt_expireYear = $expireyear;
        $billinginfo->pt_expireMonth = $expiremonth;
        $billinginfo->pt_securitycode = $securitycode;
        $billinginfo->pt_country = $country;
        $billinginfo->pt_state = $state;
        $billinginfo->pt_address = $address1;
        $billinginfo->pt_address1 = $address2;
        $billinginfo->pt_city = $city;
        $billinginfo->pt_postalcode = $postalcode;
        $billinginfo->pt_phonenumber = $phonenumber;

        $billinginfo->save();

        return response()->json(["result"=>true]);
    }

    function userdetailIndex()
    {
        $userid = Auth::user()->id;
        $ptinfo = Ptinfo::where('pt_userid', $userid)->first();

        return response()->json($ptinfo);
    }

    function changecontact(Request $request)
    {
        $userid = Auth::user()->id;

        $name = $request['name'];
        $address = $request['address'];
        $city = $request['city'];
        $country = $request['country'];
        $state = $request['state'];

        $contactinfo = Ptinfo::where('pt_userid', $userid)->first();

        $contactinfo->pt_contactname = $name;
        $contactinfo->pt_contactaddress = $address;
        $contactinfo->pt_contactcity = $city;
        $contactinfo->pt_contactcountry = $country;
        $contactinfo->pt_contactstate = $state;

        $contactinfo->save();

        return response()->json(["result"=>"true"]);
    }

    function Downgrade(Request $request)
    {
        $user = Auth::user();
        $subscriptInfo = \FitHabit\Subscription::where('user_id', $user->id)->first();
        if($subscriptInfo->name == "plan1")
        {
            $user->subscription('plan1')->cancelNow();
            $user->user_type = 0;
            $user->save();

            return response()->json(["result"=>true]);
        }
        else if($subscriptInfo->name == "plan2")
        {
            $user->subscription('plan2')->cancelNow();
            $user->user_type = 0;
            $user->save();

            return response()->json(["result"=>true]);
        }
        return response()->json(["result"=>false]);
    }

    public function orderPost(Request $request)
    {
        $userid = Auth::user()->id;
        $user = User::find($userid);
        $input = $request->all();
        $stripeToken = $request->input('stripeToken');

        try {
            $user->subscription($input['plane'])->create($stripeToken,[
                'email' => $user->email
            ]);
            return back()->with('success','Subscription is completed.');
        } catch (Exception $e) {
            return back()->with('success',$e->getMessage());
        }
    }

    public function CreateSubscription(Request $request)
    {
        $userid = Auth::user()->id;
        $user = User::find($userid);
        $ptinfo = Ptinfo::where('pt_userid', $userid)->first();

        $stripeToken = $request->input('stripeToken');

        if(!$user->subscribed('plan1'))
        {
            $user->newsubscription('plan1', 'plan1')->trialDays(14)->create($stripeToken);

            $userfirstname = $request->input('fstname');
            $userlastname = $request->input('lstname');
            $zipcode = $request->input('zipcode');
            $cardnumber = $request->input('cnum');
            $expYear = $request->input('expYear');
            $expMonth = $request->input('expMonth');
            $code = $request->input('code');

            $ptinfo->pt_firstname = $userfirstname;
            $ptinfo->pt_lastname = $userlastname;
            $ptinfo->pt_cardnumber = $cardnumber;
            $ptinfo->pt_postalcode = $zipcode;
            $ptinfo->pt_expireYear = $expYear;
            $ptinfo->pt_expireMonth = $expMonth;
            $ptinfo->pt_securitycode = $code;
            $ptinfo->save();

            $user->user_firstlogin = 0;
            $user->save();
        }
        return redirect('\dashboard');
    }


    public function stripeConnect(Request $request)
    {
      if ($request->code)
      {
        $token_request_body = array(
          'client_secret' => env('STRIPE_SECRET'),
          'grant_type' => 'authorization_code',
          'client_id' => env('STRIPE_CLIENT_ID'),
          'code' => $request->code,
        );

        $req = curl_init(env('STRIPE_TOKEN_URI'));
        $certPath = "/js/ca.pem";

        curl_setopt($req, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($req, CURLOPT_POST, true );
        curl_setopt($req, CURLOPT_POSTFIELDS, http_build_query($token_request_body));
        curl_setopt($req, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($req, CURLOPT_CAINFO, $certPath);

        $respCode = curl_getinfo($req, CURLINFO_HTTP_CODE);
        $resp = json_decode(curl_exec($req), true);
        curl_close($req);

            if (isset($resp['access_token']))
            {
                $data['user_id'] = \Auth::id();
                $data['token_type'] = $resp['token_type'];
                /*$data['stripe_publishable_key'] = $resp['stripe_publishable_key'];
                $data['stripe_user_id'] = $resp['stripe_user_id'];*/

                $StripeAccounts = StripeAccounts::updateOrCreate($data);
                $StripeAccounts->stripe_publishable_key = $resp['stripe_publishable_key'];
                $StripeAccounts->stripe_user_id = $resp['stripe_user_id'];
                $StripeAccounts->access_token = $resp['access_token'];
                $StripeAccounts->livemode = $resp['livemode'];
                $StripeAccounts->refresh_token = $resp['refresh_token'];
                $StripeAccounts->scope = $resp['scope'];
                $StripeAccounts->save();

                return redirect('accountsetting');
            }
            else if(isset($resp['error']))
            {
                echo $resp['error_description'];
            }
            else
            {
                echo "Oops something went wrong, please try agin";
            }
      }
      else
      {
        $authorize_request_body = array(
            'response_type' => 'code',
            'scope' => 'read_write',
            'client_id' => env('STRIPE_CLIENT_ID')
        );
        $url = env('STRIPE_AUTHORIZE_URI') . '?' . http_build_query($authorize_request_body);
        return redirect($url);
      }
    }

    public function changeProfilePic(Request $request)
    {
        $userid = Auth::user()->id;
        $user = User::where('id', $userid)->first();

        if($request->hasFile('photo')) {
            $fileName = 'profile'.$userid. '.' .
                $request->file('photo')->getClientOriginalExtension();

            $request->file('photo')->move(
                base_path() . '/public/images/dashboard/profilepic/'.$userid.'/', $fileName
            );

            $url = 'images/dashboard/profilepic/'.$userid.'/'.$fileName;
            $user->user_profilepicurl = $url;
            $user->save();
            return response()->json(['result'=>true]);
        }

        return response()->json(['result'=>false]);
    }

    public function changeBioInfo(Request $request)
    {
        $bioinfo = $request->input("newBio");
        $userid = Auth::user()->id;
        $user = User::where('id', $userid)->first();
        $user->user_bioinfo = $bioinfo;
        $user->save();
        return response()->json(['result'=>true]);
    }
}
