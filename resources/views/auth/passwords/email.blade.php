@extends('layouts.app')

@section('content')       
       <section id="loginform"><!--form-->
            <div class="container">
                <div class="row center">
                    <div class="col-sm-4 col-sm-offset-2" >
                        <img src="../images/home/forgot.png" class="program img-responsive" alt="" />
                    </div>
                    <div class="col-sm-4">
                        <div class="signup-form"><!--sign up form-->

                            @if (session('status'))
                                <div class="alert alert-success">
                                    {{ session('status') }}
                                </div>
                            @endif

                            <h2>Reset Password!</h2>

                            <form method="POST" action="{{ url('/password/email') }}">
                                {{ csrf_field() }}
                                <input type="email" name="email" placeholder="Email Address" value="{{ old('email') }}" required/>
                                <button type="submit" class="btn btn-default">Send Request</button>

                                @if ($errors->has('email'))
                                    <span class="help-block" style="color: red;">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                                
                            </form>
                        </div><!--/sign up form-->
                    </div>
                </div>
            </div>
        </section><!--/form-->
@endsection