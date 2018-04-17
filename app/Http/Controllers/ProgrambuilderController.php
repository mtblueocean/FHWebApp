<?php

namespace FitHabit\Http\Controllers;

use FitHabit\Doc;
use FitHabit\User;
use FitHabit\UserProgram;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use FitHabit\Program;
use FitHabit\Workout;
use FitHabit\Food;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Illuminate\Database\Eloquent\Collection;

class ProgrambuilderController extends Controller
{
    public $programType;

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function ProgramBuilderIndex()
    {
        return view('createprogram');
    }

    public function getSignupList()
    {
        $user = Auth::user();
        $userid = $user->id;

        /*$userprograms = UserProgram::where('userprogram_makerid', $userid)
                        ->groupby('userprogram_userid')->get();*/
        $userprograms = DB::table('userprograms')
            ->select('*', DB::raw('count(*) as countprograms'))
            ->where('userprogram_makerid', $userid)
            ->groupBy('userprogram_userid')
            ->get();

        $retcollection = new Collection();
        if ($userprograms->count() > 0) {
            $no = 1;

            foreach ($userprograms as $userprogram) {
                $userinfo = User::where('id', $userprogram->userprogram_userid)->first();
                //$userinfo = $userprogram->programPurchaser;

                $usertype = "Client";

                if (!empty($userinfo))
                {
                    if($userinfo->user_type == 1)
                    {
                        $usertype = "PT";
                    }
                    $signupdate = substr((string)$userinfo->created_at, 0, 10);
                    $tempcollection = ["No" => $no,
                        'UserName' => $userinfo->name,
                        'Email' => $userinfo->email,
                        'Type' => $usertype,
                        'SignupDate' => $signupdate,
                        'Programs' => $userprogram->countprograms,
                        'ClientId' => $userinfo->id,
                    ];
    
                    $retcollection->push($tempcollection);
                }

                $no = $no + 1;
            }
        }
        return response()->json($retcollection);
    }


    public function getProgramList()
    {
        $user = Auth::user();
        $userid = $user->id;

        $programs = Program::where('program_maker', $userid)
            ->get();

        $retcollection = new Collection();

        if ($programs->count() > 0)
        {
            $no = 1;
            foreach($programs as $program)
            {
                $id = $program->program_id;
                $programname = $program->program_name;
                $programkind = $program->program_kind;
                $programtype = "";
                $sProgramtype = "";
                switch($programkind)
                {
                    case 1:
                        $programtype = "Workout";
                        $sProgramtype = "workout";
                        break;
                    case 2:
                        $programtype = "Nutrition";
                        $sProgramtype = "nutrition";
                        break;
                    case 3:
                        $programtype = "InfoDoc";
                        $sProgramtype = "infodoc";
                        break;
                    default:
                        break;
                }

                $programcreated = substr((string)$program->created_at, 0, 10);
                $programmodified = substr((string)$program->updated_at, 0, 10);
                $programsignups = $program->program_soldcount;
                $programpurchasedcount = UserProgram::where('userprogram_programid', $id)
                                                ->where('userprogram_makerid', $userid)
                                                ->get()->count();
                $programavailability = $program->program_type;
                $status = $program->program_ispublished;

                $statusstr = "";
                switch($status)
                {
                    case 0:
                        $statusstr = "Editing...";
                        break;
                    case 1:
                        $statusstr = "Published";
                        break;
                    default:
                        break;
                }

                $availablestr = "";
                switch($programavailability)
                {
                    case 1:
                        $availablestr = "Public";
                        break;
                    case 2:
                        $availablestr = "Custom";
                        break;
                    case 3:
                        $availablestr = "Internal";
                        break;
                    default:
                        break;
                }
                $editurl = "/programbuilder/".$sProgramtype."/".$userid."/".$id;
                $tempcollection = [ "No" => $no,
                    'ProgramName' => $programname,
                    'ProgramType' =>  $programtype,
                    'ProgramCreated' => $programcreated,
                    'ProgramModified' => $programmodified,
                    'SignUps' => $programpurchasedcount,
                    'Available' => $availablestr,
                    'Status' => $statusstr,
                    'ProgramId' => $id,
                    'EditUrl' => $editurl,
                ];
                $retcollection->push($tempcollection);

                $no = $no + 1;
            }

            return response()->json($retcollection);
        }
        else
        {
            return response()->json();
        }
    }

