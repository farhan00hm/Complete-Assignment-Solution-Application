<div id="header">
    <div class="container">
        <div class="left-side">
            <div id="logo">
                <a href="/"><img style="height: 100px; width: 100px;" src="{{ asset('images/logos/PNG-105.png') }}" data-sticky-logo="{{ asset('images/logos/PNG-105.png') }}" data-transparent-logo="{{ asset('images/logos/PNG-105.png') }}" alt=""></a>
            </div>
            @if(!Auth::check())
            <nav id="navigation" style="float: right;">
                <ul id="responsive">
                    <li>
                        <a style="padding: 0 10px !important; line-height: 50px;" href="/">
                            Home
                        </a>
                    </li>
                    <li>
                        <a style="padding: 0 10px !important; line-height: 50px;" href="/pages/how-it-works">
                            How it Works
                        </a>
                    </li>
                    <li>
                        <a style="padding: 0 10px !important; line-height: 50px;" href="/pages/contact-us">
                            Contact Us
                        </a>
                    </li>
                    <li>
                        <a style="padding: 0 10px !important; line-height: 50px;" href="/pages/about">
                            About
                        </a>
                    </li>
                    <li>
                        <a style="padding: 0 10px !important; line-height: 50px;" href="/login">
                            Login
                        </a>
                    </li>

                    <li>
                        <button class="button full-width button-sliding-icon ripple-effect" type="submit">
                            <a style="color: #fff; padding: 0 !important; width: 200px !important;" href="/freelancer/apply">Become a Freelancer</a>
                        </button>
                    </li>
                </ul>
            </nav>
            @endif
            <div class="clearfix"></div>
        </div>
        <div class="right-side">
            @if(Auth::check())
                <nav id="navigation">
                    <ul id="responsive">
                        <li>
                            <a style="padding: 0 10px !important; line-height: 50px;" href="/pages/how-it-works">
                                How it Works
                            </a>
                        </li>
                        <li>
                            <a style="padding: 0 10px !important; line-height: 50px;" href="/pages/contact-us">
                                Contact Us
                            </a>
                        </li>
                        <li>
                            <a style="padding: 0 10px !important; line-height: 50px;" href="/pages/about">
                                About
                            </a>
                        </li>
                    </ul>
                </nav>

                <!-- User Menu -->
                <div class="header-widget">
                    <div class="header-notifications user-menu">
                        <div class="header-notifications-trigger">
                            <a href="#"><div class="user-avatar status-online"><img src="{{ asset('img/user-avatar-placeholder.png') }}" alt=""></div></a>
                        </div>

                        <!-- Dropdown -->
                        <div class="header-notifications-dropdown">
                            <div class="user-status">
                                <div class="user-details">
                                    <div class="user-avatar status-online"><img src="{{ asset('img/user-avatar-placeholder.png') }}" alt=""></div>
                                    <div class="user-name">
                                        @if(Auth::user()->isPrivileged())
                                            {{ @Auth::user()->email }}
                                        @else
                                            {{ @Auth::user()->first_name }} {{ @Auth::user()->last_name }}
                                        @endif
                                        <span>{{ @Auth::user()->user_type }}</span>
                                    </div>
                                </div>
                            </div>

                            <ul class="user-menu-small-nav">
                                <li><a href="/dashboard"><i class="icon-material-outline-dashboard"></i> Dashboard</a></li>
                                <li><a href="/settings"><i class="icon-material-outline-settings"></i> Settings</a></li>
                                <li><a href="/logout"><i class="icon-material-outline-power-settings-new"></i> Logout</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Mobile Navigation Button -->
            <span class="mmenu-trigger">
                <button class="hamburger hamburger--collapse" type="button">
                    <span class="hamburger-box">
                        <span class="hamburger-inner"></span>
                    </span>
                </button>
            </span>
        </div>
    </div>
</div>
