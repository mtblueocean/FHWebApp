<?php

namespace FitHabit;

use Illuminate\Database\Eloquent\Model;

class Userbodyfat extends Model
{
    //
    protected $guarded = [];
    public $primaryKey = 'id';
    protected $fillable = ['userid', 'old', 'new', 'delta'];
}
