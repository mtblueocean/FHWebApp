@extends('layouts.app')

@section('content')       
       <section id="loginform"><!--form-->
            <div class="container">
                <div class="row center">

                    <div class="col-sm-4 col-sm-offset-2" >
                        <img src="images/home/phone.png" class="program img-responsive" alt="" />
                    </div>
                    <div class="col-sm-4">
                        <div class="login-form"><!--login form-->
                            <h2>Login to your account</h2>
                            <form method="POST" action="{{ route('login') }}">
                                {!! csrf_field() !!}
                                <input type="email" name="email" id="email" value="{{ old('email') }}" placeholder="Email Address" autocomplete="off" required {{count($errors) == 0 || $errors->first('email') ? 'autofocus' : ''}}/>
                                <input type="password" name="password" id="password" placeholder="Password" pattern=".{6,}" autocomplete="off" required  title="6 characters at minimum." {{$errors->first('password') ? 'autofocus' : ''}}/>
                                <span>
                                    <input name="remember" id="remember" type="checkbox" class="checkbox" autocomplete="off" {{ old('remember') ? 'checked' : '' }}>Keep me signed in</span>

                                <div>
                                    <button style="float: left; margin-left: -20px" type="submit" class="btn btn-default">Login</button>
                                    <a href="{{ route('password.request') }}" style="margin-top: 30px; float:right; color: #1f648b">Forgot Password?</a>
                                </div>
                                <div class="row" style="clear: both; margin-left:0px; margin-right: 0px">
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
                                </div>
                            </form>
                        </div><!--/login form-->
                    </div>
                </div>
            </div>
        </section><!--/form-->
@endsection