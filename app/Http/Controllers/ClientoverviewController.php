<?php

namespace FitHabit\Http\Controllers;

use FitHabit\Clientnutrition;
use FitHabit\Clientworkout;
use FitHabit\Program;
use FitHabit\User;
use FitHabit\UserProgram;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;

class ClientoverviewController extends Controller
{
    function showIndex($userID)
    {
        $activeUserPrograms = $this->getUserActiveProgramInfos($userID);

        $workoutId = 0;
        $nutritionId = 0;
        $workoutWeeks = 0;
        $nutritionWeeks = 0;
        $programweeks = 0;
        $workoutName = "";
        $nutritionName = "";
        $programName = "";
        $userinfo = User::where('id', $userID)->first();
        if($activeUserPrograms != "NOINFO")
        {
            $idInfo = $this->getActiveProgramIDS($activeUserPrograms);
            $workoutId = $idInfo[0];
            $nutritionId = $idInfo[1];
            $workoutWeeks = $idInfo[2];
            $nutritionWeeks = $idInfo[3];
            $workoutName = $idInfo[4];
            $nutritionName = $idInfo[5];
        }

        if($workoutId == 0 && $nutritionId == 0)
        {
            $programID = 0;
            $programType = 1;
            $errno = 1;
            $programName = "";
            return view('clientdetailview', compact('programType', 'userID', 'programID', 'errno', 'programweeks', 'programName', 'userinfo'));
        }

        if($workoutId != 0)
        {
            $programID = $workoutId;
            $programType = 1;
            $errno = 3;
            $programweeks = $workoutWeeks;
            $programName = $workoutName;
            return view('clientdetailview', compact('programType', 'userID', 'programID', 'errno', 'programweeks', 'programName', 'userinfo'));
        }

        if($nutritionId != 0)
        {
            $programID = $nutritionId;
            $programType = 2;
            $errno = 3;
            $programweeks = $nutritionWeeks;
            $programName = $nutritionName;
            return view('clientdetailview', compact('programType', 'userID', 'programID', 'errno', 'programweeks', 'programName', 'userinfo'));
        }

        $programID = 0;
        $programType = 1;
        $errno = 1;
        $programweeks = 0;
        $programName = "";
        return view('clientdetailview', compact('programType', 'userID', 'programID', 'errno', 'programweeks', 'programName', 'userinfo'));
    }

    function showWorkoutOverview($userID)
    {
        $programID = 0;
        $programType = 1;
        $errno = 1;
        $programweeks = 0;
        $programName = "";
        $activeUserPrograms = $this->getUserActiveProgramInfos($userID);
        $userinfo = User::where('id', $userID)->first();
        if($activeUserPrograms != "NOINFO")
        {
            $idInfo = $this->getActiveProgramIDS($activeUserPrograms);
            $programID = $idInfo[0];
            $programweeks = $idInfo[2];
            $programName = $idInfo[4];
        }

        if($programID > 0)
        {
            $errno = 3;
        }
        return view('clientdetailview', compact('programType', 'userID', 'programID', 'errno', 'programweeks', 'programName', 'userinfo'));
    }

    function showNutritionOverview($userID)
    {
        $programID = 0;
        $programType = 2;
        $errno = 2;
        $programweeks = 0;
        $programName = "";
        $activeUserPrograms = $this->getUserActiveProgramInfos($userID);
        $userinfo = User::where('id', $userID)->first();

        if($activeUserPrograms != "NOINFO")
        {
            $idInfo = $this->getActiveProgramIDS($activeUserPrograms);
            $programID = $idInfo[1];
            $programweeks = $idInfo[3];
            $programName = $idInfo[5];
        }

        if($programID > 0)
        {
            $errno = 3;
        }
        return view('clientdetailview', compact('programType', 'userID', 'programID', 'errno', 'programweeks', 'programName', 'userinfo'));
    }

