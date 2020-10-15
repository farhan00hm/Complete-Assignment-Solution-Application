@extends('member.template')

@section('content')
    <div class="dashboard-box main-box-in-row">
        <div class="headline">
            <h3><i class="icon-feather-bar-chart-2"></i> Freelancers - Approved</h3>
        </div>
        <div class="contentdashboard-box main-box-in-row table-responsive" style="overflow-x:auto; padding: 10px;">
            @if($experts->count() < 1)
                <div class="row">
                    <div class="col-md-12">
                        <p style="padding: 20px;">No approved experts in the system.</p>
                    </div>
                </div>
            @else
                <div class="contentdashboard-box main-box-in-row table-responsive" style="overflow-x:auto;">
                    <table class="table table-striped experts-table">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>School</th>
                                <th>Qualification</th>
                                <th>&nbsp;</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($experts as $expert)
                                <tr>
                                    <td>{{ $expert->user->first_name }} {{ $expert->user->last_name }}</td>
                                    <td>{{ $expert->user->email }}</td>
                                    <td>{{ $expert->user->school }}</td>
                                    <td>{{ $expert->qualification }}</td>
                                    <td>
                                        <a class="btn btn-success" href="/users/freelancers/profile/{{ $expert->uuid }}" style="color: #fff ">
                                            Profile
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
            <div>&nbsp;</div>
            <div>
                {{ $experts->links() }}
            </div>
        </div>


    </div>

@endsection

@section('bootstrap')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
@endsection

@section('scripts')
    <script src="{{ asset('member/js/pdfobjects.min.js') }}"></script>
    <script>
        $(document).ready(function(){
            // Approve pending freelancers
            $(".experts-table tbody").on("click", ".approve", function(e){
                e.preventDefault();

                var token = $("#token").val();
                var uuid = $(this).attr('data-code');

                const formData = {'uuid':uuid, '_token':token};

                $.ajax({
                    url: '/users/freelancers/pending/approve',
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

            // Decline solution expert application
            $(".experts-table tbody").on("click", ".decline", function(e){
                e.preventDefault();

                var token = $("#token").val();
                var uuid = $(this).attr('data-code');

                const formData = {'uuid':uuid, '_token':token};

                $.ajax({
                    url: '/users/freelancers/pending/decline',
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

        })
    </script>
@endsection
