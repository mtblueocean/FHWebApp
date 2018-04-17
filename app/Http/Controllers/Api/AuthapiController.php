<?php

namespace FitHabit\Http\Controllers\Api;

use FitHabit\Clientnutrition;
use FitHabit\Clientworkout;
use FitHabit\Doc;
use FitHabit\Program;
use FitHabit\Userbodyfat;
use FitHabit\UserProgram;
use FitHabit\Userweight;
use Illuminate\Http\Request;
use FitHabit\Http\Controllers\Controller;
use FitHabit\User;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;
use Exception;
use Illuminate\Database\Eloquent\Collection;
class AuthapiController extends Controller
{
    //

    public function reserveregister(Request $request)
    {
        $input = $request->all();
        $input['password'] = Hash::make($input['password']);
        $user = User::create([
            'name' => $input['name'],
            'email' => $input['email'],
            'user_type' => 1,
            'user_firstlogin' => 1,
            'password' => $input['password'],
        ]);
        //return redirect('http://127.0.0.1:8000');
        return redirect('http://fithabit.io/reserved.php');
    }

    public function register(Request $request)
    {
        $input = $request->all();
        $input['password'] = Hash::make($input['password']);
        $user = User::create([
            'name' => $input['name'],
            'email' => $input['email'],
            'user_type' => 0,
            'password' => $input['password'],
        ]);

        return response()->json(['result'=>true]);
    }

    public function login(Request $request)
    {
        $input = $request->all();
        if (!$token = JWTAuth::attempt($input)) {
            return response()->json(['result' => false, 'message' => 'Incorrect Credential Info.']);
        }

        $user = JWTAuth::toUser($token);

        if($user->user_type)
        {
            return response()->json(['result' => false, 'message' => 'PT Can not login.']);
        }

        $userpurchasedprograms = UserProgram::where('userprogram_userid', $user->id)->get();
        //$user->userpurchasedprogram;
        $retcollection = new Collection();

        $activeworkoutinfo = [];
        $activenutritioninfo = [];
        $docinfo = new Collection();

        foreach($userpurchasedprograms as $userpurchasedprogram)
        {
            $userpurchasedprograminfo = $userpurchasedprogram->program;
            $maker = User::where('id', $userpurchasedprogram->userprogram_makerid)->first();
            $makername = "";
            if($maker != null)
            {
                $makername = $maker->name;
            }
            $userprograminfo = [
                'program' => $userpurchasedprograminfo,
                'active' => $userpurchasedprogram->userprogram_activestatus,
                'startdate' => $userpurchasedprogram->userprogram_startdate,
                'remainingdays' => $userpurchasedprogram->userprogram_remainingday,
                'progress' => $userpurchasedprogram->userprogram_progress,
                'accuracy' => $userpurchasedprogram->userprogram_accuracy,
                'completeday' => $userpurchasedprogram->userprogram_completeday,
                'missedday' => $userpurchasedprogram->userprogram_missedday,
                'restday' =>  $userpurchasedprogram->userprogram_restday,
                'makername' => $makername
            ];

            if($userpurchasedprogram->userprogram_activestatus == 1)
            {
                if($userpurchasedprograminfo->program_kind == 1)
                {
                    $activeworkoutinfo = Clientworkout::where('clientworkout_userid', $user->id)
                        ->where('clientworkout_programid', $userpurchasedprogram->userprogram_programid)
                        ->get();
                }
                else if($userpurchasedprograminfo->program_kind == 2)
                {
                    $activenutritioninfo = Clientnutrition::where('clientnutrition_userid', $user->id)
                        ->where('clientnutrition_programid', $userpurchasedprogram->userprogram_programid)
                        ->get();
                }
            }

            if($userpurchasedprograminfo->program_kind == 3)
            {
                $userdoc = Doc::where('doc_programid', $userpurchasedprograminfo->program_id)->first();
                $docinfo->push($userdoc);
            }

            $retcollection->push($userprograminfo);
        }



        $userweighthistory = Userweight::where('userid', $user->id)->get();
        //$user->userweighthistory;

        //$userfathistory = $user->userfathistory;
        $userfathistory = Userbodyfat::where('userid', $user->id)->get();

        return response()->json([
            'result' => true,
            'message' => 'Login Success!',
            'usertoken' => $token,
            'data' => [
                'info' => $user,
                'programinfo' => $retcollection,
                'weighthistory'=> $userweighthistory,
                'fathistory' => $userfathistory,
                'activeworkoutinfo' => $activeworkoutinfo,
                'activenutritioninfo' => $activenutritioninfo,
                'docinfo' => $docinfo
            ]
        ]);
    }

