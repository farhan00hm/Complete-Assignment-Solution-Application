<!doctype html>
<html lang="en">
<head>
	<title class="no-print">Invoice</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<link rel="icon" type="image/png" sizes="32x32" href="{{ asset('img/Bemexpress_favicon.ico') }}">
	<link href="//netdna.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
	<link rel="stylesheet" href="{{ asset('member/css/style.css') }}">
	<link rel="stylesheet" href="{{ asset('member/css/colors/blue.css') }}">
	<link rel="stylesheet" href="{{ asset('member/css/custom.css') }}">
	@yield('styles')
</head>
<body class="gray">
	<div id="wrapper">
		<header id="header-container" class="fullwidth">
		    @include('sections.header')
		</header>

		<div class="clearfix"></div>
		
		<div class="margin-top-70"></div>
		<div id="app">
			<meta name="csrf-token" content="{{ csrf_token() }}">
			<input type="hidden" id="token" name="_token" value="{{ csrf_token() }}">
			@yield('content')
		</div>
		<div class="margin-top-70"></div>

		@include('member.sections.footer')

	</div>
	<script src="{{ asset('member/js/jquery-3.3.1.min.js') }}"></script>
	<script src="{{ asset('member/js/popper.min.js') }}"></script>
	@yield('scripts')
</body>
</html>