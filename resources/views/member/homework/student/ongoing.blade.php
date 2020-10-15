@extends('member.template')

@section('content')
    <div class="dashboard-box main-box-in-row">
        <div class="headline">
            <h3><i class="icon-feather-bar-chart-2"></i> Ongoing @if(Auth::user()->user_type == "Student")Homework @else Project @endif</h3>
        </div>
        <div class="contentdashboard-box main-box-in-row table-responsive" style="overflow-x:auto; padding: 10px;">
            @if($hws->count() == 0)
                <div class="row">
                    <div class="col-md-12">
                        <p style="padding: 20px;">You have no ongoing @if(Auth::user()->user_type == "Student")homework. @else project. @endif</p>
                    </div>
                </div>
            @else
                <div class="contentdashboard-box main-box-in-row table-responsive" style="overflow-x:auto;">
                    <table class="table table-striped cats-table">
                        <thead>
                            <tr>
                                <th>Title</th>
                                <th>Bids</th>
                                <th>Deadline</th>
                                <th>Budget</th>
                                <th>Hired On</th>
                                <th>View Bids</th>
                                <th>&nbsp;</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($hws as $hw)
                                <tr>
                                    <td>{{ $hw->title }}</td>
                                    <td>{{ $hw->bids->count() }}</td>
                                    <td>
                                        {{ \Carbon\Carbon::parse($hw->deadline)->isoFormat('MMM Do') }}
                                    </td>
                                    <td>{{ $hw->budget }}</td>
                                    <td>
                                        @if(!empty($hw->hired_on))
                                            {{ \Carbon\Carbon::parse($hw->hired_on)->isoFormat('MMM Do, Y') }}
                                        @else
                                            &nbsp;
                                        @endif
                                    </td>
                                    <td>
                                        <a title="View bids" class="btn button" style="color: #fff; background: #17a2b8; padding: 5px 15px;" href="/homeworks/{{ $hw->uuid }}/bids">
                                            View Bids
                                        </a>
                                    </td>
                                    <td>
                                        <a class="btn button" style="color: #fff; background: #17a2b8; padding: 5px 15px;" href="/homeworks/single/{{ $hw->uuid }}">
                                            View
                                        </a>
                                    </td>
                                     <td>
                                        <a class="delete" style="color: #a62026" href="#" data-code="{{ $hw->uuid }}" title="Delete homework">
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
                    url: '/homeworks/delete',
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
