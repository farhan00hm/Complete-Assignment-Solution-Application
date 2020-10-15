@extends('member.template')

@section('content')
    <div class="dashboard-box main-box-in-row">
        <div class="headline">
            <h3><i class="icon-material-outline-face"></i> Profile - {{ $expert->user->first_name }} {{ $expert->user->last_name }}
                <button class="btn-success button mb-10" id="approve" style="color: #ffffff; float: right;line-height: 20px; box-shadow: none; margin-right: 5px; background-color: #218838 !important;" data-code="{{ $expert->uuid }}">
                    <i style="color: #fff;" class="icon-feather-check-circle"></i> Approve
                </button>
                <button class="btn-danger button mb-10" id="decline" style="color: #ffffff; float: right;line-height: 20px; box-shadow: none; margin-right: 5px; background-color: #dc3545 !important;" data-code="{{ $expert->uuid }}">
                    <i style="color: #fff;" class="icon-material-outline-highlight-off"></i> Decline
                </button>
                <button class="btn-info button mb-10" data-toggle="modal" data-target="#infoModal" style="color: #ffffff; float: right;line-height: 20px; box-shadow: none; margin-right: 5px; background-color: #17a2b8 !important;">
                    <i style="color: #fff;" class="icon-material-outline-info"></i> More Info
                </button>
            </h3>
        </div>

        <div class="content">
            <ul class="fields-ul">
                <li>
                    <div class="row">
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
            </ul>
        </div>



        <!-- View File Modal -->
        <div class="modal fade bd-example-modal-lg" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">File Viewer</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <span id="fileView"></span>
                    </div>
                </div>
            </div>
        </div>

        <!-- More info Modal -->
        <div class="modal fade bd-example-modal-lg" id="infoModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Ask for more information</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form method="post" id="more-info" name="more-info">
                            <div class="col-xl-12 submit-field">
                                <h5>Description</h5>
                                <textarea cols="30" rows="5" class="with-border" id="info-desc" name="info-desc"></textarea>
                                <input type="hidden" name="uuid" id="uuid">
                            </div>
                        </form>
                        <!-- Button -->
                        <button id="request" class="button button-sliding-icon ripple-effect margin-top-10" style="width: 100px;"> Request <i class="icon-material-outline-arrow-right-alt"></i></button>
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
            // Approve pending freelancers
            $("#approve").click(function(e){
                e.preventDefault();

                var token = $("#token").val();
                var uuid = $("#uuid").val();

                const formData = {'uuid':uuid, '_token':token};

                $.ajax({
                    url: '/users/freelancers/pending/approve',
                    type: 'POST',
                    data: formData,
                    datatype: 'json'
                })
                .done(function (data) {
                    if(data.success == 1){
                        success_snackbar(data.message, 3000)
                        setTimeout(function(){
                            window.location.href = "/users/freelancers/pending-approval";
                        }, 3000);
                    }else{
                        danger_snackbar(data.error, 5000)
                    }
                })
                .fail(function (jqXHR, textStatus, errorThrown) {
                    danger_snackbar('Error - ' + jqXHR.status + ': ' + jqXHR.statusText, 8000);
                });
            });

            // Decline solution expert application
            $("#decline").click(function(e){
                e.preventDefault();

                var token = $("#token").val();
                var uuid = $("#uuid").val();

                const formData = {'uuid':uuid, '_token':token};

                $.ajax({
                    url: '/users/freelancers/pending/decline',
                    type: 'POST',
                    data: formData,
                    datatype: 'json'
                })
                .done(function (data) {
                    if(data.success == 1){
                        success_snackbar(data.message, 3000)
                        setTimeout(function(){
                            window.location.href = "/users/freelancers/pending-approval";
                        }, 3000);
                    }else{
                        danger_snackbar(data.error, 5000)
                    }
                })
                .fail(function (jqXHR, textStatus, errorThrown) {
                    danger_snackbar('Error - ' + jqXHR.status + ': ' + jqXHR.statusText, 8000);
                });
            });

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

            // Ask for more infomation
            $("#request").click(function(e){
                e.preventDefault();

                var token = $("#token").val();
                var uuid = $("#uuid").val();
                var info = $("#info-desc").val();

                const formData = {'uuid':uuid, 'info':info, '_token':token};

                $.ajax({
                    url: '/users/freelancers/pending/request-info',
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
