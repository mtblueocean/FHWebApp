@extends('layouts.app')

@section('content')

    <div class="dashboardBackground">
        <div class="dashboardContent">
            <div><!--header-->
                <div class="row">
                    <div class="col-sm-4">
                        <p style="margin-bottom:10px;margin-top:20px;margin-left:40px;font-size: 30px; font-weight: bold"><b>Support</b></p>
                    </div>
                    <div class="col-sm-8">

                    </div>
                </div>
                <!--split-->
                <div class="splitterdiv">
                </div><!--split-->
            </div><!--header-->
            <div class="tablediv">
                <div style="margin-left: 20px; margin-right: 10px;display: table">
                    <p id="mailtolabel" style="float:left;margin-right: 10px; margin-top:20px; font-size: 15px; font-weight: bold"><b>To: </b></p>
                    <select id="maleto" style="float:left;margin-right: 10px; width:200px; margin-top: 15px; text-align: center" class="form-control selectWidth">
                        <option value="none" selected disabled>-- Choose --</option>
                        <?php
                        $options = ["Customer Service", "FH Plus Member", "Technical Support", "Personal Trainer Support", "Feature Request", "Billing"];
                        $values = ["cs@fithabit.io", "plusmembers@fithabit.io","ts@fithabit.io","ptsupport@fithabit.io", "request@fithabit.io", "billing@fithabit.io"];
                        ?>
                        @for ($i = 0; $i <= 5; $i++)
                            <option value="{{$values[$i]}}">{{$options[$i]}}</option>
                        @endfor
                    </select>
                </div>



                <div class="row" style="margin-left: 10px; margin-top: 10px; margin-right:10px;">
                    <div class="col-sm-8">
                        <textarea class="form-control" rows="11"></textarea>
                        <div>
                            <button type="button" class="next-but" style="float: right">Send</button>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <p>Thank you for contacting FitHabit support.<br>
                            We will do our best to get back to you in
                            the shortest time possible.
                            <br>
                            <br>
                            If you have a question about a workout,
                            nutrition, or information product you’ve
                            purchased from a FitHabit vendor, please
                            contact them directly using the mobile app.
                            <br>
                            <br>
                            All other request will be handled here.
                            <br>
                            <br>
                            Thank you once again for supporting FitHabit
                            and we will reach you as quick as we can!
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection