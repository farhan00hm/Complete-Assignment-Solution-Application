@extends('member.template2')

@section('content')
    <div class="dashboard-box main-box-in-row">
        <div class="headline">
            <h3><i class="icon-feather-bar-chart-2"></i> Completed @if(Auth::user()->user_type == "Student")Homework @else Project @endif</h3>
        </div>
        <div class="contentdashboard-box main-box-in-row table-responsive" style="overflow-x:auto; padding: 10px;">
            @if($hws->count() == 0)
                <div class="row">
                    <div class="col-md-12">
                        <p style="padding: 20px;">No @if(Auth::user()->user_type == "Student")homeworks @else projects @endif with the selected status.</p>
                    </div>
                </div>
            @else
                <div class="contentdashboard-box main-box-in-row table-responsive" style="overflow-x:auto;">
                    <table class="table table-striped completed-hw-table">
                        <thead>
                            <tr>
                                <th>Title</th>
                                <th>Awarded To</th>
                                <th>Amount</th>
                                <th>Hired On</th>
                                <th>Completed On</th>
                                <th>Status</th>
                                <th>&nbsp;</th>
                                <th>&nbsp;</th>
                                <th>&nbsp;</th>
                                <th>&nbsp;</th>
                            </tr>
                        </thead>
                        <tbody>
{{--                        {{ dd($hws) }}--}}
                            @foreach($hws as $hw)
                                <tr>
                                    <td>
                                        <a title="View homework" href="/homeworks/single/{{ $hw->uuid }}">{{ $hw->title }}</a>
                                    </td>
                                    <td>
                                        <a title="View solution expert profile" href="/users/freelancers/profile/{{ $hw->awardedTo->expert->uuid }}">{{ $hw->awardedTo->username }}</a>
                                    </td>
                                    <td>{{ $hw->winning_bid_amount }}</td>
                                    <td>
                                        @if(!empty($hw->hired_on))
                                            {{ \Carbon\Carbon::parse($hw->hired_on)->isoFormat('MMM Do, Y') }}
                                        @else
                                            &nbsp;
                                        @endif
                                    </td>
                                    <td>
                                        {{ \Carbon\Carbon::parse($hw->solution->created_at)->isoFormat('MMM Do') }}
                                    </td>
                                    <td>
                                      {{--  <?php
                                          $interval = $hw->solution->created_at->addDays(3);
                                          if($hw->status === 6 && $interval > $hw->solution->created_at)
                                          {
                                             return $hw->status == 8;
                                          }
                                       ?> --}}
                                        @if($hw->status === 6)
                                            <span class="dashboard-status-button yellow">Pending Approval</span>
                                        @elseif($hw->status === 8)
                                            <span class="dashboard-status-button green">Approved </span>
                                        @else
                                            <span class="dashboard-status-button yellow">Unknown</span>
                                        @endif
                                    </td>
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
                                        @if($hw->status === 6)
                                            <a class="btn btn-success approve" style="color: #fff" href="#" data-code="{{ $hw->uuid }}" title="Approve homework solution">
                                                Approve Solution
                                            </a>
                                        @else
                                            &nbsp;
                                        @endif
                                    </td>
                                    <td>
                                        @if($hw->status === 6)
                                            @if($hw->solution->status == 1)
                                                <a class="btn btn-info revision" style="color: #fff" href="#" data-code="{{ $hw->uuid }}"  title="Request homework solution revision">
                                                    Request Revision
                                                </a>
{{--                                                <button class="btn button" data-toggle="modal" data-target="#revisionModal" onclick="requestRevision(this)">Request Revision</button>--}}
                                            @elseif($hw->solution->status == 6)
                                                <a class="btn btn-info" style="color: #fff; cursor: not-allowed;" href="#" data-code="{{ $hw->uuid }}" title="Revision requested">
                                                    Revision Requested
                                                </a>
                                            @endif
                                        @endif
                                    </td>
                                    
                                    <td>
                                        <a  class="btn button" style="color: #fff; background: #17a2b8; padding: 5px 15px;" href="/homeworks/single/{{ $hw->uuid }}" title="Click to view full homework and solution files">
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
    <!-- Request Modal -->
    <div class="modal fade bd-example-modal-lg" id="revisionModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Revision Request</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="post" id="more-info" name="more-info">
                        <div class="row">
                            <div class="col-xl-12">
                                <div class="submit-field">
                                    <h5>Request Note <small>(Max 300 characters)</small></h5>
                                    <textarea cols="30" rows="5" class="with-border" id="intro" name="intro" ></textarea>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-xl-3" style="float: right">
                                <div class="submit-field">
                                    <h5>Completed Answer</h5>
                                    <div class="input-with-icon">
                                        <input class="with-border" type="text" id="amount" name="amount">
                                        <i>%</i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                    <!-- Button -->
                    <a class="btn btn-info revision" id="submitRevisionNote" style="color: #fff" href="#" data-code="{{ $hw->uuid }}" data-toggle="modal" data-target="#revisionModal"  title="Request homework solution revision">
                        Request Revision
                    </a>
{{--                    <button id="bid" class="button button-sliding-icon ripple-effect margin-top-10 revision" style="width: 100px;"><a class="btn btn-info" style="color: #fff" href="#" data-code="{{ $hw->uuid }}" title="Request homework solution revision">--}}
{{--                        </a>Submit request <i class="icon-material-outline-arrow-right-alt"></i></button>--}}
                </div>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
    <script>
        $(document).ready(function(){
            $(".completed-hw-table tbody").on("click", ".approve", function(e){
                e.preventDefault();

                var token = $("#token").val();
                var uuid = $(this).attr('data-code');

                const formData = {'uuid':uuid, '_token':token};

                $.ajax({
                    url: '/homeworks/solution/approve',
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

            var revisionToken = "";
            var revisionUuid = ""
            $(".completed-hw-table tbody").on("click", ".revision", function(e){
                $('#revisionModal').modal('show');
                revisionToken = $("#token").val();
                revisionUuid = $(this).attr('data-code');
            });

            $("#submitRevisionNote").click(function (e){
                e.preventDefault();
                var revisionNote = $("#intro").val();
                var percentage = $("#amount").val();

                const formData = {'uuid':revisionUuid, '_token':revisionToken,'note':revisionNote, 'percentage':percentage};


                $.ajax({
                    url: '/homeworks/solution/revision',
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

        })
    </script>
@endsection
