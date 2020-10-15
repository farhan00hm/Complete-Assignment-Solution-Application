@extends('auth.template')
@section('styles')
    <style type="text/css">
        #country-list{float:left;list-style:none;margin-top:-3px;padding:0;width:190px;position: absolute;}
        #country-list li{padding: 10px; background: #f0f0f0; border-bottom: #bbb9b9 1px solid;}
        #country-list li:hover{background:#ece3d2;cursor: pointer;}
        #search-box{padding: 10px;border: #a8d4b1 1px solid;border-radius:4px;}
    </style>
@endsection
@section('content')
	<div class="container">
		<div class="row">
			<div class="col-xl-8 offset-xl-2" style="margin: 3rem auto;">
				<div class="login-register-page">
					<div class="welcome-text">
						<h3 style="font-size: 26px;">Complete your profile</h3>
					</div>

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
							<label for="parent-radio" class="ripple-effect-dark"><i class="icon-feather-users"></i> Non Student</label>
						</div>

						<div>
							<input type="radio" name="account-type-radio" id="fl-radio" value="FL" class="account-type-radio"/>
							<label for="fl-radio" class="ripple-effect-dark"><i class="icon-feather-award"></i> Freelancer</label>
						</div>
					</div>

					<section id="student" class="hidden">
						<div class="row">
							<div class="col-xl-6">
                                <div class="input-with-icon-left">
                                    <i class="icon-feather-user"></i>
                                    <input type="text" class="input-text with-border" name="student-first" id="student-first" placeholder="Your first name" value="{{ Auth::user()->first_name }}" />
                                </div>
                            </div>
                            <div class="col-xl-6">
                                <div class="input-with-icon-left">
                                    <i class="icon-feather-user"></i>
                                    <input type="text" class="input-text with-border" name="student-last" id="student-last" placeholder="Your last name" value="{{ Auth::user()->last_name }}" />
                                </div>
                            </div>


                            <div class="col-xl-6">
        						<div class="input-with-icon-left">
        							<i class="icon-material-baseline-mail-outline"></i>
        							<input type="email" class="input-text with-border" name="student-email" id="student-email" placeholder="Email address"  value="{{ Auth::user()->email }}" readonly="true" />
        						</div>
                            </div>
                                <div class="col-xl-6">
        						<div class="input-with-icon-left">
        							<i class="icon-feather-user-check"></i>
        							<input type="text" class="input-text with-border" name="student-username" id="student-username" placeholder="Your username" required/>
        						</div>
                            </div>
                            <div class="col-xl-6 submit-field">
                                <select class="selectpicker with-border" data-size="7" title="Select your gender" id="student-gender" name="student-gender">
                                    <option value="Female">Female</option>
                                    <option value="Male">Male</option>
                                    <option value="Other">Other</option>
                                </select>
                            </div>
                            <div class="col-xl-6">
                                <div class="input-with-icon-left">
                                    <i class="icon-line-awesome-birthday-cake"></i>
                                    <input type="date" class="input-text with-border" name="student-dob" id="student-dob" placeholder="Your date of birth" required/>
                                </div>
                            </div>
                            <div class="col-xl-6">
                                <div class="input-with-icon-left">
                                    <i class="icon-line-awesome-phone-square"></i>
                                    <input type="text" class="input-text with-border" name="student-phone" id="student-phone" placeholder="Your phone (include country code)" required/>
                                </div>
                            </div>
                            <div class="col-xl-12">
        						<div class="input-with-icon-left">
        							<i class="icon-material-outline-school"></i>
        							<input type="text" class="input-text with-border" name="student-school" id="student-school" placeholder="Your school name" required/>
        						</div>
                            </div>
                        </div>

						<button class="button full-width button-sliding-icon ripple-effect margin-top-10" id="studentCompleteProfile" type="submit" style="min-width: 200px;">Complete Profile</button>
					</section>

					<section id="parent" class="hidden">
						<div class="row">
							<div class="col-xl-6">
                                <div class="input-with-icon-left">
                                    <i class="icon-feather-user"></i>
                                    <input type="text" class="input-text with-border" name="parent-first" id="parent-first" placeholder="Your first name" value="{{ Auth::user()->first_name }}" />
                                </div>
                            </div>
                            <div class="col-xl-6">
                                <div class="input-with-icon-left">
                                    <i class="icon-feather-user"></i>
                                    <input type="text" class="input-text with-border" name="parent-last" id="parent-last" placeholder="Your last name" value="{{ Auth::user()->last_name }}" />
                                </div>
                            </div>
						    <div class="col-xl-6">
        						<div class="input-with-icon-left">
        							<i class="icon-material-baseline-mail-outline"></i>
        							<input type="email" class="input-text with-border" name="parent-email" id="parent-email" placeholder="Email address"  value="{{ Auth::user()->email }}" readonly="true" />
        						</div>
                            </div>
                            <div class="col-xl-6">
        						<div class="input-with-icon-left">
        							<i class="icon-feather-user-check"></i>
        							<input type="text" class="input-text with-border" name="parent-username" id="parent-username" placeholder="Your username" required/>
        						</div>
                            </div>
                            <div class="col-xl-6 submit-field">
                                <select class="selectpicker with-border" data-size="7" title="Select your gender" id="parent-gender" name="parent-gender">
                                    <option value="Female">Female</option>
                                    <option value="Male">Male</option>
                                    <option value="Other">Other</option>
                                </select>
                            </div>
                            <div class="col-xl-6">
                                <div class="input-with-icon-left">
                                    <i class="icon-line-awesome-birthday-cake"></i>
                                    <input type="date" class="input-text with-border" name="parent-dob" id="parent-dob" placeholder="Your date of birth" required/>
                                </div>
                            </div>
                            <div class="col-xl-6">
                                <div class="input-with-icon-left">
                                    <i class="icon-line-awesome-phone-square"></i>
                                    <input type="text" class="input-text with-border" name="parent-phone" id="parent-phone" placeholder="Your phone (include country code)" required/>
                                </div>
                            </div>
                            <div class="col-xl-12">
        						<div class="input-with-icon-left">
        							<i class="icon-material-outline-school"></i>
        							<input type="text" class="input-text with-border" name="parent-school" id="parent-school" placeholder="School name" required/>
        						</div>
                            </div>
                        </div>

						<button class="button full-width button-sliding-icon ripple-effect margin-top-10" id="parentCompleteProfile" type="submit" style="min-width: 200px;">Complete Profile</button>
					</section>


					<section id="fl" class="hidden">
						<form method="post" id="application" name="application" enctype="multipart/form-data">
						<div class="row">
                            <div class="col-xl-6 submit-field">
                                <h5>First name</h5>
                                <div class="input-with-icon-left">
                                    <i class="icon-feather-user"></i>
                                    <input type="text" class="input-text with-border" name="fl-first" id="fl-first" placeholder="Your first name" value="{{ Auth::user()->first_name }}" />
                                </div>
                            </div>
                            <div class="col-xl-6 submit-field">
                                <h5>Last name</h5>
                                <div class="input-with-icon-left">
                                    <i class="icon-feather-user"></i>
                                    <input type="text" class="input-text with-border" name="fl-last" id="fl-last" placeholder="Your last name" value="{{ Auth::user()->last_name }}" />
                                </div>
                            </div>

                            <div class="col-xl-6 submit-field">
                                <h5>Email</h5>
                                <div class="input-with-icon-left">
                                    <i class="icon-material-baseline-mail-outline"></i>
                                    <input type="text" class="input-text with-border" name="fl-email" id="fl-email" placeholder="Your email address" value="{{ Auth::user()->email }}" readonly="true" />
                                </div>
                            </div>
                            <div class="col-xl-6 submit-field">
                                <h5>Username</h5>
                                <div class="input-with-icon-left">
                                    <i class="icon-feather-user-check"></i>
                                    <input type="text" class="input-text with-border" name="fl-username" id="fl-username" placeholder="Preferred username"/>
                                </div>
                            </div>

                            <div class="col-xl-12 submit-field">
                                <h5>DoB</h5>
                                <div class="input-with-icon-left">
                                    <i class="icon-line-awesome-birthday-cake"></i>
                                    <input type="date" class="input-text with-border" name="fl-dob" id="fl-dob" placeholder="Your date of birth"/>
                                </div>
                            </div>

                            <div class="col-xl-12 submit-field">
                                <h5>Gender</h5>
                                <select class="selectpicker with-border" data-size="7" title="Select your gender" id="fl-gender" name="fl-gender">
                                    <option value="Female">Female</option>
                                    <option value="Male">Male</option>
                                    <option value="Other">Other</option>
                                </select>
                            </div>

                            <div class="col-xl-6 submit-field" style="margin-bottom: 25px !important;">
                                <h5>Educational qualification</h5>
                                <select class="selectpicker with-border" data-size="7" title="Select your educational qualification" id="fl-qualification" name="fl-qualification">
                                    <option value="Bsc">Bsc</option>
                                    <option value="Msc">Msc</option>
                                    <option value="Phd">Phd</option>
                                    <option value="ND">ND</option>
                                    <option value="HND">HND</option>
                                    <option value="NCE">NCE</option>
                                    <option value="WAEC">WAEC</option>
                                    <option value="Other">Other</option>
                                </select>
                            </div>

                            <div class="col-xl-12 submit-field" style="margin-bottom: 25px !important;" id="q-other">
                                <h5>Qualification name</h5>
                                <input type="text" class="input-text with-border" name="other" id="other" placeholder="Enter your qualification name"/>
                            </div>

                            <div class="col-xl-12 submit-field" style="margin-bottom: 25px !important;">
                                <h5>What subjects are you expert in?</h5>
                                <select class="selectpicker with-border" data-size="7" title="Select your areas of expertise" id="areas" name="areas" multiple>
                                    @foreach($areas as $area)
                                        <option value="{{ $area->id }}">{{ $area->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-xl-12 submit-field">
                                <h5>Describe yourself<small>(Min: 200 characters)</small></h5>
                                <textarea cols="30" rows="5" class="with-border" id="fl-description" name="fl-description"></textarea>
                                <div class="uploadButton margin-top-30">
                                    <input class="uploadButton-input" type="file" name="files[]" accept="application/pdf" id="upload" multiple />
                                    <label class="uploadButton-button ripple-effect" for="upload">Upload File(s)</label>
                                    <span class="uploadButton-file-name">Upload your files (Resume, certificates, transcripts).</span>
                                </div>
                            </div>

                        </div>

						<button class="button full-width button-sliding-icon ripple-effect margin-top-10" id="seCompleteProfile" type="submit" style="min-width: 200px;">Complete Profile</button>
					</form>
				</section>
			</div>

			</div>
		</div>
	</div>
@endsection
