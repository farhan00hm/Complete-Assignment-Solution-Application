@extends('member.template')

@section('content')
    <div class="dashboard-box main-box-in-row" style="min-height: 550px;">
        <div class="headline">
            <h3><i class="icon-line-awesome-trophy"></i> {{ $hw->title }} - Bids ({{ $hw->bids->count() }})</h3>
        </div>


        <div class="content">
            <ul class="dashboard-box-list bids-ul">
                @if($hw->bids->count() > 0)
                    @foreach($hw->bids as $bid)
                        <li>
                            <div class="job-listing width-adjustment">
                                <div class="job-listing-details">
                                    <div class="job-listing-description">
                                        <h3 class="job-listing-title">
                                            Submited By: <a href="/users/freelancers/profile/{{$bid->bidder->expert->uuid}}">
                                                {{$bid->bidder->username}}
                                            </a>
                                        </h3>
                                    </div>
                                </div>
                            </div>

                            <ul class="dashboard-task-info">
                                <li><strong>&#8358; {{ $bid->amount }}</strong><span>Bid Amount</span></li>
                                <li><strong>{{ $bid->expected_completion_date }}</strong><span>Expected Delivery Date</span></li>
                            </ul>

                            <div class="job-listing width-adjustment">
                                <div class="job-listing-details">
                                    <div class="job-listing-description">
                                        <p>{{ $bid->proposal }}</p>
                                    </div>
                                </div>
                            </div>

                            <div class="buttons-to-right always-visible margin-top-20">
                                @if($hw->status == 3 || $hw->status == 4)
                                    @if($bid->status == 1)
                                        <button class="btn-success button mb-10" style="color: #ffffff; line-height: 20px; box-shadow: none; margin-right: 5px; background-color: #218838 !important;">
                                            <i style="color: #fff;" class="icon-feather-check-circle"></i> Winning Bid
                                        </button>
                                    @endif
                                @elseif($bid->status == 3)
                                    <button class="btn-danger button mb-10" style="color: #ffffff;line-height: 20px; box-shadow: none; margin-right: 5px; background-color: #dc3545 !important;" >
                                        <i style="color: #fff;" class="icon-material-outline-highlight-off"></i> Bid Declined
                                    </button>
                                @else
                                    <button class="btn-danger button mb-10 decline" id="decline" style="color: #ffffff;line-height: 20px; box-shadow: none; margin-right: 5px; background-color: #dc3545 !important;" data-code="{{ $bid->uuid }}">
                                        <i style="color: #fff;" class="icon-material-outline-highlight-off"></i> Decline Bid
                                    </button>
                                    <button class="btn-success button mb-10 hire" id="hire" style="color: #ffffff; line-height: 20px; box-shadow: none; margin-right: 5px; background-color: #218838 !important;" data-code="{{ $bid->uuid }}" data-attr="{{ $bid->amount }}">
                                        <i style="color: #fff;" class="icon-feather-check-circle"></i> Accept/Hire
                                    </button>
                                    @if($bid->counterBid)
                                        @if($bid->counterBid->status == 0)
                                            <button class="btn-info button mb-10" style="color: #888; line-height: 20px; box-shadow: none; margin-right: 5px; background-color: #f4f4f4 !important;">
                                                Active Counter Offer: &#8358; {{ $bid->counterBid->amount }}
                                            </button>
                                        @elseif($bid->counterBid->status == 1)
                                            <button class="btn-success button mb-10" style="color: #fff; line-height: 20px; box-shadow: none; margin-right: 5px; background-color: #218838 !important;">
                                                Accepted Counter Offer: &#8358; {{ $bid->counterBid->amount }}
                                            </button>
                                        @else
                                            <button class="btn-danger button mb-10" style="color: #fff; line-height: 20px; box-shadow: none; margin-right: 5px; background-color: #dc3545 !important;">
                                                Declined Counter Offer: &#8358; {{ $bid->counterBid->amount }}
                                            </button>
                                        @endif
                                    @else
                                        <button class="btn-info button mb-10 counter" id="counter" data-toggle="modal" data-target="#counterModal" data-code="{{ $bid->id }}" style="color: #ffffff; line-height: 20px; box-shadow: none; margin-right: 5px; background-color: #17a2b8 !important;">
                                            <i style="color: #fff;" class="icon-material-outline-info"></i> Counter Offer
                                        </button>
                                    @endif
                                @endif
                            </div>
                        </li>
                    @endforeach
                @else
                    <p style="padding: 20px;">This homework has not received bids yet.</p>
                @endif
                <input type="hidden" name="walletBalance" id="walletBalance" value="{{ Auth::user()->wallet }}">
            </ul>
        </div>


        <!-- Counter Bid Modal -->
        <div class="modal fade bd-example-modal-lg" id="counterModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Counter Offer</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form method="post" id="more-info" name="more-info">
                            <div class="row">
                                <div class="col-xl-12">
                                    <div class="submit-field">
                                        <h5>Amount</h5>
                                        <div class="input-with-icon">
                                            <input class="with-border" type="number" id="amount" name="amount">
                                            <i class="currency">&#8358;</i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xl-12">
                                    <div class="submit-field">
                                        <h5>Optional Note <small>(Max 200 characters)</small></h5>
                                        <textarea cols="30" rows="3" class="with-border" id="note" name="note"></textarea>
                                        <input type="hidden" name="clickedBid" id="clickedBid">
                                    </div>
                                </div>
                                <div class="col-xl-12">
                                    <div class="checkbox">
                                        <input type="checkbox" id="terms" name="terms">
                                        <label for="terms">
                                            <span class="checkbox-icon"></span>
                                            By submitting a counter offer, you agree that if the solution expert agrees to the offer, they will automatically be hired for this homework.
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </form>

                        <button id="counterOffer" class="button button-sliding-icon ripple-effect margin-top-10" style="width: 100px;"> Send Counter Offer <i class="icon-material-outline-arrow-right-alt"></i></button>
                        </div>
                </div>
            </div>
        </div>

    </div>

