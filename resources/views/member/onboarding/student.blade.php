@extends('auth.template')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-xl-8 offset-xl-2">
                <div class="login-register-page">
                    <div class="welcome-text">
                        <h3>Complete your profile</h3>
                    </div>

                    <form method="post" id="profile-form">
                        <div class="row">
                            <div class="col-xl-6">
                                <div class="input-with-icon-left">
                                    <i class="icon-feather-user"></i>
                                    <input type="text" class="input-text with-border" name="first" id="first" placeholder="Your first name" required/>
                                </div>
                            </div>
                            <div class="col-xl-6">
                                <div class="input-with-icon-left">
                                    <i class="icon-feather-user"></i>
                                    <input type="text" class="input-text with-border" name="last" id="last" placeholder="Your last name" required/>
                                </div>
                            </div>
                            <div class="col-xl-6">
                                <div class="input-with-icon-left">
                                    <i class="icon-feather-user-check"></i>
                                    <input type="text" class="input-text with-border" name="username" id="username" placeholder="Preferred username" required/>
                                </div>
                            </div>
                            <div class="col-xl-6 submit-field">
                                <select class="selectpicker with-border" data-size="7" title="Select your gender" id="gender" name="gender">
                                    <option value="Female">Female</option>
                                    <option value="Male">Male</option>
                                    <option value="Other">Other</option>
                                </select>
                            </div>
                            <div class="col-xl-6">
                                <div class="input-with-icon-left">
                                    <i class="icon-line-awesome-birthday-cake"></i>
                                    <input type="date" class="input-text with-border" name="dob" id="dob" placeholder="Your date of birth" required/>
                                </div>
                            </div>
                            <div class="col-xl-6">
                                <div class="input-with-icon-left">
                                    <i class="icon-line-awesome-phone-square"></i>
                                    <input type="text" class="input-text with-border" name="phone" id="phone" placeholder="Your phone (include country code)" required/>
                                </div>
                            </div>
                            <div class="col-xl-12">
                                <div class="input-with-icon-left">
                                    <i class="icon-material-outline-school"></i>
                                    <input type="text" class="input-text with-border" name="school" id="school" placeholder="Your school name" required/>
                                </div>
                            </div>
                    </form>

                    <!-- Button -->
                    <button id="onboardStudent" class="button full-width button-sliding-icon ripple-effect margin-top-10" type="submit" form="login-form">Create Profile <i class="icon-material-outline-arrow-right-alt"></i></button>
                </div>
            </div>
        </div>
    </div>
@endsection
