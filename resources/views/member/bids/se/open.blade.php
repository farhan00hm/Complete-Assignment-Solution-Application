@extends('member.template')

@section('content')
    <div class="dashboard-box main-box-in-row">
        <div class="headline">
            <h3><i class="icon-feather-bar-chart-2"></i> Open Bids</h3>
        </div>
        <div class="contentdashboard-box main-box-in-row table-responsive" style="overflow-x:auto; padding: 10px;">
            @if($bids->count() == 0)
                <div class="row">
                    <div class="col-md-12">
                        <p style="padding: 20px;">You have no open bids.</p>
                    </div>
                </div>
            @else
                <div class="contentdashboard-box main-box-in-row table-responsive" style="overflow-x:auto;">
                    <table class="table table-striped bids-table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Homework Title</th>
                                <th>Amount</th>
                                <th>Expected Completion Date</th>
                                <th>Submitted On</th>
                                <th>&nbsp;</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($bids as $bid)
                                <tr>
                                    <td>{{ $bid->id }}</td>
                                    <td>{{ $bid->homework->title }}</td>
                                    <td>{{ $bid->amount }}</td>
                                    <td>
                                        {{ \Carbon\Carbon::parse($bid->expected_completion_date)->isoFormat('MMM Do, Y') }}
                                    </td>
                                    <td>
                                        {{ \Carbon\Carbon::parse($bid->created_at)->isoFormat('MMM Do, h:mm A') }}
                                    </td>
                                    <td>
                                        <a class="delete" title="Withdraw bid" style="color: #a62026" href="#" data-code="{{ $bid->id }}">
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
                {{ $bids->links() }}
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
            $(".bids-table tbody").on("click", ".delete", function(e){
                e.preventDefault();

                var token = $("#token").val();
                var bidId = $(this).attr('data-code');
                
                const formData = {'bidId':bidId, '_token':token};

                $.ajax({
                    url: '/bids/withdraw',
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