    function getUserActiveProgramInfos($userID)
    {
        $activeUserPrograms = UserProgram::where('userprogram_userid', $userID)
            ->where('userprogram_activestatus', 1)
            ->get();
        if($activeUserPrograms->count() > 0)
        {
            return $activeUserPrograms;
        }
        return "NOINFO";
    }

    function getActiveProgramIDS($activeprograminfos)
    {
        $workoutId = 0;
        $nutritionId = 0;
        $workoutWeeks = 0;
        $nutritionWeeks = 0;
        $nutritionName = "";
        $workoutName = "";

        foreach($activeprograminfos as $activeUserProgram)
        {
            $useractiveProgramInfo = Program::where('program_id', $activeUserProgram->userprogram_programid)->first();
            if($useractiveProgramInfo != null)
            {
                if($useractiveProgramInfo->program_kind == 1)
                {
                    $workoutId = $useractiveProgramInfo->program_id;
                    $workoutWeeks = $useractiveProgramInfo->program_weeks;
                    $workoutName = $useractiveProgramInfo->program_name;
                }
                else if($useractiveProgramInfo->program_kind == 2)
                {
                    $nutritionId = $useractiveProgramInfo->program_id;
                    $nutritionWeeks = $useractiveProgramInfo->program_weeks;
                    $nutritionName = $useractiveProgramInfo->program_name;
                }
            }
        }
        return [$workoutId, $nutritionId, $workoutWeeks, $nutritionWeeks, $workoutName, $nutritionName];
    }

    function getWeekDayInfos()
    {
        //$curWeekDayInfo = ['#34495E', '#34495E', '#34495E', '#34495E', '#34495E', '#34495E', '#34495E'];

    }

    function WorkoutDetail(Request $request)
    {
        $programid = $request->input('ProgramID');
        $weekid = $request->input('SelectedWeek');
        $userid = $request->input('UserID');

        $retWorkout = new Collection();

        $programInfo = UserProgram::where('userprogram_programid', (int)$programid)
            ->where('userprogram_userid', (int)$userid)
            ->first();
        $programstartdate = new Carbon($programInfo->userprogram_startdate);

        if((int)$weekid > 0)
        {
            $clientworkouts = Clientworkout::where('clientworkout_programid', $programid)
                ->where('clientworkout_userid', $userid)
                ->where('clientworkout_week', $weekid)
                ->where('clientworkout_daytype', 1)
                ->orderBy('clientworkout_day', 'asc')
                ->get();

            if($clientworkouts->count() > 0)
            {
                foreach ($clientworkouts as $clientworkout)
                {
                    $week = $clientworkout->clientworkout_week;
                    $day = $clientworkout->clientworkout_day;
                    $daydiff = ($week - 1) * 7 + $day - 1;
                    $workoutdate = $programstartdate->addDays($daydiff);
                    $workoutweekday = $workoutdate->format('l');

                    $workoutdatestr = $workoutdate->format('m-d-Y');
                    $musclegroup = $this->getMuscleGroup($clientworkout->clientworkout_musclegroup);
                    $extype = $this->getExType($clientworkout->clientworkout_extype);
                    $exProgress = $clientworkout->clientworkout_exprogress;

                    $completed = 0;
                    if($exProgress >= 1)
                    {
                        $completed = 1;
                    }

                    $workinfo = [ "Date" => $workoutdatestr,
                        "Day" => $workoutweekday,
                        "Muscle" => $musclegroup,
                        "ExName" => $clientworkout->clientworkout_exname,
                        "ExType" => $extype,
                        "Sets" => $clientworkout->clientworkout_sets,
                        "SetContent" => $clientworkout->clientworkout_setcontent,
                        "SetInfo" => $clientworkout->clientworkout_setinfo,
                        "Completed" => $completed,
                        "Exid" => $clientworkout->clientworkout_id
                    ];
                    $retWorkout->push($workinfo);
                }
            }
        }
        return response()->json($retWorkout);
    }

