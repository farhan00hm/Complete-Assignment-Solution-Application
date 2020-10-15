@extends('member.template')

@section('content')
	<div class="dashboard-content-container">
		<div class="dashboard-content-inner" style="padding: 30px !important;">
			<div class="row">
				<div class="col-xl-12">
					<div class="dashboard-box margin-top-0">
						<div class="headline">
							<h3>Submit Homework Solutions</h3>
						</div>

						<div class="content with-padding padding-bottom-10">
							<form method="post" id="submit-homework" name="submit-homework" enctype="multipart/form-data" action="/homeworks/submit" method="POST">
								@csrf
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
											<input type="text" class="with-border" id="title" name="title" value="{{ old('title', @$hw->title) }}" readonly>
										</div>
									</div>

									<div class="col-xl-6">
										<div class="submit-field">
											<h5>Amount</h5>
											<div class="input-with-icon">
												<input type="text" class="with-border" id="amount" name="amount" value="{{ old('amount', @$hw->winning_bid_amount) }}" readonly>
												<i class="currency">&#8358;</i>
											</div>
										</div>
									</div>
								</div>

								<div class="row">
									<div class="col-xl-6">
										<div class="submit-field">
											<h5>Deadline</h5>
											<input type="date" class="with-border" id="deadline" name="deadline" value="{{ old('deadline', @$hw->deadline) }}" readonly>
										</div>
									</div>
									<div class="col-xl-6">
										<div class="submit-field">
											<h5>Hired On</h5>
											<input type="date" class="with-border" id="hired" name="hired" value="{{ old('hired', @$hw->hired_on) }}" readonly>
											<input type="hidden" name="id" id="id" value="{{ @$hw->id }}">
										</div>
									</div>
								</div>
						<div class="row">
                                 
                            
                              <p>Refund Option:</p>
                             <fieldset>
                                  <div class="some-class">
                                    <input type="radio" class="radio" name="refund" value="0" id="r1" />
                                    <label for="y">Full Refund</label>
                                    <input type="radio" class="radio" name="refund" value="1" id="r2" />
                                    <label for="z">Partial Refund</label>
                                  </div>

                                 <div class="text">
                                    <p> Write percent (%) of acceptness
                                        <input type="number" name="acceptness" id="text1" maxlength="30">
                                    </p>
                                </div>
                                </fieldset>

                                {{-- <input type="submit" value="Submit"> --}}
                         

                        </div>
								

								<div class="row">
									<div class="col-xl-12">
										<div class="submit-field">
											<h5>Submission Notes </h5>
											<textarea cols="30" rows="5" class="with-border" id="notes" name="notes" value="{{ old('notes') }}">{{ old('notes') }}</textarea>
											<div class="uploadButton margin-top-30">
												<input class="uploadButton-input" type="file" name="files[]" accept="image/*, application/pdf" id="upload" value="{{ old('files') }}" multiple/>
												<label class="uploadButton-button ripple-effect" for="upload">Upload Files</label>
												<span class="uploadButton-file-name">Images or documents for the homework solutions</span>
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-xl-12">
											<button type="submit" class="button ripple-effect big margin-top-30 margin-bottom-20"><i class="icon-line-awesome-rocket"></i> Submit Homework Solutions</button>
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



@section('scripts')


 <script>
        $(document).ready(function () {
            $(".text").hide();
            $("#r1").click(function () {
                $(".text").hide();
            });
            $("#r2").click(function () {
                $(".text").show();
            });
        });
    </script>

@endsection    