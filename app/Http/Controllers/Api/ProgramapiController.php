<?php

namespace FitHabit\Http\Controllers\Api;

use FitHabit\Clientnutrition;
use FitHabit\Clientworkout;
use FitHabit\UserProgram;
use Illuminate\Http\Request;
use FitHabit\Http\Controllers\Controller;
use FitHabit\User;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;
use Exception;
use Illuminate\Database\Eloquent\Collection;

class ProgramapiController extends Controller
{
    public function setstartdate(Request $request)
    {
        $input = $request->all();
        $user = JWTAuth::toUser($input['token']);
        $programID = (int)$input['programid'];
        $startdate = $input['startdate'];
        $remainingday = $input['remaining'];

        $program = UserProgram::where('userprogram_programid' , $programID)
                        ->where('userprogram_userid', $user->id)->first();
        $program->userprogram_startdate = $startdate;
        $program->userprogram_remainingday = $remainingday;
        $program->save();
        return response()->json(['result' => true, 'message' => 'success']);
    }

    public function resetworkout(Request $request)
    {
        $input = $request->all();
        $user = JWTAuth::toUser($input['token']);
        $programID = (int)$input['programid'];

        UserProgram::where('userprogram_userid', $user->id)
            ->where('userprogram_programid', $programID)
            ->update(['userprogram_startdate' => '0000-00-00']);

        Clientworkout::where('clientworkout_userid', $user->id)
            ->where('clientworkout_programid', $programID)
            ->update(['clientworkout_setinfo' => '', 'clientworkout_exprogress' => 0.00, 'clientworkout_dayprogress' => 0.00]);

        return response()->json(['result' => true, 'message' => 'success']);
    }

    public function resetnutrition(Request $request)
    {
        $input = $request->all();
        $user = JWTAuth::toUser($input['token']);
        $programID = (int)$input['programid'];

        UserProgram::where('userprogram_userid', $user->id)
            ->where('userprogram_programid', $programID)
            ->update(['userprogram_startdate' => '0000-00-00']);

        Clientnutrition::where('clientnutrition_userid', $user->id)
            ->where('clientnutrition_programid', $programID)
            ->update(['clientnutrition_complete' => 0, 'clientnutrition_foodprogress' => 0.00, 'clientnutrition_dayprogress' => 0.00]);
        return response()->json(['result' => true, 'message' => 'success']);
    }

    public function updateuserprograminfo(Request $request)
    {
        $input = $request->all();
        $user = JWTAuth::toUser($input['token']);
        $programID = (int)$input['programid'];
        $programProgress = (double)$input['progress'];
        $programAccuracy = (double)$input['accuracy'];
        $programMissed = (int)$input['missed'];
        $programRest = (int)$input['rest'];
        $programCompleted = (int)$input['completed'];

        $program = UserProgram::where('userprogram_userid', $user->id)
            ->where('userprogram_programid', $programID)->first();

        $program->userprogram_progress = $programProgress;
        $program->userprogram_accuracy = $programAccuracy;
        $program->userprogram_completeday = $programCompleted;
        $program->userprogram_missedday = $programMissed;
        $program->userprogram_restday = $programRest;

        $program->save();
        return response()->json(['result' => true, 'message' => 'success']);
    }

    public function updateusernutritioninfo(Request $request)
    {
        $input = $request->all();
        $user = JWTAuth::toUser($input['token']);
        $nutID = (int)$input['nutritionid'];
        $programID = (int)$input['nutprogramid'];
        $week = (int)$input['nutweek'];
        $day = (int)$input['nutday'];
        $foodprogress = (double)$input['foodprogress'];
        $dayprogress = (double)$input['dayprogress'];

        $nutrition = Clientnutrition::where('clientnutrition_id', $nutID)
                            ->where('clientnutrition_userid', $user->id)
                            ->where('clientnutrition_programid', $programID)->first();
        $nutrition->clientnutrition_complete = 1;
        $nutrition->save();

        $affectRows = Clientnutrition::where('clientnutrition_userid',$nutrition->clientnutrition_userid)
            ->where('clientnutrition_programid',$nutrition->clientnutrition_programid)
            ->where('clientnutrition_week',$nutrition->clientnutrition_week)
            ->where('clientnutrition_day',$nutrition->clientnutrition_day)
            ->where('clientnutrition_mealtype', $nutrition->clientnutrition_mealtype)
            ->update(array('clientnutrition_foodprogress' => $foodprogress));

        $affectedRows = Clientnutrition::where('clientnutrition_userid',$nutrition->clientnutrition_userid)
            ->where('clientnutrition_programid',$nutrition->clientnutrition_programid)
            ->where('clientnutrition_week',$nutrition->clientnutrition_week)
            ->where('clientnutrition_day',$nutrition->clientnutrition_day)
            ->update(array('clientnutrition_dayprogress' => $dayprogress));

        return response()->json(['result' => true, 'message' => 'success']);
    }

