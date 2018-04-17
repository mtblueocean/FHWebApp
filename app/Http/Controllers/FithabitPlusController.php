<?php

namespace FitHabit\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB;

class FitHabitPlusController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function FithabitPlusIndex()
    {
        $page = "Please display FitHabit page content here.";
        return view('fithabitplus', compact('page'));
    }

}
