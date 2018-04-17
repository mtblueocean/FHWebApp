<?php

namespace FitHabit;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;

class Program extends Model
{
    use Notifiable;
    //program_id
    /*protected $fillable = [
        'program_name',
        'program_type',
        'program_maker',
        'program_image',
        'program_description',
        'program_price',
        'program_soldcount',
        'program_ispublished',
        'program_publishdate',
        'program_istrial',
        'program_trialdays',
        'program_trialstartdate',
        'program_weeks',
        'program_isfree',
        'program_kind',
        'program_active',
        'program_sharelink'
    ];*/
    protected $primaryKey = 'program_id';

    protected $fillable = [
        'program_name',
        'program_description',
        'program_type',
        'program_maker',
        'program_price',
        'program_weeks',
        'program_kind',
        'program_isfree',
    ];

    protected $hidden = [

    ];

    public function user()
    {
        return $this->hasOne('FitHabit\User','id','program_maker');
    }
}
