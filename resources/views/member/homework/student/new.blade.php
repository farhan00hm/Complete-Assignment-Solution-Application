@extends('member.template2')

@section('content')
	<div class="dashboard-content-container">
		<div class="dashboard-content-inner" style="padding: 30px !important;">
			<div class="row">
				<div class="col-xl-12">
					<div class="dashboard-box margin-top-0">
						<div class="headline">
							<h3>Create @if(Auth::user()->user_type == "Student")Homework @else Project @endif</h3>
						</div>

						<div class="content with-padding padding-bottom-10">
							<form method="post" id="post-homework" name="post-homework" enctype="multipart/form-data" action="/homeworks/create" method="POST">
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
								{{-- @if (count($errors) > 0)
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
			                    @endif --}}
								<div class="row">
									<div class="col-xl-6">
										<div class="submit-field">
											<h5>Title</h5>
											<input type="text" class="with-border" id="title" name="title" value="{{ old('title') }}">
										</div>
									</div>

									<div class="col-xl-6">
										<div class="submit-field">
											<h5>Budget</h5>
											<div class="input-with-icon">
												<input class="with-border" type="text" id="budget" name="budget" value="{{ old('budget') }}">
												<i class="currency">&#8358;</i>
											</div>
										</div>
									</div>
								</div>

								<div class="row">
									<div class="col-xl-6">
										<div class="submit-field">
											<h5>Level</h5>
											<select class="selectpicker with-border" data-size="7" title="Select @if(Auth::user()->user_type == "Student")homework @else project @endif level" id="level" name="level">
				                                @foreach($cats as $cat)
				                                    <option value="{{ $cat->id }}">{{ $cat->name }}</option>
				                                @endforeach
				                            </select>
										</div>
									</div>

									<div class="col-xl-6">
										<div class="submit-field">
											<h5>Expert Category</h5>
											<select id="category" name="category" style="border: 1px solid #e0e0e0; padding: 8px;">

				                            </select>
										</div>
									</div>

									<div class="col-xl-6">
										<div class="submit-field">
											<h5>Deadline</h5>
											<input type="date" class="with-border" id="deadline" name="deadline" value="{{ old('deadline') }}">
										</div>
									</div>
								</div>

								<div class="row">
									<div class="col-xl-12">
										<div class="submit-field">
											<h5>Description</h5>
											<textarea cols="30" rows="5" class="with-border" id="description" name="description" value="{{ old('description') }}">{{ old('description') }}</textarea>
											<div class="uploadButton margin-top-30">
												<input class="uploadButton-input" type="file" name="files[]" accept="image/*, application/pdf" id="upload" value="{{ old('files') }}" multiple/>
												<label class="uploadButton-button ripple-effect" for="upload">Upload Files</label>
												<span class="uploadButton-file-name">Images or documents for your homework</span>
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-xl-12">
											<button type="submit" class="button ripple-effect big margin-top-30 margin-bottom-20"><i class="icon-feather-plus"></i> Post Homework</button>
										</div>
									</div>
								</div>
							</form>
						</div>
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
	<script type="text/javascript">
		$(document).ready(function(){
            $("#level").on('change', function(){
            	var token = $("#token").val();
		        var id = $("#level").val();

		        var formData = {'id':id, '_token':token};

		        $.ajax({
		            type: 'POST',
		            url: '/categories/get-subs',
		            data: formData,
		            datatype: 'json'
		        })
		        .done(function (data) {
		            if(data.success == 1){
		            	console.log(data.subs)
		                $("#category").html(data.subs);
		            }else{
		                $("#category").html('');
		                danger_snackbar(data.message, 5000);
		            }
		        })
		        .fail(function (jqXHR, textStatus, errorThrown) {
		            danger_snackbar('Error - ' + jqXHR.status + ': ' + jqXHR.statusText, 10000);
		        });
		    });
        })

        // Restrict user inputting non-numeric value into Budget field

        // Restricts input for the given textbox to the given inputFilter.
        function setInputFilter(textbox, inputFilter) {
            ["input", "keydown", "keyup", "mousedown", "mouseup", "select", "contextmenu", "drop"].forEach(function(event) {
                textbox.addEventListener(event, function() {
                    if (inputFilter(this.value)) {
                        this.oldValue = this.value;
                        this.oldSelectionStart = this.selectionStart;
                        this.oldSelectionEnd = this.selectionEnd;
                    } else if (this.hasOwnProperty("oldValue")) {
                        this.value = this.oldValue;
                        this.setSelectionRange(this.oldSelectionStart, this.oldSelectionEnd);
                    } else {
                        this.value = "";
                    }
                });
            });
        }


        // Install input filters.
        setInputFilter(document.getElementById("budget"), function(value) {
            return /^\d*[.,]?\d{0,2}$/.test(value); });

	</script>
@endsection
