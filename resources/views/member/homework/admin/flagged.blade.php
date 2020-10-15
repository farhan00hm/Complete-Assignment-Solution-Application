@extends('member.template')

@section('content')
    <div class="dashboard-box main-box-in-row">
        <div class="headline">
            <h3><i class="icon-material-outline-outlined-flag"></i> Flagged Homework</h3>
        </div>
        <div class="contentdashboard-box main-box-in-row table-responsive" style="overflow-x:auto; padding: 10px;">
            @if($hws->count() == 0)
                <div class="row">
                    <div class="col-md-12">
                        <p style="padding: 20px;">No flagged homeworks yet :-)</p>
                    </div>
                </div>
            @else
                <div class="contentdashboard-box main-box-in-row table-responsive" style="overflow-x:auto;">
                    <table class="table table-striped cats-table">
                        <thead>
                            <tr>
                                <th>Title</th>
                                <th>Flagged By</th>
                                <th>Reason for Flagging</th>
                                <th>View Homework</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($hws as $hw)
                                <tr>
                                    <td>{{ $hw->homework->title }}</td>
                                    <td>
                                        <a style="color: #00a554" href="/users/freelancers/profile/{{ $hw->flaggedBy->expert->uuid }}">
                                            {{ $hw->flaggedBy->username }}
                                        </a>
                                    </td>
                                    <td>{{ $hw->reason }}</td>
                                    <td>
                                        <a class="btn button" style="color: #fff; background: #17a2b8; padding: 5px 15px;" href="/homeworks/single/{{ $hw->homework->uuid }}">
                                            View
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
                {{ $hws->links() }}
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
            $(".cats-table tbody").on("click", ".delete", function(e){
                e.preventDefault();

                var token = $("#token").val();
                var uuid = $(this).attr('data-code');

                const formData = {'uuid':uuid, '_token':token};

                $.ajax({
                    url: '/categories/delete',
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
