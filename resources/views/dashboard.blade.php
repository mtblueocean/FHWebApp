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
                <div class="row" style="padding-left: 20px; padding-right: 20px; padding-top: 20px; padding-bottom: 20px">
                    <div class="col-sm-5 col-md-5 col-lg-5">
                        <div>
                            <p style="margin-bottom:20px;margin-left:20px;font-size: 30px; font-weight: bold"><b>Dashboard</b></p>
                        </div>
                        <div style="margin-bottom:20px;">

                                {!! $chartjs->render() !!}

                        </div>
                        <div>
                            <div class="row">
                                <div class="col-sm-6 col-md-6 col-lg-6">
                                    <p style="margin-left:20px;font-size: 20px; font-weight: bold"><b>YTD SignUps</b></p>
                                </div>
                                <div class="col-sm-6 col-md-6 col-lg-6">
                                    <p style="margin-left:20px;font-size: 20px; font-weight: bold"><b>YTD Revenue</b></p>
                                </div>
                            </div>
                            <div  class="row rowdivider">

                            </div>
                            <div class="row">
                                <div class="col-sm-6 col-md-6 col-lg-6">
                                    <p style="margin-left:20px; font-weight: bold" class="btn dashboard-btn dashboard-btn-left"><b>{{$ytdsignup}}</b></p>
                                </div>
                                <div class="col-sm-6 col-md-6 col-lg-6">
                                    <p style="margin-left:20px; font-weight: bold" class="btn dashboard-btn dashboard-btn-left"><b>$0</b></p>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="col-sm-4 col-md-4 col-lg-4">
                        <div style="margin-top: 10px">
                            <p style="margin-bottom:20px;margin-left:20px;font-size: 18px; font-weight: bold; vertical-align: bottom"><b>This Month</b></p>
                        </div>
                        <div style="margin-top: 40px">
                            <div class="row">
                                <div class="col-sm-6 col-md-6 col-lg-6">
                                    <p style="margin-bottom:15px;margin-left:20px;font-size: 16px; vertical-align: bottom">Sign Ups</p>
                                </div>
                                <div class="col-sm-6 col-md-6 col-lg-6">
                                    <p style="text-align:right;margin-left:20px; font-weight: bold" class="btn dashboard-btn dashboard-btn-right"><b>{{$monthsignup}}</b></p>
                                </div>
                            </div>
                        </div>
                        <div style="margin-top:22px">
                            <div class="row">
                                <div class="col-sm-6 col-md-6 col-lg-6">
                                    <p style="margin-bottom:15px;margin-left:20px;font-size: 16px; vertical-align: bottom">Program Ups</p>
                                </div>
                                <div class="col-sm-6 col-md-6 col-lg-6">
                                    <p style="text-align:right;margin-left:20px; font-weight: bold" class="btn dashboard-btn dashboard-btn-right"><b>{{$monthprogramsignup}}</b></p>
                                </div>
                            </div>
                        </div>

                        <div style="margin-top: 22px">
                            <div class="row">
                                <div class="col-sm-6 col-md-6 col-lg-6">
                                    <p style="margin-bottom:15px;margin-left:20px;font-size: 16px; vertical-align: bottom">Revenue</p>
                                </div>
                                <div class="col-sm-6 col-md-6 col-lg-6">
                                    <p style="text-align:right;margin-left:20px; font-weight: bold" class="btn dashboard-btn dashboard-btn-right"><b>$0</b></p>
                                </div>
                            </div>
                        </div>
                        <div style="margin-top: 70px">
                            <p style="margin-bottom:20px;margin-left:20px;font-size: 18px; font-weight: bold; vertical-align: bottom"><b>OverView</b></p>
                        </div>

                        <div>
                            <div class="row">
                                <div class="col-sm-8 col-md-8 col-lg-8">
                                    <p style="margin-bottom:20px;margin-left:20px;font-size: 16px; vertical-align: bottom">Workout Programs</p>
                                </div>
                                <div class="col-sm-4 col-md-4 col-lg-4">
                                    <p style="text-align:right;margin-left:20px;font-size: 16px;"><b>{{$workcount}}</b></p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-8 col-md-8 col-lg-8">
                                    <p style="margin-bottom:20px;margin-left:20px;font-size: 16px; vertical-align: bottom">Nutrition Programs</p>
                                </div>
                                <div class="col-sm-4 col-md-4 col-lg-4">
                                    <p style="text-align:right;margin-left:20px;font-size: 16px;"><b>{{$nutcount}}</b></p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-8 col-md-8 col-lg-8">
                                    <p style="margin-bottom:20px;margin-left:20px;font-size: 16px; vertical-align: bottom">Information Programs</p>
                                </div>
                                <div class="col-sm-4 col-md-4 col-lg-4">
                                    <p style="text-align:right;margin-left:20px;font-size: 16px;"><b>{{$doccount}}</b></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-3 col-md-3 col-lg-3" style="margin-top: 16px">
                        <iframe width="100%" height="160px" src="https://www.youtube.com/embed/e55jQCk5-PY?rel=0&amp;contols=0&amp;showinfo=0" frameborder="0" allowfullscreen class=""></iframe>
                        <div style="margin: 10px 0">
                        <label style="word-wrap: break-word; width: 100%; font-size: 12px">Welcome to your FitHabit dashboard. This in an overview of your activity with your fit habit account. From here you can view your revenue and signups for the year and the current month in addition to the total number of programs you have created. To get more detail on any item, click on any of the links in the menu.</label>
                        </div>
                        
                    </div>
                </div>
        </div>
    </div>

    <div id="myModal" name="myModal" class="modal fade" data-keyboard="false" data-backdrop="static" id="squarespaceModal" tabindex="-1" role="dialog" aria-labelledby="modalLabel">
        <div class="modal-dialog" >
            <div class="modal-content" style="background-color: #f3f1f5">
                <h3 class="registerModalTitle" id="lineModalLabel">STEP 2 OF 2: <p class="lead"><b>START YOUR FREE 14 DAY TRIAL!</b></p></h3>
                <h3 class="registerModalTitleDescription" id="linemodeldescription"><strong>No contracts, downgrade or cancel your account anytime<br>with a single click from your dashboard...</strong></h3>

                <div class="modal-body">
                    <!-- content goes here -->
                    <form id="subscriptionForm" action="{{url('/subscription')}}" method="post">
                        <input type="hidden" name="stripePubKey" value="{{$stripePubKey}}">
                        {!! csrf_field() !!}
                        <div class="modal-form" style="padding: 30px 30px 15px 30px">
                            <label style="margin-bottom:20px; font-size:15px;" for="exampleInputEmail1"><b>Add Credit Card</b></label>
                            <a style="float:right; color: #2a6496" href="#">Why do we ask for your credit card?</a>
                            <div class="form-group">
                                <input type="firstname" data-stripe="firstname" class="form-control" id="firstname" placeholder="First name" required>
                            </div>
                            <div class="form-group">
                                <input type="lastname" class="form-control" id="lastname" placeholder="Last name" required>
                            </div>
                            <div class="form-group">
                                <input type="cardnum" class="form-control" id="cardnum" placeholder="Credit Card Number" required>
                            </div>
                            <div class="form-group">
                                <div style="width:100%;">
                                <div class="col-sm-8 col-md-8 col-lg-8" style="margin-bottom: 15px">
                                    <div class="expiry-wrapper">
                                        <span style=" margin-left: -10px; margin-right: 15px; margin-top: -20px; padding-top: -10px"> ExpireDate </span>
                                        <select id="expiremonth" class="form-control card-expiry-month stripe-sensitive required" style="width: 100px">
                                        </select>
                                        <script type="text/javascript">
                                            var select = $(".card-expiry-month"),
                                                    month = new Date().getMonth() + 1;
                                            for (var i = 1; i <= 12; i++) {
                                                select.append($("<option value='"+i+"' "+(month === i ? "selected" : "")+">"+i+"</option>"))
                                            }
                                        </script>
                                        <span> / </span>
                                        <select id="expireyear" class="form-control card-expiry-year stripe-sensitive required" style="width: 100px"></select>
                                        <script type="text/javascript">
                                            var select = $(".card-expiry-year"),
                                                    year = new Date().getFullYear();
                                            for (var i = 0; i < 12; i++) {
                                                select.append($("<option value='"+(i + year)+"' "+(i === 0 ? "selected" : "")+">"+(i + year)+"</option>"))
                                            }
                                        </script>
                                    </div>
                                </div>
                                <div class="col-sm-4 col-md-4 col-lg-4">
                                <input style="margin-right:-10px;float: right" type="cvcode" class="form-control" id="cvcode" placeholder="CV Code..." required>
                                </div>
                                </div>

                            </div>
                            <div class="form-group">
                                <input type="zip" class="form-control" id="zip" placeholder="Zip" required>
                            </div>
                            <label style="width:100%;font-size:15px;margin-top: 15px;text-align: center">Free for 14 days then $0.00 a month until cancelled.</label>
                        </div>
                        <label style="color:#3b366f; font-size:15px;margin-top: 20px; width: 100%; text-align: center">By clicking the button below you agree to our <a href="#" style="color: red">Terms of Service</a></label>
                        <div>
                            <button type="submit" style="width: 99%; height: 50px; background-color: #EE5D4F;color: white; font-weight: bold" class="btn btn-default">CREATE MY FITHABIT PERSONAL TRAINER ACCOUNT NOW</button>
                        </div>
                    </form>
                    <div>
                        <label style="width:100%; text-align:center;color:#3b366f; font-size:15px;margin-top: 30px;" for="exampleInputEmail1">Logged in as {{ Auth::user()->email }}</php><br>Not your user? <a href="{{ url('/logout') }}" style="color:#3b366f; font-style: italic; font-weight: bold" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                Logout
                            </a></label>



                        <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                            {{ csrf_field() }}
                        </form>

                    </div>

                </div>

            </div>
        </div>
    </div>


