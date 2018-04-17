<?php

namespace FitHabit\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB;

class BlogController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function BlogIndex()
    {
        $page = "Please display blog page content here.";
        return view('blog', compact('page'));
    }

}
