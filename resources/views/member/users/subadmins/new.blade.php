@extends('member.template2')

@section('content')
    <div class="dashboard-box main-box-in-row">
        <div class="headline">
            <h3><i class="icon-feather-folder-plus"></i> Create a Sub Admin
            </h3>
        </div>
        
        <div class="content with-padding padding-bottom-10">
            <div class="row">
                <div class="col-xl-6">
                    <div class="submit-field">
                        <h5>First Name</h5>
                        <input type="text" class="with-border" placeholder="e.g. John" name="first" id="first">
                    </div>
                </div>
                <div class="col-xl-6">
                    <div class="submit-field">
                        <h5>Last Name</h5>
                        <input type="text" class="with-border" placeholder="e.g. Doe" name="last" id="last">
                    </div>
                </div>

                <div class="col-xl-6">
                    <div class="submit-field">
                        <h5>Email</h5>
                        <input type="text" class="with-border" placeholder="e.g. johndoe@example.com" name="email" id="email">
                    </div>
                </div>

                <div class="col-xl-6 submit-field">
                    <h5>Role</h5>
                    <select class="selectpicker with-border" id="role" name="role">
                        @foreach($roles as $role)
                            <option value="{{ $role->name }}">{{ $role->long_name }} | {{ $role->description }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-xl-12">
                    <button class="button ripple-effect big margin-top-20 margin-bottom-20" id="createSubadmin">Create</button>
                </div>

            </div>
        </div>

    </div>

@endsection

@section('bootstrap')
    <script src="//netdna.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
@endsection

@section('scripts')
    <script>
        $(document).ready(function(){
            $("#createSubadmin").click(function(e){
                e.preventDefault();

                var token = $("#token").val();
                var first = $("#first").val();
                var last = $("#last").val();
                var email = $("#email").val();
                var role = $("#role").val();

                const formData = {'first':first, 'last':last, 'email':email, 'role':role, '_token':token};

                $.ajax({
                    url: '/users/subadmins/create',
                    type: 'POST',
                    data: formData,
                    datatype: 'json'
                })
                .done(function (data) { 
                    if(data.success == 1){
                        success_snackbar(data.message, 5000)
                        setTimeout(function(){
                            window.location.href = "/users/subadmins";
                        }, 5000);
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