    function NutritionDetail(Request $request)
    {
        $programid = $request->input('ProgramID');
        $weekid = $request->input('SelectedWeek');
        $userid = $request->input('UserID');

        $retNutrition = new Collection();

        //return response()->json(['data'=>(int)$userid]);
        $programInfo = UserProgram::where('userprogram_programid', (int)$programid)
                            ->where('userprogram_userid', (int)$userid)
                            ->first();
        $programstartdate = new Carbon($programInfo->userprogram_startdate);

        if((int)$weekid > 0)
        {
            $clientnutritions = Clientnutrition::where('clientnutrition_programid', $programid)
                ->where('clientnutrition_userid', $userid)
                ->where('clientnutrition_week', $weekid)
                ->where('clientnutrition_daytype', 1)
                ->orderBy('clientnutrition_day', 'asc')
                ->get();

            if($clientnutritions->count() > 0)
            {
                foreach ($clientnutritions as $clientnutrition)
                {
                    $week = $clientnutrition->clientnutrition_week;
                    $day = $clientnutrition->clientnutrition_day;
                    $daydiff = ($week - 1) * 7 + $day - 1;
                    $nutritiondate = $programstartdate->addDays($daydiff);
                    $nutritionweekday = $nutritiondate->format('l');
                    //$nutritionweekday = substr($nutritionweekday, 0, 2);
                    $nutritiondatestr = $nutritiondate->format('m-d-Y');
                    $measurement = $this->getFoodMeasurement($clientnutrition->clientnutrition_foodunit);
                    $meala = $this->getMeal($clientnutrition->clientnutrition_mealtype);
                    $completed = $clientnutrition->clientnutrition_complete;

                    $nutinfo = [ "Date" => $nutritiondatestr,
                        "Day" => $nutritionweekday,
                        "Meal" => $meala,
                        "Food" => $clientnutrition->clientnutrition_foodname,
                        "Qty" => $clientnutrition->clientnutrition_foodquantity,
                        "Measurement" => $measurement,
                        "Protein" => $clientnutrition->clientnutrition_protein,
                        "Carbs" => $clientnutrition->clientnutrition_carbs,
                        "Fat" => $clientnutrition->clientnutrition_fat,
                        "Calories" => $clientnutrition->clientnutrition_calories,
                        "Completed" => $completed
                    ];
                    $retNutrition->push($nutinfo);
                }
            }
        }
        return response()->json($retNutrition);
    }

    function getMeal($no)
    {
        $meal = "";
        switch($no)
        {
            case 1:
                $meal = "Breakfast";
                break;
            case 2:
                $meal = "Lunch";
                break;
            case 3:
                $meal = "Dinner";
                break;
            case 4:
                $meal = "Snack";
                break;
            case 5:
                $meal = "Supplement";
                break;
            default:
                $meal = "";
                break;
        }
        return $meal;
    }

    function getMuscleGroup($no)
    {
        $muscle = "";
        switch($no)
        {
            case 1:
                $muscle = "Compound";
                break;
            case 2:
                $muscle = "Abdominals";
                break;
            case 3:
                $muscle = "Back";
                break;
            case 4:
                $muscle = "Biceps";
                break;
            case 5:
                $muscle = "Chest";
                break;
            case 6:
                $muscle = "Forearms";
                break;
            case 7:
                $muscle = "Legs";
                break;
            case 8:
                $muscle = "Shoulders";
                break;
            case 9:
                $muscle = "Trapezius";
                break;
            case 10:
                $muscle = "Triceps";
                break;
            default:
                break;
        }
        return $muscle;
    }

    function getExType($no)
    {
        $extype = "";
        switch($no)
        {
            case 0:
                $extype = "Strength";
                break;
            case 1:
                $extype = "Conditioning";
                break;
        }
        return $extype;
    }

    function getFoodMeasurement($no)
    {
        $unit = "";
        switch($no)
        {
            case 1:
                $unit = "Grams";
                break;
            case 2:
                $unit = "Cup";
                break;
            case 3:
                $unit = "Ounce";
                break;
            case 4:
                $unit = "Teaspoon";
                break;
            case 5:
                $unit = "Tablespoon";
                break;
            default:
                break;
        }
        return $unit;
    }

