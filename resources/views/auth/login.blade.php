@extends('auth.template')

@section('styles')
    <style type="text/css">
        a.fb{
            border-color: #3b5998;
            color: #3b5998;
        }

        a.fb:hover{
            color: #ffffff;
        }

        a.google{
            border-color: #dd4b39;
            color: #dd4b39;
        }

        a.google:hover{
            color: #ffffff;
        }
    </style>
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-xl-6 offset-xl-3">
                <div class="login-register-page">
                    <div class="welcome-text">
                        <h3>We're glad to see you again!</h3>
                        <span>Don't have an account? <a href="/register">Sign Up!</a></span>
                    </div>
                        
                    <!-- Form -->
                    <form method="post" id="login-form">
                        <div id="resp"></div>
                        <div class="input-with-icon-left">
                            <i class="icon-material-baseline-mail-outline"></i>
                            <input type="text" class="input-text with-border" name="emailaddress" id="emailaddress" placeholder="Email Address" required/>
                        </div>

                        <div class="input-with-icon-left">
                            <i class="icon-material-outline-lock"></i>
                            <input type="password" class="input-text with-border" name="password" id="password" placeholder="Password" required/>
                        </div>
                        <a href="/forgot-password" class="forgot-password">Forgot Password?</a>
                    </form>
                    
                    <!-- Button -->
                    <button id="signIn" class="button full-width button-sliding-icon ripple-effect margin-top-10" type="submit" form="login-form">Log In <i class="icon-material-outline-arrow-right-alt"></i></button>

                    <!-- Social Login -->
                    <div class="social-login-separator"><span>or</span></div>
                    <div class="social-login-buttons">
                        <button class="facebook-login ripple-effect">
                            <a href="{{url('/redirect/facebook')}}" class="fb">
                                <i class="icon-brand-facebook-f"></i> Log In via Facebook
                            </a>
                        </button>
                        <button class="google-login ripple-effect">
                            <a href="{{url('/redirect/google')}}" class="google">
                                <i class="icon-brand-google-plus-g"></i> Log In via Google+
                            </a>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection