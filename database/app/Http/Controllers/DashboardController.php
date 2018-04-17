<?php

namespace App\Http\Controllers;

use App\Ptinfo;
use Carbon\Carbon;
use Faker\Provider\DateTime;
use Illuminate\Http\Request;
use fx3costa\laravelchartjs;
use App\Program;
use Illuminate\Support\Facades\Auth;
use Stripe\Stripe;
class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        $showmodal = "no";

        if($user->user_firstlogin == 1 && $user->user_type == 1)
        {
            $showmodal = "yes";
        }

        $chartjs = app()->chartjs
            ->name('ClientChart')
            ->type('line')
            ->element('lineChartTest')
            ->labels(['January', 'February', 'March', 'April', 'May', 'June', 'July'])
            ->datasets([
                [
                    "label" => "SignUps",
                    'backgroundColor' => "rgba(65, 131, 215, 0.3)",
                    'borderColor' => "rgba(65, 131, 215, 0.7)",
                    "pointBorderColor" => "rgba(255, 255, 255, 0.7)",
                    "pointBackgroundColor" => "rgba(65, 131, 215, 0.7)",
                    "pointHoverBackgroundColor" => "#f00",
                    "pointHoverBorderColor" => "rgba(220,220,220,1)",
                    'data' => [65, 40, 80, 81, 56, 55, 40],
                ],
                [
                    "label" => "Revenue",
                    'backgroundColor' => "rgba(77, 175, 124, 0.3)",
                    'borderColor' => "rgba(77, 175, 124, 0.7)",
                    "pointBorderColor" => "rgba(255, 255, 255, 0.7)",
                    "pointBackgroundColor" => "rgba(77, 175, 124, 0.7)",
                    "pointHoverBackgroundColor" => "#00f",
                    "pointHoverBorderColor" => "rgba(220,220,220,1)",
                    'data' => [40, 33, 44, 44, 90, 23, 80],
                ]
            ])
            ->options([]);
        return view('dashboard', compact('chartjs', 'showmodal'));
    }

    public function showSupport()
    {
        return view('support');
    }

    public function showaccountsettings()
    {
        Stripe::setApiKey("sk_test_uzKnCrEhFpzNAanHjnqI5c0U");
        $user = Auth::user();
        $userdetail = Ptinfo::where('pt_userid', $user->id)->first();
        $usersubscription = \App\Subscription::where('user_id', $user->id)->first();
        $stripeAccount =  \App\StripeAccounts::where('user_id', $user->id)->first();

        $BillingLabel = "";
        $price = "0.00";
        if($user->onTrial())
        {
            $BillingLabel = "Trial";
        }
        else
        {
            if($user->subscribed('plan1'))
            {
                if($user->subscription('plan1')->onTrial())
                {
                    $BillingLabel = "Trial";
                    $price = "0.00";
                }
                else
                {
                    $BillingLabel = "Monthly";
                    $price = "10.00";
                }
            }
            else if($user->subscribed('plan2'))
            {
                if($user->subscription('plan2')->onTrial())
                {
                    $BillingLabel = "Trial";
                    $price = "0.00";
                }
                else
                {
                    $BillingLabel = "Annual";
                    $price = "10.00";
                }
            }
        }

        $date = new Carbon($user->created_at);
        $strdate = $date->format('m/d/Y');

        $contactname = "";
        if($userdetail->pt_contactname != "")
        {
            $contactname = "Mr.".$userdetail->pt_contactname;
        }
        $address = "";
        if($userdetail->pt_contactaddress != "")
        {
            $address = $userdetail->pt_contactaddress;
        }
        $address1 = "";

        if($userdetail->pt_contactcity != "")
        {
            $address1 = $userdetail->pt_contactcity;
        }

        if($userdetail->pt_contactstate != "")
        {
            if($address1 == "")
            {
                $address1 = $userdetail->pt_contactstate;
            }
            else
            {
                $address1 = $address1.", ".$userdetail->pt_contactstate;
            }
        }
        $zipcode = "";

        if($userdetail->pt_postalcode != "")
        {
            $zipcode = $userdetail->pt_postalcode;
        }

        $country = "";
        if($userdetail->pt_contactcountry != "")
        {
            $country = $userdetail->pt_contactcountry;
        }


        $access_token = "";
        $token_type = "";
        $stripe_publishable_key = "";
        $stripe_user_id = "";

        if($stripeAccount)
        {
          $access_token = $stripeAccount->access_token;
          $token_type = $stripeAccount->token_type;
          $stripe_publishable_key = $stripeAccount->stripe_publishable_key;
          $stripe_user_id = $stripeAccount->stripe_user_id;
        }

        return view('accountsettings', compact('user','userdetail', 'BillingLabel', 'price', 'usersubscription', 'strdate', 'contactname', 'address', 'address1', 'zipcode', 'country', 'access_token', 'token_type', 'stripe_publishable_key', 'stripe_user_id'));
    }

    public function showsignuplist()
    {
        return view('signuplist');
    }

    public function showclientoverview()
    {
        $workoutpercent = 28;
        $nutritionpercent = 78.5;
        return view('clientoverview', compact('workoutpercent', 'nutritionpercent'));
    }

    public function showmyprograms()
    {
        $user = Auth::user();
        $userid = $user->id;

        return view('myPrograms',compact('user'));
    }
}
