@extends('member.template')

@section('content')
    <div class="dashboard-box main-box-in-row">
        <div class="headline">
            <h3><i class="icon-feather-bar-chart-2"></i> Commissions</h3>
        </div>
        <div class="contentdashboard-box main-box-in-row table-responsive" style="overflow-x:auto; padding: 10px;">
            @if($comms->count() < 1)
                <div class="row">
                    <div class="col-md-12">
                        <p style="padding: 20px;">No commissions yet.</p>
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
                                <th>Amount</th>
                                <th>Transaction Comments</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($comms as $comm)
                                <tr>
                                    <td>
                                        <a href="/homeworks/single/{{ @$comm->homework->uuid }}">
                                            {{ @$comm->homework->title }}
                                        </a>
                                    </td>
                                    <td>{{ $comm->escrow->transaction->sk_ref }}</td>
                                    <td>{{ $comm->escrow->transaction->status }}</td>
                                    <td>{{ $comm->amount }}</td>
                                    <td>{{ $comm->escrow->transaction->comments }}</td>
                                    <td>
                                        {{ \Carbon\Carbon::parse($comm->created_at)->isoFormat('MMM Do, h:mm A') }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
            <div>&nbsp;</div>
            <div>
                {{ $comms->links() }}
            </div>
        </div>
    </div>
@endsection

@section('bootstrap')
    <script src="//netdna.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
@endsection

@section('scripts')
    
@endsection