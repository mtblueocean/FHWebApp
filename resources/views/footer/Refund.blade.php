@extends('layouts.app')

@section('content')

    @if(Auth::guest())
        <div class="dashboardBackground" style="margin-top: 80px;">
            <div class="dashboardContent">
    @else
        <div class="dashboardBackground">
            <div class="dashboardContent">
    @endif
            <div class="row refund" style="padding: 20px 50px">                   
                <p class="p1">Refunds</p>                  
                <div class="col-sm-12 col-md-12 col-lg-12">                        
                    <p class="p3"> We want you to be satisfied, so all programs purchased on FitHabit can be refunded within 30 days. Please note, however, that refunds are only available for programs purchased on the FitHabit website (at www.fithabit.io) or the Android app; any courses purchased through a third party website or the iOS app will not be eligible for refunds (for more details on refund restrictions, please see below). For whatever reson, if you are unhappy with a program, please let us know through the Contact Support form or by requesting a refund from the praam dashboard. We're here to help.<br /><br />All refunds will be credited back a card or PayPal account. Note: Purchases made on the iOS mobile app cannot be refunded.</p>
                    <p class="p2">Reasons for Denied Refunds.</p>
                    <p class="p3"> While our 30 day refund policy is in place to protect members (user), we must also protect our online personal trainers from fraud and provide a reasonable payment schedule. Payments are sent to online personal trainers after 30 days, so we will not process refund requests received after the refund window.<br /><br />
                    If all coursecontent was downloaded before the refund was requested, the refund request may be rejected.<br /><br />
                    Finally, students who purchase and refund multiple courses over an extended period may be subject to suspension for abuse of the refund policy.</p>
                    <p class="p2">Refunds for Bundles Purchased Through Third Party</p>
                    <p class="p3"> If you purchased the course through a third party vendor, unfortunately, we cannot process your refund. Since we did not process the original payment, we do not have the transaction on file, and cannot initiate a refund for you. Please contact the third party vendor directly to request a refund.</p>
                    <p class="p2">Mobile Purchases</p>
                    <p class="p3"> Purchases made through the iOS mobile app cannot be be refunded. On the iOS app, payments are processed by Apple and as a result we do not have the ability to refund the course. If you would like to request a refund, please reach out to Apple Support directly.</p>
                </div>
            </div>
        </div>
    </div>
   
@endsection
