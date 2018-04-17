<?php

namespace App\Http\Controllers;

use App\UserProgram;
use Illuminate\Http\Request;
use App\Program;
use Illuminate\Support\Facades\Auth;
use Stripe\Stripe;
use App\User;

class FinderController extends Controller
{
    //
    public function __construct()
    {
        Stripe::setApiKey("sk_test_uzKnCrEhFpzNAanHjnqI5c0U");
        $this->middleware('auth');
    }

    public function Index()
    {
        $user = Auth::user();
        $userprograms = UserProgram::where('userprogram_userid', $user->id)->get();

        $workoutprograms = Program::where('program_type', 1)
            ->where('program_kind', 1)
            ->where('program_ispublished', 1)
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

        return view('ProgramFinder/FinderIndex', compact('workoutprograms', 'nutritionprograms', 'infodocprograms'));
    }

    public function WorkoutIndex()
    {

        $programs = Program::where('program_type', 1)
            ->where('program_kind', 1)
            ->where('program_ispublished', 1)
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

    public function NutritionIndex()
    {
        $programs = Program::where('program_type', 1)
            ->where('program_kind', 2)
            ->where('program_ispublished', 1)
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

    public function InfodocIndex()
    {
        $programs = Program::where('program_type', 1)
            ->where('program_kind', 3)
            ->where('program_ispublished', 1)
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
        return view('ProgramFinder/PurchaseProgram', compact('program', 'programtype'));
    }

    public function PurchaseProcess(Request $request)
    {
        \Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
        $user = Auth::user();
        $programid = $request->input('programId');
        $stripeToken = $request['stripeToken'];
        $program = Program::where('program_id', $programid)->first();
        $programmakerid = $program->program_maker;
        $programmaker = User::where('id', $programmakerid)->first();
        $stripeid = $programmaker->stripe_id;

        $price = floatval($program->program_price);

        $commissionPercentage = '6';
        $commissionPercentageAmount = round($price * $commissionPercentage / 100) + 1;
        $sellerFinalPrice = $price - $commissionPercentageAmount;

        $sellerStripeDetails =  $programmaker->stripeDetails;
        $sellerStripeAccount = $sellerStripeDetails["stripe_user_id"];
        $descriptionString = "";

        $descriptionString = $user->email." purchased program".$program->program_name." from ".$programmaker->email;

        $charge = \Stripe\Charge::create(array(
            "amount" => $price * 100,
            "currency" => "usd",
            "source" => $stripeToken['id'],
            "application_fee" => $commissionPercentageAmount*100,
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
        return Auth::user() && \App\User::where('id', Auth::user()->id)->whereNotNull('stripe_id')->first();
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
