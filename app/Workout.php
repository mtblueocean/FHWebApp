<?php

namespace FitHabit;

use Illuminate\Database\Eloquent\Model;

class Workout extends Model
{
    protected $primaryKey = 'workout_id';

    protected $fillable = [
        'workout_programid',
        'workout_week',
        'workout_day',
        'workout_daytype',
        'workout_extype',
        'workout_musclegroup',
        'workout_exname',
        'workout_exid',
        'workout_order',
        'workout_sets',
        'workout_setcontent',
    ];

    protected $hidden = [

    ];
}
