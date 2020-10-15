@if(Auth::user()->isAdmin())
    <ul data-submenu-title="Users">
        @if(Auth::user()->user_type == "Admin")
            <li <?php if (@$link == "subs"){ echo 'class="active"'; } ?> >
                <a href="/users/subadmins"><i class="icon-feather-user-plus"></i>
                    Sub Admins
                </a>
            </li>
        @endif
        <li <?php if (@$link == "studs"){ echo 'class="active"'; } ?> >
            <a href="/users/students"><i class="icon-feather-user"></i>
                Students
            </a>
        </li>
        <li <?php if (@$link == "pnts"){ echo 'class="active"'; } ?> >
            <a href="/users/non-students"><i class="icon-feather-users"></i>
                Professional
            </a>
        </li>
        <li <?php if (@$link == "exps"){ echo 'class="active"'; } ?> >
            <a href="/users/freelancers">
                <i class="icon-feather-award"></i>
                Freelancers
            </a>
            <ul>
                <li>
                    <a href="/users/freelancers/approved">Approved</a>
                </li>
                <li>
                    <a href="/users/freelancers/pending-approval">Pending</a>
                </li>
            </ul>
        </li>
    </ul>

    <ul data-submenu-title="Financials">
        <li <?php if (@$link == "dcnt"){ echo 'class="active"'; } ?> >
            <a href="/discount-codes">
                <i class="icon-feather-credit-card"></i>
                Discount Codes
            </a>
            <ul>
                <li>
                    <a href="/discount-codes/new">New</a>
                </li>
                <li>
                    <a href="/discount-codes/active">Active</a>
                </li>
                <li>
                    <a href="/discount-codes/inactive">Inactive</a>
                </li>
            </ul>
        </li>
        <li <?php if (@$link == "comm"){ echo 'class="active"'; } ?> >
            <a href="/financials/commissions">
                <i class="icon-material-outline-input"></i>
                Commissions
            </a>
        </li>
    </ul>

    <ul data-submenu-title="Categories">
        <li <?php if (@$link == "cats"){ echo 'class="active"'; } ?> >
            <a href="/categories">
                <i class="icon-line-awesome-graduation-cap"></i>
                Expert Categories
            </a>
            <ul>
                <li>
                    <a href="/categories">Categories</a>
                </li>
                <li>
                    <a href="/categories/sub-categories">Sub Categories</a>
                </li>
            </ul>
        </li>
    </ul>

    <ul data-submenu-title="Homework">
        <li <?php if (@$link == "flhw"){ echo 'class="active"'; } ?> >
            <a href="/homeworks/flagged">
                <i class="icon-material-outline-outlined-flag"></i>
                Flagged Homework
            </a>
        </li>
    </ul>

    <!--<ul data-submenu-title="Messaging">
        <li <?php if (@$link == "msngs"){ echo 'class="active"'; } ?> >
            <a href="/messages">
                <i class="icon-feather-message-square"></i>
                Messages
            </a>
        </li>
    </ul> -->
    <!-- End admin and subadmin menu -->
@endif
