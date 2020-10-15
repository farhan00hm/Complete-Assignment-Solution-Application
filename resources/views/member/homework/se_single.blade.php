@extends('member.template')

@section('content')
    <div class="dashboard-box main-box-in-row" style="min-height: 550px;">
        <div class="headline">
            <h3>Homework - {{ $hw->title }}
                @if(Auth::user()->user_type == "SE")
                    @if(!$bid)
                        @if(Auth::user()->flaggedHomeworks->where('homework_id', $hw->id)->first())
                            <button class="btn-danger button mb-10" style="color: #ffffff; float: right;line-height: 20px; box-shadow: none; margin-right: 5px; background-color: #dc3545 !important;">
                                <i style="color: #fff;" class="icon-material-outline-outlined-flag"></i> You flagged this homework
                            </button>
                        @else
                            @if(empty($hw->awarded_to))
                                <button class="btn-info button mb-10" data-toggle="modal" data-target="#bidModal" style="color: #ffffff; float: right; line-height: 20px; box-shadow: none; background-color: #17a2b8 !important;">
                                    <i style="color: #fff;" class="icon-line-awesome-trophy"></i> Bid
                                </button>
                                <button class="btn-danger button mb-10" data-toggle="modal" data-target="#flagModal"  style="color: #ffffff; float: right;line-height: 20px; box-shadow: none; margin-right: 5px; background-color: #dc3545 !important;">
                                    <i style="color: #fff;" class="icon-material-outline-outlined-flag"></i> Flag
                                </button>
                            @else
                                <button class="btn-info button mb-10" style="color: #ffffff; float: right; line-height: 20px; box-shadow: none; background-color: #17a2b8 !important;">
                                    <i style="color: #fff;" class="icon-line-awesome-times-circle-o"></i> Homework not available
                                </button>
                            @endif
                        @endif
                    @else
                        @if($hw->awarded_to == Auth::user()->id)
                            <button class="btn-success button mb-10" style="color: #ffffff; float: right;line-height: 20px; box-shadow: none; margin-right: 5px; background-color: #218838 !important;">
                                <i style="color: #fff;" class="icon-material-outline-check-circle"></i> You were hired for this homework
                            </button>
                        @else
                            <button class="btn-danger button mb-10" id="withdraw" style="color: #ffffff; float: right;line-height: 20px; box-shadow: none; margin-right: 5px; background-color: #dc3545 !important;" data-code="{{ $bid->id }}">
                                <input type="hidden" name="bidId" id="bidId" value="{{ $bid->id }}">
                                <i style="color: #fff;" class="icon-material-outline-highlight-off"></i> Withdraw Bid
                            </button>
                            <button class="btn-success button mb-10" style="color: #ffffff; float: right;line-height: 20px; box-shadow: none; margin-right: 5px; background-color: #218838 !important;">
                                <i style="color: #fff;" class="icon-line-awesome-trophy"></i> Active Bid Amount: {{ $bid->amount }}
                            </button>
                        @endif
                    @endif
                @endif

                @if(Auth::user()->isPrivileged())
                    <!-- Check if the homework has been flagged -->
                    @if($hw->flags->count() > 0)
                        <button class="btn-danger button mb-10" id="approveFlag" style="color: #ffffff; float: right;line-height: 20px; box-shadow: none; margin-right: 5px; background-color: #dc3545 !important;" data-code="{{ $hw->id }}">
                            Approve Flag & Remove Homework
                        </button>
                        <button class="btn-success button mb-10" id="declineFlag" style="color: #ffffff; float: right;line-height: 20px; box-shadow: none; margin-right: 5px; background-color: #37a000 !important;" data-code="{{ $hw->id }}">
                            Decline Flag
                        </button>
                    @endif
                @endif
            </h3>
        </div>

        <div class="content">
            <ul class="fields-ul">
                <li>
                    <div class="row">
                        @if(Auth::user()->user_type == "SE")
                        <div class="col-xl-3">
                            <div class="submit-field">
                                <h5>Posted By</h5>
                                <a href="{{route('users.students.profile',[$hw->postedBy->uuid]) }}"><p>{{ $hw->postedBy->username }}</p></a>
{{--                                <p>{{ $hw->postedBy->username }}</p>--}}
                            </div>
                        </div>
                        @endif

                        
                        <div class="col-xl-3">
                            <div class="submit-field">
                                <h5>Budget</h5>
                                <p>&#8358; {{ $hw->budget }}</p>
                            </div>
                        </div>

                        <div class="col-xl-3">
                            <div class="submit-field">
                                <h5>Deadline</h5>
                                <p>{{ $hw->deadline }}</p>
                            </div>
                        </div>

                        <div class="col-xl-3">
                            <div class="submit-field">
                                <h5>Category</h5>
                                <p>{{ @$hw->subcategory->name }}</p>
                            </div>
                        </div>
                    </div>

                 
                </li>
                @if($hw->files->count() > 0)
                    <li>
                        <div class="row">
                            <div class="col-xl-12">
                                <div class="submit-field">
                                    <h5>Attachments</h5>
                                        <div class="attachments-container margin-top-0 margin-bottom-0">
                                            <?php $i = 1; ?>
                                            @foreach($hw->files as $file)
                                                <div class="attachment-box ripple-effect" style="flex: 0 1 calc(33% - 21px);">
                                                    <span>Attachment {{ $i }}</span>
                                                    <span>
                                                        <a class="btn btn-info" href="/homework/files/download?path={{ $file->upload_path }}" style="color: #ffffff; margin-top: 10px;">
                                                            Download
                                                        </a>
                                                    </span>
                                                </div>
                                                <?php $i += 1; ?>
                                            @endforeach
                                        </div>
                                    <div class="clearfix"></div>

                                </div>
                            </div>
                        </div>
                    </li>
                @endif
                <li>
                     {{--  <div class="row">
                                 
                             <form action="/action_page.php">
                              <p>Refund Option:</p>
                             <fieldset>
                                  <div class="some-class">
                                    <input type="radio" class="radio" name="x" value="y" id="r1" />
                                    <label for="y">Full Refund</label>
                                    <input type="radio" class="radio" name="x" value="z" id="r2" />
                                    <label for="z">Partial Refund</label>
                                  </div>

                                 <div class="text">
                                    <p> Write percent (%) of acceptness
                                        <input type="number" name="text1" id="text1" maxlength="30">
                                    </p>
                                </div>
                                </fieldset>

                                <input type="submit" value="Submit">
                            </form>

                        </div> --}}
                       
                    <div class="row">
                        <div class="col-xl-12">
                            <div class="submit-field">
                                <h5>Description</h5>
                                {{ $hw->description }}
                                <input type="hidden" name="id" id="id" value="{{ $hw->id }}">
                                <input type="hidden" name="uuid" id="uuid" value="{{ $hw->uuid }}">
                            </div>
                        </div>
                    </div>
                </li>

                <li>
                    <div class="row">
                        <div class="col-xl-12">
                            <div class="submit-field">
                                <h5>Solution Notes</h5>
                                @if(!empty(@$hw->solution->notes))
                                    {{ $hw->solution->notes }}
                                @else
                                    <p>Solution notes not available yet.</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </li>

                <li>
                    <div class="row">
                        <div class="col-xl-12">
                            <div class="submit-field">
                                <h5>Solution Files</h5>
                                @if(!empty($hw->solution->files))
                                    <div class="attachments-container margin-top-0 margin-bottom-0">
                                        <?php $i = 1; ?>
                                        @foreach(@$hw->solution->files as $file)
                                            <div class="attachment-box ripple-effect" style="flex: 0 1 calc(33% - 21px);">
                                                <span>File {{ $i }}</span>
                                                <span>
                                                    <a class="btn btn-info" href="/homework/files/download?path={{ @$file->upload_path }}" style="color: #ffffff; margin-top: 10px;">
                                                        Download
                                                    </a>
                                                </span>
                                            </div>
                                            <?php $i += 1; ?>
                                        @endforeach
                                    </div>
                                @else
                                    <p>Solution files not available yet or not files associated with the homework solutions</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </li>
            </ul>
        </div>

        <!-- Bid Modal -->
        <div class="modal fade bd-example-modal-lg" id="bidModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Bid</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form method="post" id="more-info" name="more-info">
                            <div class="row">
                                <div class="col-xl-6">
                                    <div class="submit-field">
                                        <h5>Amount</h5>
                                        <div class="input-with-icon">
                                            <input class="with-border" type="text" id="amount" name="amount">
                                            <i class="currency">&#8358;</i>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-6">
                                    <div class="submit-field">
                                        <h5>Expected Completion Date</h5>
                                        <input type="date" class="with-border" id="completion" name="completion">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xl-12">
                                    <div class="submit-field">
                                        <h5>Short Introduction <small>(Max 300 characters)</small></h5>
                                        <textarea cols="30" rows="5" class="with-border" id="intro" name="intro"></textarea>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <!-- Button -->
                        <button id="bid" class="button button-sliding-icon ripple-effect margin-top-10" style="width: 100px;"> Submit Bid <i class="icon-material-outline-arrow-right-alt"></i></button>
                        </div>
                </div>
            </div>
        </div>

        <!-- Flag homework Modal -->
        <div class="modal fade bd-example-modal-lg" id="flagModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Flag Homework</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form method="post" id="more-info" name="more-info">
                            <div class="col-xl-12 submit-field">
                                <h5>Reason for Flagging</h5>
                                <textarea cols="30" rows="5" class="with-border" id="reason" name="reason"></textarea>
                            </div>
                            <div class="col-xl-12">
                                <div class="checkbox">
                                    <input type="checkbox" id="terms" name="terms">
                                    <label for="terms"><span class="checkbox-icon"></span> By flagging a homework, you accept that you have gone through the homework and you are convinced it violates Bemexpress terms.</label>
                                </div>
                            </div>
                        </form>

                        <button id="flag" class="button button-sliding-icon ripple-effect margin-top-10" style="width: 100px;"> Flag <i class="icon-material-outline-arrow-right-alt"></i></button>
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
    <script src="{{ asset('member/js/pdfobjects.min.js') }}"></script>
    <script>
        $(document).ready(function(){
            // Approve pending solution experts
            $("#bid").click(function(e){
                e.preventDefault();

                var token = $("#token").val();
                var hwId = $("#id").val();
                var amount = $("#amount").val();
                var completion = $("#completion").val();
                var intro = $("#intro").val();

                const formData = {'hwId':hwId, 'amount':amount, 'completion':completion, 'intro':intro, '_token':token};

                $.ajax({
                    url: '/bids/submit',
                    type: 'POST',
                    data: formData,
                    datatype: 'json'
                })
                .done(function (data) {
                    if(data.success == 1){
                        success_snackbar(data.message, 3000)
                        setTimeout(function(){
                            location.reload();
                        }, 3000);
                    }else{
                        danger_snackbar(data.error, 5000)
                    }
                })
                .fail(function (jqXHR, textStatus, errorThrown) {
                    danger_snackbar('Error - ' + jqXHR.status + ': ' + jqXHR.statusText, 8000);
                });
            });

            // Withdral a bid
            $("#withdraw").click(function(e){
                e.preventDefault();

                var token = $("#token").val();
                var bidId = $("#bidId").val();
                var hwId = $("#id").val();

                const formData = {'bidId':bidId, 'hwId':hwId, '_token':token};

                $.ajax({
                    url: '/bids/withdraw',
                    type: 'POST',
                    data: formData,
                    datatype: 'json'
                })
                .done(function (data) {
                    if(data.success == 1){
                        success_snackbar(data.message, 3000)
                        setTimeout(function(){
                            location.reload();
                        }, 3000);
                    }else{
                        danger_snackbar(data.error, 5000)
                    }
                })
                .fail(function (jqXHR, textStatus, errorThrown) {
                    danger_snackbar('Error - ' + jqXHR.status + ': ' + jqXHR.statusText, 8000);
                });
            });

            // Flag a homework
            $("#flag").click(function(e){
                e.preventDefault();

                var token = $("#token").val();
                var id = $("#id").val();
                var reason = $("#reason").val();
                var terms = $("#terms").val();

                if ($('input[name="terms"]:checked').length > 0) {
                    terms = 1;
                } else {
                    terms = 0;
                    danger_snackbar("You must accept you have read through the homework and you are convinced it violates Bemexpress terms.", 5000);
                    return false;
                }

                const formData = {'id':id, 'reason':reason, 'terms':terms, '_token':token};

                $.ajax({
                    url: '/homeworks/flag',
                    type: 'POST',
                    data: formData,
                    datatype: 'json'
                })
                .done(function (data) {
                    if(data.success == 1){
                        success_snackbar(data.message, 3000)
                        setTimeout(function(){
                            location.reload();
                        }, 3000);
                    }else{
                        danger_snackbar(data.error, 5000)
                    }
                })
                .fail(function (jqXHR, textStatus, errorThrown) {
                    danger_snackbar('Error - ' + jqXHR.status + ': ' + jqXHR.statusText, 8000);
                });
            });

            // Admin approve flag and delete homework
            $("#approveFlag").click(function(e){
                e.preventDefault();

                var token = $("#token").val();
                var hwId = $("#id").val();

                const formData = {'hwId':hwId, '_token':token};

                $.ajax({
                    url: '/homeworks/flagged/approve',
                    type: 'POST',
                    data: formData,
                    datatype: 'json'
                })
                .done(function (data) {
                    if(data.success == 1){
                        success_snackbar(data.message, 3000)
                        setTimeout(function(){
                            window.location.href = "/homeworks/flagged"
                        }, 3000);
                    }else{
                        danger_snackbar(data.error, 5000)
                    }
                })
                .fail(function (jqXHR, textStatus, errorThrown) {
                    danger_snackbar('Error - ' + jqXHR.status + ': ' + jqXHR.statusText, 8000);
                });
            });

            // Admin decline flagged homework
            $("#declineFlag").click(function(e){
                e.preventDefault();

                var token = $("#token").val();
                var hwId = $("#id").val();

                const formData = {'hwId':hwId, '_token':token};

                $.ajax({
                    url: '/homeworks/flagged/decline',
                    type: 'POST',
                    data: formData,
                    datatype: 'json'
                })
                .done(function (data) {
                    if(data.success == 1){
                        success_snackbar(data.message, 3000)
                        setTimeout(function(){
                            window.location.href = "/homeworks/flagged"
                        }, 3000);
                    }else{
                        danger_snackbar(data.error, 5000)
                    }
                })
                .fail(function (jqXHR, textStatus, errorThrown) {
                    danger_snackbar('Error - ' + jqXHR.status + ': ' + jqXHR.statusText, 8000);
                });
            });

        })
    </script>
@endsection
