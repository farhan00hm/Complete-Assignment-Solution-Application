@extends('pdfs.template')

@section('styles')
	<link rel="stylesheet" href="{{ asset('css/invoice.css') }}">
@endsection

@section('content')
	<div class="container">
		<div id="invoice">

			<div class="row" id="top">
				<div class="col-xl-6">
					<div id="inv-logo">
						<img src="{{ asset('images/logos/PNG-105.png') }}" alt="BemexpressNG logo">
					</div>
				</div>

				<div class="col-xl-6">	

					<p id="details">
						No. <strong><?php echo date('Y-m'); ?></strong> /{{ $paymentId }} <br>
						<strong><?php echo date('Y-m-d'); ?></strong> <br>
						<strong>Status: </strong> Paid
					</p>
				</div>
			</div>


			<!-- Client & Supplier -->
			<div class="row">
				<div class="col-xl-12">
					<h2>Weekly Payment</h2>
				</div>

				<div class="col-xl-6">	
					<strong class="margin-bottom-5">BemexpressNG</strong>
					<p>
						BemexpressNG<br>
						130 - 90402 <br>
						Lagos, Nigeria. <br>
					</p>
				</div>

				<div class="col-xl-6" style="text-align: right;">	
					<strong class="margin-bottom-5">{{ $user->first_name }} {{ $user->last_name }}</strong>
					<p>
						{{ $user->email }} <br>
						{{ $user->expert->bank_name }} <br>
						{{ $user->expert->account_number }} <br>
					</p>
				</div>
			</div>


			<!-- Invoice -->
			<div class="row">
				<div class="col-xl-12">
					<table class="margin-top-20">
						<tr>
							<th>Description</th>
							<th>Amount (&#8358;)</th>
							<th>Tax (&#8358;)</th>
							<th>Total (&#8358;)</th>
						</tr>
						<tr>
							<td>Weekly solution expert payment</td> 
							<td>{{ $walletBalance }}</td>
							<td>0.00</td>
							<td>{{ $walletBalance }}</td>
						</tr>
						
					</table>
				</div>
				
				<div class="col-xl-4 col-md-offset-8">	
					<table id="totals">
						<tr>
							<th><span>&#8358; {{ $walletBalance }}</span></th>
						</tr>
					</table>
				</div>
			</div>


			<!-- Footer -->
			<div class="row">
				<div class="col-xl-12">
					<ul id="inv-footer">
						<li>
							<a href="#" onclick="printInvoice()">Print Receipt</a>
						</li>
						<li><span>BemexpressNG</span></li>
						<li>info@bemexpress.com</li>
						<li>www.bemexpress.com</li>
					</ul>
				</div>
			</div>
				
		</div>
	</div>
@endsection

@section('scripts')
	<script src="{{ asset('js/jQuery.print.min.js') }}"></script>
	<script type="text/javascript">
		function printInvoice() {
			$("#invoice").print({
	        	globalStyles: true,
	        	mediaPrint: false,
	        	stylesheet: null,
	        	noPrintSelector: ".no-print",
	        	iframe: true,
	        	append: null,
	        	prepend: null,
	        	manuallyCopyFormValues: true,
	        	deferred: $.Deferred(),
	        	timeout: 250,
	        	title: null,
	        	doctype: '<!doctype html>'
			});
		}
	</script>
@endSection
