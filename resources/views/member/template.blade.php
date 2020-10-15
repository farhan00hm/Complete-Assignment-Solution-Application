<!doctype html>
<html lang="en">
<head>
    <title>{{ $title }}</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    @yield('sockets')
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('img/skooli_favicon.ico') }}">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('member/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('member/css/colors/blue.css') }}">
    <link rel="stylesheet" href="{{ asset('member/css/custom.css') }}">

 <style type="text/css">
     
     fieldset {
      overflow: hidden
    }
    
    .some-class {
      float: left;
      clear: none;
    }
    
    label {
      float: left;
      clear: none;
      display: block;
      padding: 0px 1em 0px 8px;
    }
    
    input[type=radio],
    input.radio {
      float: left;
      clear: none;
      margin: 2px 0 0 2px;
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

            <!-- Sidebar/Main menu -->
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