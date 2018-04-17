@extends('layouts.app')

@section('content')
    <section id="loginform"><!--form-->
        <div class="container">
            <div class="row center">
                <div class="col-sm-6" style="text-align: center">
                    <h4 class="customH4">Your Personal Training Business in the Palm of Your Hand</h4>                    

                    <iframe width="100%" height="315" src="https://www.youtube.com/embed/1lJu4cy0hhY?rel=0&amp;controls=0&amp;showinfo=0" frameborder="0" allowfullscreen></iframe>

                    <p class="rounded">Want to learn FitHabit live? Signup for an <a class="customlink" href="#"> upcoming class</a> </p>
                </div>
                <div class="col-sm-4  col-sm-offset-1" style="text-align: center">
                    <h2 class="customH2">Platform Edition Signup</h2>
                    <div class="signup-form"><!--sign up form-->
                        <form method="POST" action="{{ route('register') }}">
                            {{ csrf_field() }}
                            <input type="hidden" id="usertype" name="usertype" value="ptuser" />
                            <input id="name" type="text" name="name" id="name" placeholder="Name" value="{{ old('name') }}" autocomplete="off" required {{count($errors) == 0 || $errors->first('name') ? 'autofocus' : ''}}/>
                            <input id="email" type="email" name="email" placeholder="Email Address" value="{{ old('email') }}" autocomplete="off"  {{$errors->first('email') ? 'autofocus' : ''}}/>
                            <input id="password" type="password" name="password" pattern=".{6,}" placeholder="Password" autocomplete="off" required title="6 characters at minimum." {{$errors->first('password') ? 'autofocus' : ''}}/>
                            <input id="password-confirm" type="password" name="password_confirmation" pattern=".{6,}" placeholder="Confirm Password" autocomplete="off" required title="6 characters at minimum."/>

                            <button type="submit" style="width:97%; background-color: #EE5D4F;font-weight: bold" class="btn btn-default">TRY US OUT FOR 14 DAYS</button>

                            @if ($errors->has('name'))
                                <span class="help-block" style="color: red;">
                                    <strong>{{ $errors->first('name') }}</strong>
                                </span>
                            @endif

                            @if ($errors->has('email'))
                                <span class="help-block" style="color: red;">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                            @endif

                            @if ($errors->has('password'))
                                <span class="help-block" style="color: red;">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span>
                            @endif
                        </form>
                    </div><!--/sign up form-->
                </div>
            </div>           
        </div>
        <div class="step1">
            <div class="container">
                <h1><strong> Inside your Dashboard </strong></h1>
                <h4>We’re not a replacement for your website, we’re a power tool to help you generate<br>
                    more revenue and run your online personal training business more efﬁciently.</h4>
                <h4>With FitHabit Platform edition, there’s not need to send PDF’s, ask clients to send<br>
                    updated stats or manually change and mail out different versions of your program.</h4>
                <h4>You can do it here all in FitHabit.</h4>
                <img src="{{asset('images/home/ptregister/macbook.png')}}" class="macbook img-responsive" alt="" />
            </div>
        </div>

        <div class="step2">
            <div class="container">
                <h1><strong>Keep More of your Revenue</strong></h1>
                <h4>Not only does Fithabit manage your products and client, but we manage your payments too.</h4>
                <h4>Using Fithabit gives you more of your own money. All you need is a free Stripe account to get</h4>
                <h4>started and your off!</h4>

                <div class="row center">
                    <div class="col-sm-5" >
                        <div class="revenue">
                            <img src="{{asset('images/home/ptregister/clickbank.png')}}" class="revenueImg img-responsive" alt="" />
                        </div>
                        <h4>$47 one time activation charge <br> & $29.99 for additional accounts.</h4>
                        <h4>7.5% + $1 Transaction Fee</h4>
                        <h4>9.9% + $1 for recurring products over $40</h4>

                    </div>
                    <div class="col-sm-2">
                        <div class="betweenrevenue">

                        </div>
                    </div>
                    <div class="col-sm-5" >
                        <div class="revenue">
                            <img src="{{asset('images/home/ptregister/fhrevenue.png')}}" class="revenueImg img-responsive" alt="" />
                        </div>
                        <h4>6.0% + $1 Transaction Fee</h4>
                        <h4>That's it. Fithabit believes in keeping it <br> simple and letting you keep more money from the product you created.</h4>
                    </div>
                </div>
            </div>
        </div>

        <div class="step3">
            <div class="container">
                <h1><strong>More Features!</strong></h1>

                <div class="morefeature col-sm-6" >
                    <div class="featurerightpane">
                        <div class="row center">
                            <div class="col-sm-4" style="text-align: center">
                                <img src="{{asset('images/home/ptregister/openMarket.png')}}" class="featureimg"/>
                            </div>
                            <div class="col-sm-8">
                                <h4 style="font-size: 24px; font-weight: bold">Marketplace</h4>
                                <h4>Not only do can you sell your programs on your own site, you can make them available in the FitHabit Program Finder Marketplace for web & mobile. Everyone gets a 2 week preview of your program so they know exactly what they’re getting.</h4>
                            </div>
                        </div>
                        <div class="row center">
                            <div class="col-sm-4" style="text-align: center">
                                <img src="{{asset('images/home/ptregister/clientTracking.png')}}" class="featureimg"/>
                            </div>
                            <div class="col-sm-8">
                                <h4 style="font-size: 24px; font-weight: bold">Client Tracking</h4>
                                <h4>Never ask for a client update again! No need to send texts & emails back & forth to check in on your clients. View their progress from FitHabit’s web or mobile app including body stats, gym attendance, & diet adherence.</h4>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="morefeature col-sm-6" >
                    <div class="featurerightpane">
                        <div class="row center">
                            <div class="col-sm-8">
                                <h4 style="font-size: 24px; font-weight: bold">Sales Automation</h4>
                                <h4>No need to send clients to a download link. Stop wasting time setting up complex shopping carts. We’ve done it all for you.View your revenue & signups with a single click. All you need is a free Stripe account and you’re ready to go.</h4>
                            </div>
                            <div class="col-sm-4" style="text-align: center">
                                <img src="{{asset('images/home/ptregister/salesAutomation.png')}}" class="featureimg"/>
                            </div>

                        </div>
                        <div class="row center">
                            <div class="col-sm-8">
                                <h4 style="font-size: 24px; font-weight: bold">Grow your business</h4>
                                <h4>Save time & money. Don’t waste your money trying to build your own app. We’re software developers & know what it takes to build, maintain, & innovate. Getting clients is enough work by itself, let FitHabit do the work for you.</h4>
                            </div>
                            <div class="col-sm-4" style="text-align: center">
                                <img src="{{asset('images/home/ptregister/growYourBiz.png')}}" class="featureimg"/>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="step4">
            <div class="container">
                <h1><strong>How much does FitHabit Personal Trainer Cost?</strong></h1>
                <h4>The better question is what is not having FitHabit</h4>
                <h4>Personal Trainer Edition costing you every month?</h4>
                <img src="{{asset('images/home/ptregister/macbook.png')}}" class="macbook img-responsive" alt="" />

                <h1><strong>Just $37/month</strong></h1>
                <h4>or save $74 (2 months) and pay just $370 for a year</h4>
                <form class="form-ptregister">
                    <!--<button type="submit" data-toggle="modal" data-target="#squarespaceModal" style="background-color: #EE5D4F;font-weight: bold" class="btn btn-default">GET STARTED</button>-->
                    <button type="button" id="btnStart" name="btnStart" style="background-color: #EE5D4F;font-weight: bold" class="btn btn-default">GET STARTED</button>
                </form>
            </div>
        </div>


        <!-- line modal -->
        <div class="modal fade" id="squarespaceModal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
            <div class="modal-dialog" >
                <div class="modal-content" style="background-color: #f3f1f5">
                        <button type="button" class="close customed" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
                    <h3 class="registerModalTitle" id="lineModalLabel">STEP 2 OF 2: <p class="lead"><b>START YOUR FREE 14 DAY TRIAL!</b></p></h3>
                    <h3 class="registerModalTitleDescription" id="linemodeldescription"><strong>No contracts, downgrade or cancel your account anytime<br>with a single click from your dashboard...</strong></h3>

                    <div class="modal-body">
                        <!-- content goes here -->
                        <form >

                            <div class="modal-form" style="padding: 30px 30px 15px 30px">
                                <label style="margin-bottom:20px; font-size:15px;" for="exampleInputEmail1"><b>Add Credit Card</b></label>
                                <a style="float:right; color: #2a6496" href="#">Why do we ask for your credit card?</a>
                                <div class="form-group">

                                    <input type="firstname" class="form-control" id="firstname" placeholder="First name">
                                </div>
                                <div class="form-group">
                                    <input type="lastname" class="form-control" id="lastname" placeholder="Last name">
                                </div>
                                <div class="form-group">
                                    <input type="cardnum" class="form-control" id="cardnum" placeholder="Credit Card Number">
                                </div>
                                <div class="form-group">
                                    <input style="width:69%;" type="expdate" class="form-control" id="expdate" placeholder="Expiration Date">

                                    <input style="width:30%; float: right" type="cvvcode" class="form-control" id="cvvcode" placeholder="CVV Code...">
                                </div>
                                <div class="form-group">
                                    <input type="zip" class="form-control" id="zip" placeholder="Zip">
                                </div>
                                <label style="width:100%;font-size:15px;margin-top: 15px;text-align: center">Free for 14 days then $0.00 a month until cancelled.</label>
                            </div>
                            <label style="color:#3b366f; font-size:15px;margin-top: 20px; width: 100%; text-align: center">By clicking the button below you agree to our <a href="#" style="color: red">Terms of Service</a></label>
                            <div>
                                <button type="submit" style="width: 99%; height: 50px; background-color: #EE5D4F;color: white; font-weight: bold" class="btn btn-default">CREATE MY FITHABIT PERSONAL TRAINER ACCOUNT NOW</button>
                            </div>
                        </form>
                        <div>
                            <label style="width:100%; text-align:center;color:#3b366f; font-size:15px;margin-top: 30px;" for="exampleInputEmail1">Logged in as rhb@fithabit.io<br>Not your user? <a href="#" style="color:#3b366f; font-style: italic; font-weight: bold"> Logout</a></label>
                        </div>

                    </div>

                </div>
            </div>
        </div>
    </section><!--/form-->

    <script>
        $('#btnStart').on("click",function(){
            $("html, body").animate({ scrollTop: 0 }, 500);
            return false;
        });
    </script>
@endsection