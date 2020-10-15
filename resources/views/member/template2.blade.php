<!doctype html>
<html lang="en">
<!-- This template does not include bootstrap -->
<head>
    <title>{{ $title }}</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('img/skooli_favicon.ico') }}">
    <link href="//netdna.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/css/bootstrap-select.min.css">
    <link rel="stylesheet" href="{{ asset('member/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('member/css/colors/blue.css') }}">
    <link rel="stylesheet" href="{{ asset('member/css/custom.css') }}">
    <style type="text/css">
        .bootstrap-select>.dropdown-toggle {
            height: 48px;
        }
    </style>
</head>

<body class="gray">
    <div id="wrapper">
        <header id="header-container" class="fullwidth dashboard-header not-sticky">
            @include('member.sections.header')
        </header>
        <div class="clearfix"></div>


        <!-- Dashboard Container -->
        <div class="dashboard-container">

            <!-- Dashboard Sidebar -->
            @include('member.menus.wrapper')


            <!-- Content Section -->
            <div class="dashboard-content-container" data-simplebar>
                <div class="dashboard-content-inner" id="app" style="margin-top: -25px; padding: 30px;">
                    <meta name="_token" content="{{ csrf_token() }}" /> 
                    <input type="hidden" id="token" name="_token" value="{{ csrf_token() }}">
                    @yield('content')
            
                    <!-- Footer -->
                    <div class="dashboard-footer-spacer"></div>
                        <div class="small-footer margin-top-15">
                            <div class="small-footer-copyrights">
                                © 2020 <strong>Bemexpress</strong>. All Rights Reserved. support@bemexpress.com
                            </div>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script src="{{ asset('member/js/jquery-3.3.1.min.js') }}"></script>
        @yield('bootstrap')
        <script src="{{ asset('member/js/jquery-migrate-3.0.0.min.js') }}"></script>
        <script src="{{ asset('member/js/mmenu.min.js') }}"></script>
        <script src="{{ asset('member/js/tippy.all.min.js') }}"></script>
        <script src="{{ asset('member/js/simplebar.min.js') }}"></script>
        <script src="{{ asset('member/js/bootstrap-slider.min.js') }}"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/bootstrap-select.min.js"></script>
        <script src="{{ asset('member/js/snackbar.js') }}"></script>
        <script src="{{ asset('member/js/clipboard.min.js') }}"></script>
        <script src="{{ asset('member/js/magnific-popup.min.js') }}"></script>
        <script src="{{ asset('member/js/slick.min.js') }}"></script>
        <script src="{{ asset('member/js/custom.js') }}"></script>
        <script src="{{ asset('member/js/utils.js') }}"></script>
        <script type="text/javascript">
            $(document).ready(function(){
                $('.selectpicker').selectpicker({
                });
            })
        </script>
        @yield('scripts')
    </body>
</html>