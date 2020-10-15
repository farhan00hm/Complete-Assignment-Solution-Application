@if(Auth::user()->user_type == "Student" || Auth::user()->user_type == "Professional" )
    <ul data-submenu-title="Core">
        <li <?php if (@$link == "hwks"){ echo 'class="active"'; } ?> >
            <a href="/homeworks">
                <i class="icon-line-awesome-list-alt"></i>
                @if(Auth::user()->user_type == "Student")Homework @else Project @endif
            </a>
            <ul>
                <li>
                    <a href="/homeworks/new">@if(Auth::user()->user_type == "Student")Post Homework @else Post Project @endif</a>
                </li>
                <li>
                    <a href="/homeworks/open">Open</a>
                </li>
                <li>
                    <a href="/homeworks/ongoing">Ongoing</a>
                </li>
                <li>
                    <a href="/homeworks/completed?status=pending" title="Completed homeworks whose solutions are waiting your approval">Completed (Pending)</a>
                </li>
                <li>
                    <a href="/homeworks/completed?status=approved" title="Completed homeworks whose solutions you have accepted">Completed (Approved)</a>
                </li>
                <li>
                    <a href="/homeworks/archive" title="Your Archived homeworks">Archived</a>
                </li>
                <li>
                    <a href="/homeworks/canceled" title="Your Canceled homeworks">Canceled</a>
                </li>
            </ul>
        </li>
    </ul>
      <ul data-submenu-title="Messaging">
        <li <?php if (@$link == "messages"){ echo 'class="active"'; } ?> >
            <a href="/messages">
                <i class="icon-feather-message-square"></i> 
                Messages
            </a>
        </li>
    </ul>
    <ul data-submenu-title="Financials">
        <li <?php if (@$link == "wallet"){ echo 'class="active"'; } ?> >
            <a href="/user/financials/wallet"><i class="icon-material-outline-account-balance-wallet"></i>
                Wallet
            </a>
        </li>
        <li <?php if (@$link == "fncls"){ echo 'class="active"'; } ?> >
            <a href="/user/transactions">
                <i class="icon-line-awesome-list-alt"></i>
                Transactions
            </a>
            <ul>
                <li>
                    <a href="/user/financials/transactions">Transactions</a>
                </li>
            </ul>
        </li>
        <li <?php if (@$link == "disc"){ echo 'class="active"'; } ?> >
            <a href="/user/discount-codes"><i class="icon-feather-credit-card"></i>
                Discount Codes
            </a>
        </li>
    </ul>
    <!-- <ul data-submenu-title="Messaging">
        <li <?php if (@$link == "msngs"){ echo 'class="active"'; } ?> >
            <a href="/messages">
                <i class="icon-feather-message-square"></i>
                Messages
            </a>
        </li>
    </ul> -->
    <!-- End student and parent menu -->
@endif
