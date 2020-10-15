@extends('member.template2')

@section('content')
    <div class="dashboard-box main-box-in-row">
        <div class="headline">
            <h3><i class="icon-feather-bar-chart-2"></i> Active Discount Codes
                <a href="/discount-codes/new" class="button mb-10" style="float: right; color: #fff; line-height: 20px; box-shadow: none;">+ Create New</a>
            </h3>
        </div>
        <div class="contentdashboard-box main-box-in-row table-responsive" style="overflow-x:auto; padding: 10px;">
            @if($codes->count() < 1)
                <div class="row">
                    <div class="col-md-12">
                        <p style="padding: 20px;">No active discount codes. To create a discount code, click the new button.</p>
                    </div>
                </div>
            @else
                <div class="contentdashboard-box main-box-in-row table-responsive" style="overflow-x:auto; min-height: 400px;">
                    <table class="table table-striped discounts-table">
                        <thead>
                            <tr>
                                <th>Created By</th>
                                <th>Code</th>
                                <th>Amount</th>
                                <th>Created At</th>
                                <th>Redeem Count</th>
                                <th>Comments</th>
                                <th>Deactivate</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($codes as $code)
                                <tr>
                                    <td>{{ $code->createdBy->first_name }} {{ $code->createdBy->last_name }}</td>
                                    <td>{{ $code->code }}</td>
                                    <td>{{ $code->amount }}</td>
                                    <td>
                                        {{ \Carbon\Carbon::parse($code->created_at)->isoFormat('MMM Do, h:mm A') }}
                                    </td>
                                    <td>{{ $code->redeem_count }}</td>
                                    <td>{{ $code->comments }}</td>
                                    <td>
                                        <a class="delete" style="color: #a62026" href="#" data-code="{{ $code->uuid }}" title="Deactivate discount code" >
                                            <i class="icon-line-awesome-times-circle"></i>
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
                {{ $codes->links() }}
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
            $(".discounts-table tbody").on("click", ".delete", function(e){
                e.preventDefault();

                var token = $("#token").val();
                var uuid = $(this).attr('data-code');
                
                const formData = {'uuid':uuid, '_token':token};

                $.ajax({
                    url: '/discount-codes/delete',
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