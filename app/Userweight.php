<?php

namespace FitHabit;

use Illuminate\Database\Eloquent\Model;

class Userweight extends Model
{
    //
    protected $guarded = [];
    public $primaryKey = 'id';
    protected $fillable = ['userid', 'old', 'new', 'delta'];
}
