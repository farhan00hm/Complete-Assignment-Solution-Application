@extends('auth.template')

@section('styles')
    <style type="text/css">
        .icon-box-circle {
    		background-color: #fbfbfb;
        }
    </style>
@endsection

@section('content')
	<div class="container">
		<div class="row">
			<div class="col-xl-12">
				<div class="section-headline centered margin-top-0 margin-bottom-5">
					<h3>For Students and Professionals</h3>
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-xl-4 col-md-4">
				<div class="icon-box with-line">
					<div class="icon-box-circle">
						<div class="icon-box-circle-inner">
							<i class="icon-line-awesome-lock"></i>
							<div class="icon-box-check"><i class="icon-material-outline-check"></i></div>
						</div>
					</div>
					<h3>Create an Account</h3>
					<p>
						Create a free account with your email address and password
					</p>
				</div>
			</div>

			<div class="col-xl-4 col-md-4">
				<div class="icon-box with-line">
					<div class="icon-box-circle">
						<div class="icon-box-circle-inner">
							<i class="icon-feather-user-check"></i>
							<div class="icon-box-check"><i class="icon-material-outline-check"></i></div>
						</div>
					</div>
					<h3>Update your Profile</h3>
					<p>
						Once you have created an account, fill in your profile details (name, school) and your level of study.
					</p>
				</div>
			</div>

			<div class="col-xl-4 col-md-4">
				<div class="icon-box">
					<div class="icon-box-circle">
						<div class="icon-box-circle-inner">
							<i class="icon-material-outline-folder"></i>
							<div class="icon-box-check"><i class="icon-material-outline-check"></i></div>
						</div>
					</div>
					<h3>Post a Homework</h3>
					<p>
						You can post a homework problem and wait for freelancers to bid.
					</p>
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-xl-4 col-md-4">
				<div class="icon-box with-line">
					<div class="icon-box-circle">
						<div class="icon-box-circle-inner">
							<i class="icon-material-outline-account-balance-wallet"></i>
							<div class="icon-box-check"><i class="icon-material-outline-check"></i></div>
						</div>
					</div>
					<h3>Topup your Wallet</h3>
					<p>
						Add cash to your wallet ready to accept winning bids
					</p>
				</div>
			</div>

			<div class="col-xl-4 col-md-4">
				<div class="icon-box with-line">
					<div class="icon-box-circle">
						<div class="icon-box-circle-inner">
							<i class="icon-line-awesome-trophy"></i>
							<div class="icon-box-check"><i class="icon-material-outline-check"></i></div>
						</div>
					</div>
					<h3>Choose the Winning Bid</h3>
					<p>Go through the bids to choose the winning bid. You can as well send counter offers to bidders</p>
				</div>
			</div>

			<div class="col-xl-4 col-md-4">
				<div class="icon-box">
					<div class="icon-box-circle">
						<div class="icon-box-circle-inner">
							<i class="icon-feather-download-cloud"></i>
							<div class="icon-box-check"><i class="icon-material-outline-check"></i></div>
						</div>
					</div>
					<h3>Accept Solution</h3>
					<p>Once the solution expert is done with the problem, you can view the uploaded files and accept the homework solution or request for revisions.</p>
				</div>
			</div>
		</div>

		<div class="clearfix margin-top-50"></div>

		<div class="row">
			<div class="col-xl-12">
				<div class="section-headline centered margin-top-50 margin-bottom-5">
					<h3>For Freelancers</h3>
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-xl-4 col-md-4">
				<div class="icon-box with-line">
					<div class="icon-box-circle">
						<div class="icon-box-circle-inner">
							<i class="icon-line-awesome-lock"></i>
							<div class="icon-box-check"><i class="icon-material-outline-check"></i></div>
						</div>
					</div>
					<h3>Apply for a Freelancer Account</h3>
					<p>
						Fill in an application form with your profile details, qualifications in your area of expertise.
					</p>
				</div>
			</div>

			<div class="col-xl-4 col-md-4">
				<div class="icon-box with-line">
					<div class="icon-box-circle">
						<div class="icon-box-circle-inner">
							<i class="icon-feather-user-check"></i>
							<div class="icon-box-check"><i class="icon-material-outline-check"></i></div>
						</div>
					</div>
					<h3>Get Admin Approval</h3>
					<p>
						Once you have submited an application, the admin will review your details for approval. You will get an email with approval status.
					</p>
				</div>
			</div>

			<div class="col-xl-4 col-md-4">
				<div class="icon-box">
					<div class="icon-box-circle">
						<div class="icon-box-circle-inner">
							<i class="icon-material-outline-folder"></i>
							<div class="icon-box-check"><i class="icon-material-outline-check"></i></div>
						</div>
					</div>
					<h3>Bid for Homework</h3>
					<p>
						Once you have been approved, you can now bid for homeworks in your area of expertise as well as accept counter offers.
					</p>
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-xl-4 col-md-4">
				<div class="icon-box with-line">
					<div class="icon-box-circle">
						<div class="icon-box-circle-inner">
							<i class="icon-line-awesome-trophy"></i>
							<div class="icon-box-check"><i class="icon-material-outline-check"></i></div>
						</div>
					</div>
					<h3>Get Hired</h3>
					<p>
						If your bid is successful, the student will select you to work on the homework problem.
					</p>
				</div>
			</div>

			<div class="col-xl-4 col-md-4">
				<div class="icon-box with-line">
					<div class="icon-box-circle">
						<div class="icon-box-circle-inner">
							<i class="icon-feather-download-cloud"></i>
							<div class="icon-box-check"><i class="icon-material-outline-check"></i></div>
						</div>
					</div>
					<h3>Submit Solution</h3>
					<p>Once you are done with the problem, you can submit solution files for student review.</p>
				</div>
			</div>

			<div class="col-xl-4 col-md-4">
				<div class="icon-box">
					<div class="icon-box-circle">
						<div class="icon-box-circle-inner">
							<i class="icon-material-outline-account-balance-wallet"></i>
							<div class="icon-box-check"><i class="icon-material-outline-check"></i></div>
						</div>
					</div>
					<h3>Get Paid</h3>
					<p>
						On successful submision, you wallet will be credited with the bid amount.
					</p>
				</div>
			</div>
		</div>



	</div>

@endsection