    public function updateuserworkoutinfo(Request $request)
    {
        $input = $request->all();
        $user = JWTAuth::toUser($input['token']);
        $workoutID = (int)$input['workoutid'];

        $setinfo = $input['setinfo'];

        $curexprogress = (double)$input['curexprogress'];
        $curdayprogress = (double)$input['curdayprogress'];

        $workout = Clientworkout::where('clientworkout_id', $workoutID)
            ->where('clientworkout_userid', $user->id)->first();
        $workout->clientworkout_setinfo = $setinfo;
        $workout->clientworkout_exprogress = $curexprogress;
        //$workout->clientworkout_dayprogress = $curdayprogress;
        $workout->save();

        $affectedRows = Clientworkout::where('clientworkout_userid',$workout->clientworkout_userid)
            ->where('clientworkout_programid',$workout->clientworkout_programid)
            ->where('clientworkout_week',$workout->clientworkout_week)
            ->where('clientworkout_day',$workout->clientworkout_day)
            ->update(array('clientworkout_dayprogress' => $curdayprogress));
            //->update(array('status' => 2));
        return response()->json(['result' => true, 'message' => 'success']);
    }

    public function setactivenutrition(Request $request)
    {
        $input = $request->all();
        $user = JWTAuth::toUser($input['token']);
        $lastactive = $input['pastactiveProgramid'];
        $curactive = $input['currentactiveProgramid'];
        $convert = $input['convert'];

        $lastnutritioninfos = new Collection();

        if((int)$lastactive > 0)
        {
            $pastProgram = UserProgram::where('userprogram_userid', $user->id)
                ->where('userprogram_programid', $lastactive)->first();
            $pastProgram->userprogram_activestatus = 0;
            if((int)$convert == 0)
            {
                $pastProgram->userprogram_startdate = '';
                $pastNutritions = Clientnutrition::where('clientnutrition_userid', $user->id)
                                                ->where('clientnutrition_programid', $lastactive)
                                                ->update(['clientnutrition_complete' => '0', 'clientnutrition_foodprogress' => 0.00, 'clientnutrition_dayprogress' => 0.00]);
            }
            $pastProgram->save();
        }

        $activenutritioninfo = new Collection();
        if((int)$curactive > 0)
        {
            $newProgram = UserProgram::where('userprogram_userid', $user->id)
                ->where('userprogram_programid', $curactive)->first();
            $newProgram->userprogram_activestatus = 1;
            $newProgram->save();
            $activenutritioninfo = $newProgram->nutritioninfo;
        }

        return response()->json([
            'result' => true,
            'message' => 'Set Active Success!',
            'data' => [
                'activenutritioninfo' => $activenutritioninfo
            ]
        ]);
    }

    public function setactiveprogram(Request $request)
    {
        $input = $request->all();
        $user = JWTAuth::toUser($input['token']);
        $lastactive = $input['pastactiveProgramid'];
        $curactive = $input['currentactiveProgramid'];
        $convert = $input['convert'];
        $lastworkoutinfos = new Collection();
        if((int)$lastactive > 0)
        {
            $pastProgram = UserProgram::where('userprogram_userid', $user->id)
                                    ->where('userprogram_programid', $lastactive)->first();
            $pastProgram->userprogram_activestatus = 0;
            if((int)$convert == 0)
            {
                $pastProgram->userprogram_startdate = '';
                $pastWorkouts = Clientworkout::where('clientworkout_userid', $user->id)
                    ->where('clientworkout_programid', $lastactive)
                    ->update(['clientworkout_setinfo' => '', 'clientworkout_exprogress' => 0.00,'clientworkout_dayprogress' => 0.00]);
            }
            $pastProgram->save();
        }

        $activeworkoutinfo = new Collection();
        if((int)$curactive > 0)
        {
            $newProgram = UserProgram::where('userprogram_userid', $user->id)
                ->where('userprogram_programid', $curactive)->first();
            $newProgram->userprogram_activestatus = 1;
            $newProgram->save();
            $activeworkoutinfo = $newProgram->workoutinfo;
        }

        return response()->json([
            'result' => true,
            'message' => 'Set Active Success!',
            'data' => [
                'activeworkoutinfo' => $activeworkoutinfo
            ]
        ]);
    }
}