@endsection

@section('bootstrap')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
@endsection

@section('scripts')
    <script>
        $(document).ready(function(){
            $(".bids-ul li").on("click", ".hire", function(e){
                e.preventDefault();

                var token = $("#token").val();
                var uuid = $(this).attr('data-code');
                var bidAmount = $(this).attr('data-attr');
                var walletBalance = $("#walletBalance").val();

                // Check if bid amount exceeds wallet balance
                if (parseInt(bidAmount) > parseInt(walletBalance)) {
                    info_snackbar("Insufficient funds in wallet. Redirecting to top up page ... ", 3000)
                    setTimeout(function(){
                        window.location.href = "/user/financials/wallet";
                    }, 3000);
                    return false;
                }else{
                    const formData = {'uuid':uuid, '_token':token};

                    $.ajax({
                        url: '/bids/hire',
                        type: 'POST',
                        data: formData,
                        datatype: 'json'
                    })
                    .done(function (data) {
                        if(data.success == 1){
                            success_snackbar(data.message, 5000)
                            setTimeout(function(){
                                window.location.href = data.redirect;
                            }, 5000);
                        }else{
                            danger_snackbar(data.error, 5000)
                            setTimeout(function(){
                                window.location.href = data.redirect;
                            }, 5000);
                        }
                    })
                    .fail(function (jqXHR, textStatus, errorThrown) {
                        danger_snackbar('Error - ' + jqXHR.status + ': ' + jqXHR.statusText, 8000);
                    });
                }

            });

            $(".bids-ul li").on("click", ".decline", function(e){
                e.preventDefault();

                var token = $("#token").val();
                var uuid = $(this).attr('data-code');

                const formData = {'uuid':uuid, '_token':token};

                $.ajax({
                    url: '/bids/decline',
                    type: 'POST',
                    data: formData,
                    datatype: 'json'
                })
                .done(function (data) {
                    if(data.success == 1){
                        success_snackbar(data.message, 5000)
                        setTimeout(function(){
                            location.reload();
                        }, 5000);
                    }else{
                        danger_snackbar(data.error, 5000)
                        setTimeout(function(){
                            location.reload();
                        }, 5000);
                    }
                })
                .fail(function (jqXHR, textStatus, errorThrown) {
                    danger_snackbar('Error - ' + jqXHR.status + ': ' + jqXHR.statusText, 8000);
                });
            });

            $(".bids-ul li").on("click", ".counter", function(){
                var id = $(this).attr('data-code');
                $("#clickedBid").val(id);
            });

            $("#counterOffer").click(function(e) {
                e.preventDefault();

                if ($('input[name="terms"]:checked').length <= 0) {
                    danger_snackbar("You must accept that, By submitting a counter offer, you agree that if the solution expert agrees to the offer, they will automatically be hired for this homework.", 5000);
                    return false;
                }

                var token = $("#token").val();
                var bidId = $("#clickedBid").val();
                var offerAmount = $("#amount").val();
                var note = $("#note").val();
                var walletBalance = $("#walletBalance").val();

                // Check if counter offer amount exceeds wallet balance
                if (parseInt(offerAmount) > parseInt(walletBalance)) {
                    info_snackbar("Insufficient funds in wallet. Your wallet balance must have the amount to counter offer. Redirecting to top up page ... ", 4000)
                    setTimeout(function(){
                        window.location.href = "/user/financials/wallet";
                    }, 4000);
                    return false;
                }else{
                    const formData = {'bidId':bidId, 'amount':offerAmount, 'note':note, '_token':token};

                    $.ajax({
                        url: '/bids/counter-offer',
                        type: 'POST',
                        data: formData,
                        datatype: 'json'
                    })
                    .done(function (data) {
                        if(data.success == 1){
                            success_snackbar(data.message, 5000)
                            setTimeout(function(){
                                location.reload()
                            }, 5000);
                        }else{
                            danger_snackbar(data.error, 5000)
                        }
                    })
                    .fail(function (jqXHR, textStatus, errorThrown) {
                        danger_snackbar('Error - ' + jqXHR.status + ': ' + jqXHR.statusText, 8000);
                    });
                }

            });
        })
    </script>
@endsection