    function ExerciseDetail(Request $request)
    {
        $clientworkoutid = $request->input('ClientWorkoutID');
        $exinfo = Clientworkout::where('clientworkout_id', (int)$clientworkoutid)->first();

        $retcollection = new Collection();
        if($exinfo != null)
        {
            $setinfo = $exinfo->clientworkout_setinfo;
            $extype = $exinfo->clientworkout_extype;

            $exclient = $exinfo->clientworkout_userid;
            $exprogram = $exinfo->clientworkout_program;
            $exweek = $exinfo->clientworkout_week;
            $exday = $exinfo->clientworkout_day;
            $curOrder = ($exweek - 1) * 7 + $exday;
            $lastinfos = Clientworkout::where('clientworkout_programid', $exprogram)
                                        ->where('clientworkout_userid', $exclient)
                                        ->where('clientworkout_week', '<=', $exweek)
                                        ->where('clientworkout_setinfo', '<>', "")
                                        ->get();
            $lastsetjson = "";
            $lastex = 0;
            if($lastinfos->count() > 0)
            {
                foreach($lastinfos as $lastinfo)
                {
                    $lastweek = $lastinfo->clientworkout_week;
                    $lastday = $lastinfo->clientworkout_day;
                    $lastOrder = ($lastweek - 1) * 7 + $lastday;
                    if($lastOrder < $curOrder)
                    {
                        $lastex = $lastinfos->clientworkout_extype;
                        $lastsetinfo = $lastinfos->clientworkout_setinfo;
                        $lastsetinfo = "[".$lastsetinfo."]";
                        $lastsetjson = \GuzzleHttp\json_decode($lastsetinfo);
                    }
                }
            }

            if($setinfo != null && $setinfo != "")
            {
                $setinfo = "[".$setinfo."]";
                $setjson = \GuzzleHttp\json_decode($setinfo);
                $cnt = 0;
                foreach($setjson as $info)
                {
                    $lastreps = "--";
                    $lastvalue = "--";
                    if($lastsetjson != "")
                    {
                        if($lastsetjson[$cnt] != null)
                        {
                            $lastreps = $lastsetjson[$cnt]->reps;
                            $lastvalue = $lastsetjson[$cnt]->value;
                            if($lastex == 1)
                            {
                                $lastvalue = $this->covertValueToTime($lastsetjson[$cnt]->value);
                            }
                        }
                    }

                    $setno = $info->index;
                    $setvalue = $info->val;
                    if($extype == 1)
                    {
                        $setvalue = $this->covertValueToTime($setvalue);
                    }
                    $setreps = $info->reps;
                    $setrest = $info->rest;
                    $setrest = $this->covertValueToTime($setrest);
                    $lastsessionvalue = $lastvalue."/".$lastreps;

                    $setinfo = [ "SetNo" => $setno,
                        "Value" => $setvalue,
                        "Reps" => $setreps,
                        "LastSession" => $lastsessionvalue,
                        "Rest" => $setrest
                    ];

                    $retcollection->push($setinfo);
                    $cnt = $cnt + 1;
                }
            }
            //{"index":"1","val":"25","reps":"3","rest":"2"},{"index":"2","val":"2.5","reps":"13","rest":"2"},{"index":"3","val":"20","reps":"2","rest":"2"},{"index":"4","val":"40","reps":"11","rest":"3"}
            //{"index":"1","val":"50","reps":"7","rest":"1"}
        }
        return response()->json($retcollection);
    }

    function covertValueToTime($value)
    {
        $minute = (int)($value / 60);
        $sec = (int)($value % 60);
        $minuteString = (string)$minute;
        $secString = (string)$sec;
        $retstring = "";
        if($minute <= 9)
        {
            $minuteString = "0".(string)$minute;
        }
        if($sec <= 9)
        {
            $secString = "0".(string)$sec;
        }
        $retstring = $minuteString.":".$secString;
        return $retstring;
    }

