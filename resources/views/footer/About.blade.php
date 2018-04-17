@extends('layouts.app')

@section('content')

    @if(Auth::guest())
        <div class="dashboardBackground" style="margin-top: 80px;">
            <div class="dashboardContent">
    @else
        <div class="dashboardBackground">
            <div class="dashboardContent">
    @endif

            <div class="row about" style="padding: 20px 50px">                   
                <p class="p1">About</p>                  
                <div class="col-sm-12 col-md-12 col-lg-12">                        
                    <p class="p3">FitHabit is a Health and Wellness company for everyone. While we do make software, we 
don’t believe that there is a one size fits all solution to get in shape like other apps that pre-package 12 week transformation packages. We believe the key to getting in shape is not
through technology that gives your fancy graphs and charts to show people their progress. We don’t believe in glossy Hollywood style productions for everyday people to follow along to. </p>
                    <p class="p3">So what do we believe in?</p>                   
                    <p class="p3">We believe in you. People are inspired by people, not apps. People are inspired by your 
dedication, not bits of data. People are inspired by results, not marketing hype. </p>
                    <p class="p3">FitHabit is going to give you the tools you need to transform the your life and the lives of 
hundreds, thousands, and maybe even of millions of people like you. Together we will create a stronger version of all of us.<br /><br /><br /></p>
                    <p class="p3">Sincerely,<br /><br /></p>
                    <p class="p3">RH Blanchfeld<br />Founder FitHabit.io</p>
                </div>
            </div>
        </div>
    </div>
   
@endsection
