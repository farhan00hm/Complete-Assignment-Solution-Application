@extends('member.template2')

@section('content')
    <div class="dashboard-box main-box-in-row">
        <div class="headline">
            <h3><i class="icon-feather-bar-chart-2"></i> InActive Discount Codes
                <a href="/discount-codes/new" class="button mb-10" style="float: right; color: #fff; line-height: 20px; box-shadow: none;">+ Create New</a>
            </h3>
        </div>
        <div class="contentdashboard-box main-box-in-row table-responsive" style="overflow-x:auto; padding: 10px;">
            @if($codes->count() < 1)
                <div class="row">
                    <div class="col-md-12">
                        <p style="padding: 20px;">No inactive discount codes.</p>
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
                                <th>Comments</th>
                                <th>Redeem count</th>
                                <th>Deactivated On</th>
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
                                    <td>{{ $code->comments }}</td>
                                    <td>{{ $code->redeem_count }}</td>
                                    <td>
                                        {{ \Carbon\Carbon::parse($code->invalidated_on)->isoFormat('Y-MM-DD') }}
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
        
    </script>
@endsection