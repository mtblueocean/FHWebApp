<?php

namespace FitHabit\Http\Controllers;

use FitHabit\UserProgram;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use FitHabit\Program;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Stripe\Collection;
use Stripe\Stripe;
use FitHabit\User;
use Illuminate\Support\Facades\DB;

class FinderController extends Controller
{
    //
    public function __construct()
    {
        Stripe::setApiKey($this->stripeSecureKey);
        //$this->middleware('auth');

        parent::__construct();
    }

    public function LinkIndex($programlink)
    {
        $program = Program::where('program_link', $programlink)->first();
        $purchaseProgramid = $program->program_id;

        if (Auth::guest()) { // When not logged in.
            return Redirect::route('register', array('purchaseProgramid' => $purchaseProgramid));
        } else {
            return Redirect::route('directlink', array('purchaseProgramid' => $purchaseProgramid));
        }

        return Redirect::route('directlink', array('purchaseProgramid' => $purchaseProgramid));
    }

    public function userprogramIndex(Request $request)
    {
        $searchName = $request->input('q');
        $user = Auth::user();
        $userid = $user->id;

        $userprograms = UserProgram::where('userprogram_userid', $userid)->get();


        $workoutprograms = new \Illuminate\Database\Eloquent\Collection();
        $nutritionprograms = new \Illuminate\Database\Eloquent\Collection();
        $infodocprograms = new \Illuminate\Database\Eloquent\Collection();

        foreach ($userprograms as $userprogram) {
            $addedprogram = $userprogram->program;
            $addedprogram['program_purchased'] = 1;

            $searchName = strtolower($searchName);
            $programname = strtolower($addedprogram->program_name);

            if($addedprogram->program_kind == 1)
            {
                if($searchName != "")
                {
                    if (strpos($programname, $searchName) !== false) {
                        $workoutprograms->add($addedprogram);
                    }
                }
                else
                {
                    $workoutprograms->add($addedprogram);
                }

            }
            else if($addedprogram->program_kind == 2)
            {
                if($searchName != "")
                {
                    if (strpos($programname, $searchName) !== false) {
                        $nutritionprograms->add($addedprogram);
                    }
                }
                else {
                    $nutritionprograms->add($addedprogram);
                }
            }
            else if($addedprogram->program_kind == 3)
            {
                if($searchName != "")
                {
                    if (strpos($programname, $searchName) !== false) {
                        $infodocprograms->add($addedprogram);
                    }
                }
                else {
                    $infodocprograms->add($addedprogram);
                }
            }
        }
        $fromindex = 0;
        return view('ProgramFinder/FinderIndex', compact('workoutprograms', 'nutritionprograms', 'infodocprograms', 'fromindex'));
    }

    public function Index(Request $request)
    {
        $searchName = $request->input('q');
        $user = Auth::user();
        $userprograms = UserProgram::where('userprogram_userid', $user->id)->get();

        $workoutprograms = Program::where('program_type', 1)
            ->where('program_kind', 1)
            ->where('program_ispublished', 1)
            ->where('program_name', 'LIKE', '%'.$searchName.'%')
            ->orderBy('program_soldcount', 'desc')
            ->limit(6)
            ->get();

        foreach($workoutprograms as $workoutprogram)
        {
            $workoutprogram['program_purchased'] = 0;
            foreach($userprograms as $userprogram)
            {

                if($workoutprogram->program_id == $userprogram->userprogram_programid)
                {
                    $workoutprogram['program_purchased'] = 1;

                    break;
                }
            }
        }


        $nutritionprograms = Program::where('program_type', 1)
            ->where('program_kind', 2)
            ->where('program_ispublished', 1)
            ->where('program_name', 'LIKE', '%'.$searchName.'%')
            ->orderBy('program_soldcount', 'desc')
            ->limit(6)
            ->get();

        foreach($nutritionprograms as $nutritionprogram)
        {
            $nutritionprogram['program_purchased'] = 0;
            foreach($userprograms as $userprogram)
            {
                if($userprogram->userprogram_programid == $nutritionprogram->program_id)
                {
                    $nutritionprogram['program_purchased'] = 1;
                    break;
                }
            }
        }

        $infodocprograms = Program::where('program_type', 1)
            ->where('program_kind', 3)
            ->where('program_ispublished', 1)
            ->where('program_name', 'LIKE', '%'.$searchName.'%')
            ->orderBy('program_soldcount', 'desc')
            ->limit(6)
            ->get();

        foreach($infodocprograms as $infodocprogram)
        {
            $infodocprogram['program_purchased'] = 0;
            foreach($userprograms as $userprogram)
            {
                if($userprogram->userprogram_programid == $infodocprogram->program_id)
                {
                    $infodocprogram['program_purchased'] = 1;
                    break;
                }
            }
        }

        $fromindex = 1;
        return view('ProgramFinder/FinderIndex', compact('workoutprograms', 'nutritionprograms', 'infodocprograms', 'fromindex'));
    }

