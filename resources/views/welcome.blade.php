<!doctype html>
<html lang="en">
<head>

    <!-- Basic Page Needs
    ================================================== -->
    <title>Bemexpress | Get Professional Homework Help</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

    <!-- CSS
    ================================================== -->
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('img/skooli_favicon.ico') }}">
    <link rel="stylesheet" href="{{ asset('member/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('member/css/colors/blue.css') }}">

</head>
<body>

<!-- Wrapper -->
<div id="wrapper" class="wrapper-with-transparent-header">

    <header id="header-container" class="fullwidth">
        @include('sections.header')
    </header>
    <div class="clearfix"></div>
    <!-- Header Container / End -->


    <!-- Intro Banner
    ================================================== -->
<!--<div class="intro-banner dark-overlay" data-background-image="{{ asset('images/home-background-02.jpg') }}">-->
    <div class="intro-banner dark-overlay" data-background-image="{{ asset('images/Canva_hero.jpg') }}">

        <!-- Transparent Header Spacer -->
        <div class="transparent-header-spacer"></div>

        <div class="container">

            <!-- Intro Headline -->
            <div class="row">
                <div class="col-md-12">
                    <div class="banner-headline">
                        <h3>
                            <strong>Need help with your homework?</strong>
                            <br>
                            <span>Join a huge community of curated freelancers ready help you come up with your homework solutions.</span>
                        </h3>
                    </div>
                </div>
            </div>

            <!-- Search Bar -->
            <div class="row">
                <div class="col-md-12">
                    <div class="margin-top-95">
                        @if(Auth::check())
                            <a href="/dashboard" class="button button-sliding-icon ripple-effect big margin-top-20">Go
                                to Dashboard <i class="icon-material-outline-arrow-right-alt"></i></a>
                        @else
                            <a href="/register" class="button button-sliding-icon ripple-effect big margin-top-20">Get
                                Started <i class="icon-material-outline-arrow-right-alt"></i></a>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Stats -->
            <div class="row">
                <div class="col-md-12">
                    <ul class="intro-stats margin-top-45 hide-under-992px">
                        <li>
                            <strong class="counter">1,586</strong>
                            <span>Homework Posted</span>
                        </li>
                        <li>
                            <strong class="counter">1,232</strong>
                            <span>Freelancers</span>
                        </li>
                        <li>
                            <strong class="counter">7,300,543</strong>
                            <span>Spent</span>
                        </li>
                    </ul>
                </div>
            </div>

        </div>
    </div>


    <!-- Content
    ================================================== -->

    <!-- Popular Job Categories -->
    <!--<div class="section margin-top-65 margin-bottom-30">
        <div class="container">
            <div class="row">
                <div class="col-xl-12">
                    <div class="section-headline centered margin-top-0 margin-bottom-45">
                        <h3>Popular Categories</h3>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6">
                    <a href="jobs-list-layout-1.html" class="photo-box small" data-background-image="images/job-category-01.jpg">
                        <div class="photo-box-content">
                            <h3>Web / Software Dev</h3>
                            <span>612</span>
                        </div>
                    </a>
                </div>

                <div class="col-xl-3 col-md-6">
                    <a href="jobs-list-layout-full-page-map.html" class="photo-box small" data-background-image="images/job-category-02.jpg">
                        <div class="photo-box-content">
                            <h3>Data Science / Analitycs</h3>
                            <span>113</span>
                        </div>
                    </a>
                </div>

                <div class="col-xl-3 col-md-6">
                    <a href="jobs-grid-layout-full-page.html" class="photo-box small" data-background-image="images/job-category-03.jpg">
                        <div class="photo-box-content">
                            <h3>Accounting / Consulting</h3>
                            <span>186</span>
                        </div>
                    </a>
                </div>

                <div class="col-xl-3 col-md-6">
                    <a href="jobs-list-layout-2.html" class="photo-box small" data-background-image="images/job-category-04.jpg">
                        <div class="photo-box-content">
                            <h3>Writing & Translations</h3>
                            <span>298</span>
                        </div>
                    </a>
                </div>

                <div class="col-xl-3 col-md-6">
                    <a href="jobs-list-layout-1.html" class="photo-box small" data-background-image="images/job-category-05.jpg">
                        <div class="photo-box-content">
                            <h3>Sales & Marketing</h3>
                            <span>549</span>
                        </div>
                    </a>
                </div>

                <div class="col-xl-3 col-md-6">
                    <a href="jobs-list-layout-full-page-map.html" class="photo-box small" data-background-image="images/job-category-06.jpg">
                        <div class="photo-box-content">
                            <h3>Graphics & Design</h3>
                            <span>873</span>
                        </div>
                    </a>
                </div>

                <div class="col-xl-3 col-md-6">
                    <a href="jobs-grid-layout-full-page.html" class="photo-box small" data-background-image="images/job-category-07.jpg">
                        <div class="photo-box-content">
                            <h3>Digital Marketing</h3>
                            <span>125</span>
                        </div>
                    </a>
                </div>

                <div class="col-xl-3 col-md-6">
                    <a href="jobs-list-layout-2.html" class="photo-box small" data-background-image="images/job-category-08.jpg">
                        <div class="photo-box-content">
                            <h3>Education & Training</h3>
                            <span>445</span>
                        </div>
                    </a>
                </div>

            </div>
        </div>
    </div> -->
    <!-- Features Cities / End -->


    <!-- Features Jobs -->
    <div class="section gray margin-top-45 padding-top-65 padding-bottom-75">
        <div class="container">
            <div class="row">
                <div class="col-xl-12">

                    <!-- Section Headline -->
                    <div class="section-headline margin-top-0 margin-bottom-35">
                        <h3>Featured Homework</h3>
                        @if(@Auth::user()->user_type == "FL")
                            <a href="/freelancer/homeworks/open" class="headline-link">Browse All Homework</a>
                        @endif
                    </div>
                    <div class="tasks-list-container compact-list margin-top-35">
                        @foreach($homeworks->take(5) as $homework)
                            @if(@Auth::user()->user_type == "FL")
                                <a href="/homeworks/single/{{ $homework->uuid }}" class="task-listing">
                                    @else
                                        <a href="#" class="task-listing">
                                            @endif
                                            <div class="task-listing-details">
                                                <div class="task-listing-description">
                                                    <h3 class="task-listing-title">{{ $homework->title }}</h3>
                                                    <ul class="task-icons">
                                                        <li><i class="icon-feather-calendar"></i>
                                                            Posted: {{ $homework->updated_at->diffForHumans() }}</li>
                                                        <li><i class="icon-material-outline-access-time"></i>
                                                            Deadline: {{ \Carbon\Carbon::parse($homework->deadline)->isoFormat('MMM Do') }}
                                                        </li>
                                                    </ul>
                                                    <div class="task-tags margin-top-15">
                                                        <span>{{ @$homework->subcategory->name }}</span>
                                                    </div>
                                                </div>

                                            </div>

                                            <div class="task-listing-bid">
                                                <div class="task-listing-bid-inner">
                                                    <div class="task-offers">
                                                        <strong>{{ $homework->budget }}</strong>
                                                        <span>Budget</span>
                                                    </div>
                                                    @if(@Auth::user()->user_type == "FL")
                                                        <span
                                                            class="button button-sliding-icon ripple-effect">Bid Now <i
                                                                class="icon-material-outline-arrow-right-alt"></i></span>
                                                    @endif
                                                </div>
                                            </div>
                                        </a>
                                @endforeach
                    </div>

                </div>
            </div>
        </div>
    </div>
    <!-- Featured Jobs / End -->


    <!-- Counters -->
    <div class="section padding-top-70 padding-bottom-75">
        <div class="container">
            <div class="row">

                <div class="col-xl-12">
                    <div class="counters-container">

                        <!-- Counter -->
                        <div class="single-counter">
                            <i class="icon-line-awesome-suitcase"></i>
                            <div class="counter-inner">
                                <h3><span class="counter">1,586</span></h3>
                                <span class="counter-title">Homework Posted</span>
                            </div>
                        </div>

                        <!-- Counter -->
                        <div class="single-counter">
                            <i>&#8358;</i>
                            <div class="counter-inner">
                                <h3><span class="counter">7,300,543</span></h3>
                                <span class="counter-title">Spent</span>
                            </div>
                        </div>

                        <!-- Counter -->
                        <div class="single-counter">
                            <i class="icon-line-awesome-user"></i>
                            <div class="counter-inner">
                                <h3><span class="counter">2,413</span></h3>
                                <span class="counter-title">Freelancers</span>
                            </div>
                        </div>

                        <!-- Counter -->
                        <div class="single-counter">
                            <i class="icon-line-awesome-trophy"></i>
                            <div class="counter-inner">
                                <h3><span class="counter">99</span>%</h3>
                                <span class="counter-title">Satisfaction Rate</span>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Counters / End -->


    <!-- Footer
    ================================================== -->
    @include('member.sections.footer')

