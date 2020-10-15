@extends('member.template')

@section('content')
    <div class="dashboard-box main-box-in-row">
        <div class="headline">
            <h3>Completed Homework</h3>
        </div>
        <div class="contentdashboard-box main-box-in-row table-responsive" style="overflow-x:auto; padding: 10px;">
            @if($hws->count() == 0)
                <div class="row">
                    <div class="col-md-12">
                        <p style="padding: 20px;">You have not completed any homeworks</p>
                    </div>
                </div>
            @else
                <div class="contentdashboard-box main-box-in-row table-responsive" style="overflow-x:auto;">
                    <table class="table table-striped cats-table">
                        <thead>
                            <tr>
                                <th>Title</th>
                                <th>Deadline</th>
                                <th>Hired On</th>
                                <th>Submitted on</th>
                                <th>Amount</th>
                                <th> </th>
                                <th>&nbsp;</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($hws as $hw)
                                <tr>
                                    <td>
                                        <a style="color: #00a554" href="/homeworks/single/{{ $hw->uuid }}">
                                            {{ $hw->title }}
                                        </a>
                                    </td>
                                    <td>
                                        {{ \Carbon\Carbon::parse($hw->deadline)->isoFormat('MMM Do') }}
                                    </td>
                                    <td>
                                        @if(!empty($hw->hired_on))
                                            {{ \Carbon\Carbon::parse($hw->hired_on)->isoFormat('MMM Do, h:mm A') }}
                                        @endif
                                    </td>
                                    <td>
                                        @if(!empty($hw->solution->created_at))
                                            {{ \Carbon\Carbon::parse($hw->solution->created_at)->isoFormat('MMM Do, h:mm A') }}
                                        @endif
                                    </td>
                                    <td>{{ $hw->winning_bid_amount }}</td>
                                    <td>
                                        @if($hw->status === 8)
                                            @if(@$hw->reviews->where('reviewer', Auth::user()->id)->count() > 0)
                                                <div class="star-rating" data-rating="{{ $hw->reviews->where('reviewer', Auth::user()->id)->first()->rating }}"></div>
                                            @else
                                                <a class="btn btn-info rate" style="color: #fff" href="/homeworks/{{ $hw->uuid }}/review" title="Review solution expert">
                                                    Review Freelancer
                                                </a>
                                            @endif
                                        @else
                                            &nbsp;
                                        @endif
                                    </td>
                                    <td>
                                        <a class="btn button" style="color: #fff; background: #17a2b8; padding: 5px 15px;" href="/homeworks/single/{{ $hw->uuid }}" title="View Homework">
                                            View
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

        })
    </script>
@endsection
