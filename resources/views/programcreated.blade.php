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
                <div class="col-sm-3 col-md-3 col-lg-3">
                    <div style="text-align:center;margin-bottom:20px;margin-top:20px">
                        <img id="profilepic" class="phoneimg" src="{{asset('images/home/phone1.png')}}"/>
                    </div>
                </div>

                <div class="col-sm-6 col-md-6 col-lg-6" >
                    <div style="margin-top: 10px">
                        <p style="margin-bottom:20px;margin-left:20px;font-size: 30px; font-weight: bold; vertical-align: bottom"><b>YOUR PROGRAM HAS BEEN CREATED!</b></p>
                    </div>
                    <div style="margin-top: 50px">
                        <p style="margin-bottom:20px;margin-left:20px;font-size: 15px; vertical-align: bottom"><b>Free Product: </b> If your program is public, your program will now be available in the FitHabit program Finder.
                            People will be able to instantly add your program to their account.</p>

                        <p style="margin-bottom:20px;margin-left:20px;font-size: 15px; vertical-align: bottom"><b>Paid Product: </b> If your program is a paid program, they will receive their program after payment confirmation.
                            You will receive a confirmation email of the purchase; Purchased programs and other financial data will be available in the revenue tab.</p>

                        <p style="margin-bottom:20px;margin-left:20px;font-size: 15px; vertical-align: bottom"><b>Custom Program: </b> If you have created a custom program for a client, use the share link to distribute your program. The user will be taken through the registration process and your program will be added to your clients account.</p>
                        <p style="margin-bottom:20px;margin-left:20px;font-size: 15px; vertical-align: bottom">Custom program tokens can only be used once. If your users link is accidentally shared with someone else, you will need to edit your program to generate a new link. You can remove any unauthorized users in the signups tab.</p>
                    </div>
                </div>
                <div class="col-sm-3 col-md-3 col-lg-3">
                    <div class="row">
                        <div style="margin-top: 25px">
                            <p style="margin-bottom:20px;margin-left:20px;font-size: 15px; font-weight: bold; vertical-align: bottom"><b>Email Share Link:</b></p>
                        </div>
                        <div style="text-align:center;margin-top: 30px">
                            <p id="linktext" data-link="{{$link}}" style="margin-bottom:10px;margin-left:20px;font-size: 14px; color: #5d4ca7; font-weight: bold; vertical-align: bottom"><b>{{$link_name}}</b></p>
                            <a href="#" onclick="copyToClipboard('#linktext')" style="color: #424242"><p style="margin-bottom:20px;margin-left:20px;font-size: 15px; font-weight: bold; vertical-align: bottom"><b>Copy</b></p></a>
                        </div>
                        <div style="margin-top: 30px">
                            <p style="margin-bottom:10px;margin-left:20px;font-size: 14px; font-weight: bold; vertical-align: bottom"><b>Custom Programs:</b></p>
                            <p style="margin-bottom:20px;margin-left:20px;font-size: 12px; font-weight: bold; vertical-align: bottom">If you are selling a custom program to a client, you may use this link to send with a personalized welcome email.<br>
                                Copy and Paste this link into an email</p>
                        </div>
                        <div style="margin-top: 30px">
                            <p style="margin-bottom:10px;margin-left:20px;font-size: 14px; font-weight: bold; vertical-align: bottom"><b>Public and Paid Products:</b></p>
                            <p style="margin-bottom:20px;margin-left:20px;font-size: 12px; font-weight: bold; vertical-align: bottom">Feel free to share this link with your friends and followers on social media.<br>
                            They will be directed to your product on FitHabit to add or purchase your product. Once they register, your product will immediately be available to them on the FitHabit Mobile App.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        function copyToClipboard(element) {
            var $temp = $("<input>");
            $("body").append($temp);
            $temp.val($(element).data('link')).select();
            document.execCommand("copy");
            $temp.remove();
        }
    </script>
@endsection
