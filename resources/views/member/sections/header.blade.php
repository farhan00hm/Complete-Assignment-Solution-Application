<div id="header">
    <div class="container">
        <div class="left-side">
            <div id="logo">
                <a href="/"><img style="height: 80px; width: 80px;" src="{{ asset('images/logos/PNG-105.png') }}"
                                 data-sticky-logo="{{ asset('images/logos/PNG-105.png') }}"
                                 data-transparent-logo="{{ asset('images/logos/PNG-105.png') }}" alt=""></a>
            </div>
            <div class="clearfix"></div>
        </div>


        <div class="right-side">

           {{--  <div class="header-notifications user-menu">
                <div class="header-notifications-trigger" style="float: left; margin-right: 20px; font-size: large">
                    <a href="#">
                        <i class="icon-material-outline-notifications"></i>
                        <span class="badge badge-light">{{ auth()->user()->unreadNotifications->count() }}</span>
                    </a>
                </div>

                <!-- Notifications Dropdown -->
                <div class="header-notifications-dropdown">
                    <ul class="user-menu-small-nav">
                        @foreach(auth()->user()->unreadNotifications as $notification)
                            <li style="background-color: lightgray; margin: 5px; padding: 5px;">
                                <a href="{{ url('/') }}/mark-notification-read/{{ $notification->id }}">{{ $notification->data['hwTitle'] }}</a>
                            </li>
                        @endforeach
                        @foreach(auth()->user()->readNotifications as $notification)
                            <li>
                                <a href="{{ url('/') }}/homeworks/single/{{ $notification->data["hwUuid"] }}">{{ $notification->data['hwTitle'] }}</a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div> --}}


 


            <div class="header-notifications user-menu">
                <div class="header-notifications-trigger" style="float: left; margin-right: 20px; font-size: large">
                    <a href="#">
                        <i class="icon-material-outline-notifications"></i>
                        <span class="badge badge-light">{{ auth()->user()->unreadNotifications->count() }}</span>
                    </a>
                </div>

                <!-- Notifications Dropdown -->
                <div class="header-notifications-dropdown">
                    <ul class="user-menu-small-nav">
                        @foreach(auth()->user()->unreadNotifications as $notification)
                            <li style="background-color: lightgray; margin: 5px; padding: 5px;">
                                <a href="{{ url('/') }}/mark-notification-read/{{ $notification->id }}">{{ $notification->data['hwTitle'] }}</a>
                            </li>
                        @endforeach
                        @foreach(auth()->user()->readNotifications as $notification)
                            <li>
                                <a href="{{ url('/') }}/homeworks/single/{{ $notification->data["hwUuid"] }}">{{ $notification->data['hwTitle'] }}</a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>


            <!-- User Menu -->
            <div class="header-widget">
                <div class="header-notifications user-menu">
                    <div class="header-notifications-trigger">
                        <a href="#">
                            <div class="user-avatar status-online"><img
                                    src="{{ asset('img/user-avatar-placeholder.png') }}" alt=""></div>
                        </a>
                    </div>

                    <!-- Dropdown -->
                    <div class="header-notifications-dropdown">
                        <div class="user-status">
                            <div class="user-details">
                                <div class="user-avatar status-online"><img
                                        src="{{ asset('img/user-avatar-placeholder.png') }}" alt=""></div>
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
                            <li><a href="/logout"><i class="icon-material-outline-power-settings-new"></i> Logout</a>
                            </li>
                            {{--                            <li><a href="#"><i class="icon-material-outline-notifications"> Notification</i></a></li>--}}
                        </ul>
                    </div>
                </div>
            </div>


            <!-- Mobile Navigation Button -->
            <span class="mmenu-trigger">
                <button class="hamburger hamburger--collapse dashboard-responsive-nav-trigger">
                    <span class="hamburger-box">
                        <span class="hamburger-inner"></span>
                    </span>
                </button>
            </span>
        </div>
    </div>
</div>
