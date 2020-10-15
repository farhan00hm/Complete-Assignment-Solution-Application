@if(Auth::user()->isP())
    <ul data-submenu-title="Users">
        <li <?php if (@$link == "studs"){ echo 'class="active"'; } ?> >
            <a href="/users/students"><i class="icon-feather-user"></i> 
                Students
            </a>
        </li>
        <li <?php if (@$link == "pnts"){ echo 'class="active"'; } ?> >
            <a href="/users/non-students"><i class="icon-feather-users"></i> 
                Non-students
            </a>
        </li>
    </ul>
    <ul data-submenu-title="Payroll">
        <li <?php if (@$link == "payroll"){ echo 'class="active"'; } ?> >
            <a href="/payroll"><i class="icon-feather-wallet"></i> 
                Payroll
            </a>
        </li>
    </ul>
    <!-- End payroll subadmin menu -->
@endif