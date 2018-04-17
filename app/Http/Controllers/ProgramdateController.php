<?php

namespace FitHabit\Http\Controllers;

use FitHabit\Clientworkout;
use FitHabit\User;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ProgramdateController extends Controller
{
    public static function getCurWeekInfos($startdate, $curdate, $programID, $userID)
    {
        $curdayDiff = $curdate->diffIndays($startdate);
        $monday = $curdate->startOfWeek();
        $mondayDiff = $monday->diffInDays($startdate);

        $weekDayColor = ['#DADFE1', '#DADFE1', '#DADFE1', '#DADFE1', '#DADFE1', '#6BB9F0', '#6BB9F0'];

        for($i = 0; $i < 7; $i ++)
        {
            $weekdayDiff = $mondayDiff + $i;

            $weekDayWeek = (int)($weekdayDiff / 7) + 1;
            $weekDayDay = $weekdayDiff % 7 + 1;

            $dayWorkoutInfo = Clientworkout::where('clientworkout_userid', $userID)
                                            ->where('clientworkout_programid', $programID)
                                            ->where('clientworkout_week', $weekDayWeek)
                                            ->where('clientworkout_day', $weekDayDay)
                                            ->first();
            if($dayWorkoutInfo == null)
            {
                $weekDayColor[$i] = '#34495E';//EmptyDayColor  34495E
            }
            else
            {
                if($dayWorkoutInfo->clientworkout_daytype == 1)
                {
                    if($weekdayDiff > $curdayDiff)
                    {
                        //AvailableDayColor  DADFE1
                        $weekDayColor[$i] = '#DADFE1';
                    }
                    else
                    {
                        $dayProgress = $dayWorkoutInfo->clientworkout_dayprogress;
                        if($dayProgress < 1)
                        {
                            if($weekdayDiff == $curdayDiff)
                            {
                                //Current Progress Color   F89406
                                $weekDayColor[$i] = '#F89406';
                            }
                            else
                            {
                                //Missed Color EC644B
                                $weekDayColor[$i] = '#EC644B';
                            }
                        }
                        else
                        {
                            //CompletedDayColor    03C9A9
                            $weekDayColor[$i] = '#03C9A9';
                        }
                    }
                }
                else
                {
                    //RestDayColor  6BB9F0
                    $weekDayColor[$i] = '#6BB9F0';
                }
            }
            //$weekDayColor[$i] = $weekdayDiff;
        }
        //$weekDayColor[0] = $curdayDiff;
        return $weekDayColor;
    }
}
