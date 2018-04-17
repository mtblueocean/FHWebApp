<?php

namespace FitHabit;

use Illuminate\Database\Eloquent\Model;

class UserProgram extends Model
{
    //
    protected $table = 'userprograms';
    protected $primaryKey = 'userprogram_id';

    protected $guarded = [];

    protected $fillable = [
        'userprogram_userid',
        'userprogram_programid',
        'userprogram_activestatus',
        'userprogram_makerid',
    ];

    protected $hidden = [

    ];



    public function programMaker()
    {
        return $this->hasOne('FitHabit\User','id','userprogram_makerid');
    }

    public function programPurchaser()
    {
        return $this->hasOne('FitHabit\User','id','userprogram_userid');
    }

    public function program()
    {
        return $this->hasOne('FitHabit\Program', 'program_id', 'userprogram_programid');
    }

    public function workoutinfo()
    {
        return $this->hasMany('FitHabit\Clientworkout', 'clientworkout_userid', 'userprogram_userid')->orWhere('clientworkout_programid', 'userprogram_programid');
            //->hasMany('FitHabit\Clientworkout', 'clientworkout_programid', 'userprogram_programid');
    }

    public function nutritioninfo()
    {
        return $this->hasMany('FitHabit\Clientnutrition', 'clientnutrition_userid', 'userprogram_userid')->orWhere('clientnutrition_programid', 'userprogram_programid');
    }
}
