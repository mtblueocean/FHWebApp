@extends('layouts.app')

@section('content')
    @if(Auth::guest())
        <div class="dashboardBackground" style="margin-top: 80px;">
            <div class="dashboardContent">
    @else
        <div class="dashboardBackground">
            <div class="dashboardContent">
    @endif

            <div class="row terms" style="padding: 20px 50px">                   
                <p class="p1">Terms of Service ("Terms")</p>                  
                <div class="col-sm-12 col-md-12 col-lg-12">                        
                    <p class="p3"> Last updated: February 26, 2017<br /><br />Please read these Terms of Service ("Terms", "Terms of Service") carefully before using the www.fithabit.io website (the "Service") operated by FitHabit ("us", "we", or "our").<br /><br />
                    Your access to and use of the Service is conditioned on your acceptance of and compliance with these Terms. These Terms apply to all visitors, users and others who access or use the Service.<br /><br />
                    By accessing or using the Service you agree to be bound by these Terms. If you disagree with any part of the terms then you may not access the Service. <a href="https://termsfeed.com/blog/sample-terms-and-conditions-template/">Our Terms & Conditions</a> was created with TermsFeed.</p>
                    <p class="p2">Accounts</p>
                    <p class="p3"> When you create an account with us, you must provide us information that is accurate, complete, and current at all times. Failure to do so constitutes a breach of the Terms, which may result in immediate termination of your account on our Service.<br /><br />
                    You are responsible for safeguarding the password that you use to access the Service and for any activities or actions under your password, whether your password is with our Service or a third-party service.<br /><br />
                    You agree not to disclose your password to any third party. You must notify us immediately upon becoming aware of any breach of security or unauthorized use of your account.</p>
                    <p class="p2">Links To Other Web Sites</p>
                    <p class="p3"> Our Service may contain links to third-party web sites or services that are not owned or controlled by FitHabit.<br /><br />
                    FitHabit has no control over, and assumes no responsibility for, the content, privacy policies, or practices of any third party web sites or services. You further acknowledge and agree that FitHabit shall not be responsible or liable, directly or indirectly, for any damage or loss caused or alleged to be caused by or in connection with use of or reliance on any such content, goods or services available on or through any such web sites or services.<br /><br />
                    We strongly advise you to read the terms and conditions and privacy policies of any third-party web sites or services that you visit.</p>
                    <p class="p2">Termination</p>
                    <p class="p3">We may terminate or suspend access to our Service immediately, without prior notice or liability, for any reason whatsoever, including without limitation if you breach the Terms.<br /><br />
                    All provisions of the Terms which by their nature should survive termination shall survive termination, including, without limitation, ownership provisions, warranty disclaimers, indemnity and limitations of liability.<br /><br />
                    We may terminate or suspend your account immediately, without prior notice or liability, for any reason whatsoever, including without limitation if you breach the Terms.<br /><br />
                    Upon termination, your right to use the Service will immediately cease. If you wish to terminate your account, you may simply discontinue using the Service.<br /><br />
                    All provisions of the Terms which by their nature should survive termination shall survive termination, including, without limitation, ownership provisions, warranty disclaimers, indemnity and limitations of liability.</p>
                    <p class="p2">Governing Law</p>
                    <p class="p3">These Terms shall be governed and construed in accordance with the laws of Delaware, United States, without regard to its conflict of law provisions.<br /><br />
                    Our failure to enforce any right or provision of these Terms will not be considered a waiver of those rights. If any provision of these Terms is held to be invalid or unenforceable by a court, the remaining provisions of these Terms will remain in effect. These Terms constitute the entire agreement between us regarding our Service, and supersede and replace any prior agreements we might have between us regarding the Service.</p>
                    <p class="p2">Changes</p>
                    <p class="p3">We reserve the right, at our sole discretion, to modify or replace these Terms at any time. If a revision is material we will try to provide at least 15 days notice prior to any new terms taking effect. What constitutes a material change will be determined at our sole discretion.<br /><br />
                    By continuing to access or use our Service after those revisions become effective, you agree to be bound by the revised terms. If you do not agree to the new terms, please stop using the Service.</p>
                    <p class="p2">Contact Us</p>
                    <p class="p3">If you have any questions about these Terms, please contact us.</p>
                </div>
            </div>
        </div>
    </div>
   
@endsection
