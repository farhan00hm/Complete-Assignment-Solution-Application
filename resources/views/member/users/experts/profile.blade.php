@extends('member.template')

@section('content')
    <div class="dashboard-box main-box-in-row">
        <div class="headline">
            <h3><i class="icon-material-outline-face"></i> Profile -
                @if(Auth::user()->isPrivileged())
                    {{ $expert->user->first_name }} {{ $expert->user->last_name }}
                @else
                    {{ $expert->user->username }}
                @endif
            </h3>
        </div>

        <div class="content">
            <ul class="fields-ul">
                <li>
                    <div class="row">
                        @if(Auth::user()->isPrivileged())
                            <div class="col-xl-4">
                                <div class="submit-field">
                                    <h5>Name</h5>
                                    <p>{{ $expert->user->first_name }} {{ $expert->user->last_name }}</p>
                                </div>
                            </div>

                            <div class="col-xl-4">
                                <div class="submit-field">
                                    <h5>Email</h5>
                                    <p>{{ $expert->user->email }}</p>
                                </div>
                            </div>
                        @endif

                        <div class="col-xl-4">
                            <div class="submit-field">
                                <h5>School</h5>
                                <p>{{ $expert->user->school }}</p>
                            </div>
                        </div>

                        <div class="col-xl-4">
                            <div class="submit-field">
                                <h5>Qualification</h5>
                                <p>{{ $expert->qualification }}</p>
                            </div>
                        </div>
                    </div>
                </li>
                <li>
                    <div class="row">
                        <div class="col-xl-12">
                            <div class="submit-field">
                                <h5>Areas of Expertise</h5>
                                <div class="keywords-container">
                                    <div class="keywords-list">
                                        @foreach($expert->subjects as $subject)
                                            <span class="keyword"><span>&nbsp;&nbsp;</span><span class="keyword-text">{{ $subject->name }}</span></span>
                                        @endforeach
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </li>

                <li>
                    <div class="row">
                        <div class="col-xl-12">
                            <div class="submit-field">
                                <h5>Attachments</h5>
                                <div class="attachments-container margin-top-0 margin-bottom-0">
                                    <?php $i = 1; ?>
                                    @if($expert->files->count() == 0)
                                        <p>No files uploaded alongside this application.</p>
                                    @else
                                        @foreach($expert->files as $expf)
                                            <div class="attachment-box ripple-effect">
                                                <span>File {{ $i }}</span>
                                                <i>PDF</i>
                                                <span>
                                                    <a class="btn btn-info view-file" data-code="{{ $expf->upload_path }}" href="#" style="color: #ffffff;">View</a>
                                                </span>
                                            </div>
                                            <?php $i += 1; ?>
                                        @endforeach
                                    @endif
                                </div>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                    </div>
                </li>
                <li>
                    <div class="row">
                        <div class="col-xl-12">
                            <div class="submit-field">
                                <h5>Brief Introduction</h5>
                                {{ $expert->description }}
                                <input type="hidden" name="id" id="id" value="{{ $expert->id }}">
                                <input type="hidden" name="uuid" id="uuid" value="{{ $expert->uuid }}">
                            </div>
                        </div>
                    </div>
                </li>

                <li>
                    <div class="row">
                        <div class="col-xl-12">
                            <div class="submit-field">
                                <h3>Ratings and Reviews</h3>
                                @foreach($expert->user->reviewee as $review)
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

                @if(Auth::user()->isPrivileged())
                    <h3 style="margin-top: 20px; margin-left: 20px;">Transactions</h3>
                    <li style="padding: 3px;">
                        <div class="contentdashboard-box main-box-in-row table-responsive" style="overflow-x:auto; padding: 2px;">
                            @if($trxs->count() < 1)
                                <div class="row">
                                    <div class="col-md-12">
                                        <p style="padding: 20px;">Solution expert has no recent transactions.</p>
                                    </div>
                                </div>
                            @else
                                <div class="contentdashboard-box main-box-in-row table-responsive" style="overflow-x:auto; min-height: 400px;">
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

            </ul>
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
            /*
            * View expert files
            */
            $(".fields-ul li").on("click", ".view-file", function(e){
                e.preventDefault();

                var path = $(this).attr('data-code');

                var options = {
                    height: "500px"
                };
                PDFObject.embed(path, "#fileView", options);

                $('#exampleModal').modal('show');
            });
        })
    </script>
@endsection