    public function userdetails(Request $request)
    {
        $input = $request->all();
        $token = $input['token'];
        $user = JWTAuth::toUser($token);

        if($user->user_type == 1)
        {

        }
        $userpurchasedprograms = UserProgram::where('userprogram_userid', $user->id)->get();
        //$user->userpurchasedprogram;
        $retcollection = new Collection();

        $activeworkoutinfo = [];
        $activenutritioninfo = [];
        $docinfo = new Collection();

        foreach($userpurchasedprograms as $userpurchasedprogram)
        {
            $userpurchasedprograminfo = $userpurchasedprogram->program;
            $maker = User::where('id', $userpurchasedprogram->userprogram_makerid)->first();
            $makername = "";
            if($maker != null)
            {
                $makername = $maker->name;
            }
            $userprograminfo = [
                'program' => $userpurchasedprograminfo,
                'active' => $userpurchasedprogram->userprogram_activestatus,
                'startdate' => $userpurchasedprogram->userprogram_startdate,
                'remainingdays' => $userpurchasedprogram->userprogram_remainingday,
                'progress' => $userpurchasedprogram->userprogram_progress,
                'accuracy' => $userpurchasedprogram->userprogram_accuracy,
                'completeday' => $userpurchasedprogram->userprogram_completeday,
                'missedday' => $userpurchasedprogram->userprogram_missedday,
                'restday' =>  $userpurchasedprogram->userprogram_restday,
                'makername' => $makername
            ];

            if($userpurchasedprogram->userprogram_activestatus == 1)
            {
                if($userpurchasedprograminfo->program_kind == 1)
                {
                    $activeworkoutinfo = Clientworkout::where('clientworkout_userid', $user->id)
                        ->where('clientworkout_programid', $userpurchasedprogram->userprogram_programid)
                        ->get();
                }
                else if($userpurchasedprograminfo->program_kind == 2)
                {
                    $activenutritioninfo = Clientnutrition::where('clientnutrition_userid', $user->id)
                        ->where('clientnutrition_programid', $userpurchasedprogram->userprogram_programid)
                        ->get();
                }
            }

            if($userpurchasedprograminfo->program_kind == 3)
            {
                $userdoc = Doc::where('doc_programid', $userpurchasedprograminfo->program_id)->first();
                $docinfo->push($userdoc);
            }

            $retcollection->push($userprograminfo);
        }



        $userweighthistory = Userweight::where('userid', $user->id)->get();
        //$user->userweighthistory;

        //$userfathistory = $user->userfathistory;
        $userfathistory = Userbodyfat::where('userid', $user->id)->get();

        return response()->json([
            'result' => true,
            'message' => 'Login Success!',
            'usertoken' => $token,
            'data' => [
                'info' => $user,
                'programinfo' => $retcollection,
                'weighthistory'=> $userweighthistory,
                'fathistory' => $userfathistory,
                'activeworkoutinfo' => $activeworkoutinfo,
                'activenutritioninfo' => $activenutritioninfo,
                'docinfo' => $docinfo
            ]
        ]);
    }

    public function changepassword(Request $request)
    {
        $input = $request->all();
        $user = JWTAuth::toUser($input['token']);
        $curpassword = $input['pass'];
        $newpassword = $input['newpass'];

        if (Hash::check($curpassword, $user->password))
        {
            $user->password = Hash::make($newpassword);
            $user->save();

            return response()->json(['result' => true, 'message' => 'success']);
        }
        else
        {
            return response()->json(['result' => false, 'message' => 'failure']);
        }
    }