    public function NewProgramIndex($programtype)
    {
        $type = $programtype;
        $newprogram = 1;
        $programdata = [];

        $formurl = 'programbuilder/'.$type;

        switch($type)
        {
            case "workout":
                $isFree = 1;
                return view('newprogram', compact('isFree', 'type', 'programdata', 'newprogram', 'formurl'));
                break;
            case "nutrition":
                $isFree = 1;
                return view('newprogram', compact('isFree', 'type', 'programdata', 'newprogram', 'formurl'));
            case "infodoc":
                $isFree = 1;
                return view('newprogram', compact('isFree', 'type', 'programdata', 'newprogram', 'formurl'));
                break;
            default:
                break;
        }
    }

    public function CreateProgram($programtype, Request $request)
    {
        $request->flash();
        $user = Auth::user();
        $userid = $user->id;
        $input = $request->all();
        $validateRule = array(
            'program_name' => 'required|max:255|unique:programs',
        );
        /*$this->validate($request, [
            'program_name' => 'required|max:255|unique:programs',
        ]);*/
        $validationResult = Validator::make($input, $validateRule);
        $validator = Validator::make($request->all(), [
            'file' => 'max:500000',
        ]);
        if($validationResult->fails())
        {
            return redirect()->back()
                ->withErrors($validationResult)
                ->withInput();
        }

        $programkind = 0;
        switch($programtype) {
            case "workout":
                $programkind = 1;
                break;
            case "nutrition":
                $programkind = 2;
                break;
            case "infodoc":
                $programkind = 3;
                break;
            default:
                break;
        }

        $isfree = 0;

        if($input['paymethod'] == "free")
        {
            $isfree = 1;
        }

        $programprice = 0;

        if($isfree == 0)
        {
            $programprice = $input['programprice'];
        }

        if($programkind == 3)
        {
            $program = Program::create([
                'program_name' => $input['program_name'],
                'program_description' => $input['productdescription'],
                'program_type' => $input['program_type'],
                'program_maker' => $user->id,
                'program_price' => $programprice,
                'program_weeks' => 0,
                'program_kind' => $programkind,
                'program_isfree' => $isfree,
            ]);
        }
        else
        {
            $program = Program::create([
                'program_name' => $input['program_name'],
                'program_description' => $input['productdescription'],
                'program_type' => $input['program_type'],
                'program_maker' => $user->id,
                'program_price' => $programprice,
                'program_weeks' => $input['programweek'],
                'program_kind' => $programkind,
                'program_isfree' => $isfree,
            ]);
        }


        if($request->hasFile('imageprogram')) {
            $fileName = 'program_'.$program->program_id. '.' .
                $request->file('imageprogram')->getClientOriginalExtension();

            $request->file('imageprogram')->move(
                base_path() . '/public/images/program/'.$userid.'/', $fileName
            );

            $url = 'images/program/'.$userid.'/'.$fileName;
            $program->program_image = $url;
        }

        $program->save();

        switch($programtype)
        {
            case "workout":
                return redirect('/programbuilder/'.$programtype.'/'.$userid.'/'.$program->program_id.'/edit');
                break;
            case "nutrition":
                return redirect('/programbuilder/'.$programtype.'/'.$userid.'/'.$program->program_id.'/edit');
                break;
            case "infodoc":
                $doc_programid = $program->program_id;
                $doc = Doc::create([
                    'doc_programid' => $doc_programid,
                    'doc_content' => '',
                ]);
                return redirect('/programbuilder/'.$programtype.'/'.$userid.'/'.$program->program_id.'/edit');
                break;
            default:
                break;
        }
    }

