@extends('layouts.app')

@section('content')

    <style>
        video {
            margin-top: 10px;
            max-width: 100%;
            height: auto;
            background-color: #0a97b9;
            border-style: solid;
            border-width: 1px;
            margin-bottom: 20px;
        }
    </style>

    <div class="dashboardBackground">
        <div class="dashboardContent">

            <div>
                <p style="margin-bottom:20px;margin-top:20px;margin-left:40px;font-size: 30px; font-weight: bold"><b>Create a Program</b></p>
            </div>
            <div class="row" style="margin-left:auto; margin-right:auto; width: 70%;">
                <div class="col-sm-4 col-md-4 col-lg-4" style="padding: 10px">
                    <div class="createprogrampane">
                        <div style="text-align:center;margin-bottom:20px; position: relative; vertical-align: bottom">

                                <img style="width: 100%" src="{{asset('images/dashboard/workoutprogram.png')}}" alt=""/>
                                <div class="caption" style="vertical-align: bottom">
                                    <p style="font-size: 35px; color: white; font-weight: bold; text-shadow: 2px 2px #424242;">WORKOUT</p>
                                </div>
                        </div>

                        <div style="text-align:center;margin-bottom:42px;">
                            <label style="font-size: 16px; word-wrap: break-word; width: 95%">Build workout programs for users to track and follow their progress through FitHabit's simple to use interface.<br> Your workout programs are tracked and recorded for you and your client in the app.</label>
                        </div>

                        <div style="text-align:center;margin-bottom:20px;">
                            <a href="{{ url('/programbuilder/workout') }}" style="margin-bottom: 30px; width: 60%; height: 50px; padding-top: 10px; background-color: #61ce7b; font-size:20px;color: white; font-weight: bold" class="btn btn-default">Workout</a>
                        </div>
                    </div>
                </div>

                <div class="col-sm-4 col-md-4 col-lg-4" style="padding: 10px">
                    <div class="createprogrampane">
                        <div style="text-align:center;margin-bottom:20px; position: relative; vertical-align: bottom">

                            <img style="width: 100%" src="{{asset('images/dashboard/nutritionprogram.png')}}" alt=""/>
                            <div class="caption" style="vertical-align: bottom">
                                <p style="font-size: 35px; color: white; font-weight: bold; text-shadow: 2px 2px #424242;">NUTRITION</p>
                            </div>
                        </div>

                        <div style="text-align:center;margin-bottom:42px;">
                            <label style="font-size: 16px; word-wrap: break-word; width: 95%">Build the perfect nutrition plans for your clients.<br>Create meals, portion sizes, and macronutrient ratios with ease. You can even edit client portions to fit their needs as they progress in your program.</label>
                        </div>

                        <div style="text-align:center;margin-bottom:20px;">
                            <a href="{{ url('/programbuilder/nutrition') }}" style="margin-bottom: 30px; width: 60%; height: 50px; padding-top: 10px; background-color: #61ce7b; font-size:20px;color: white; font-weight: bold" class="btn btn-default">Nutrition</a>
                        </div>
                    </div>
                </div>

                <div class="col-sm-4 col-md-4 col-lg-4" style="padding: 10px">
                    <div class="createprogrampane">
                        <div style="text-align:center;margin-bottom:20px; position: relative; vertical-align: bottom">

                            <img style="width: 100%" src="{{asset('images/dashboard/infoprogram.png')}}" alt=""/>
                            <div class="caption" style="vertical-align: bottom">
                                <p style="font-size: 35px; color: white; font-weight: bold; text-shadow: 2px 2px #424242;">INFO DOC</p>
                            </div>
                        </div>

                        <div style="text-align:center;margin-bottom:20px;">
                            <label style="font-size: 16px; word-wrap: break-word; width: 95%">Create beautiful information products for your followers and clients. You can insert video, images, and text which are rendered beautifully in FitHabit. You can easily update your info products and publish changes in real time.</label>
                        </div>

                        <div style="text-align:center;margin-bottom:20px;">
                            <a href="{{ url('/programbuilder/infodoc') }}" style="margin-bottom: 30px; width: 60%; height: 50px; padding-top: 10px; background-color: #61ce7b; font-size:20px;color: white; font-weight: bold" class="btn btn-default">Info Docs</a>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