    public function updateuserinfo(Request $request)
    {
        $input = $request->all();
        $user = JWTAuth::toUser($input['token']);
        if ($request->has('bioinfo'))
        {
            $bioinfo = $input['bioinfo'];
            $user->user_bioinfo = $bioinfo;
        }
        if ($request->has('sex'))
        {
            $sex = $input['sex'];
            $user->user_sex = $sex;
        }
        if ($request->has('measurement'))
        {
            $measurement = $input['measurement'];
            $user->user_measurement = $measurement;
        }
        if ($request->has('age'))
        {
            $age = $input['age'];
            $user->user_age = (int)$age;
        }
        if ($request->has('height'))
        {
            $height = $input['height'];
            $user->user_height = (int)$height;
        }
        if ($request->has('weight'))
        {
            $weight = $input['weight'];
            if ($request->has('oldweight'))
            {
                $oldweight = $input['oldweight'];
                $datestr = $input['datestr'];

                $userweighthistory = Userweight::create([
                    'userid' => $user->id,
                    'old' => (int)$oldweight,
                    'new' => (int)$weight,
                    'delta' => (int)$weight - (int)$oldweight,
                    'created_at' => $datestr,
                ]);
                $userweighthistory->created_at = $datestr;
                $userweighthistory->updated_at = $datestr;
                $userweighthistory->save();
            }
            $user->user_weight = (int)$weight;
        }
        if ($request->has('body_fat'))
        {
            $body_fat = $input['body_fat'];
            if ($request->has('oldbodyfat'))
            {
                $oldbodyfat = $input['oldbodyfat'];
                $datestr = $input['datestr'];

                $userbodyfathistory = Userbodyfat::create([
                    'userid' => $user->id,
                    'old' => (int)$oldbodyfat,
                    'new' => (int)$body_fat,
                    'delta' => (int)$body_fat - (int)$oldbodyfat,
                    'created_at' => $datestr,
                ]);
                $userbodyfathistory->created_at = $datestr;
                $userbodyfathistory->updated_at = $datestr;
                $userbodyfathistory->save();
            }
            $user->user_fat = (int)$body_fat;
        }

        $userbfdate = "";
        $userwtdate = "";

        if($user->user_firstlogin == 1)
        {
            $user->user_firstlogin = 0;

            $userbodyfathistory = Userbodyfat::create([
                'userid' => $user->id,
                'old' => 0,
                'new' => (int)$body_fat,
                'delta' => (int)$body_fat,
            ]);

            $userweighthistory = Userweight::create([
                'userid' => $user->id,
                'old' => 0,
                'new' => (int)$weight,
                'delta' => (int)$weight,
            ]);
            $userbfdate = (string)$userbodyfathistory->created_at;
            $userwtdate = (string)$userweighthistory->created_at;
        }
        $user->save();
        return response()->json(['result' => true, 'message' => 'success', 'bfdate' => $userbfdate, 'wtdate' => $userwtdate]);
    }

    public function ConfirmResetPWDcode(Request $request)
    {
        $input = $request->all();
        $resetcode = $input['code'];
        $email = $input['email'];

        $user = User::where('email', $email)->first();
        $code = $user->resetcode;
        $createdtime =(string)$user->updated_at;
        $date = date_create_from_format('Y-m-d H:i:s', $createdtime);
        $curdate = date('Y-m-d H:i:s');
        $newdate = date_create_from_format('Y-m-d H:i:s', $curdate);
        $interval = $newdate->diff($date);
        $elapsed = $interval->format('%i');
        if($resetcode == '' || $resetcode == null)
        {
            return response()->json(['result' => false, 'message' => 'Input Code.']);
        }

        if($resetcode == $code)
        {
            if((int)$elapsed < 5)
            {
                $user->resetcode = '';
                $user->save();
                return response()->json(['result' => true, 'message' => 'success', 'cur'=>$newdate, 'orig' => $date, 'min' => $elapsed]);
            }
            else
            {
                $user->resetcode = '';
                $user->save();
                return response()->json(['result' => false, 'message' => 'Code Expired']);
            }
        }
        return response()->json(['result' => false, 'message' => 'Wrong Code']);
    }

    public function ResetPwd(Request $request)
    {
        $input = $request->all();
        $email = $input['email'];
        $password = $input['password'];
        $user = User::where('email', $email)->first();
        if($user == null)
        {
            return response()->json(['result' => false, 'message' => 'failure']);
        }
        else
        {
            $user->password = Hash::make($password);
            $user->resetcode = "";
            $user->save();
            return response()->json(['result' => true, 'message' => 'success']);
        }
    }
}