</div>
<!-- Wrapper / End -->


<!-- Scripts
================================================== -->
<script src="{{ asset('member/js/jquery-3.3.1.min.js') }}"></script>
<script src="{{ asset('member/js/jquery-migrate-3.0.0.min.js') }}"></script>
<script src="{{ asset('member/js/mmenu.min.js') }}"></script>
<script src="{{ asset('member/js/tippy.all.min.js') }}"></script>
<script src="{{ asset('member/js/simplebar.min.js') }}"></script>
<script src="{{ asset('member/js/bootstrap-slider.min.js') }}"></script>
<script src="{{ asset('member/js/bootstrap-select.min.js') }}"></script>
<script src="{{ asset('member/js/snackbar.js') }}"></script>
<script src="{{ asset('member/js/clipboard.min.js') }}"></script>
<script src="{{ asset('member/js/counterup.min.js') }}"></script>
<script src="{{ asset('member/js/magnific-popup.min.js') }}"></script>
<script src="{{ asset('member/js/slick.min.js') }}"></script>
<script src="{{ asset('member/js/custom.js') }}"></script>

{{--Add tidio chatbot--}}
<script src="//code.tidio.co/ubbmmwgj1nsksvwkhkx7to6zmfhbjop2.js" async></script>

</body>
</html>
