@extends('member.template')

@section('content')
    <div class="dashboard-box main-box-in-row">
        <div class="headline">
            <h3><i class="icon-material-outline-account-balance-wallet"></i> Wallet</h3>
        </div>
        <div class="content">
            <div class="row" style="padding: 10px;">
                <div class="col-xl-6 fun-fact" data-fun-fact-color="#36bd78">
                    <div class="fun-fact-text">
                        <span>Wallet Balance</span>
                        <h4 id="wallet">&#8358; {{ Auth::user()->wallet }}</h4>
                    </div>
                    <div class="fun-fact-icon">
                        <i style="color: #00a554;" class="icon-material-outline-account-balance-wallet"></i>
                    </div>
                </div>
                <div class="col-xl-6 fun-fact" data-fun-fact-color="#36bd78">
                    <div class="row" style="margin-top: 5px;">
                        <div class="col-xl-8">
                            <div class="submit-field">
                                <h5>Amount</h5>
                                <input type="text" id="amount" name="amount" class="with-border" placeholder="Amount to top up wallet" required>
                            </div>
                        </div>
                        <div class="col-xl-4">
                            <input type="hidden" name="email" id="email" value="{{ Auth::user()->email }}">
                            <input type="hidden" name="phone" id="phone" value="{{ Auth::user()->phone }}">
                            <input type="hidden" name="paystackKey" id="paystackKey" value="{{ env('PAYSTACK_PUBLIC_KEY') }}">
                            <button class="btn-info button" style="color: #ffffff; float: right; box-shadow: none; background-color: #17a2b8 !important; margin-top: 20px;" onclick="payWithPaystack()">
                                Top Up
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="dashboard-box main-box-in-row">
        <div class="headline">
            <h3><i class="icon-feather-bar-chart-2"></i> Recent Wallet Topups</h3>
        </div>
        <div class="contentdashboard-box main-box-in-row table-responsive" style="overflow-x:auto; padding: 10px;">
            @if($topups->count() < 1)
                <div class="row">
                    <div class="col-md-12">
                        <p style="padding: 20px;">You have no recent top up transactions.</p>
                    </div>
                </div>
            @else
                <div class="contentdashboard-box main-box-in-row table-responsive" style="overflow-x:auto; min-height: 400px;">
                    <table class="table table-striped discounts-table">
                        <thead>
                            <tr>
                                <th>Reference</th>
                                <th>Status</th>
                                <th>Amount</th>
                                <th>Comments</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($topups->take(5) as $trx)
                                <tr>
                                    <td>{{ $trx->sk_ref }}</td>
                                    <td>{{ $trx->status }}</td>
                                    <td>{{ $trx->amount }}</td>
                                    <td>{{ $trx->comments }}</td>
                                    <td>
                                        {{ \Carbon\Carbon::parse($trx->created_at)->isoFormat('MMM Do, h:mm A') }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
            <div>&nbsp;</div>
            <div>
                {{ $topups->links() }}
            </div>
        </div>
    </div>
   
@endsection

@section('bootstrap')
    <script src="//netdna.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
@endsection

@section('scripts')
    <script src="https://js.paystack.co/v1/inline.js"></script>
    <script type="text/javascript">
        function payWithPaystack(){
            var enteredAmount = $("#amount").val();
            var amount = parseInt(enteredAmount + '00');
            var email =  $("#email").val();
            var phone =  $("#phone").val();
            var key =  $("#paystackKey").val();

            var token = $("#token").val();
            
            const formData = {'amount':enteredAmount, 'processor': 'Paystack', '_token':token};

            $.ajax({
                url: '/user/financials/wallet/top-up',
                type: 'POST',
                data: formData,
                datatype: 'json'
            })
            .done(function (data) { 
                if(data.success == 1){
                    var handler = PaystackPop.setup({
                        key: key,
                        email:  email,
                        amount: amount,
                        ref: data.sk_ref,
                        metadata: {
                            custom_fields: [
                                {
                                    display_name: "Mobile Number",
                                    variable_name: "mobile_number",
                                    value: phone
                                }
                            ]
                        },
                        callback: function(response){
                            const formData = {'sk_ref':response.reference, 'trans':response.trans, 'status':response.status, 'message':response.message, '_token':token};

                            $.ajax({
                                url: '/user/financials/wallet/top-up/paystack-callback',
                                type: 'POST',
                                data: formData,
                                datatype: 'json'
                            })
                            .done(function (data) { 
                                if(data.success == 1){
                                    success_snackbar(data.message, 5000)
                                    setTimeout(function(){
                                        $("#amount").val("");
                                        $("#wallet").html("&#8358; " + data.balance + ".00");
                                    }, 500);
                                }else{
                                    danger_snackbar(data.error, 5000)
                                }
                            })
                            .fail(function (jqXHR, textStatus, errorThrown) { 
                                danger_snackbar('Error - ' + jqXHR.status + ': ' + jqXHR.statusText, 8000);
                            });
                        },
                        onClose: function(){
                            console.log('Paystack payment window closed');
                        }
                    });
                    handler.openIframe();
                }else{
                    danger_snackbar(data.error, 5000)
                }

            })
            .fail(function (jqXHR, textStatus, errorThrown) { 
                danger_snackbar('Error - ' + jqXHR.status + ': ' + jqXHR.statusText, 8000);
            });
        }
    </script>
@endsection