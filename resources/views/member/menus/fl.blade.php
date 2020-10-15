@if(Auth::user()->user_type == "FL" )
    <!--  These menus should only be available if the FL profile is approved -->
    @if(Auth::user()->expert->approved == 1 and Auth::user()->email_verified_at != null)
        <ul data-submenu-title="Core">
            <li <?php if (@$link == "hwks"){ echo 'class="active"'; } ?> >
                <a href="/homeworks">
                    <i class="icon-line-awesome-list-alt"></i>
                    Homework
                </a>
                <ul>
                    <li>
                        <a href="/freelancer/homeworks/open">Open</a>
                    </li>
                    <li>
                        <a href="/freelancer/homeworks/ongoing">Ongoing</a>
                    </li>
                    <li>
                        <a href="/freelancer/homeworks/completed">Completed</a>
                    </li>
                </ul>
            </li>
            <li <?php if (@$link == "bids"){ echo 'class="active"'; } ?> >
                <a href="/bids">
                    <i class="icon-line-awesome-trophy"></i>
                    Bids
                </a>
                <ul>
                    <li>
                        <a href="/bids/open">Open</a>
                    </li>
                    <li>
                        <a href="/bids/counter-offers">Counter Bids</a>
                    </li>
                    <li>
                        <a href="/bids/declined">Declined</a>
                    </li>
                </ul>
            </li>
            <li <?php if (@$link == "trx"){ echo 'class="active"'; } ?> >
                <a href="/freelancer/financials/transactions"><i class="icon-line-awesome-credit-card"></i>
                    Transactions
                </a>
            </li>
        </ul>
    @endif
    <!--<ul data-submenu-title="Messaging">
        <li <?php if (@$link == "msngs"){ echo 'class="active"'; } ?> >
            <a href="/messages">
                <i class="icon-feather-message-square"></i>
                Messages
            </a>
        </li>
    </ul> -->
    <!-- End expert menu -->
@endif
