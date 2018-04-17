<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserProgram extends Model
{
    //
    protected $table = 'userprograms';
    protected $primaryKey = 'userprogram_id';

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
        return $this->hasOne('App\User','id','userprogram_makerid');
    }

    public function programPurchaser()
    {
        return $this->hasOne('App\User','id','userprogram_userid');
    }
}
