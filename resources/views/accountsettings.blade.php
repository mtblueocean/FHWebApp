@extends('layouts.app')
@section('content')

    <div class="dashboardBackground">
        <input type="hidden" name="stripePubKey" value="{{$stripePubKey}}">
        <div class="dashboardContent">
            <div class="row" style="padding-left: 20px; padding-right: 20px; padding-top: 20px; padding-bottom: 20px">
                <div class="col-sm-3 col-md-3 col-lg-3">
                    <div>
                        <p style="margin-bottom:20px;margin-left:20px;font-size: 30px; font-weight: bold"><b>Account Settings</b></p>
                    </div>
                    <div style="text-align:center;margin-bottom:20px;">
                        <a href=""><img id="profilepic" class="bigProfile img-circle"
                             @if (Auth::user()->user_profilepicurl == "")
                                src="{{asset('images/dashboard/emptyprofile.jpg')}}"
                             @else
                                src="{{asset(Auth::user()->user_profilepicurl)}}"
                             @endif
                             alt="" /></a>
                        <input type="file" id="inputimg" name="inputimg" style="display: none;" />
                    </div>
                    <div style="text-align:center;margin-bottom:20px;">
                        <p style="margin-top:20px;font-size: 26px; font-weight: bold"><b>{{$user->name}}</b></p>
                        <div style="text-align: center">
                        <p class="bioinfo" id="userbiop" style="font-size: 18px;"><?php
                            if ($user->user_bioinfo == "")
                            {
                                echo "Double click to change your bio information.";
                            }
                            else
                            {
                                echo $user->user_bioinfo;
                            }
                            ?>
                        </p>
                            <input name="bioinfoedit" id="bioinfoedit" style="display: none; margin-bottom: 10px"/>
                        </div>
                        <p><a href="/stripe/connect" ><img style="max-width:60%;" src="{{url('site-images/stripe-connect.png')}}" /></a></p>
                    </div>
                </div>

                <div class="col-sm-5 col-md-5 col-lg-5" style="padding-left: 50px" >
                    <div style="margin-top: 10px">
                        <p style="margin-bottom:20px;margin-left:20px;font-size: 18px; font-weight: bold; vertical-align: bottom"><b>Account Information</b></p>
                    </div>
                    <div style="margin-top: 50px">
                        <div class="row">
                            <div class="col-sm-8 col-md-8 col-lg-8">
                                <p style="margin-bottom:20px;margin-left:20px;font-size: 16px; vertical-align: bottom">Change Password</p>
                            </div>
                            <div class="col-sm-4 col-md-4 col-lg-4">
                                <a href="" data-toggle="modal" data-target="#ChangePasswordModal" style="margin-left:50px;color: #2a6496; font-size: 16px">Edit</a>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-8 col-md-8 col-lg-8">
                                <p style="margin-bottom:20px;margin-left:20px;font-size: 16px; vertical-align: bottom">Change Billing Method</p>
                            </div>
                            <div class="col-sm-4 col-md-4 col-lg-4">
                                <a href="" data-toggle="modal" data-target="#ChangeBilling" style="margin-left:50px;color: #2a6496; font-size: 16px">Edit</a>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-8 col-md-8 col-lg-8">
                                <p style="margin-bottom:20px;margin-left:20px;font-size: 16px; vertical-align: bottom">Downgrade to Standard Account</p>
                            </div>
                            <div class="col-sm-4 col-md-4 col-lg-4">
                                <a href="" data-toggle="modal" data-target="#DowngradeModal" style="margin-left:50px;color: #2a6496; font-size: 16px">Edit</a>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-8 col-md-8 col-lg-8">
                                <p style="margin-bottom:20px;margin-left:20px;font-size: 16px; vertical-align: bottom">Change Contact Information</p>
                            </div>
                            <div class="col-sm-4 col-md-4 col-lg-4">
                                <a href="" data-toggle="modal" data-target="#ChangeContactinfo" style="margin-left:50px;color: #2a6496; font-size: 16px">Edit</a>
                            </div>
                        </div>
                        <div>
                            <p id="contactlabel" style="margin-left:20px;font-size: 16px; vertical-align: bottom">
                                @if ($contactname != "")
                                    {{$contactname}}<br>
                                @endif
                                @if ($address != "")
                                    {{$address}}<br>
                                @endif
                                @if ($address1 != "")
                                    {{$address1}}<br>
                                @endif
                                @if ($zipcode != "")
                                    {{$zipcode}}<br>
                                @endif
                                @if ($country != "")
                                    {{$country}}<br>
                                @endif
                                @if ($user->email != "")
                                    {{$user->email}}
                                @endif
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-sm-4 col-md-4 col-lg-4">
                    <div class="row">
                        <div style="margin-top: 10px">
                            <p style="margin-bottom:20px;margin-left:50px;font-size: 18px; font-weight: bold; vertical-align: bottom"><b>Membership Information</b></p>
                        </div>
                        <div style="margin-top: 50px">
                            <div class="row">
                                <div class="col-sm-6 col-md-6 col-lg-6">
                                    <p style="margin-bottom:20px;margin-left:50px;font-size: 16px; vertical-align: bottom">Billing</p>
                                </div>
                                <div class="col-sm-6 col-md-6 col-lg-6">
                                    <a style="color: #2a6496; font-size: 16px">{{$BillingLabel}}</a>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-6 col-md-6 col-lg-6">
                                    <p style="margin-bottom:20px;margin-left:50px;font-size: 16px; vertical-align: bottom">Price</p>
                                </div>
                                <div class="col-sm-6 col-md-6 col-lg-6">
                                    <a style="color: #2a6496; font-size: 16px">$ {{$price}}</a>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-6 col-md-6 col-lg-6">
                                    <p style="margin-bottom:20px;margin-left:50px;font-size: 16px; vertical-align: bottom">Join Date</p>
                                </div>
                                <div class="col-sm-6 col-md-6 col-lg-6">
                                    <a style="color: #2a6496; font-size: 16px">{{$strdate}}</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!--ChangePassword Modal-->
    <div class="modal fade" id="ChangePasswordModal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
        <div class="modal-dialog" >
            <div class="modal-content" style="background-color: #f3f1f5">
                <button type="button" class="close customed" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
                <h3 class="registerModalTitleDescription" id="linemodeldescription"><strong>Change Password</strong></h3>

                <div class="modal-body">
                    <!-- content goes here -->
                    <form id="changePasswordForm">
                        {{ csrf_field() }}
                        <div class="modal-form" style="padding: 30px 30px 15px 30px">
                            <div class="form-group">
                                <label>Enter Current Password</label>
                                <input type="password" id="curPassword" pattern=".{6,}" class="form-control" placeholder="Current Password" required title="6 characters at minimum.">
                            </div>
                            <div class="form-group">
                                <label>New Password</label>
                                <input type="password" class="form-control" id="newPassword" pattern=".{6,}" placeholder="New Password" required title="6 characters at minimum.">
                            </div>
                            <div class="form-group">
                                <label>New Password Again</label>
                                <input type="password" class="form-control" id="confirmPassword" pattern=".{6,}" placeholder="Confirm New Password" required title="6 characters at minimum.">
                            </div>
                        </div>
                        <div class="row" style="margin-top: 30px">
                            <div class="col-sm-6">
                                <button type="button" name="changepasswordcancelbtn" id="changepasswordcancelbtn" style="width: 98%; height: 50px; background-color: white;color: #424242; font-weight: bold" class="btn btn-default">Cancel</button>
                            </div>
                            <div class="col-sm-6">
                                <button type="submit" style="width: 98%; height: 50px; background-color: #8dcea5;color: white; font-weight: bold" class="btn btn-default">Save</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>




    <!--Downgrade Modal-->
    <div class="modal fade" id="DowngradeModal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
        <div class="modal-dialog" >
            <div class="modal-content" style="background-color: #f3f1f5">
                <button type="button" class="close customed" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
                <h3 class="registerModalTitleDescription" id="linemodeldescription"><strong>Downgrade Account</strong></h3>

                <div class="modal-body">
                    <!-- content goes here -->
                    <form id="downgradeForm">
                        <div class="modal-form" style="padding: 30px 30px 15px 30px">
                            <label>Downgrading your account will remove your programs from the Program Finder.  Your clients will still be able to use your programs but will not be able to communicate with you.</label>
                            <label style="margin-top: 20px">Don't worry, your programs will be achieved for 30 days if you decided to change your mind.</label>
                            <label style="margin-top: 20px">You can still use the FitHabit app to record your workouts and if you would like to reactivate your account send an email to pt@fithabit.io</label>
                        </div>
                        <div class="row" style="margin-top: 30px">
                            <div class="col-sm-6">
                                <button type="button" id="downgradecancel" style="width: 98%; height: 50px; background-color: white;color: #424242; font-weight: bold" class="btn btn-default">Cancel</button>
                            </div>
                            <div class="col-sm-6">
                                <button type="submit" style="width: 98%; height: 50px; background-color: #EF4836; color: white; font-weight: bold" class="btn btn-default">Downgrade</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!--ChangeContactInfo Modal-->
    <div class="modal fade" id="ChangeContactinfo" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
        <div class="modal-dialog" >
            <div class="modal-content" style="background-color: #f3f1f5">
                <button type="button" class="close customed" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
                <h3 class="registerModalTitleDescription" id="linemodeldescription"><strong>Change Contact Information</strong></h3>

                <div class="modal-body">
                    <!-- content goes here -->
                    <form id="changeContactForm">
                        <div class="modal-form" style="padding: 30px 30px 15px 30px">
                            <div class="form-group">
                                <label>Name</label>
                                <input type="contactname" id="contactname" class="form-control" placeholder="Name" required>
                            </div>
                            <div class="form-group">
                                <label>Address</label>
                                <textarea class="form-control" rows="2" name="contactaddress" id="contactaddress" placeholder="Address" required></textarea>
                            </div>
                            <div class="form-group">
                                <label>City</label>
                                <input type="text" class="form-control" id="contactcity" placeholder="City" required>
                            </div>
                            <div class="form-group">
                                <label>Country</label>
                                <select id="contactcountry" name="contactcountry" required></select>
                            </div>
                            <div class="form-group">
                                <label>State</label>
                                <select name="contactstate" id="contactstate" required></select>
                            </div>
                        </div>
                        <div class="row" style="margin-top: 30px">
                            <div class="col-sm-6">
                                <button type="button" id="changecontactcancel" name="changecontactcancel" style="width: 98%; height: 50px; background-color: white;color: #424242; font-weight: bold" class="btn btn-default">Cancel</button>
                            </div>
                            <div class="col-sm-6">
                                <button type="submit" style="width: 98%; height: 50px; background-color: #8dcea5;color: white; font-weight: bold" class="btn btn-default">Save</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>



    <!--ChangeBillingMethod Modal-->
    <div class="modal fade" id="ChangeBilling" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
        <div class="modal-dialog" >
            <div class="modal-content" style="background-color: #f3f1f5">
                <button type="button" class="close customed" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
                <h3 class="registerModalTitleDescription" id="linemodeldescription"><strong>Change Billing Method</strong></h3>

                <div class="modal-body">
                    <!-- content goes here -->
                    <form id="changeBillingForm">
                        <div class="modal-form" style="padding: 30px 30px 15px 30px">
                            <div class="form-group">
                                <label>Status</label>
                                <p>This will replace your primary payment method.</p>
                            </div>
                            <div class="form-group">
                                <label>First Name</label>
                                <input type="text" id="firstname" class="form-control" placeholder="First Name" required>
                            </div>
                            <div class="form-group">
                                <label>Last Name</label>
                                <input type="text" id="lastname" class="form-control" placeholder="Last Name" required>
                            </div>
                            <div class="form-group">
                                <label>Card Number</label>
                                <input type="text" id="cardnumber" class="form-control" placeholder="Card Number" required>
                            </div>

                            <div class="form-group">
                                <label>Expiration Date</label>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <select id="selectMonth" style="width:100%;" class="form-control selectWidth" required>
                                            <?php
                                            $month = ["January", "Feburary", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"]
                                             ?>
                                                <option value="-1" selected disabled>Month</option>
                                            @for ($i = 0; $i <= 11; $i++)
                                                <option value="{{$i}}">{{$month[$i]}}</option>
                                            @endfor
                                        </select>
                                    </div>
                                    <div class="col-sm-6">
                                        <select id="selectYear" style="width:100%;" class="form-control selectWidth" required>
                                            <option value="-1" selected disabled>Year</option>
                                            @for ($i = date('Y'); $i <= 2030; $i++)
                                                <option class="">{{$i}}</option>
                                            @endfor
                                        </select>
                                    </div>
                                </div>
                            </div>


                            <div class="form-group">
                                <label>Security Code</label>
                                <div class="row">
                                    <div class="col-sm-8">
                                        <input type="text" style="width: 50%;" class="form-control" id="securitycode" placeholder="Security Code" required>
                                        <a href="" style="margin-left:10px;width: 50%; color: #424242"><i style="margin-right: 5px" class="fa fa-keyboard-o"></i>What's this?</a>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label>Country</label>
                                <select id="country1" name="country" required></select>
                            </div>
                            <div class="form-group">
                                <label>State</label>
                                <select name="state" id="state1" required></select>
                            </div>

                            <div class="form-group">
                                <label>Address</label>
                                <textarea class="form-control" rows="2" name="address1" id="address1" placeholder="Address" required></textarea>
                            </div>
                            <div class="form-group">
                                <label>Address(optional)</label>
                                <textarea class="form-control" rows="2" name="addressoptional" id="addressoptional" placeholder="Address(optional)"></textarea>
                            </div>

                            <div class="form-group">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <label>City</label>
                                        <input type="text" class="form-control" id="city" name="city" placeholder="City" required>
                                    </div>
                                    <div class="col-sm-6">
                                        <label>Postal Code</label>
                                        <input type="text" class="form-control" id="postalcode" name="postalcode" placeholder="Postal Code(optional)" required>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label>Phone Number</label>
                                <div class="row" >
                                <div class="phone-number" style="margin-left: 15px">

                                        <div class="col-xs-3">
                                            <div class="input-group">
                                            <span class="input-group-addon">+</span>
                                            <input type="tel" name="phonea" id="phonea" class="form-control" value="" size="3" maxlength="3" required title="">
                                                </div>
                                        </div>

                                        <div class="col-xs-3">
                                            <input type="tel" name="phoneb" id="phoneb" class="form-control" value="" size="3" maxlength="4" required title="">
                                        </div>
                                        <div class="col-xs-4">
                                            <input type="tel" name="phonec" id="phonec" class="form-control" value="" size="4" maxlength="5" required title="">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row" style="margin-top: 30px">
                            <div class="col-sm-6">
                                <button type="button" id="changebillingcancel" name="changebillingcancel" style="width: 98%; height: 50px; background-color: white;color: #424242; font-weight: bold" class="btn btn-default">Cancel</button>
                            </div>
                            <div class="col-sm-6">
                                <button type="submit" style="width: 98%; height: 50px; background-color: #8dcea5;color: white; font-weight: bold" class="btn btn-default">Save</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!--scripts-->
    <script src="{{asset('js/countries.js')}}"></script>

    <script>
        var stripePubKey = $('input[name=stripePubKey]').val();
        Stripe.setPublishableKey(stripePubKey);
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            beforeSend:function(){
                $(".loadingmodal").show();
            },
            complete: function () {
                $(".loadingmodal").hide();
            }
        });

        populateCountries("contactcountry", "contactstate"); // first parameter is id of country drop-down and second parameter is id of state drop-down
        populateCountries("country1", "state1"); // first parameter is id of country drop-down and second parameter is id of state drop-down


        $("#changePasswordForm").submit(function(event){
            event.preventDefault();
            //var curPassword = $("#curPassword").val();
            var newPassword = $("#newPassword").val();
            var curPassword = $("#curPassword").val();
            var confirmPassword = $("#confirmPassword").val();

            if(newPassword != confirmPassword)
            {
                showAlert("Confirm Password does not match.");
                return;
            }
            var postUrl = "/changepassword";

            var postdata = {
                //curPassword: curPassword,
                newPassword: newPassword,
                curPassword: curPassword
            };

            $.ajax({
                type: "POST",
                url: postUrl,
                data: postdata,
                dataType: "json",
                success: function (data) {
                    var res = data['result'];

                    /*if( res == "false" )
                    {
                        showAlert("Please Input CurPassword Correctly.");
                    }
                    else
                    {*/
                        //showAlert("Password was changed successfully.");
                    //}
                    if(res == true)
                    {
                        showAlert("Password was changed successfully.");
                        dismissmodal($('#ChangePasswordModal'));
                    }
                    else
                    {
                        showAlert("Please Input CurPassword Correctly.");
                    }
                },
                error: function (result) {
                    showAlert("Error Changing Password.");
                }
            });
        });

        $('#ChangeBilling').on('shown.bs.modal', function (){
            $.ajax({
                type: "GET",
                url: '/userdetail',
                dataType: "json",
                success: function (data) {

                    var firstname = $('#firstname').val(data['pt_firstname']);
                    var lastname = $('#lastname').val(data['pt_lastname']);
                    var cardnumber = $('#cardnumber').val(data['pt_cardnumber']);
                    var expiremonth = $('#selectMonth').val(data['pt_expireMonth']);
                    var expireyear = $('#selectYear').val(data['pt_expireYear']);
                    var securitycode = $('#securitycode').val(data['pt_securitycode']);
                    var country = $('#country1').val(data['pt_country']);
                    var state = $('#state1').val(data['pt_state']);
                    var address1 = $('#address1').val(data['pt_address']);
                    var address2 = $('#addressoptional').val(data['pt_address1']);
                    var city = $('#city').val(data['pt_city']);
                    var postalcode = $('#postalcode').val(data['pt_postalcode']);
                    var phonea = $('#phonea').val(data['pt_phonenumber']);
                    var phoneb = $('#phoneb').val(data['pt_phonenumber']);
                    var phonec = $('#phonec').val(data['pt_phonenumber']);
                },
                error: function (result) {
                    showAlert("Error Loading Contact Info.");
                }
            });
        });

        $("#changeBillingForm").submit(function(event) {
            event.preventDefault();

            $('#changeBillingForm').prop('disabled', true);
            Stripe.card.createToken({
                number: $('#cardnumber').val(),
                cvc: $('#securitycode').val(),
                exp_month: $('#selectMonth').val(),
                exp_year: $('#selectYear').val()
            }, stripeResponseHandler);
            return false;
        });


        function stripeResponseHandler(status, response) {
            var $form = $('#changeBillingForm');
            var token = response.id;

            if (response.error) {
                showAlert(response.error.message);
                $form.find('.submit').prop('disabled', false);
            }
            else
            {
                var firstname = $('#firstname').val();
                var lastname = $('#lastname').val();
                var cardnumber = $('#cardnumber').val();
                var expiremonth = $('#selectMonth').val();
                var expireyear = $('#selectYear').val();
                var securitycode = $('#securitycode').val();
                var country = $('#country1').val();
                var state = $('#state1').val();
                var address1 = $('#address1').val();
                var address2 = $('#addressoptional').val();
                var city = $('#city').val();
                var postalcode = $('#postalcode').val();
                var phonea = $('#phonea').val();
                var phoneb = $('#phoneb').val();
                var phonec = $('#phonec').val();

                var phone = phonea + "-" + phoneb + "-" + phonec;

                var postUrl = "/changebilling";

                var postdata = {
                    firstname : firstname,
                    lastname : lastname,
                    cardnumber : cardnumber,
                    expiremonth : expiremonth,
                    expireyear : expireyear,
                    securitycode : securitycode,
                    country : country,
                    state : state,
                    address1 : address1,
                    address2 : address2,
                    city : city,
                    postalcode : postalcode,
                    phonenumber : phone,
                    stripeToken: token
                };

                $.ajax({
                    type: "POST",
                    url: postUrl,
                    data: postdata,
                    dataType: "json",
                    success: function (data) {
                        dismissmodal($("#ChangeBilling"));
                        window.location = '\accountsetting';
//                        showAlert("Updated Successfully.");

                    },
                    error: function (result) {
                        showAlert("Error Changing BillingMethod.");
                    }
                });
            }
        };

        $('#ChangeContactinfo').on('shown.bs.modal', function (){
            $.ajax({
                type: "GET",
                url: '/userdetail',
                dataType: "json",
                success: function (data) {
                    var name = $('#contactname').val(data['pt_contactname']);
                    var address = $('#contactaddress').val(data['pt_contactaddress']);
                    var city = $('#contactcity').val(data['pt_contactcity']);
                    var country = $('#contactcountry').val(data['pt_contactcountry']);
                    var state = $('#contactstate').val(data['pt_contactstate']);
                },
                error: function (result) {
                    showAlert("Error Loading Contact Info.");
                }
            });
        });

        $("#changeContactForm").submit(function(event) {
            event.preventDefault();

            var name = $('#contactname').val();
            var address = $('#contactaddress').val();
            var city = $('#contactcity').val();
            var country = $('#contactcountry').val();
            var state = $('#contactstate').val();

            var postUrl = "/changecontact";

            var postdata = {
                name: name,
                address: address,
                city: city,
                country: country,
                state: state
            };

            $.ajax({
                type: "POST",
                url: postUrl,
                data: postdata,
                dataType: "json",
                success: function (data) {
                    var name = $('#contactname').val(data['pt_contactname']);
                    var address = $('#contactaddress').val(data['pt_contactaddress']);
                    var city = $('#contactcity').val(data['pt_contactcity']);
                    var country = $('#contactcountry').val(data['pt_contactcountry']);
                    var state = $('#contactstate').val(data['pt_contactstate']);
                    dismissmodal($("#ChangeContactinfo"));
                    window.location = '\accountsetting';
                  //  showAlert("Updated Successfully.");
                },
                error: function (result) {
                    showAlert("Error Changing Contact Info.");
                }
            });
        });

        $("#downgradeForm").submit(function(event) {
            event.preventDefault();

            var postdata = {
                name: ""
            };

            var postUrl = "/downgrade";
            $.ajax({
                type: "POST",
                url: postUrl,
                data: postdata,
                dataType: "json",
                success: function (data) {
//                    showAlert("Updated Successfully.");
                    dismissmodal($("#DowngradeModal"));
                    window.location = '\accountsetting';
                },
                error: function (result) {
                    showAlert("Error Downgrade.");
                }
            });
        });

        function dismissmodal(item)
        {
            item.modal('hide');
            //$('#ChangePasswordModal').modal('hide');
        }

        $('#changecontactcancel').click(function() {
            dismissmodal($('#ChangeContactinfo'));
        });

        $('#ChangeContactinfo').on('hidden.bs.modal', function () {
            dismissmodal($('#ChangeContactinfo'));
        });

        $('#changepasswordcancelbtn').click(function() {
            dismissmodal($('#ChangePasswordModal'));
        });

        $('#ChangePasswordModal').on('hidden.bs.modal', function () {
            dismissmodal($('#ChangePasswordModal'));
        });

        $('#changebillingcancel').click(function() {
            dismissmodal($('#ChangeBilling'));
        });

        $('#ChangeBilling').on('hidden.bs.modal', function () {
            dismissmodal($('#ChangeBilling'));
        });

        $('#downgradecancel').click(function() {
            dismissmodal($('#DowngradeModal'));
        });

        $('#DowngradeModal').on('hidden.bs.modal', function () {
            dismissmodal($('#DowngradeModal'));
        });

        $("#profilepic").click(function() {
            event.preventDefault();
            $("#inputimg").trigger("click");
        });

        $("#inputimg").change(function(){
            var image = "";
            var input = $("#inputimg")[0];
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    image = e.target.result;
                    var selectedImage = new Image();
                    selectedImage.src =  e.target.result;
                    if(selectedImage.width == 512 && selectedImage.height == 512)
                    {
                        $('#profilepic').attr('src', image);
                        $('#navProfilePic').attr('src', image);

                        var postUrl = "/changeprofilepic";
                        var files = $('#inputimg')[0].files[0];
                        var postdata = new FormData();
                        postdata.append('photo', files);

                        console.log(postdata);
                        $.ajax({
                            type: "POST",
                            url: postUrl,
                            data: postdata,
                            contentType: false,
                            processData: false,
                            success: function (data) {
                                if(data['result'] == false)
                                {
                                    showAlert("Error Saving Photo.");
                                }
                                else
                                {
                                    showAlert("Photo Saved.");
                                }
                            },
                            error: function (result) {
                                showAlert("Error Saving Photo.");
                            }
                        });
                    }
                    else
                    {
                        showAlert("Image size should be 512px by 512px.");
                    }
                };
                reader.readAsDataURL(input.files[0]);
            }
        });

        $("#userbiop").dblclick(function(){
            var txtBio = $("#userbiop").text();
            $("#userbiop").hide();
            $("#bioinfoedit").width('80%');
            $("#bioinfoedit").show();
            $("#bioinfoedit").val(txtBio);
            $("#bioinfoedit").focus();
        });

        $("#bioinfoedit").focusout(function() {
            var txtBio = $("#bioinfoedit").val();
            $("#bioinfoedit").hide();
            $('#userbiop').text(txtBio);
            $("#userbiop").show();
            $("#userbiop").width("100%");

            var postdata = {
                newBio: txtBio
            };
            var postUrl = "/changebio";
            $.ajax({
                type: "POST",
                url: postUrl,
                data: postdata,
                dataType: "json",
                success: function (data) {
                    showAlert("Bioinfo Saved.");
                },
                error: function (result) {
                    showAlert("Error Saving Bioinfo.");
                }
            });
        })

    </script>
@endsection
