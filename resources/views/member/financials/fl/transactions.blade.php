@extends('member.template')

@section('content')
    <div class="dashboard-box main-box-in-row">
        <div class="headline">
            <h3><i class="icon-feather-bar-chart-2"></i> Transactions</h3>
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
                                <th>Homework</th>
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
                                    <td>
                                        <a href="/homeworks/single/{{ @$trx->homework->uuid }}">
                                            {{ @$trx->homework->title }}
                                        </a>
                                    </td>
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
    
@endsection