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
                        <h3>Enter your email to recover your password</h3>
                        <span>Here by mistake? <a href="/login">Login!</a></span>
                    </div>
                        
                    <!-- Form -->
                    <form method="post" id="forgot-form">
                        <div id="resp"></div>
                        <div class="input-with-icon-left">
                            <i class="icon-material-baseline-mail-outline"></i>
                            <input type="text" class="input-text with-border" name="emailaddress" id="emailaddress" placeholder="Email Address" required/>
                        </div>
                    </form>
                    
                    <!-- Button -->
                    <button id="forgot" class="button full-width button-sliding-icon ripple-effect margin-top-10" type="submit" form="login-form">Recover Account <i class="icon-material-outline-arrow-right-alt"></i></button>
                </div>
            </div>
        </div>
    </div>
@endsection