    public function WorkoutIndex(Request $request)
    {
        $searchName = $request->input('q');

        $programs = Program::where('program_type', 1)
            ->where('program_kind', 1)
            ->where('program_ispublished', 1)
            ->where('program_name', 'LIKE', '%'.$searchName.'%')
            ->orderBy('program_soldcount', 'desc')
            ->limit(42)
            ->get();

        $user = Auth::user();
        $userprograms = UserProgram::where('userprogram_userid', $user->id)->get();

        foreach($programs as $program)
        {
            $program['program_purchased'] = 0;
            foreach($userprograms as $userprogram)
            {

                if($program->program_id == $userprogram->userprogram_programid)
                {
                    $program['program_purchased'] = 1;
                    break;
                }
            }
        }

        $programtype = "Workout";
        return view('ProgramFinder/AllIndex', compact('programs', 'programtype'));
    }

    public function NutritionIndex(Request $request)
    {
        $searchName = $request->input('q');

        $programs = Program::where('program_type', 1)
            ->where('program_kind', 2)
            ->where('program_ispublished', 1)
            ->where('program_name', 'LIKE', '%'.$searchName.'%')
            ->orderBy('program_soldcount', 'desc')
            ->limit(42)
            ->get();

        $user = Auth::user();
        $userprograms = UserProgram::where('userprogram_userid', $user->id)->get();

        foreach($programs as $program)
        {
            $program['program_purchased'] = 0;
            foreach($userprograms as $userprogram)
            {

                if($program->program_id == $userprogram->userprogram_programid)
                {
                    $program['program_purchased'] = 1;
                    break;
                }
            }
        }

        $programtype = "Nutrition";
        return view('ProgramFinder/AllIndex', compact('programs', 'programtype'));
    }

    public function InfodocIndex(Request $request)
    {
        $searchName = $request->input('q');

        $programs = Program::where('program_type', 1)
            ->where('program_kind', 3)
            ->where('program_ispublished', 1)
            ->where('program_name', 'LIKE', '%'.$searchName.'%')
            ->orderBy('program_soldcount', 'desc')
            ->limit(42)
            ->get();

        $user = Auth::user();
        $userprograms = UserProgram::where('userprogram_userid', $user->id)->get();

        foreach($programs as $program)
        {
            $program['program_purchased'] = 0;
            foreach($userprograms as $userprogram)
            {

                if($program->program_id == $userprogram->userprogram_programid)
                {
                    $program['program_purchased'] = 1;
                    break;
                }
            }
        }

        $programtype = "InfoDoc";
        return view('ProgramFinder/AllIndex', compact('programs', 'programtype'));
    }

    public function PurchaseIndex(Request $request)
    {
        $programid = $request->input('purchaseProgramid');
        if($programid == "")
        {
            return redirect('/');
        }
        $program= Program::where('program_id', $programid)->first();

        $programtype = "";
        switch($program->program_kind)
        {
            case 1:
                $programtype = "Workout";
                break;
            case 2:
                $programtype = "Nutrition";
                break;
            case 3:
                $programtype = "InfoDoc";
                break;
            default:
                break;
        }

        // Get the stripe publishable key for local and live site.
        if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') { // In case of windows server.
            $stripePubKey = 'pk_test_gzBKWQ1XzvYovh2Ox7enuC7W';
        } else {
            $stripePubKey = 'pk_live_DgYMe7qp2ksF8rR06ioIeAkk'; // Live Mode
        }

        return view('ProgramFinder/PurchaseProgram', compact('program', 'programtype', 'stripePubKey'));
    }

    public function PurchaseProcess(Request $request)
    {
        // Get the stripe publishable key for local and live site.
        if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') { // In case of windows server.
            $stripeSecureKey = 'sk_test_th2NqY6ZybETfOiGhjA3V6bT';
        } else {
            $stripeSecureKey = 'sk_live_MS8y9Uan1lY9tpHQZJMjsKEM'; // Live Mode
        }

        \Stripe\Stripe::setApiKey($stripeSecureKey);
        $user = Auth::user();
        $programid = $request->input('programId');
        $stripeToken = $request['stripeToken'];
        $program = Program::where('program_id', $programid)->first();
        $programmakerid = $program->program_maker;
        $programmaker = User::where('id', $programmakerid)->first();
        $stripeid = $programmaker->stripe_id;

        $price = floatval($program->program_price);

        $commissionPercentage = '6';
        $commissionPercentageAmount = $price * $commissionPercentage / 100 + 1;
        $sellerFinalPrice = $price - $commissionPercentageAmount;

        $sellerStripeDetails =  $programmaker->stripeDetails;
        $sellerStripeAccount = $sellerStripeDetails["stripe_user_id"];

        $descriptionString = "";

        $descriptionString = $user->email." purchased program".$program->program_name." from ".$programmaker->email;

        $sellerStripeAccount = 'acct_17lmXfBwdM1LkuG7';// Connected user ID on live mode.

        $charge = \Stripe\Charge::create(array(
            "amount" => ceil($price * 100),
            "currency" => "usd",
            "source" => $stripeToken['id'],
            "application_fee" => ceil($commissionPercentageAmount*100),
            "description" => $descriptionString,
        ), array("stripe_account" => $sellerStripeAccount));

        if($charge["status"] == "succeeded")
        {
            //UserProgram::create()

            return response()->json(['result'=>true, 'data'=>$charge]);
        }
        else
        {
            return response()->json(['result'=>false, 'data'=>$charge]);
        }

    }

    public function PurchaseFinish(Request $request)
    {
        $programid = $request->input('purchaseProgramid');
        $program= Program::where('program_id', $programid)->first();
        $programtype = "";
        $user = Auth::user();
        $programmakerid = $program->program_maker;

        switch($program->program_kind)
        {
            case 1:
                $programtype = "Workout";
                $sqlQuery = "INSERT INTO clientworkouts (  clientworkout_userid ".
				            ",clientworkout_programid".
                            ",clientworkout_workoutid".
                            ",clientworkout_week".
                            ",clientworkout_day".
                            ",clientworkout_daytype".
                            ",clientworkout_extype".
                            ",clientworkout_musclegroup".
                            ",clientworkout_exname".
                            ",clientworkout_exid".
                            ",clientworkout_order".
                            ",clientworkout_sets".
                            ",clientworkout_setcontent ".
                            ") ".
                            "SELECT ".$user->id." AS ".
                            "workout_userid, ".
                            "workout_programid, ".
                            "workout_id, ".
                            "workout_week, ".
                            "workout_day, ".
                            "workout_daytype, ".
                            "workout_extype, ".
                            "workout_musclegroup, ".
                            "workout_exname, ".
                            "workout_exid, ".
                            "workout_order, ".
                            "workout_sets, ".
                            "workout_setcontent ".
                            "FROM workouts ".
                            "WHERE workout_programid = ". $programid;
                            $result = DB::select(DB::raw($sqlQuery));
                break;
            case 2:
                $programtype = "Nutrition";
                $sqlQuery = "INSERT INTO clientnutritions (  clientnutrition_userid ".
                    ",clientnutrition_programid".
                    ",clientnutrition_foodid".
                    ",clientnutrition_week".
                    ",clientnutrition_day".
                    ",clientnutrition_daytype".
                    ",clientnutrition_mealtype".
                    ",clientnutrition_foodname".
                    ",clientnutrition_foodunit".
                    ",clientnutrition_foodquantity".
                    ",clientnutrition_protein".
                    ",clientnutrition_fat".
                    ",clientnutrition_carbs".
                    ",clientnutrition_calories".
                    ",clientnutrition_order".
                    ") ".
                    "SELECT ".$user->id." AS food_userid, ".
                    "food_programid, ".
                    "food_id, ".
                    "food_week, ".
                    "food_day, ".
                    "food_daytype, ".
                    "food_mealtype, ".         //foodname,foodunit
                    "food_name, ".
                    "food_quantitytype, ".
                    "food_quantity, ".
                    "food_protein, ".
                    "food_fat, ".
                    "food_carbs, ".
                    "food_calories, ".
                    "food_order ".
                    "FROM foods ".
                    "WHERE food_programid = ". $programid;
                $result = DB::select(DB::raw($sqlQuery));
                break;
            case 3:
                $programtype = "InfoDoc";
                break;
            default:
                break;
        }

        $userprogram = UserProgram::create([
            'userprogram_userid' => $user->id,
            'userprogram_programid' => $programid,
            'userprogram_activestatus' => 0,
            'userprogram_makerid' => $programmakerid,
        ]);

        return view('ProgramFinder/PurchaseFinish', compact('program', 'programtype'));
    }

/*
    public function postPayWithStripe()
    {
        return $this->chargeCustomer($program->id, $program->price, $program->name, $request->input('stripeToken'));
    }

    public function chargeCustomer($programid, $programprice, $programname, $token)
    {
        \Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));

        if (!$this->isStripeCustomer())
        {
            $customer = $this->createStripeCustomer($token);
        }
        else
        {
            $customer = \Stripe\Customer::retrieve(Auth::user()->stripe_id);
        }

        return $this->createStripeCharge($programid, $programprice, $programname, $customer);
    }

    public function createStripeCharge($programid, $programprice, $programname, $customer)
    {
        try {
            $charge = \Stripe\Charge::create(array(
                "amount" => $programprice,
                "currency" => "usd",
                "customer" => $customer->id,
                "description" => $programname
            ));
        } catch(\Stripe\Error\Card $e) {
            return redirect()
                ->route('index')
                ->with('error', 'Your credit card was been declined. Please try again or contact us.');
        }

        return $this->postStoreOrder($programname);
    }

    public function createStripeCustomer($token)
    {
        \Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));

        $customer = \Stripe\Customer::create(array(
            "description" => Auth::user()->email,
            "source" => $token
        ));

        Auth::user()->stripe_id = $customer->id;
        Auth::user()->save();

        return $customer;
    }

    public function isStripeCustomer()
    {
        return Auth::user() && \FitHabit\User::where('id', Auth::user()->id)->whereNotNull('stripe_id')->first();
    }

    public function postStoreOrder($product_name)
    {
        Order::create([
            'email' => Auth::user()->email,
            'product' => $product_name
        ]);

        return redirect('/')->with('msg', 'Thanks for your purchase!');
    }*/
}
