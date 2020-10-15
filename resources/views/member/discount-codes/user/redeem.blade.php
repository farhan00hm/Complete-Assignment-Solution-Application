@extends('member.template')

@section('content')
    <div class="dashboard-box main-box-in-row">
        <div class="headline">
            <h3><i class="icon-material-outline-account-balance-wallet"></i> Wallet</h3>
        </div>
        <div class="content">
            <div class="row" style="padding: 10px;">
                <div class="col-xl-4 fun-fact" data-fun-fact-color="#36bd78">
                    <div class="fun-fact-text">
                        <span>Wallet Balance</span>
                        <h4 id="wallet">&#8358; {{ Auth::user()->wallet }}</h4>
                    </div>
                    <div class="fun-fact-icon">
                        <i style="color: #00a554;" class="icon-material-outline-account-balance-wallet"></i>
                    </div>
                </div>
                <div class="col-xl-8 fun-fact" data-fun-fact-color="#36bd78">
                    <div class="row" style="margin-top: 5px;">
                        <div class="col-xl-9">
                            <div class="submit-field">
                                <h5>Discount Code</h5>
                                <input type="text" id="code" name="code" class="with-border" placeholder="Enter discount code" required>
                            </div>
                        </div>
                        <div class="col-xl-3">
                            <button class="button ripple-effect big margin-top-20 margin-bottom-20" id="redeem">Redeem</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="dashboard-box main-box-in-row">
        <div class="headline">
            <h3><i class="icon-feather-bar-chart-2"></i> My Redeemed Discount Codes</h3>
        </div>
        <div class="contentdashboard-box main-box-in-row table-responsive" style="overflow-x:auto; padding: 10px;">
            @if($codes->count() < 1)
                <div class="row">
                    <div class="col-md-12">
                        <p style="padding: 20px;">You have not redeemed any discount codes.</p>
                    </div>
                </div>
            @else
                <div class="contentdashboard-box main-box-in-row table-responsive" style="overflow-x:auto; min-height: 400px;">
                    <table class="table table-striped discounts-table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Code</th>
                                <th>Amount</th>
                                <th>Redeeed On</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($codes as $code)
                                <tr>
                                    <td>{{ $code->id }}</td>
                                    <td>{{ $code->discountCode->code }}</td>
                                    <td>{{ $code->discountCode->amount }}</td>
                                    <td>
                                        {{ \Carbon\Carbon::parse($code->created_at)->isoFormat('MMM Do, Y') }}
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
    <script type="text/javascript">
        $("#redeem").click(function(e){
            e.preventDefault();

            var token = $("#token").val();
            var code = $("#code").val();

            const formData = {'code':code, '_token':token};

            $.ajax({
                url: '/user/discount-codes/redeem',
                type: 'POST',
                data: formData,
                datatype: 'json'
            })
            .done(function (data) { 
                if(data.success == 1){
                    success_snackbar(data.message, 6000)
                    setTimeout(function(){
                        location.reload();
                    }, 6000);
                }else{
                    danger_snackbar(data.error, 5000)
                }
            })
            .fail(function (jqXHR, textStatus, errorThrown) {  
                danger_snackbar('Error - ' + jqXHR.status + ': ' + jqXHR.statusText, 8000);
            });
        });
    </script>
@endsection