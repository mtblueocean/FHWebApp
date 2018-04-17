<?php

namespace FitHabit\Http\Controllers;

use FitHabit\Doc;
use Illuminate\Http\Request;
use FitHabit\Workout;
use FitHabit\Program;
use FitHabit\Food;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Collection;

class WorkoutController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {

    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getWorkouts(Request $request)
    {
        $programid = $request->input('ProgramId');
        $programtype = $request->input('ProgramType');
        if($programtype == "infodoc")
        {
            $docdata = Doc::where('doc_programid', $programid)->first();
            return response()->json([
                'success' => 'true',
                'docdata' => $docdata->doc_content
            ]);
        }

        $weekid = $request->input('SelectedWeek');
        $dayid = $request->input('SelectedDay');




        $workouts = new Collection();

        if( (int)$weekid > 0)
        {
            if( (int)$dayid > 0)
            {
                switch($programtype)
                {
                    case "workout":
                        $workouts = Workout::where('workout_programid', $programid)
                            ->where('workout_week', $weekid)
                            ->where('workout_day', $dayid)
                            ->orderBy('workout_day', 'asc')
                            ->get();
                        break;
                    case "nutrition":
                        $workouts = Food::where('food_programid', $programid)
                            ->where('food_week', $weekid)
                            ->where('food_day', $dayid)
                            ->orderBy('food_day', 'asc')
                            ->get();
                        break;
                    case "infodoc":
                        break;
                    default:
                        break;
                }
            }
            else
            {
                switch($programtype)
                {
                    case "workout":
                        $workouts = Workout::where('workout_programid', $programid)
                            ->where('workout_week', $weekid)
                            ->orderBy('workout_day', 'asc')
                            ->get();
                        break;
                    case "nutrition":
                        $workouts = Food::where('food_programid', $programid)
                            ->where('food_week', $weekid)
                            ->orderBy('food_day', 'asc')
                            ->get();
                        break;
                    case "infodoc":
                        break;
                    default:
                        break;
                }
            }
        }

        $retcollection = new Collection();

        if ($workouts->count() > 0)
        {
            $no = 1;

            switch($programtype)
            {
                case "workout":
                    foreach($workouts as $workout)
                    {
                        $id = $workout->workout_id;
                        $day = $workout->workout_day;
                        $week = $workout->workout_week;
                        $daytype = $workout->workout_daytype;
                        $extype = $workout->workout_extype;
                        $muscleGroup = $workout->workout_musclegroup;
                        $exname = $workout->workout_exname;
                        $sets = $workout->workout_sets;
                        $setinfo = $workout->workout_setcontent;

                        if($daytype == 0)
                        {
                            $sets = "";
                        }

                        $tempcollection = [ "No" => $no,
                            "Day" => $day,
                            "Week" => $week,
                            "DayType" => $daytype,
                            "MuscleGroup" => $muscleGroup,
                            "ExerciseType" => $extype,
                            "ExerciseName" => $exname,
                            "SetCount" => $sets,
                            "Setsdata" => $setinfo,
                            "WorkoutId" => $id
                        ];
                        $retcollection->push($tempcollection);

                        $no = $no + 1;
                    }
                    break;
                case "nutrition":
                    foreach($workouts as $workout)
                    {
                        $id = $workout->food_id;
                        $day = $workout->food_day;
                        $week = $workout->food_week;
                        $daytype = $workout->food_daytype;
                        $mealtype = $workout->food_mealtype;
                        $foodname = $workout->food_name;
                        $foodquantity = $workout->food_quantity;
                        $foodquantitytype = $workout->food_quantitytype;
                        $protein = $workout->food_protein;
                        $fat = $workout->food_fat;
                        $carbs = $workout->food_carbs;
                        $calories = $workout->food_calories;

                        if($daytype == 0)
                        {
                            $foodquantity = "";
                            $protein = "";
                            $fat = "";
                            $carbs = "";
                            $calories = "";
                        }

                        $tempcollection = [ "No" => $no,
                            "Day" => $day,
                            "Week" => $week,
                            "DayType" => $daytype,
                            "MealType" => $mealtype,
                            "FoodName" => $foodname,
                            "Quantity" => $foodquantity,
                            "QuantityType" => $foodquantitytype,
                            "Protein" => $protein,
                            "Carbs" => $carbs,
                            "Fat" => $fat,
                            "Calories" => $calories,
                            "MealId" => $id

                        ];

                        $retcollection->push($tempcollection);

                        $no = $no + 1;
                    }
                    break;
                case "infodoc":

                    break;
                default:
                    break;
            }



            return response()->json($retcollection);
        }
        else
        {
            return response()->json();
        }
    }

