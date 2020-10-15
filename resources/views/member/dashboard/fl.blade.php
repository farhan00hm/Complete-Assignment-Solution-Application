@extends('member.template')

@section('content')
{{--    Display email verification status--}}
    @if(Session::has('message'))
        <div class="alert alert-danger">
            <button type="button" class="btn close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">×</span>
            </button>
            <p>{{ Session::get('message') }}</p>
        </div>
    @elseif(Auth::user()->email_verified_at == null)
        <div class="alert alert-warning">
            <button type="button" class="btn close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">×</span>
            </button>
            <p>Your email is not verified</p>
        </div>
    @endif
    <div class="dashboard-box main-box-in-row">
        <div class="headline">
            <h3><i class="icon-feather-bar-chart-2"></i> Summary</h3>
        </div>
        <div class="content">
            <div class="row" style="padding: 10px;">
                <div class="col-xl-4 fun-fact" data-fun-fact-color="#36bd78">
                    <div class="fun-fact-text">
                        <a href="/freelancer/financials/transactions">
                            <span>Wallet Balance</span>
                            <h4 id="noOfTrx">{{ Auth::user()->wallet }}</h4>
                        </a>
                    </div>
                    <div class="fun-fact-icon">
                        <i style="color: #00a554;">&#8358;</i>
                    </div>
                </div>
                <div class="col-xl-4 fun-fact" data-fun-fact-color="#36bd78">
                    <div class="fun-fact-text">
                        <a href="/freelancer/homeworks/ongoing">
                            <span>Ongoing Homework</span>
                            <h4 id="ongoing">{{ Auth::user()->awarded->whereIn('status', [3, 5])->count() }}</h4>
                        </a>
                    </div>
                    <div class="fun-fact-icon">
                        <i style="color: #00a554;" class="icon-line-awesome-list"></i>
                    </div>
                </div>
                <div class="col-xl-4 fun-fact" data-fun-fact-color="#36bd78">
                    <div class="fun-fact-text">
                        <a href="/freelancer/homeworks/completed">
                            <span>Completed Homework</span>
                            <h4 id="completed">{{ Auth::user()->awarded->where('status', 8)->count() }}</h4>
                        </a>
                    </div>
                    <div class="fun-fact-icon">
                        <i style="color: #00a554;" class="icon-line-awesome-list-alt"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="dashboard-box main-box-in-row">
        <div class="headline">
            <h3><i class="icon-feather-bar-chart-2"></i> Recent Transactions</h3>
        </div>
        <div class="contentdashboard-box main-box-in-row table-responsive" style="overflow-x:auto; padding: 10px;">
            @if($trxs->count() < 1)
                <div class="row">
                    <div class="col-md-12">
                        <p style="padding: 20px;">You have no recent transactions.</p>
                    </div>
                </div>
            @else
                <div class="contentdashboard-box main-box-in-row table-responsive" style="overflow-x:auto; min-height: 400px;">
                    <table class="table table-striped discounts-table">
                        <thead>
                            <tr>
                                <th>Reference</th>
                                <th>Status</th>
                                <th>Type</th>
                                <th>Amount</th>
                                <th>Comments</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($trxs->take(5) as $trx)
                                <tr>
                                    <td>{{ $trx->sk_ref }}</td>
                                    <td>{{ $trx->status }}</td>
                                    <td>{{ $trx->type }}</td>
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
                {{ $trxs->links() }}
            </div>
        </div>
    </div>

@endsection

@section('bootstrap')
    <script src="//netdna.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
@endsection

@section('scripts')
    <script>

    </script>
@endsection
