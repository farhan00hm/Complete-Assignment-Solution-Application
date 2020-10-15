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
			<div class="col-xl-6 offset-xl-3" style="margin: 3rem auto;">
				<div class="login-register-page">
					<div class="welcome-text">
						<h3 style="font-size: 26px;">Let's create your account!</h3>
						<span>Already have an account? <a href="/login">Log In!</a></span>
					</div>

					<form method="post" action="/signup" id="register-account-form">
						<div>
							<small>I am a</small>
						</div>
						<div class="account-type">
							<div>
								<input type="radio" name="account-type-radio" id="student-radio" value="Student" class="account-type-radio" />
								<label for="student-radio" class="ripple-effect-dark" title="I am a student"><i class="icon-feather-user"></i> Student</label>
							</div>

							<div>
								<input type="radio" name="account-type-radio" id="parent-radio" value="Professional" class="account-type-radio"/>
								<label for="parent-radio" class="ripple-effect-dark"><i class="icon-feather-users"></i> Professionals</label>
							</div>
						</div>

						<div class="input-with-icon-left">
							<i class="icon-material-baseline-mail-outline"></i>
							<input type="email" class="input-text with-border" name="email" id="email" placeholder="Email Address" required/>
						</div>

						<div class="input-with-icon-left" title="Should be at least 8 characters long" data-tippy-placement="bottom">
							<i class="icon-material-outline-lock"></i>
							<input type="password" class="input-text with-border" name="password" id="password" placeholder="Password" required/>
                            <span style="font-size: 9px; color: red"><strong>* Use at least 1 uppercase letter, 1 lowercase letter, 1 digit, 1 special letter and password length at least 6 character long</strong></span>
						</div>


						<div class="input-with-icon-left">
							<i class="icon-material-outline-lock"></i>
							<input type="password" class="input-text with-border" name="confirm" id="confirm" placeholder="Repeat Password" required/>
						</div>

						<button class="button full-width button-sliding-icon ripple-effect margin-top-10" id="signUp" type="submit" form="login-form">Create Account</button>

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
					</form>
				</div>

			</div>
		</div>
	</div>
@endsection
