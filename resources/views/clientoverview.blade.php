@extends('layouts.app')

@section('content')

    <div class="dashboardBackground">
        <div class="dashboardContent">
            <div><!--header-->
                <div class="row">
                    <div class="col-sm-4">
                        <p style="margin-bottom:10px;margin-top:20px;margin-left:40px;font-size: 30px; font-weight: bold"><b>Client Overview</b></p>
                    </div>
                    <div class="col-sm-8">
                        <a href="/clientoverview/{{$userinfo->id}}"  class="btnViewWholeData">View full user workout, nutrition data</a>
                    </div>
                </div>
                <!--split-->
                <div style="border-width: 1px; border-style: solid; margin-left: 30px; margin-right: 30px">
                </div><!--split-->
            </div><!--header-->
            <div><!--Contents-->
                <div class="row">
                    <div class="col-sm-3"><!--profile picture div-->
                        <div style="text-align:center;margin-top:30px;margin-bottom:20px;">
                            @if ($userinfo->user_profilepicurl == "")
                                <a class="bigProfile"><img class="clientprofile img-circle" src="{{asset('images/dashboard/emptyprofile.jpg')}}" alt="" /></a>
                            @else
                                <a class="bigProfile"><img class="clientprofile img-circle" src="{{asset($userinfo->user_profilepicurl)}}" alt="" /></a>
                            @endif

                        </div>
                    </div>
                    <div class="col-sm-5"><!--status div-->
                        <div style="margin-top: 20px">
                            <p style="font-size: 18px; font-weight: bold; vertical-align: bottom"><b>{{$userinfo->name}}</b></p>
                            @if ($userinfo->user_bioinfo == "")
                                <p style="font-size: 15px; vertical-align: top; margin-top: -10px">no bioinfo</p>
                            @else
                                <p style="font-size: 15px; vertical-align: top; margin-top: -10px">{{$userinfo->user_bioinfo}}</p>
                            @endif

                        </div>
                        <div class="row">
                            <div class="col-sm-3" style="padding-top: 20px">
                                <p style="font-size: 18px; font-weight: bold;"><b>Weight</b></p>
                                @if($userinfo->user_fat == 0)
                                    <p style="font-size: 32px; font-weight: bold;"><b>---</b></p>
                                @else
                                    <p style="font-size: 32px; font-weight: bold;"><b>{{$userinfo->user_weight}}</b></p>
                                @endif
                            </div>
                            <div class="col-sm-3" style="padding-top: 20px; text-align: center">
                                <p style="font-size: 18px; font-weight: bold;"><b>Body Fat</b></p>
                                @if($userinfo->user_fat == 0)
                                    <p style="font-size: 32px; font-weight: bold;"><b>---</b></p>
                                @else
                                    <p style="font-size: 32px; font-weight: bold;"><b>{{$userinfo->user_fat}}%</b></p>
                                @endif
                            </div>
                            <div class="col-sm-3" style="text-align: center;">
                                <p style="font-size: 15px;">workout</p>
                                <div class="workoutchart" data-percent="{{$workoutpercent}}"></div>
                            </div>
                            <div class="col-sm-3" style="text-align: center;">
                                <p style="font-size: 15px;">nutrition</p>
                                <div class="nutritionchart" data-percent="{{$nutritionpercent}}"></div>
                            </div>
                        </div>
                        <div class="row" style="margin-bottom: 30px">
                            <div class="col-sm-3" style="padding-top: 40px">
                                <p style="font-size: 18px; font-weight: bold;"><b>Accuracy</b></p>
                                <p style="font-size: 28px; font-weight: bold;"><b>{{$accuracy}} %</b></p>
                            </div>
                            <div class="col-sm-3" style="padding-top: 40px; text-align: center">
                                <p style="font-size: 18px; font-weight: bold;"><b>FitDays</b></p>
                                <p style="font-size: 28px; font-weight: bold;"><b>{{$fiddays}}</b></p>
                            </div>
                            <div class="col-sm-3" style="padding-top: 40px; text-align: center">
                                <p style="font-size: 18px; font-weight: bold;"><b>Missed</b></p>
                                <p style="font-size: 28px; font-weight: bold;"><b>{{$misseddays}}</b></p>
                            </div>
                            <div class="col-sm-3" style="padding-top: 40px; text-align: center">
                                <p style="font-size: 18px; font-weight: bold;"><b>Rest</b></p>
                                <p style="font-size: 28px; font-weight: bold;"><b>{{$restdays}}</b></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4" style="padding-left: 20px"><!--weekview div-->
                        <div style="padding-left:10px;margin-top: 20px">
                            <p style="font-size: 18px; font-weight: bold; vertical-align: bottom"><b>This Week</b></p>
                        </div>
                        <div style="text-align:center;margin-top:30px;margin-bottom:20px; margin-right: 30px;">
                            <button class="weekview futureday" style="background-color: {{$curWeekDayInfo[0]}};" href="{{ url('/') }}">Mo</button>
                            <button class="weekview futureday" style="background-color: {{$curWeekDayInfo[1]}};" href="{{ url('/') }}">Tu</button>
                            <button class="weekview futureday" style="background-color: {{$curWeekDayInfo[2]}};" href="{{ url('/') }}">We</button>
                            <button class="weekview futureday" style="background-color: {{$curWeekDayInfo[3]}};" href="{{ url('/') }}">Th</button>
                            <button class="weekview futureday" style="background-color: {{$curWeekDayInfo[4]}};" href="{{ url('/') }}">Fr</button>
                            <button class="weekview restday" style="background-color: {{$curWeekDayInfo[5]}};" href="{{ url('/') }}">Sa</button>
                            <button class="weekview restday" style="background-color: {{$curWeekDayInfo[6]}};" href="{{ url('/') }}">Su</button>
                        </div>

                        <div style="margin-top:30px; margin-right: 30px;">
                            <div style="text-align: left" class="col-sm-8">
                                <p style="font-size: 18px; font-weight: bold;"><b>Programs</b></p>
                                @if($activeprogram == "")
                                    <p style="font-size: 18px;">No Data to display</p>
                                @else
                                    <p style="font-size: 18px;">{{$activeprogram->program_name}}</p>

                                    @if($activenutritionprogram == "")
                                    @else
                                        <p style="font-size: 18px;">{{$activenutritionprogram->program_name}}</p>
                                    @endif
                                @endif
                            </div>

                            <div class="col-sm-4" style="padding-top:5px; text-align: right;">
                                <p style="font-size: 15px; font-weight: bold;"><b>Start Date</b></p>

                                @if($activeprogram == "")
                                    <p style="font-size: 15px; padding-top:3px; font-weight: bold;"><b>--/--/--</b></p>
                                @else
                                    @if($strdate == "")
                                        <p style="font-size: 15px; padding-top:3px; font-weight: bold;"><b>--/--/--</b></p>
                                    @else
                                        <p style="font-size: 18px;">{{$strdate}}</p>
                                    @endif

                                    @if($activenutritionprogram == "")
                                    @else
                                        @if($nutdate == "")
                                            <p style="font-size: 15px; padding-top:3px; font-weight: bold;"><b>--/--/--</b></p>
                                        @else
                                            <p style="font-size: 18px;">{{$nutdate}}</p>
                                        @endif
                                    @endif
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!--scripts-->
    <script src="{{asset('js/jquery.circlechart.js')}}"></script>

    <script>
        //$('.demo').percentcircle();

        $('.workoutchart').percentcircle({
            animate : true,
            diameter : 100,
            guage: 2,
            coverBg: '#fff',
            bgColor: '#efefef',
            fillColor: '#27bF61',
            percentSize: '15px',
            percentWeight: 'normal',
        });

        $('.nutritionchart').percentcircle({
            animate : true,
            diameter : 100,
            guage: 2,
            coverBg: '#fff',
            bgColor: '#efefef',
            fillColor: '#27bF61',
            percentSize: '15px',
            percentWeight: 'normal',
        });
    </script>

@endsection