    public function addWorkout(Request $request)
    {
        $dayType = $request->input('DayType');
        $programType = $request->input('ProgramType');
        $programid = $request->input('ProgramId');
        $week = $request->input('Week');
        $day = $request->input('Day');
        $dayType = $request->input('DayType');

        $tempcollection = new Collection();

        switch($programType)
        {
            case "workout":
                $muscleGroup = $request->input('MuscleGroup');
                $exerciseName = $request->input('ExerciseName');
                $setInfo = $request->input('Setsdata');
                if($setInfo == null)
                {
                    $setInfo = "";
                }
                $setCount = $request->input('SetCount');
                $exerciseType = $request->input('ExerciseType');

                if($dayType == 0)
                {
                    $setCount = 0;
                    $exerciseName = "";
                    $muscleGroup = 0;
                    $exerciseType = 2;

                    $deleteworkout = Workout::where('workout_week', $week)
                        ->where('workout_day', $day)
                        ->where('workout_programid', $programid)
                        ->delete();
                }
                else
                {
                    $prevRestWorkout = Workout::where('workout_week', $week)
                        ->where('workout_day', $day)
                        ->where('workout_daytype', 0)
                        ->delete();
                }

                $workout = Workout::create([
                    'workout_programid' => $programid,
                    'workout_week' => $week,
                    'workout_day' => $day,
                    'workout_daytype' => $dayType,
                    'workout_extype' => $exerciseType,
                    'workout_musclegroup' => $muscleGroup,
                    'workout_exname' => $exerciseName,
                    'workout_sets' => $setCount,
                    'workout_setcontent' => $setInfo,
                ]);

                $tempcollection = [ "No" => 123,
                    "Day" => (int)$workout->workout_day,
                    "Week" => (int)$workout->workout_week,
                    "DayType" => (int)$workout->workout_daytype,
                    "MuscleGroup" => (int)$workout->workout_musclegroup,
                    "ExerciseType" => (int)$workout->workout_extype,
                    "ExerciseName" => $workout->workout_exname,
                    "SetCount" => (int)$workout->workout_sets,
                    "Setsdata" => $workout->workout_setcontent,
                    "WorkoutId" => (int)$workout->workout_id
                ];
                break;
            case "nutrition":
                $mealtype = $request->input('MealType');
                $foodname = $request->input('FoodName');
                $quantity = $request->input('Quantity');
                $quantitytype = $request->input('QuantityType');
                $protein = $request->input('Protein');
                $carbs = $request->input('Carbs');
                $fat = $request->input('Fat');
                $calories = $request->input('Calories');

                if($dayType == 0)
                {
                    $mealtype = 0;
                    $foodname = "";
                    $quantity = 0;
                    $quantitytype = 0;
                    $protein = 0;
                    $carbs = 0;
                    $fat = 0;
                    $calories = 0;

                    $deleteworkout = Food::where('food_week', $week)
                        ->where('food_day', $day)
                        ->where('food_programid', $programid)
                        ->delete();
                }
                else
                {
                    $prevRestWorkout = Food::where('food_week', $week)
                        ->where('food_day', $day)
                        ->where('food_daytype', 0)
                        ->delete();
                }

                $workout = Food::create([
                    'food_programid' => $programid,
                    'food_week' => $week,
                    'food_day' => $day,
                    'food_daytype' => $dayType,
                    'food_mealtype' => $mealtype,
                    'food_name' => $foodname,
                    'food_quantity' => $quantity,
                    'food_quantitytype' => $quantitytype,
                    'food_protein' => $protein,
                    'food_fat' => $fat,
                    'food_carbs' => $carbs,
                    'food_calories' => $calories,
                ]);

                $tempcollection = [ "No" => 123,
                    "Day" => (int)$workout->food_day,
                    "Week" => (int)$workout->food_week,
                    "DayType" => (int)$workout->food_daytype,
                    "MealType" => (int)$workout->food_mealtype,
                    "FoodName" => $workout->food_name,
                    "Quantity" => $workout->food_quantity,
                    "QuantityType" => (int)$workout->food_quantitytype,
                    "Protein" => $workout->food_protein,
                    "Carbs" => $workout->food_carbs,
                    "Fat" => $workout->food_fat,
                    "Calories" => $workout->food_calories,
                    "MealId" => (int)$workout->food_id
                ];
                break;
            case "infodoc":
                break;
        }
        return response()->json(collect($tempcollection));
    }

