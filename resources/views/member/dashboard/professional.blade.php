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
                        <span>Wallet Balance</span>
                        <h4 id="wallet">&#8358; {{ Auth::user()->wallet }}</h4>
                    </div>
                    <div class="fun-fact-icon">
                        <i style="color: #00a554;" class="icon-material-outline-account-balance-wallet"></i>
                    </div>
                </div>
                <div class="col-xl-4 fun-fact" data-fun-fact-color="#36bd78">
                    <div class="fun-fact-text">
                        <span>Ongoing Homework</span>
                        <h4 id="ongoing">{{ Auth::user()->posted->where('status', 3)->count() }}</h4>
                    </div>
                    <div class="fun-fact-icon">
                        <i style="color: #00a554;" class="icon-line-awesome-list"></i>
                    </div>
                </div>
                <div class="col-xl-4 fun-fact" data-fun-fact-color="#36bd78">
                    <div class="fun-fact-text">
                        <span>Completed Homework</span>
                        <h4 id="completed">{{ Auth::user()->posted->where('status', 4)->count() }}</h4>
                    </div>
                    <div class="fun-fact-icon">
                        <i style="color: #00a554;" class="icon-line-awesome-list-alt"></i>
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