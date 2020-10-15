@extends('member.template')

@section('content')
    <div class="dashboard-box main-box-in-row">
        <div class="headline">
            <h3><i class="icon-feather-bar-chart-2"></i> Declined Bids</h3>
        </div>
        <div class="contentdashboard-box main-box-in-row table-responsive" style="overflow-x:auto; padding: 10px;">
            @if($bids->count() == 0)
                <div class="row">
                    <div class="col-md-12">
                        <p style="padding: 20px;">You have no declined bids. :-) </p>
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
                                <th>Submitted On</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($bids as $bid)
                                <tr>
                                    <td>{{ $bid->id }}</td>
                                    <td>{{ $bid->homework->title }}</td>
                                    <td>{{ $bid->amount }}</td>
                                    <td>
                                        {{ \Carbon\Carbon::parse($bid->created_at)->isoFormat('MMM Do, h:mm A') }}
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