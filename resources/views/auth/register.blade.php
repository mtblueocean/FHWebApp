@extends('layouts.app')

@section('content')       
       <section id="loginform"><!--form-->
            <div class="container">
                <div class="row center">

                    <div class="col-sm-4 col-sm-offset-2" >
                        <img src="images/home/phone.png" class="program img-responsive" alt="" />
                    </div>
                    <div class="col-sm-4">

                        <div class="signup-form"><!--sign up form-->

                            <div style="vertical-align: middle">
                                <h2>New User Signup!</h2>
                                <button type="submit" style="float:right;margin-left: 20px; margin-top: 15px" class="btn btn-hot text-uppercase btn-md" onclick="window.location='{{ url("register/pt") }}'">Platform Signup</button>
                            </div>
                            <form method="POST" action="{{ route('register') }}">
                                {{ csrf_field() }}
                                <input type="hidden" name="purchaseProgramid" value="{{$_GET['purchaseProgramid']}}">
                                <input type="hidden" id="usertype" name="usertype" value="user" />
                                <input id="name" type="text" name="name" id="name" placeholder="Name" value="{{ old('name') }}" autocomplete="off" required {{count($errors) == 0 || $errors->first('name') ? 'autofocus' : ''}}/>
                                <input id="email" type="email" name="email" placeholder="Email Address" value="{{ old('email') }}" autocomplete="off"  {{$errors->first('email') ? 'autofocus' : ''}}/>
                                <input id="password" type="password" name="password" placeholder="Password" pattern=".{6,}" autocomplete="off" required title="6 characters at minimum." {{$errors->first('password') ? 'autofocus' : ''}}/>
                                <input id="password-confirm" type="password" name="password_confirmation" pattern=".{6,}" placeholder="Confirm Password" autocomplete="off" required title="6 characters at minimum.">

                                <button type="submit" class="btn btn-default">Signup</button>

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
        </section><!--/form-->
@endsection