    public function UpdateProgram(Request $request, $programtype, $userid, $programid)
    {
        $input = $request->all();
        $existprogram = Program::where('program_id', $programid)
            ->first();
        $prevProgramName = $existprogram->program_name;
        $curProgramName = $input["program_name"];
        if($prevProgramName != $curProgramName)
        {
            $validateRule = array(
                'program_name' => 'required|max:255|unique:programs',
            );
            $validationResult = Validator::make($input, $validateRule);

            if($validationResult->fails())
            {
                return redirect()->back()
                    ->withErrors($validationResult)
                    ->withInput();
            }
        }

        $isfree = 0;

        if($input['paymethod'] == "free")
        {
            $isfree = 1;
        }

        $programprice = 0;

        if($isfree == 0)
        {
            $programprice = $input['programprice'];
        }

        if($request->hasFile('imageprogram')) {
            if($request->file('imageprogram')->isValid())
            {
                $fileName = 'program_'.$existprogram->program_id. '.' .
                    $request->file('imageprogram')->getClientOriginalExtension();

                if($fileName != "" && $fileName != null)
                {
                    $request->file('imageprogram')->move(
                        base_path() . '/public/images/program/'.$userid.'/', $fileName
                    );

                    $url = 'images/program/'.$userid.'/'.$fileName;
                    $existprogram['program_image'] = $url;
                }
            }
        }

        $existprogram['program_name'] = $input['program_name'];
        $existprogram['program_description'] = $input['productdescription'];
        $existprogram['program_price'] = $programprice;
        if($programtype == "infodoc")
        {
            $existprogram['program_weeks'] = 0;
        }
        else
        {
            $existprogram['program_weeks'] = $input['programweek'];
        }


        $existprogram['program_isfree'] = $isfree;
        $existprogram['program_type'] = $input['program_type'];

        $existprogram->save();

        switch($programtype)
        {
            case "workout":
                return redirect('/programbuilder/'.$programtype.'/'.$userid.'/'.$programid.'/edit');
                break;
            case "nutrition":
                return redirect('/programbuilder/'.$programtype.'/'.$userid.'/'.$programid.'/edit');
                break;
            case "infodoc":
                return redirect('/programbuilder/'.$programtype.'/'.$userid.'/'.$programid.'/edit');
                break;
            default:
                break;
        }
    }

    public function EditProgram($programtype, $userid, $programid)
    {
        $programdata = Program::find($programid);
        $type = $programtype;
        $isFree = 1;
        $newprogram = 0;
        $formurl = 'programbuilder/'.$type.'/'.$programdata->program_maker.'/'.$programdata->program_id;
        return view('newprogram', compact('isFree', 'type', 'programdata', 'newprogram', 'formurl'));
    }

    public function EditIndex($programtype, $userid, $programid)
    {
        $program = Program::find($programid);
        $noWeeks = $program->program_weeks;
        $programName = $program->program_name;

        $nexturl = "/programbuilder/".$programtype."/".$userid."/".$programid."/view";
        $backurl = "/programbuilder/".$programtype."/".$userid."/".$programid;

        switch($programtype)
        {
            case "workout":
                return view('inputexercises', compact('programName', 'noWeeks', 'userid', 'programid', 'nexturl', 'backurl', 'programtype'));
                break;
            case "nutrition":

                return view('inputmeal', compact('programName', 'noWeeks', 'userid', 'programid', 'nexturl', 'backurl', 'programtype'));
                break;
            case "infodoc":
                return view('infodoceditor', compact('programName', 'noWeeks', 'userid', 'programid', 'nexturl', 'backurl', 'programtype'));
                break;
            default:
                break;
        }
    }

    public function PublishProgram(Request $request,$programtype, $userid, $programid)
    {
        $program = Program::find($programid);
        $link = $this->generateRandomString();
        $program->program_ispublished = 1;
        $ldate = date('Y-m-d H:i:s');
        $program->program_publishdate = $ldate;
        $program->program_link = $link;
        $program->save();

        // Get the site domain.
        $link_name = 'fithabit.io/link/' . $link;
        $link = $_SERVER['HTTP_ORIGIN'] . '/link/' . $link;

        return view('programcreated', compact('link', 'link_name'));
    }

    public function DeleteProgram($programtype, $userid, $programid)
    {
        $deletedProgram = Program::where('program_id', $programid)->delete();
        switch($programtype)
        {
            case "workout":
                $deletedWorkout = Workout::where('workout_programid', $programid)->delete();
                break;
            case "nutrition":
                $deletedWorkout = Food::where('food_programid', $programid)->delete();
                break;
            case "infodoc":
                break;
        }

        return redirect('/myprograms');
    }

