@extends('member.template')

@section('content')
    <div class="dashboard-box main-box-in-row">
        <div class="headline">
            <h3><i class="icon-feather-bar-chart-2"></i> Summary - Financials</h3>
        </div>
        <div class="content">
            <div class="row" style="padding: 10px;">
                <div class="col-xl-4 fun-fact" data-fun-fact-color="#36bd78">
                    <div class="fun-fact-text">
                        <span>No. of Topups</span>
                        <h4 id="noOfTrx">{{ $trxCount }}</h4>
                    </div>
                    <div class="fun-fact-icon">
                        <i style="color: #00a554;" class="icon-material-outline-credit-card"></i>
                    </div>
                </div>
                <div class="col-xl-4 fun-fact" data-fun-fact-color="#36bd78">
                    <div class="fun-fact-text">
                        <span>Total Commission</span>
                        <h4 id="totalComms">
                            {{ $totalComms }}
                        </h4>
                    </div>
                    <div class="fun-fact-icon">
                        <i style="color: #00a554;">&#8358;</i>
                    </div>
                </div>
                <div class="col-xl-4 fun-fact" data-fun-fact-color="#36bd78">
                    <div class="fun-fact-text">
                        <span>Amount in Escrow</span>
                        <h4 id="escrowValue">
                            {{ $escrowValue }}
                        </h4>
                    </div>
                    <div class="fun-fact-icon">
                        <i style="color: #00a554;">&#8358;</i>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="dashboard-box main-box-in-row">
        <div class="headline">
            <h3><i class="icon-feather-bar-chart-2"></i> Summary - Users</h3>
        </div>
        <div class="content">
            <div class="row" style="padding: 10px;">
                <div class="col-xl-4 fun-fact" data-fun-fact-color="#36bd78">
                    <div class="fun-fact-text">
                        <span>Total Students</span>
                        <h4 id="noOfStudents">{{ @$noOfStudents }}</h4>
                    </div>
                    <div class="fun-fact-icon">
                        <i style="color: #00a554;" class="icon-feather-users"></i>
                    </div>
                </div>
                <div class="col-xl-4 fun-fact" data-fun-fact-color="#36bd78">
                    <div class="fun-fact-text">
                        <span>Freelancers</span>
                        <h4 id="noOfSE">{{ @$noOfSE }}</h4>
                    </div>
                    <div class="fun-fact-icon">
                        <i style="color: #00a554;" class="icon-feather-user-check"></i>
                    </div>
                </div>
                <div class="col-xl-4 fun-fact" data-fun-fact-color="#36bd78">
                    <div class="fun-fact-text">
                        <span>Assignments Posted</span>
                        <h4 id="homworksPosted">
                            {{ @$homeworksPosted }}
                        </h4>
                    </div>
                    <div class="fun-fact-icon">
                        <i style="color: #00a554;" class="icon-line-awesome-th-list"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="dashboard-box main-box-in-row">
        <div class="headline">
            <h3><i class="icon-feather-bar-chart-2"></i> Summary - Homework</h3>
        </div>
        <div class="content">
            <div class="row" style="padding: 10px;">
                <div class="col-xl-4 fun-fact" data-fun-fact-color="#36bd78">
                    <div class="fun-fact-text">
                        <span>Open Homework</span>
                        <h4 id="openHomeworks">{{ @$openHomeworks }}</h4>
                    </div>
                    <div class="fun-fact-icon">
                        <i style="color: #00a554;" class="icon-feather-users"></i>
                    </div>
                </div>
                <div class="col-xl-4 fun-fact" data-fun-fact-color="#36bd78">
                    <div class="fun-fact-text">
                        <span>Ongoing Homework</span>
                        <h4 id="ongoingHomeworks">{{ @$ongoingHomeworks }}</h4>
                    </div>
                    <div class="fun-fact-icon">
                        <i style="color: #00a554;" class="icon-feather-user-check"></i>
                    </div>
                </div>
                <div class="col-xl-4 fun-fact" data-fun-fact-color="#36bd78">
                    <div class="fun-fact-text">
                        <span>Completed Homework</span>
                        <h4 id="completedHomeworks">
                            {{ @$completedHomeworks }}
                        </h4>
                    </div>
                    <div class="fun-fact-icon">
                        <i style="color: #00a554;" class="icon-line-awesome-th-list"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('bootstrap')
    <script src="//netdna.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
@endsection

@section('scripts')

@endsection
