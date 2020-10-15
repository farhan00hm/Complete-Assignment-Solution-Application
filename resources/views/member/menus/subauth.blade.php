@if(Auth::user()->isAuth())
    <ul data-submenu-title="Users">
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

    <!-- End authentication subadmin menu -->
@endif