    function WeekDetail(Request $request)
    {
        $programid = $request->input('ProgramID');
        $weekid = $request->input('SelectedWeek');
        $userid = $request->input('UserID');
        $programtype = $request->input('ProgramType');

        $programInfo = UserProgram::where('userprogram_programid', (int)$programid)
                                    ->where('userprogram_userid', (int)$userid)
                                    ->first();
        $programStartDate = new Carbon($programInfo->userprogram_startdate);
        $infos = [0, 0, 0, 0, 0, 0, 0];

        if($programtype == 1)
        {
            for($i = 1; $i <=7; $i ++)
            {
                $info = Clientworkout::where('clientworkout_programid', (int)$programid)
                    ->where('clientworkout_userid', (int)$userid)
                    ->where('clientworkout_week', (int)$weekid)
                    ->where('clientworkout_day', $i)
                    ->first();
                if($info != null)
                {
                    $progress = $info->clientworkout_dayprogress;
                    if($info->clientworkout_daytype == 1)
                    {
                        if($progress >= 1)
                        {
                            $infos[$i - 1] = 1;
                        }
                        else
                        {
                            $infos[$i - 1] = 2;
                        }
                    }
                    else
                    {
                        $infos[$i - 1] = 3;
                    }
                }
            }
        }
        else
        {
            for($i = 1; $i <=7; $i ++)
            {
                $info = Clientnutrition::where('clientnutrition_programid', (int)$programid)
                    ->where('clientnutrition_userid', (int)$userid)
                    ->where('clientnutrition_week', (int)$weekid)
                    ->where('clientnutrition_day', (int)$i)
                    ->first();
                if($infos != null)
                {
                    $progress = (double)$info->clientnutrition_dayprogress;
                    if($info->clientnutrition_daytype == 1)
                    {
                        if($progress >= 1.0)
                        {
                            $infos[$i - 1] = 1;         //Complete
                        }
                        else
                        {
                            $infos[$i - 1] = 2;         //Missed
                        }
                    }
                    else
                    {
                        $infos[$i - 1] = 3;             //Rest
                    }
                }
            }

        }
        //return response()->json(['result' => $infos]);

        $curDate = Carbon::now();
        $curdayDiff = $curDate->diffIndays($programStartDate);

        $weekdatestr = new Collection();

        $programdate = $programStartDate->addDays(($weekid - 1) * 7);
        for($i = 0; $i < 7; $i ++)
        {
            $daydiff = ($weekid - 1) * 7 + $i;
            //$programdate = $pgdate->addDays($daydiff);
            $datestr = $programdate->format('l');
            $datestr = substr($datestr, 0, 2);

            if($infos[$i] != 0)
            {
                if($infos[$i] != 3)
                {
                    if($daydiff == $curdayDiff)
                    {
                        if($infos[$i] == 2)
                        {
                            $infos[$i] = 4;     //Current
                        }
                    }
                    else if($daydiff > $curdayDiff)
                    {
                        $infos[$i] = 5;         //Future
                    }
                }
            }

            $color = '#DADFE1';
            switch($infos[$i])
            {
                case 0:
                    $color = '#34495E';         //Empty
                    break;
                case 1:
                    $color = '#03C9A9';         //Complete
                    break;
                case 2:
                    $color = '#EC644B';         //Missed
                    break;
                case 3:
                    $color = '#6BB9F0';         //Rest
                    break;
                case 4:
                    $color = '#F89406';         //Current
                    break;
                case 5:
                    $color = '#DADFE1';         //Future
                    break;
                default:
                    $color = '#DADFE1';
                    break;
            }

            $retval = ["day" => $datestr, "color" => $color];
            $weekdatestr->push($retval);
            $programdate->addDays(1);
        }
        return response()->json(['result' => $weekdatestr]);
    }
}
