<?php

namespace FitHabit\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB;

class AccountSettingsController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function AccountSettingsIndex()
    {
        $page = "Please display account settings page content here.";
        return view('accsettings', compact('page'));
    }

}
