@extends('auth.template')

@section('styles')
    <style type="text/css">
        .submit-field{
            margin-bottom: 10px !important;
        }
    </style>
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-xl-8 offset-xl-2">
                <div class="login-register-page">
                    <div class="welcome-text" style="margin-bottom: 30px;">
                        <h3>Freelancer Application</h3>
                    </div>

                    <form method="post" id="application" name="application" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-xl-6 submit-field">
                                <h5>First name</h5>
                                <div class="input-with-icon-left">
                                    <i class="icon-feather-user"></i>
                                    <input type="text" class="input-text with-border" name="first" id="first" placeholder="Your first name"/>
                                </div>
                            </div>
                            <div class="col-xl-6 submit-field">
                                <h5>Last name</h5>
                                <div class="input-with-icon-left">
                                    <i class="icon-feather-user"></i>
                                    <input type="text" class="input-text with-border" name="last" id="last" placeholder="Your last name"/>
                                </div>
                            </div>

                            <div class="col-xl-6 submit-field">
                                <h5>Email</h5>
                                <div class="input-with-icon-left">
                                    <i class="icon-material-baseline-mail-outline"></i>
                                    <input type="text" class="input-text with-border" name="email" id="email" placeholder="Your email address"/>
                                </div>
                            </div>
                            <div class="col-xl-6 submit-field">
                                <h5>Username</h5>
                                <div class="input-with-icon-left">
                                    <i class="icon-feather-user-check"></i>
                                    <input type="text" class="input-text with-border" name="username" id="username" placeholder="Preferred username"/>
                                </div>
                            </div>
                            <div class="col-xl-6 submit-field">
                                <h5>Password</h5>
                                <div class="input-with-icon-left">
                                    <i class="icon-feather-lock"></i>
                                    <input type="password" class="input-text with-border" name="password" id="password" placeholder="Your password"/>
                                </div>
                            </div>

                            <div class="col-xl-12 submit-field">
                                <h5>DoB</h5>
                                <div class="input-with-icon-left">
                                    <i class="icon-line-awesome-birthday-cake"></i>
                                    <input type="date" class="input-text with-border" name="dob" id="dob" placeholder="Your date of birth"/>
                                </div>
                            </div>

                            <div class="col-xl-12 submit-field">
                                <h5>Gender</h5>
                                <select class="selectpicker with-border" data-size="7" title="Select your gender" id="gender" name="gender">
                                    <option value="Female">Female</option>
                                    <option value="Male">Male</option>
                                    <option value="Other">Other</option>
                                </select>
                            </div>

                            <div class="col-xl-6 submit-field" style="margin-bottom: 25px !important; margin-top: 25px;">
                                <h5>Educational qualification</h5>
                                <select class="selectpicker with-border" data-size="7" title="Select your educational qualification" id="qualification" name="qualification">
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
                                <textarea cols="30" rows="5" class="with-border" id="description" name="description"></textarea>
                                <div class="uploadButton margin-top-30">
                                    <input class="uploadButton-input" type="file" name="files[]" accept="application/pdf" id="upload" multiple />
                                    <label class="uploadButton-button ripple-effect" for="upload">Upload File(s)</label>
                                    <span class="uploadButton-file-name">Upload your files (Resume, certificates, transcripts in PDF format).</span>
                                </div>
                            </div>
                        </div>
                    </form>

                    <!-- Button -->
                    <button id="apply" class="button button-sliding-icon ripple-effect margin-top-10"> Submit Application <i class="icon-material-outline-arrow-right-alt"></i></button>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script type="text/javascript">
        $(document).ready(function(){
            $("#q-other").addClass('hidden');
        })
    </script>
@endsection