    public function saveDocContent(Request $request, $programtype, $userid, $programid)
    {
        $docdata = $request->input('editor1');
        $doc = Doc::where('doc_programid', $programid)->first();
        $doc['doc_content'] = $docdata;
        $doc->save();

        return response()->json([
            'success' => 'true',
            'docid' => $doc->doc_id
        ]);
    }

    public function saveSetContent(Request $request)
    {
        $extype = $request->input('extype');
        $id = $request->input('WorkoutId');
        $setcounts = $request->input('SetCount');

        $saveValue = "[";
        for($i = 1; $i <= $setcounts; $i ++)
        {
            $no = (string)$i;
            if($extype == "0")
            {
                $measureval = "0";
            }
            else
            {
                $measureval = $request->input('measuvalue'.$no);
            }

            $repval = $request->input('repsvalue'.$no);
            $mainval = $measureval.' '.$repval;
            $inputval = "";
            if($i < (int)$setcounts)
            {
                $inputval = '{"index":"'.$no.'", "val":"'.$measureval.'", "reps":"'.$repval.'"},';
            }
            else
            {
                $inputval = '{"index":"'.$no.'", "val":"'.$measureval.'", "reps":"'.$repval.'"}]';
            }
            $saveValue = $saveValue.$inputval;
        }

        $workout = Workout::where('workout_id', (int)$id)
            ->update([
                'workout_setcontent' => $saveValue
            ]);
    }

