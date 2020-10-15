@extends('member.template')

@section('content')
    <div class="dashboard-box main-box-in-row">
        <div class="headline">
            <h3><i class="icon-feather-bar-chart-2"></i> Summary</h3>
        </div>
        <div class="content">
            <div class="row" style="padding: 10px;">
                <div class="col-xl-4 fun-fact" data-fun-fact-color="#36bd78">
                    <div class="fun-fact-text">
                        <span>Total Students</span>
                        <h4 id="noOfTrx">10</h4>
                    </div>
                    <div class="fun-fact-icon">
                        <i style="color: #00a554;" class="icon-feather-users"></i>
                    </div>
                </div>
                <div class="col-xl-4 fun-fact" data-fun-fact-color="#36bd78">
                    <div class="fun-fact-text">
                        <span>Freelancers</span>
                        <h4 id="noOfTrx">10</h4>
                    </div>
                    <div class="fun-fact-icon">
                        <i style="color: #00a554;" class="icon-feather-user-check"></i>
                    </div>
                </div>
                <div class="col-xl-4 fun-fact" data-fun-fact-color="#36bd78">
                    <div class="fun-fact-text">
                        <span>Assignments Posted</span>
                        <h4 id="trxValue">
                            100
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
