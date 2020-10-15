<!doctype html>
<html lang="en">
<!-- This template does not include bootstrap -->
<head>
    <title>{{ $title }}</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('img/skooli_favicon.ico') }}">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('member/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('member/css/colors/blue.css') }}">
    <link rel="stylesheet" href="{{ asset('member/css/custom.css') }}">
    @yiel('styles')
</head>

<body class="gray">
    <div id="wrapper">
        <header id="header-container" class="fullwidth dashboard-header not-sticky">
            @include('member.sections.header')
        </header>
        <div class="clearfix"></div>


        <!-- Dashboard Container -->
        <div class="dashboard-container">

            <!-- Content Section -->
            <div class="dashboard-content-container" data-simplebar>
                <div class="dashboard-content-inner" id="app" style="margin-top: -25px; padding: 30px;">
                    <meta name="_token" content="{{ csrf_token() }}" /> 
                    <input type="hidden" id="token" name="_token" value="{{ csrf_token() }}">
                    @yield('content')
                </div>

                @include('member.sections.footer')
            </div>
        </div>

        <script src="{{ asset('member/js/jquery-3.3.1.min.js') }}"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
        @yield('bootstrap')
        <script src="{{ asset('member/js/jquery-migrate-3.0.0.min.js') }}"></script>
        <script src="{{ asset('member/js/mmenu.min.js') }}"></script>
        <script src="{{ asset('member/js/tippy.all.min.js') }}"></script>
        <script src="{{ asset('member/js/simplebar.min.js') }}"></script>
        <script src="{{ asset('member/js/bootstrap-slider.min.js') }}"></script>
        <script src="{{ asset('member/js/bootstrap-select.min.js') }}"></script>
        <script src="{{ asset('member/js/snackbar.js') }}"></script>
        <script src="{{ asset('member/js/clipboard.min.js') }}"></script>
        <script src="{{ asset('member/js/magnific-popup.min.js') }}"></script>
        <script src="{{ asset('member/js/slick.min.js') }}"></script>
        <script src="{{ asset('member/js/custom.js') }}"></script>
        <script src="{{ asset('member/js/utils.js') }}"></script>
        @yield('scripts')
    </body>
</html>