    function generateRandomString($length = 7) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    public function FinishProgramBuildIndex(Request $request, $programtype, $userid, $programid)
    {
        $program = Program::find($programid);
        $backurl = "/programbuilder/".$programtype."/".$userid."/".$programid;
        $publishurl = "/programbuilder/".$programtype."/".$userid."/".$programid."/publish";
        $deleteurl = "/programbuilder/".$programtype."/".$userid."/".$programid."/delete";

        $publishable = "yes";

        switch($programtype)
        {
            case "workout":
                $ProgramWorkout = Workout::where('workout_programid', $programid)->get();


                $publishable = "yes";
                if($ProgramWorkout->count() > 0)
                {
                    $emptyWorkout = Workout::where('workout_programid', $programid)
                        ->where('workout_daytype', 1)
                        ->where('workout_setcontent', '')->get();
                    if($emptyWorkout->count() > 0)
                    {
                        $publishable = "no";
                    }
                }
                else
                {
                    $publishable = "no";
                }
                break;
            case "nutrition":
                $ProgramNutrition = Food::where('food_programid', $programid)->get();
                if($ProgramNutrition->count() <= 0)
                {
                    $publishable = "no";
                }
                break;
            case "infodoc":
                $ProgramInfoDoc = Doc::where('doc_programid', $programid)->get();
                if($ProgramInfoDoc->count() <= 0)
                {
                    $publishable = "no";
                }
                else
                {
                    if( $ProgramInfoDoc->first()->doc_content == '')
                    {
                        $publishable = "no";
                    }
                }
                $ProgramWorkout = Workout::where('workout_programid', $programid)->get();
                break;
            default:
                break;
        }


        return view('publishprogram', compact('program', 'programtype', 'backurl', 'publishable', 'publishurl', 'deleteurl'));
    }

    public function ViewProgramDetailIndex($programtype, $userid, $programid)
    {
        $program = Program::find($programid);
        $noWeeks = $program->program_weeks;
        $programName = $program->program_name;

        $nexturl = "/programbuilder/".$programtype."/".$userid."/".$programid."/finish";
        $backurl = "/programbuilder/".$programtype."/".$userid."/".$programid."/edit";

        switch($programtype)
        {
            case "workout":
                return view('listexercises', compact('programName', 'noWeeks', 'userid', 'programid', 'nexturl', 'backurl', 'programtype'));
                break;
            case "nutrition":
                return view('listmeals', compact('programName', 'noWeeks', 'userid', 'programid', 'nexturl', 'backurl', 'programtype'));
                break;
            case "infodoc":
                return view('listdoc', compact('programName', 'noWeeks', 'userid', 'programid', 'nexturl', 'backurl', 'programtype'));
                break;
            default:
                break;
        }
    }

    public function PreviewProgram(Request $request)
    {
        $programid = $request->input('ProgramId');
        $programtype = $request->input('ProgramType');

        $weekid = $request->input('SelectedWeek');
        $dayid = $request->input('SelectedDay');

        $workouts = new Collection();

        if( (int)$weekid > 0)
        {
            if( (int)$dayid > 0)
            {
                switch($programtype)
                {
                    case "1":
                        $workouts = Workout::where('workout_programid', $programid)
                            ->where('workout_week', $weekid)
                            ->where('workout_day', $dayid)
                            ->orderBy('workout_day', 'asc')
                            ->get();
                        break;
                    case "2":
                        $workouts = Food::where('food_programid', $programid)
                            ->where('food_week', $weekid)
                            ->where('food_day', $dayid)
                            ->orderBy('food_day', 'asc')
                            ->get();
                        break;
                    case "3":
                        break;
                    default:
                        break;
                }
            }
            else
            {
                switch($programtype)
                {
                    case "1":
                        $workouts = Workout::where('workout_programid', $programid)
                            ->where('workout_week', $weekid)
                            ->orderBy('workout_day', 'asc')
                            ->get();
                        break;
                    case "2":
                        $workouts = Food::where('food_programid', $programid)
                            ->where('food_week', $weekid)
                            ->orderBy('food_day', 'asc')
                            ->get();
                        break;
                    case "3":
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
                case "1":
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
                case "2":
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
                case "3":

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
}