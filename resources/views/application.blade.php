@extends('layouts.app')

@section('content')
    <section id="loginform" style="margin-bottom: 0px"><!--form-->
        <style>
            /* Tooltip on top */
            .round-button-circle-rest + .tooltip > .tooltip-inner {
                background-color: #30588e;
                color: #FFFFFF;
                border: 1px solid #30588e;
                padding: 15px;
                font-size: 20px;
                margin-top: 79px;
                margin-left: 50px;
            }

            .round-button-circle-rest + .tooltip.top > .tooltip-arrow {
                border-top: 20px solid #30588e;
            }

            .round-button-circle-miss + .tooltip > .tooltip-inner {
                background-color: #b01303;
                color: #FFFFFF;
                border: 1px solid #b01303;
                padding: 15px;
                font-size: 20px;
                margin-top: 79px;
                margin-left: 50px;
            }

            .round-button-circle-miss + .tooltip.top > .tooltip-arrow {
                border-top: 20px solid #b01303;
            }

            .round-button-circle-complete + .tooltip > .tooltip-inner {
                background-color: #2c8f1e;
                color: #FFFFFF;
                border: 1px solid #2c8f1e;
                padding: 15px;
                font-size: 20px;
                margin-top: 79px;
                margin-left: 50px;
            }

            .round-button-circle-complete + .tooltip.top > .tooltip-arrow {
                border-top: 20px solid #2c8f1e;
            }
        </style>
        <div class="applicationstep1">
            <div class="container">
                <img src="{{asset('images/home/applicationTitle.png')}}" class="applicationtitleimg img-responsive" alt="" />



                <h4>Fit Habit is a Health and Wellness company for everyone.</h4>
                <div class="conainer applicationsection1Back">
                    <br>
                <h4>While we do make software, we don't believe that there is one size fts all</h4>
                <h4>solution to get in shape like other apps that prepackage 12 week transformation packages.</h4>
                <h4>We believe the key to getting in shape is not through technology that gives</h4>
                <h4>people fancy graphs and charts to track their progress.</h4>
                <h4>We don’t believe in glossy Hollywood style productions for everyday people to follow along to.</h4>
                <br><h4>So what do we believe in?</h4><br>
                <h4>We believe in you. People are inspired by people, not apps. People are inspired by your</h4>
                <h4>dedication, not bits of data. People are inspired by results, not marketing hype.</h4>
                <br>
                <h4>FitHabit is going to give you the tools you need to transform the your life and the lives of hundreds,</h4>
                <h4>thousands, and maybe even of millions of people like you.</h4>
                <br>
                <h4>Together we will create a stronger version of all of us.</h4>
                    <br>
                    <br>
                </div>
            </div>
        </div>
        <div class="applicationstep2">
            <div class="container" >
                <div class="row center">
                    <div class="col-sm-6 col-md-6 col-lg-6 pull-left" >
                        <div class="applicationstep2halfdiv">
                            <div class="row center">
                                <div class="col-sm-6 col-md-6 col-lg-6" >
                                    <div class="leftdiv">
                                        <img class="applicationstep2Phoneimg" src="{{asset('images/home/phone1.png')}}"/>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-md-6 col-lg-6" >
                                    <div style="text-align:left;margin-top: 60px; margin-right: 20px">
                                        <h3>We know fitness.</h3>
                                        <br>
                                        <h4> We didn’t make just another fitness app. FitHabit was developed by a former US Navy Physical Fitness Coordinator and created based
                                            on our experiences on finding the right workout progam, tracking our progress, and working with online personal trainers.

                                        <br>
                                        <br>
                                            It doesn’t matter if you can you can make it to the gym 3 days a week
                                            or 7. Or even if you are Paleo or a Vegan, FitHabit wants you to find the perfect program that fits your life.</h4>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="col-sm-6 col-md-6 col-lg-6 pull-right">
                        <div class="applicationstep2halfdiv">
                            <div class="row center" style="padding-left: 15px; padding-right: 15px">
                                <img class="applicationstep2Phoneimg" src="{{asset('images/home/discuss.jpg')}}"/>
                                <h5>Built by everyday people for everyday people.</h5>
                                <h6>For many people, going to the gym and keeping track of their diet is complex.
                                    <br>We make it simple for you to track your progress in weight management, workouts and nutrition.</h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="applicationstep3">
            <div class="container">
                <img src="{{asset('images/home/findprogram.png')}}" class="applicationtitleimg img-responsive" alt="" />
                <div class="row center">
                    <div class="col-sm-4" >
                        <img src="{{asset('images/home/kettle.png')}}" class="applicationfindprogramImg img-responsive" alt="" />
                    </div>
                    <div class="col-sm-4" >
                        <img src="{{asset('images/home/cap.png')}}" class="applicationfindprogramImg img-responsive" alt="" />
                    </div>
                    <div class="col-sm-4" >
                        <img src="{{asset('images/home/file.png')}}" class="applicationfindprogramImg img-responsive" alt="" />
                    </div>
                </div>
                <h3>50 Free Programs & programs by the best online personal trainers with more being added daily. Find the perfect program for you.</h3>
                <div style="text-align: center; margin-top: 50px; margin-bottom: 50px">
                    <a href="/register">Signup and get a program</a>
                    <br>
                    <br>
                    <br>
                    <a href="/register/pt" style="font-size: 25px; font-weight: normal">Online personal trainer? Add your programs to the FitHabit Program Finder Marketplace.</a>
                </div>
            </div>
        </div>

        <div class="divtrackyourprogress">
            <h1>Track Your Progress</h1>

            <div style="width: 90%; margin-top: 100px; margin-left: 5%; margin-right: 5%;float: left">
                <div class="rounddiv">
                    <div class="round-button"><div class="round-button-circle-complete" data-toggle="tooltip" data-placement="top" title="Completed Day"><a class="round-button">Mo</a></div></div>
                </div>
                <div class="rounddiv">
                    <div class="round-button"><div class="round-button-circle-complete" data-toggle="tooltip" data-placement="top" title="Completed Day"><a class="round-button">Tu</a></div></div>
                </div>
                <div class="rounddiv">
                    <div class="round-button"><div class="round-button-circle-miss" data-toggle="tooltip" data-placement="top" title="Missed Day"><a class="round-button">We</a></div></div>
                </div>
                <div class="rounddiv">
                    <div class="round-button"><div class="round-button-circle-complete" data-toggle="tooltip" data-placement="top" title="Completed Day"><a class="round-button">Th</a></div></div>
                </div>
                <div class="rounddiv">
                    <div class="round-button"><div class="round-button-circle-complete" data-toggle="tooltip" data-placement="top" title="Completed Day"><a class="round-button">Fr</a></div></div>
                </div>
                <div class="rounddiv">
                    <div class="round-button"><div class="round-button-circle-rest" data-toggle="tooltip" data-placement="top" title="Rest Day"><a class="round-button">Sa</a></div></div>
                </div>
                <div class="rounddiv">
                    <div class="round-button"><div class="round-button-circle-rest"  data-toggle="tooltip" data-placement="top" title="Rest Day"><a class="round-button">Su</a></div></div>
                </div>
            </div>
            <h2 style="margin-bottom: 50px">(Hover over button)</h2>

            <h2>Whether workout or nutrition, know where you stand in your progress day by day.</h2>
                <h2>FitHabit sends you reminders on the days you are scheduled to go to the gym to help</h2>
            <h2>you stay on habit. Remember, success or failure is just a few habits repeated daily.</h2>
        </div>

        <div class="step1">
            <div class="container">
                <h1><strong>See Fit Habit in action</strong></h1>
                <div style="width: 100%; text-align: center; margin-bottom: 50px">
                    <iframe width="560" height="315" src="https://www.youtube.com/embed/FDVUVtazCpI?rel=0&amp;showinfo=0" frameborder="0" allowfullscreen></iframe>
                </div>
            </div>
        </div>
        <div class="step2" style="margin-top: 30px">
                <div class="row" style="margin-top: 30px">
                    <div class="col-sm-3">
                        <h3>Notifications</h3>
                        <img src="{{asset('images/home/notification.png')}}" class="applicationfourprogramImg img-responsive" alt="" />
                    </div>
                    <div class="col-sm-3">
                        <h3>Check In</h3>
                        <img src="{{asset('images/home/location.png')}}" class="applicationfourprogramImg img-responsive"  alt="" />
                    </div>
                    <div class="col-sm-3">
                        <h3>Progress Photos</h3>
                        <img src="{{asset('images/home/progress.png')}}" class="applicationfourprogramImg img-responsive" style="margin-top: 10px" alt="" />
                    </div>
                    <div class="col-sm-3">
                        <h3>Share</h3>
                        <img src="{{asset('images/home/share.png')}}" class="applicationfourprogramImg img-responsive" alt="" />
                    </div>
                </div>
        </div>

        <div class="wrap" style="margin-top: 0px; margin-bottom: 0px">
            <img src="{{asset('images/home/strongMan.jpeg')}}" class="applicationfourprogramImg img-responsive" style="margin-bottom: 0px" alt="" />
            <div class="text_over_image">
                <h1>BUILD A STRONGER YOU</h1>
            </div>
            <div class="row appstoreimg">
                <div class="col-sm-6" style="text-align: right">
                    <a href="https://itunes.apple.com/us/app/fithabit/id1029906992?mt=8">
                        <img src="{{asset('images/home/apple.png')}}" class="applicationfourprogramImg img-responsive " style="margin-bottom: 0px; margin-right:40px; width: 210px; float: right" alt="" />
                    </a>
                </div>
                <div class="col-sm-6" style="text-align: left">
                    <a href="#">
                        <img src="{{asset('images/home/google.png')}}" class="applicationfourprogramImg img-responsive" style="margin-bottom: 0px; margin-left: 40px; width: 233px; float: left" alt="" />
                    </a>
                </div>
            </div>

        </div>
    </section><!--/form-->

    <script>
        $(function () {
            $('[data-toggle="tooltip"]').tooltip()
        })

    </script>
@endsection