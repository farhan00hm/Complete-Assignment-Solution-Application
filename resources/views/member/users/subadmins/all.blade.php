@extends('member.template')

@section('content')
    <div class="dashboard-box main-box-in-row">
        <div class="headline">
            <h3><i class="icon-feather-bar-chart-2"></i>Sub Admins
                <a href="/users/subadmins/new" class="button mb-10" style="float: right; color: #fff; line-height: 20px; box-shadow: none;">+ Add</a>
            </h3>
        </div>
        <div class="contentdashboard-box main-box-in-row table-responsive" style="overflow-x:auto; padding: 10px;">
            @if($subadmins->count() < 1)
                <div class="row">
                    <div class="col-md-12">
                        <p style="padding: 20px;">No sub admins in the system yet.</p>
                    </div>
                </div>
            @else
                <div class="contentdashboard-box main-box-in-row table-responsive" style="overflow-x:auto;">
                    <table class="table table-striped subs-table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Created At</th>
                                <th>&nbsp;</th>
                                <th>&nbsp;</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($subadmins as $sub)
                                <tr>
                                    <td>{{ $sub->id }}</td>
                                    <td>{{ $sub->first_name }} {{ $sub->last_name }}</td>
                                    <td>{{ $sub->email }}</td>
                                    <td>{{ $sub->roles()->first()->long_name }}</td>
                                    <td>
                                        {{ \Carbon\Carbon::parse($sub->created_at)->isoFormat('MMM Do, h:mm A') }}
                                    </td>
                                    <td>
                                        <a style="color: #00a554" href="/users/subadmins/edit/{{ $sub->uuid }}">
                                            <i class="icon-feather-edit"></i>
                                        </a>
                                    </td>
                                    <td>
                                        <a class="delete" style="color: #a62026" href="#" data-code="{{ $sub->uuid }}">
                                            <i class="icon-feather-trash"></i>
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
                {{ $subadmins->links() }}
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
            $(".subs-table tbody").on("click", ".delete", function(e){
                e.preventDefault();

                var token = $("#token").val();
                var uuid = $(this).attr('data-code');
                
                const formData = {'uuid':uuid, '_token':token};

                $.ajax({
                    url: '/users/subadmins/delete',
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