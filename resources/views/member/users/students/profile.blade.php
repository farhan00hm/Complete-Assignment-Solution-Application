@extends('member.template')

@section('content')
    <div class="dashboard-box main-box-in-row">
        <div class="headline">
            <h3><i class="icon-material-outline-face"></i> Profile -
                @if(Auth::user()->isPrivileged())
                    {{ $student->first_name }} {{ $student->last_name }}
                @else
                    {{ $student->username }}
                @endif
            </h3>
        </div>

        <div class="content">
            <ul class="fields-ul">
                <h4>Profile Details</h4>
                <li>
                    <div class="row">
                        @if(Auth::user()->isPrivileged())
                            <div class="col-xl-4">
                                <div class="submit-field">
                                    <h5>Name</h5>
                                    <p>{{ $student->first_name }} {{ $student->last_name }}</p>
                                </div>
                            </div>

                            <div class="col-xl-4">
                                <div class="submit-field">
                                    <h5>Email</h5>
                                    <p>{{ $student->email }}</p>
                                </div>
                            </div>

                            <div class="col-xl-4">
                                <div class="submit-field">
                                    <h5>Phone</h5>
                                    <p>{{ $student->phone }}</p>
                                </div>
                            </div>

                            <div class="col-xl-4">
                                <div class="submit-field">
                                    <h5>Wallet</h5>
                                    <p>&#8358; {{ $student->wallet }}</p>
                                </div>
                            </div>
                        @endif

                        <div class="col-xl-4">
                            <div class="submit-field">
                                <h5>Username</h5>
                                <p>{{ $student->username }}</p>
                            </div>
                        </div>

                        <div class="col-xl-4">
                            <div class="submit-field">
                                <h5>Gender</h5>
                                <p>{{ $student->gender }}</p>
                            </div>
                        </div>

                        <div class="col-xl-4">
                            <div class="submit-field">
                                <h5>School</h5>
                                <p>{{ $student->school }}</p>
                            </div>
                        </div>
                    </div>
                </li>

                @if(Auth::user()->isPrivileged())
                    <h4 style="margin-top: 20px;">Homework Statistics</h4>
                    <li>
                        <div class="row">
                            <div class="col-xl-4">
                                <div class="submit-field">
                                    <h5>Open Homework</h5>
                                    <p>{{ $student->posted->where('status', 1)->count() }}</p>
                                </div>
                            </div>

                            <div class="col-xl-4">
                                <div class="submit-field">
                                    <h5>Ongoing Homework</h5>
                                    <p>{{ $student->posted->whereIn('status', [3, 5])->count() }}</p>
                                </div>
                            </div>

                            <div class="col-xl-4">
                                <div class="submit-field">
                                    <h5>Completed Homework</h5>
                                    <p>{{ $student->posted->whereIn('status', [6, 8])->count() }}</p>
                                </div>
                            </div>
                        </div>
                    </li>
                @endif

                @if(Auth::user()->isPrivileged())
                    <h4 style="margin-top: 20px;">Transactions</h4>
                    <li style="padding: 3px;">
                        <div class="contentdashboard-box main-box-in-row table-responsive"
                             style="overflow-x:auto; padding: 2px;">
                            @if($trxs->count() < 1)
                                <div class="row">
                                    <div class="col-md-12">
                                        <p style="padding: 20px;">User has no recent transactions.</p>
                                    </div>
                                </div>
                            @else
                                <div class="contentdashboard-box main-box-in-row table-responsive"
                                     style="overflow-x:auto; min-height: 400px;">
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
                                                <td>&#8358; {{ $trx->amount }}</td>
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
                            <div>
                                {{ $trxs->links() }}
                            </div>
                            <div>&nbsp;</div>
                        </div>
                    </li>
                @endif

                {{--                display student reviews--}}
                <li>
                    <div class="row">
                        <div class="col-xl-12">
                            <div class="submit-field">
                                <h3>Ratings and Reviews</h3>
                                @foreach($student->reviewee as $review)
                                    <div class="boxed-list-item">
                                        <div class="item-content">
                                            <h5>{{ $review->homework->title }}</h5>
                                            <div class="item-details margin-top-10">
                                                <div class="star-rating" data-rating="{{ $review->rating }}"></div>
                                                <div class="detail-item">
                                                    <i class="icon-material-outline-date-range"></i>
                                                    {{ \Carbon\Carbon::parse($review->created_at)->isoFormat('MMMM, Y') }}
                                                </div>
                                            </div>
                                            <div class="item-description">
                                                <p>{{ $review->review }}</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="margin-top-20"></div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </li>
            </ul>
        </div>

    </div>

@endsection

@section('bootstrap')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"
            integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
            crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"
            integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
            crossorigin="anonymous"></script>
@endsection
