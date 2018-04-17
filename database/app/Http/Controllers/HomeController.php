<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('guest');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('welcome', array('title' => 'Welcome' ,'page' => 'FitHabit'));
    }

    public function programfinder()
    {

    }

    public function DisplayAbout()
    {
        return view('footer.About');
    }

    public function TermsService()
    {
        return view('footer.Terms');
    }

    public function RefundPolicy()
    {
        return view('footer.Refund');
    }
}
