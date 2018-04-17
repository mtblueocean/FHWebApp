<?php

namespace FitHabit;

use Illuminate\Database\Eloquent\Model;

class Food extends Model
{
    //
    protected $primaryKey = 'food_id';

    protected $fillable = [
        'food_programid',
        'food_week',
        'food_day',
        'food_daytype',
        'food_mealtype',
        'food_name',
        'food_quantity',
        'food_quantitytype',
        'food_protein',
        'food_fat',
        'food_carbs',
        'food_calories',
    ];

    protected $hidden = [

    ];
}
