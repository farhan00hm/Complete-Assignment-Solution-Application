@extends('member.template2')

@section('content')
    <div class="dashboard-content-container">
        <div class="dashboard-content-inner" style="padding: 30px !important;">
            <div class="row">
                <div class="col-xl-12">
                    <div class="dashboard-box margin-top-0">
                        <div class="headline">
                            <h3><i class="icon-feather-folder-open"></i> Edit Homework</h3>
                        </div>

                        <div class="content with-padding padding-bottom-10">
                            <form method="post" id="edit-homework" name="edit-homework" enctype="multipart/form-data" action="/archive/homeworks/update" method="POST">
                                @csrf
                                @if ($message = Session::get('error'))
                                    <div class="row">
                                        <div class="col-xl-12">
                                            <div class="alert alert-danger alert-block">
                                                <button type="button" class="close" data-dismiss="alert">×</button>
                                                <strong>{{ $message }}</strong>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                                @if (count($errors) > 0)
                                    <div class="row">
                                        <div class="col-xl-12">
                                            <div class="alert alert-danger">
                                                <strong>Whoops!</strong> There were some problems with your input.
                                                <ul>
                                                    @foreach ($errors as $error)
                                                        <li>{{ $error }}</li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                                <div class="row">
                                    <div class="col-xl-6">
                                        <div class="submit-field">
                                            <h5>Title</h5>
                                            <input type="text" class="with-border" id="title" name="title" value="{{ old('title', $hw->title) }}">
                                        </div>
                                    </div>

                                    <div class="col-xl-6">
                                        <div class="submit-field">
                                            <h5>Expert Category</h5>
                                            <select class="selectpicker with-border" data-size="5" title="Select category" id="sub" name="sub" >
                                                <option value="{{ $hw->sub_category_id }}" selected="">{{ @$hw->subcategory->name }}</option>
                                                @foreach($subCats as $subcat)
                                                    <option value="{{ old('sub', $subcat->id) }}">{{ old('sub', $subcat->name) }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-xl-6">
                                        <div class="submit-field">
                                            <h5>Budget</h5>
                                            <div class="input-with-icon">
                                                <input class="with-border" type="text" id="budget" name="budget" value="{{ old('budget', $hw->budget) }}">
                                                <i class="currency">&#8358;</i>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-xl-6">
                                        <div class="submit-field">
                                            <h5>Deadline</h5>
                                            <input type="date" class="with-border" id="deadline" name="deadline" value="{{ old('deadline', $hw->deadline) }}">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-xl-12">
                                        <div class="submit-field">
                                            <h5>Description</h5>
                                            <textarea cols="30" rows="5" class="with-border" id="description" name="description" value="{{ old('description', $hw->description) }}">{{ old('description', $hw->description) }}</textarea>
                                            <div class="uploadButton margin-top-30">
                                                <input class="uploadButton-input" type="file" name="files[]" accept="image/*, application/pdf" id="upload" multiple/>
                                                <label class="uploadButton-button ripple-effect" for="upload">Upload Files</label>
                                                <span class="uploadButton-file-name">Images or documents for your homework</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xl-12 submit-field">
                                        <h5>Current files (<small>To remove a file from the homework, click the delete icon</small>)</h5>
                                        <table class="table table-striped hw-table">
                                            <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>View File</th>
                                                <th>Delete</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($hw->files as $hwfile)
                                                <tr>
                                                    <td>{{ $hwfile->id }}</td>
                                                    <td><a class="btn btn-info view-file" data-code="{{ $hwfile->upload_path }}" href="#" style="color: #ffffff;">View</a></td>
                                                    <td>
                                                        <a class="delete" style="color: #a62026" href="#" data-code="{{ $hwfile->uuid }}" title="Delete file from homework">
                                                            <i class="icon-feather-trash"></i>
                                                        </a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-xl-12">
                                        <input type="hidden" name="id" id="id" value="{{ $hw->id }}">
                                        <button type="submit" class="button ripple-effect big margin-top-30 margin-bottom-20">Update Homework</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <!-- Resume Modal -->
        <div class="modal fade bd-example-modal-lg" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Resume</h5>
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
            * View uploaded file
            */
            $(".hw-table tbody").on("click", ".view-file", function(e){
                e.preventDefault();
                var path = $(this).attr('data-code');

                var options = {
                    height: "500px"
                };
                PDFObject.embed(path, "#fileView", options);

                $('#exampleModal').modal('show');
            });

            // Delete homework file
            $(".hw-table tbody").on("click", ".delete", function(e){
                e.preventDefault();

                var token = $("#token").val();
                var uuid = $(this).attr('data-code');

                const formData = {'uuid':uuid, '_token':token};

                $.ajax({
                    url: '/homeworks/files/delete',
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
