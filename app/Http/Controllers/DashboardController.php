<?php

namespace FitHabit\Http\Controllers;

use FitHabit\Ptinfo;
use FitHabit\User;
use FitHabit\UserProgram;
use Carbon\Carbon;
use Faker\Provider\DateTime;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use fx3costa\laravelchartjs;
use FitHabit\Program;
use Illuminate\Support\Facades\Auth;
use Stripe\Stripe;
use Illuminate\Support\Facades\DB;
use FitHabit\Http\Controllers\ProgramdateController;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');

        parent::__construct();
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

        $montharray = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];

        for($i = 1; $i <= 12; $i ++)
        {
            $signups = DB::table('userprograms')
                ->select('*', DB::raw('count(userprogram_id) as countsignups'), DB::raw("DATE_FORMAT(created_at, '%m-%Y') new_date"),  DB::raw('YEAR(created_at) year, MONTH(created_at) month'))
                ->where('userprogram_makerid', $user->id)
                ->where(DB::raw('YEAR(created_at)'), date("Y"))
                ->where(DB::raw('MONTH(created_at)'), $i)
                ->groupby('userprogram_userid')
                ->get();
            $signupcount = $signups->count();
            $montharray[$i - 1] = $signupcount;
        }

        $monthprogramsignup = 0;

        $thismonthpurchasedprograms = DB::table('userprograms')
            ->select('*', DB::raw("DATE_FORMAT(created_at, '%m-%Y') new_date"),  DB::raw('YEAR(created_at) year, MONTH(created_at) month'))
            ->where('userprogram_makerid', $user->id)
            ->where(DB::raw('YEAR(created_at)'), date("Y"))
            ->where(DB::raw('MONTH(created_at)'), date("m"))
            ->get();

        $monthprogramsignup = $thismonthpurchasedprograms->count();

        $workcount = 0;
        $nutcount = 0;
        $doccount = 0;

        foreach($thismonthpurchasedprograms as $purchasedprogram)
        {
            $programinfo = Program::where('program_id', $purchasedprogram->userprogram_programid)
                ->first();

            if ($programinfo) {
                if($programinfo->program_kind == 1)
                {
                    $workcount ++;
                }
                else if($programinfo->program_kind == 2)
                {
                    $nutcount ++;
                }
                else if($programinfo->program_kind == 3)
                {
                    $doccount ++;
                }
            }
        }



        $signupdata = [];
        $ytdsignup = 0;
        $monthsignup = 0;

        $curmonth = date("m");
        $monthsignup = $montharray[$curmonth - 1];

        if($montharray != [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0])
        {
            $signupdata = $montharray;
            foreach($montharray as $monthval)
            {
                $ytdsignup += $monthval;
            }
        }

        $chartjs = app()->chartjs
            ->name('ClientChart')
            ->type('line')
            ->element('lineChartTest')
            ->labels(['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'])
            ->datasets([
                [
                    "label" => "Signup",
                    'backgroundColor' => "rgba(65, 131, 215, 0.3)",
                    'borderColor' => "rgba(65, 131, 215, 0.7)",
                    "pointBorderColor" => "rgba(255, 255, 255, 0.7)",
                    "pointBackgroundColor" => "rgba(65, 131, 215, 0.7)",
                    "pointHoverBackgroundColor" => "#f00",
                    "pointHoverBorderColor" => "rgba(220,220,220,1)",
                    'data' => $signupdata,
                ],
                [
                    "label" => "Revenue (".date("Y").")",
                    'backgroundColor' => "rgba(77, 175, 124, 0.3)",
                    'borderColor' => "rgba(77, 175, 124, 0.7)",
                    "pointBorderColor" => "rgba(255, 255, 255, 0.7)",
                    "pointBackgroundColor" => "rgba(77, 175, 124, 0.7)",
                    "pointHoverBackgroundColor" => "#00f",
                    "pointHoverBorderColor" => "rgba(220,220,220,1)",
                    'data' => [],
                ]
            ]);

        $stripePubKey = $this->stripePubKey;
        return view('dashboard', compact('chartjs', 'showmodal', 'ytdsignup', 'monthsignup', 'monthprogramsignup','workcount', 'nutcount', 'doccount', 'stripePubKey'));
    }

    public function showSupport()
    {
        return view('support');
    }

    public function showaccountsettings()
    {
        Stripe::setApiKey($this->stripeSecureKey);
        $user = Auth::user();
        $userdetail = Ptinfo::where('pt_userid', $user->id)->first();
        $usersubscription = \FitHabit\Subscription::where('user_id', $user->id)->first();
        $stripeAccount =  \FitHabit\StripeAccounts::where('user_id', $user->id)->first();

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

        $stripePubKey = $this->stripePubKey;

        return view('accountsettings', compact('user','userdetail', 'BillingLabel', 'price', 'usersubscription', 'strdate', 'contactname', 'address', 'address1', 'zipcode', 'country', 'access_token', 'token_type', 'stripe_publishable_key', 'stripe_user_id', 'stripePubKey'));
    }

    public function showsignuplist()
    {
        $user = Auth::user();
        $userid = $user->id;

        $signups = DB::table('userprograms')
            ->select('*', DB::raw('count(userprogram_id) as countsignups'), DB::raw("DATE_FORMAT(created_at, '%m-%Y') new_date"),  DB::raw('YEAR(created_at) year, MONTH(created_at) month'))
            ->where('userprogram_makerid', $userid)
            ->where(DB::raw('YEAR(created_at)'), date("Y"))
            ->groupby('year','month')
            ->get();

        $montharray = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];

        foreach($signups as $signup)
        {
            $month = $signup->month;

            $montharray[$month - 1] = $signup->countsignups;
        }

        if($montharray == [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0])
        {
            $chartjs = app()->chartjs
                ->name('ClientChart')
                ->type('line')
                ->element('lineChartTest')
                ->labels(['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'])
                ->datasets([
                    [
                        "label" => "Signup (".date("Y").")",
                        'backgroundColor' => "rgba(248, 121, 121, 1.0)",
                        'borderColor' => "rgba(248, 121, 121, 1.0)",
                        "pointBorderColor" => "rgba(248, 121, 121, 1.0)",
                        "pointBackgroundColor" => "rgba(248, 121, 121, 1.0)",
                        "pointHoverBackgroundColor" => "#f87979",
                        "pointHoverBorderColor" => "rgba(255,0,0,1)",
                        //   'data' => [0, 0, 0, 0, 0, 0, 0],
                    ]
                ])
                ->options([]);
        }
        else
        {
            $chartjs = app()->chartjs
                ->name('ClientChart')
                ->type('line')
                ->element('lineChartTest')
                ->labels(['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'])
                ->datasets([
                    [
                        "label" => "Signup (".date("Y").")",
                        'backgroundColor' => "rgba(248, 121, 121, 1.0)",
                        'borderColor' => "rgba(248, 121, 121, 1.0)",
                        "pointBorderColor" => "rgba(248, 121, 121, 1.0)",
                        "pointBackgroundColor" => "rgba(248, 121, 121, 1.0)",
                        "pointHoverBackgroundColor" => "#f87979",
                        "pointHoverBorderColor" => "rgba(255,0,0,1)",
                        'data' => $montharray,
                    ]
                ])
                ->options([]);
        }

        return view('signuplist', compact('chartjs', 'user'));
    }

    public function showclientoverview(Request $request)
    {
        $input = $request->all();
        $userid = $input["clientId"];
        $maker = Auth::user();
        $userinfo = User::where('id', $userid)->first();

        $clientprograms = UserProgram::where('userprogram_userid', $userid)
            ->where('userprogram_makerid', $maker->id)
            ->where('userprogram_activestatus', 1)
            ->get();

        $activeprogram = "";
        $activenutritionprogram = "";
        $workoutpercent = 0;
        $nutritionpercent = 0;
        $strdate = "";
        $nutdate = "";

        $accuracy = "0.00";
        $fiddays = "0";
        $misseddays = "0";
        $restdays = "0";

        $curWeekDayInfo = ['#34495E', '#34495E', '#34495E', '#34495E', '#34495E', '#34495E', '#34495E'];

        if($clientprograms->count() > 0)
        {
            foreach($clientprograms as $clientprogram)
            {
                $program = Program::where('program_id', $clientprogram->userprogram_programid)->first();

                if($program->program_kind == 1)
                {
                    $workoutpercent = $clientprogram->userprogram_progress;
                    $activeprogram = $program;

                    $accuracy = (string)$clientprogram->userprogram_accuracy;
                    $fiddays = (string)$clientprogram->userprogram_completeday;
                    $misseddays = (string)$clientprogram->userprogram_missedday;
                    $restdays = (string)$clientprogram->userprogram_restday;

                    if($clientprogram->userprogram_startdate == "")
                    {
                        $strdate = "";
                    }
                    else
                    {
                        $date = new Carbon($clientprogram->userprogram_startdate);
                        $strdate = $date->format('m/d/Y');
                        $curDate = Carbon::now();
                        $curWeekDayInfo = ProgramdateController::getCurWeekInfos($date, $curDate, $clientprogram->userprogram_programid, $userid);
                    }
                }
                else
                {
                    $nutritionpercent = $clientprogram->userprogram_progress;
                    $activenutritionprogram = $program;
                    if($clientprogram->userprogram_startdate == "")
                    {
                        $nutdate = "";
                    }
                    else
                    {
                        $date = new Carbon($clientprogram->userprogram_startdate);
                        $nutdate = $date->format('m/d/Y');
                    }
                }
            }
        }


        $unactivePrograms = UserProgram::where('userprogram_userid', $userid)
            ->where('userprogram_makerid', $maker->id)
            ->where('userprogram_activestatus', 0)
            ->get();
        $unactprogram = "";
        $retPrograms = new Collection();
        if($unactivePrograms->count() > 0) {
            foreach ($unactivePrograms as $unatvieProgram)
            {
                $programItem = Program::where('program_id', $unatvieProgram->userprogram_programid)->first();
                if($programItem != null)
                {
                    $retPrograms->add($programItem);
                }
            }
            $unactprogram = $retPrograms;
        }

        return view('clientoverview', compact('workoutpercent', 'nutritionpercent', 'userinfo', 'activeprogram', 'strdate', 'activenutritionprogram', 'nutdate',  'accuracy', 'fiddays', 'misseddays','restdays', 'unactprogram','currentWeekDays', 'curWeekDayInfo' ));
    }

    public function showmyprograms()
    {
        $user = Auth::user();
        $userid = $user->id;

        return view('myPrograms',compact('user'));
    }
}