@endsection

@section('extra_script')
<script>
    var stripePubKey = $('input[name=stripePubKey]').val();
    Stripe.setPublishableKey(stripePubKey);

    var showmodal = "{{$showmodal}}";

    if(showmodal == "yes")
    {
        $('#myModal').modal('show');
    }


    $('#subscriptionForm').submit(function(event) {
        $('#subscriptionForm').prop('disabled', true);
        Stripe.card.createToken({
            number: $('#cardnum').val(),
            cvc: $('#cvcode').val(),
            exp_month: $('#expiremonth').val(),
            exp_year: $('#expireyear').val()
        }, stripeResponseHandler);
        return false;
    });


    function stripeResponseHandler(status, response) {
        var $form = $('#subscriptionForm');

        if (response.error) {
            showAlert(response.error.message);
            $form.find('.submit').prop('disabled', false);
        }
        else
        {
            var token = response.id;
            var firstname = $("#firstname").val();
            var lastname = $("#lastname").val();
            var zipcode = $("#zip").val();
            var cnum = $("#cardnum").val();
            var expMonth = $("#expiremonth").val();
            var expYear = $("#expireyear").val();
            var code = $("#cvcode").val();

            $form.append($('<input type="hidden" name="stripeToken">').val(token));
            $form.append($('<input type="hidden" name="fstname">').val(firstname));
            $form.append($('<input type="hidden" name="lstname">').val(lastname));
            $form.append($('<input type="hidden" name="zipcode">').val(zipcode));
            $form.append($('<input type="hidden" name="cnum">').val(cnum));
            $form.append($('<input type="hidden" name="code">').val(code));
            $form.append($('<input type="hidden" name="expMonth">').val(expMonth));
            $form.append($('<input type="hidden" name="expYear">').val(expYear));
            $form.get(0).submit();
        }
    };
</script>
@endsection
