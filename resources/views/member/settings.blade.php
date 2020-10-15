@extends('member.template2')

@section('content')
    <div class="col-xl-12">
        <div class="dashboard-box main-box-in-row">
            <div class="headline">
                <h3><i class="icon-feather-settings"></i> Profile Settings
                </h3>
            </div>

            <div class="content with-padding padding-bottom-10">
                <div class="row">
                    <div class="col-xl-6">
                        <div class="submit-field">
                            <h5>First Name</h5>
                            <input type="text" value="{{ Auth::user()->first_name }}" id="first" class="with-border" required>
                        </div>
                    </div>

                    <div class="col-xl-6">
                        <div class="submit-field">
                            <h5>Last Name</h5>
                            <input type="text" value="{{ Auth::user()->last_name }}" id="last" class="with-border" required>
                        </div>
                    </div>

                    @if(Auth::user()->user_type == "Student" || Auth::user()->user_type == "Professional")
                        <div class="col-xl-6 submit-field">
                            <h5>Gender</h5>
                            <select class="selectpicker with-border" id="gender" name="gender">
                                <option value="{{ Auth::user()->gender }}" selected>{{ Auth::user()->gender }}</option>
                                <option value="Female">Female</option>
                                <option value="Male">Male</option>
                                <option value="Other">Other</option>
                            </select>
                        </div>

                        <div class="col-xl-6">
                            <div class="submit-field">
                                <h5>DoB</h5>
                                <input type="date" value="{{ Auth::user()->dob }}" id="dob" class="with-border" required>
                            </div>
                        </div>

                        <div class="col-xl-6">
                            <div class="submit-field">
                                <h5>Phone</h5>
                                <input type="text" value="{{ Auth::user()->phone }}" id="phone" class="with-border" required>
                            </div>
                        </div>

                        <div class="col-xl-6">
                            <div class="submit-field">
                                <h5>School</h5>
                                <input type="text" value="{{ Auth::user()->school }}" id="school" class="with-border" required>
                            </div>
                        </div>
                    @endif

                    @if(Auth::user()->user_type == "FL")
                        <div class="col-xl-6 submit-field">
                            <h5>Gender</h5>
                            <select class="selectpicker with-border" data-size="7" id="gender" name="gender">
                                <option value="{{ Auth::user()->gender }}" selected>{{ Auth::user()->gender }}</option>
                                <option value="Female">Female</option>
                                <option value="Male">Male</option>
                                <option value="Other">Other</option>
                            </select>
                        </div>

                        <div class="col-xl-6">
                            <div class="submit-field">
                                <h5>DoB</h5>
                                <input type="date" value="{{ Auth::user()->dob }}" id="dob" class="with-border" required>
                            </div>
                        </div>

                        <div class="col-xl-6">
                            <div class="submit-field">
                                <h5>Phone</h5>
                                <input type="text" value="{{ Auth::user()->phone }}" id="phone" class="with-border" required>
                            </div>
                        </div>
                    @endif

                    <div class="col-xl-12">
                        <button id="updateProfile" class="button ripple-effect big margin-bottom-10">Update Details</button>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <div>&nbsp;</div>

    @if(Auth::user()->user_type == "FL" && Auth::user()->expert->approved == 1)
        <div class="col-xl-12">
            <div class="dashboard-box main-box-in-row">
                <div class="headline">
                    <h3><i class="icon-line-awesome-bank"></i> Banking Settings
                    </h3>
                </div>

                <div class="content with-padding padding-bottom-10">
                    <div class="row">
                        <div class="col-xl-6">
                            <div class="submit-field">
                                <h5>Bank Name</h5>
                                <input type="text" value="{{ Auth::user()->expert->bank_name }}" id="bank" class="with-border" required>
                            </div>
                        </div>

                        <div class="col-xl-6">
                            <div class="submit-field">
                                <h5>Account Number</h5>
                                <input type="text" value="{{ Auth::user()->expert->account_number }}" id="account" class="with-border" required>
                            </div>
                        </div>

                        <div class="col-xl-12">
                            <button id="updateBank" class="button ripple-effect big margin-bottom-10">
                                Update
                            </button>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    @endif

    <div>&nbsp;</div>

    @if(Auth::user()->user_type == "FL" && Auth::user()->expert->approved == 1)
        <div class="col-xl-12">
            <div class="dashboard-box main-box-in-row">
                <div class="headline">
                    <h3><i class="icon-line-awesome-certificate"></i> Academic Qualification
                    </h3>
                </div>

                <div class="content with-padding padding-bottom-10">
                    <div class="row">
                        <div class="col-xl-6 submit-field">
                            <h5>Qualification</h5>
                            <select class="selectpicker with-border" data-size="7" id="qualification" name="qualification">
                                <option value="{{ Auth::user()->expert->qualification }}" selected>{{ Auth::user()->expert->qualification }}</option>
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

                        <div class="col-xl-6 submit-field hidden" id="qualificationWrapper">
                            <h5>Qualification Name</h5>
                            <input type="text" id="qualificationName" class="with-border" name="qualificationName">
                        </div>

                        <div class="col-xl-12">
                            <div class="submit-field">
                                <h5>Your Description<small>(Min: 200 characters)</small></h5>
                                <textarea cols="30" rows="5" class="with-border" id="description" name="description"value="{{ Auth::user()->expert->description }}">{{ Auth::user()->expert->description }}</textarea>
                            </div>
                        </div>

                        <div class="col-xl-12">
                            <button id="updateQualification" class="button ripple-effect big margin-bottom-10">
                                Update
                            </button>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    @endif

    <div>&nbsp;</div>

    @if(Auth::user()->user_type == "FL" && Auth::user()->expert->approved == 1)
        <div class="col-xl-12" style="min-height: 300px;">
            <div class="dashboard-box main-box-in-row">
                <div class="headline">
                    <h3><i class="icon-line-awesome-graduation-cap"></i> My Areas of Expertise
                        <a href="#" class="button mb-10" data-toggle="modal" data-target="#addSubModal" style="float: right; color: #fff; line-height: 20px; box-shadow: none;">+ Add</a>
                    </h3>
                </div>

                <div class="content with-padding padding-bottom-10">
                    <div class="row">
                        <div class="col-xl-12">
                            @if(Auth::user()->expert->subjects->count() > 0)
                                <table class="table table-striped subs-table">
                                    <thead>
                                        <tr>
                                            <th>Level</th>
                                            <th>Subject</th>
                                            <th>Remove</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach(Auth::user()->expert->subjects as $subject)
                                            <tr>
                                                <td>{{ @$subject->subcategory->category->name }}</td>
                                                <td>{{ $subject->name }}</td>
                                                <td>
                                                    <a class="delete" title="Remove Subject" style="color: #a62026" href="#" data-code="{{ $subject->uuid }}">
                                                        <i class="icon-feather-trash"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            @else
                                <p>You have not added any areas of expertise. Use the add button to add areas of expertise.</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Add Subject Modal -->
            <div class="modal fade bd-example-modal-lg" id="addSubModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" style="z-index: 99 !important; min-height: 600px !important;">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Add Area of Expertise</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-xl-12 submit-field">
                                    <h5>Level</h5>
                                    <select class="selectpicker with-border" data-size="7" title="Choose level" id="levels" name="levels">
                                        @foreach($levels as $level)
                                            <option value="{{ $level->id }}">{{ $level->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-xl-12 submit-field">
                                    <h5>Areas of Expertise</h5>
                                    <select class="selectpicker with-border areas" data-size="7" title="Select current areas of expertise" id="areas" name="areas" multiple>

                                    </select>
                                </div>
                            </div>

                            <button id="updateAreas" class="button button-sliding-icon ripple-effect margin-top-10"> Update Subjects <i class="icon-material-outline-arrow-right-alt"></i></button>
                            </div>
                    </div>
                </div>
            </div>


        </div>
    @endif

    <div>&nbsp;</div>

    <!-- Update security details -->
    <div class="col-xl-12">
        <div class="dashboard-box margin-top-0">
            <div class="headline">
                <h3><i class="icon-material-outline-lock"></i>Change Password</h3>
            </div>

            <div class="content with-padding">
                <div class="row">
                    <div class="col-xl-4">
                        <div class="submit-field">
                            <h5>Current Password</h5>
                            <input type="password" id="current" name="current" class="with-border">
                        </div>
                    </div>

                    <div class="col-xl-4">
                        <div class="submit-field">
                            <h5>New Password</h5>
                            <input type="password" id="newPass" name="newPass" class="with-border">
                        </div>
                    </div>

                    <div class="col-xl-4">
                        <div class="submit-field">
                            <h5>Repeat New Password</h5>
                            <input type="password" id="confirm" name="confirm" class="with-border">
                        </div>
                    </div>

                    <div class="col-xl-12">
                        <a href="#" id="updateSecurity" class="button ripple-effect big">Save Changes</a>
                    </div>
                </div>
            </div>
        </div>


    </div>

@endsection

@section('bootstrap')
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
@endsection

@section('scripts')
    <script>
        $(document).ready(function(){
            $("#updateProfile").click(function(e){
                e.preventDefault();

                var token = $("#token").val();
                var first = $("#first").val();
                var last = $("#last").val();
                var gender = $("#gender").val();
                var dob = $("#dob").val();
                var phone = $("#phone").val();
                var school = $("#school").val();

                const formData = {'first':first, 'last':last, 'gender':gender, 'dob':dob, 'phone':phone, 'school':school, '_token':token};

                $.ajax({
                    url: '/settings/profile',
                    type: 'POST',
                    data: formData,
                    datatype: 'json'
                })
                .done(function (data) {
                    if(data.success == 1){
                        success_snackbar(data.message, 5000)
                        setTimeout(function(){
                            location.reload();
                        }, 5000);
                    }else{
                        danger_snackbar(data.error, 5000)
                    }
                })
                .fail(function (jqXHR, textStatus, errorThrown) {
                    danger_snackbar('Error - ' + jqXHR.status + ': ' + jqXHR.statusText, 8000);
                });
            });

            // Update banking details
            $("#updateBank").click(function(e){
                e.preventDefault();

                var token = $("#token").val();
                var bank = $("#bank").val();
                var account = $("#account").val();

                const formData = {'bank':bank, 'account_number':account, '_token':token};

                $.ajax({
                    url: '/settings/banking/update',
                    type: 'POST',
                    data: formData,
                    datatype: 'json'
                })
                .done(function (data) {
                    if(data.success == 1){
                        success_snackbar(data.message, 5000)
                        setTimeout(function(){
                            location.reload();
                        }, 5000);
                    }else{
                        danger_snackbar(data.error, 5000)
                    }
                })
                .fail(function (jqXHR, textStatus, errorThrown) {
                    danger_snackbar('Error - ' + jqXHR.status + ': ' + jqXHR.statusText, 8000);
                });
            });

            // Update academic qualification
            $("#updateQualification").click(function(e){
                e.preventDefault();

                var token = $("#token").val();
                var qualification = $("#qualification").val();
                var description = $("#description").val();

                if(qualification == "Other"){
                    qualification = $("#qualificationName").val();
                }

                const formData = {'qualification':qualification, 'description':description, '_token':token};

                $.ajax({
                    url: '/settings/academic-qualification/update',
                    type: 'POST',
                    data: formData,
                    datatype: 'json'
                })
                .done(function (data) {
                    if(data.success == 1){
                        success_snackbar(data.message, 5000)
                        setTimeout(function(){
                            location.reload();
                        }, 5000);
                    }else{
                        danger_snackbar(data.error, 5000)
                    }
                })
                .fail(function (jqXHR, textStatus, errorThrown) {
                    danger_snackbar('Error - ' + jqXHR.status + ': ' + jqXHR.statusText, 8000);
                });
            });

            // Update areas of expertise
            $("#updateAreas").click(function(e){
                e.preventDefault();

                var token = $("#token").val();
                var areas = $("#areas").val();

                const formData = {'areas':areas, '_token':token};

                $.ajax({
                    url: '/settings/areas-of-expertise/update',
                    type: 'POST',
                    data: formData,
                    datatype: 'json'
                })
                .done(function (data) {
                    if(data.success == 1){
                        success_snackbar(data.message, 5000)
                        setTimeout(function(){
                            location.reload();
                        }, 5000);
                    }else{
                        danger_snackbar(data.error, 5000)
                    }
                })
                .fail(function (jqXHR, textStatus, errorThrown) {
                    danger_snackbar('Error - ' + jqXHR.status + ': ' + jqXHR.statusText, 8000);
                });
            });

            // Remove an area of expertise
            $(".subs-table tbody").on("click", ".delete", function(e){
                e.preventDefault();

                var token = $("#token").val();
                var uuid = $(this).attr('data-code');

                const formData = {'uuid':uuid, '_token':token};

                $.ajax({
                    url: '/settings/areas-of-expertise/delete',
                    type: 'POST',
                    data: formData,
                    datatype: 'json'
                })
                .done(function (data) {
                    if(data.success == 1){
                        success_snackbar(data.message, 3000)
                        setTimeout(function(){
                            location.reload();
                        }, 3000);
                    }else{
                        danger_snackbar(data.error, 5000)
                    }
                })
                .fail(function (jqXHR, textStatus, errorThrown) {
                    danger_snackbar('Error - ' + jqXHR.status + ': ' + jqXHR.statusText, 8000);
                });
            });

            $("#updateSecurity").click(function(e){
                e.preventDefault();

                var token = $("#token").val();
                var old = $("#current").val();
                var newPass = $("#newPass").val();
                var confirm = $("#confirm").val();

                if ($.trim(newPass) !== $.trim(confirm)) {
                    danger_snackbar("Passwords do not match", 5000);
                    return false;
                }

                const formData = {'old':old, 'newPass':newPass, '_token':token};

                $.ajax({
                    url: '/settings/reset-password',
                    type: 'POST',
                    data: formData,
                    datatype: 'json'
                })
                .done(function (data) {
                    if(data.success == 1){
                        success_snackbar(data.message, 5000)
                        setTimeout(function(){
                            window.location.href = data.redirect;
                        }, 5000);
                    }else{
                        danger_snackbar(data.error, 5000)
                    }
                })
                .fail(function (jqXHR, textStatus, errorThrown) {
                    danger_snackbar('Error - ' + jqXHR.status + ': ' + jqXHR.statusText, 8000);
                });
            });

            $("#qualification").on('change', function(){
                if (this.value == "Other") {
                    $("#qualificationWrapper").removeClass("hidden");
                } else {
                    $("#qualificationWrapper").addClass("hidden");
                }
            });

            $("#levels").on('change', function(){
                var token = $("#token").val();
                var level = this.value;

                const formData = {'id':level, '_token':token};

                $.ajax({
                    url: '/categories/get-subs',
                    type: 'POST',
                    data: formData,
                    datatype: 'json'
                })
                .done(function (data) {
                    if(data.success == 1){
                        $("#areas").html(data.subs);
                        $('.areas').selectpicker('refresh');
                    }else{
                        danger_snackbar(data.error, 5000)
                    }
                })
                .fail(function (jqXHR, textStatus, errorThrown) {
                    danger_snackbar('Error - ' + jqXHR.status + ': ' + jqXHR.statusText, 8000);
                });
            });
        })
    </script>
@endsection