    public function updateWorkout(Request $request)
    {
        $week = $request->input('Week');
        $day = $request->input('Day');
        $dayType = $request->input('DayType');
        $programtype = $request->input('ProgramType');

        $tempcollection = new Collection();

        switch($programtype)
        {
            case "workout":
                $id = $request->input('WorkoutId');
                $muscleGroup = $request->input('MuscleGroup');
                $exerciseName = $request->input('ExerciseName');
                $setInfo = $request->input('Setsdata');

                if($setInfo == null)
                {
                    $setInfo = "";
                }

                $setCount = $request->input('SetCount');
                $exerciseType = $request->input('ExerciseType');


                $prevworkout = Workout::where('workout_id', $id)->first();
                $prevSetCount = $prevworkout->workout_sets;
                $prevExtype = $prevworkout->workout_extype;
                $programid = $prevworkout->workout_programid;

                if((int)$exerciseType != (int)$prevExtype)
                {
                    $setInfo = "";
                }
                else
                {
                    if((int)$setCount != (int)$prevSetCount)
                    {
                        $setInfo = "";
                    }
                }

                if($dayType == 0)
                {
                    $setInfo = "";
                    $muscleGroup = 0;
                    $exerciseType = 2;
                    $exerciseName = "";
                    $setCount = 0;
                }

                $workout = Workout::where('workout_id', $id)
                    ->update([
                        'workout_day' => $day,
                        'workout_week' => $week,
                        'workout_daytype' => $dayType,
                        'workout_musclegroup' => $muscleGroup,
                        'workout_extype' => $exerciseType,
                        'workout_exname' => $exerciseName,
                        'workout_sets' => $setCount,
                        'workout_setcontent' => $setInfo
                    ]);

                if($dayType == 0)
                {
                    $deleteworkout = Workout::where('workout_week', $week)
                        ->where('workout_day', $day)
                        ->where('workout_programid', $programid)
                        ->where('workout_id', '<>', $id)
                        ->delete();
                }

                $retworkout = Workout::where('workout_id', $id)->first();
                $tempcollection = [ "No" => 123,
                    "Day" => (int)$retworkout->workout_day,
                    "Week" => (int)$retworkout->workout_week,
                    "DayType" => (int)$retworkout->workout_daytype,
                    "MuscleGroup" => (int)$retworkout->workout_musclegroup,
                    "ExerciseType" => (int)$retworkout->workout_extype,
                    "ExerciseName" => $retworkout->workout_exname,
                    "SetCount" => (int)$retworkout->workout_sets,
                    "Setsdata" => $retworkout->workout_setcontent,
                    "WorkoutId" => (int)$retworkout->workout_id
                ];
                break;
            case "nutrition":
                $id = $request->input('MealId');
                $mealtype = $request->input('MealType');
                $foodname = $request->input('FoodName');
                $quantity = $request->input('Quantity');
                $quantitytype = $request->input('QuantityType');
                $protein = $request->input('Protein');
                $carbs = $request->input('Carbs');
                $fat = $request->input('Fat');
                $calories = $request->input('Calories');

                $programid = $request->input('ProgramId');

                if($dayType == 0)
                {
                    $mealtype = 0;
                    $foodname = "";
                    $quantity = 0;
                    $quantitytype = 0;
                    $protein = 0;
                    $carbs = 0;
                    $fat = 0;
                    $calories = 0;
                }

                $workout = Food::where('food_id', $id)
                    ->update([
                        'food_week' => $week,
                        'food_day' => $day,
                        'food_daytype' => $dayType,
                        'food_mealtype' => $mealtype,
                        'food_name' => $foodname,
                        'food_quantity' => $quantity,
                        'food_quantitytype' => $quantitytype,
                        'food_protein' => $protein,
                        'food_fat' => $fat,
                        'food_carbs' => $carbs,
                        'food_calories' => $calories
                    ]);

                if($dayType == 0)
                {
                    $deleteworkout = Food::where('food_week', $week)
                        ->where('food_day', $day)
                        ->where('food_programid', $programid)
                        ->where('food_id', '<>', $id)
                        ->delete();
                }

                $retworkout = Food::where('food_id', $id)->first();

                $tempcollection = [ "No" => 123,
                    "Day" => (int)$retworkout->food_day,
                    "Week" => (int)$retworkout->food_week,
                    "DayType" => (int)$retworkout->food_daytype,
                    "MealType" => (int)$retworkout->food_mealtype,
                    "FoodName" => $retworkout->food_name,
                    "Quantity" => $retworkout->food_quantity,
                    "QuantityType" => (int)$retworkout->food_quantitytype,
                    "Protein" => $retworkout->food_protein,
                    "Carbs" => $retworkout->food_carbs,
                    "Fat" => $retworkout->food_fat,
                    "Calories" => $retworkout->food_calories,
                    "MealId" => $retworkout->food_id
                ];
                break;
            case "infodoc":

                break;
            default:
                break;
        }
        return response()->json(collect($tempcollection));
    }

    public function deleteWorkout(Request $request)
    {
        $programtype = $request->input('ProgramType');

        switch($programtype)
        {
            case "workout":
                $id = $request->input('WorkoutId');
                $deletedRows = Workout::where('workout_id', $id)->delete();
                break;
            case "nutrition":
                $id = $request->input('MealId');
                $deletedRows = Food::where('food_id', $id)->delete();
                break;
            case "infodoc":
                break;
            default:
                break;

        }

    }
}
