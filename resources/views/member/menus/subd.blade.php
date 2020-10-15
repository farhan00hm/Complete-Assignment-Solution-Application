@if(Auth::user()->isD())
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
    </ul>

    <ul data-submenu-title="Homework">
        <li <?php if (@$link == "flhw"){ echo 'class="active"'; } ?> >
            <a href="/homeworks/flagged">
                <i class="icon-material-outline-outlined-flag"></i> 
                Flagged Homework
            </a> 
        </li>
    </ul>
    <!-- End dispute management subadmin menu -->
@endif