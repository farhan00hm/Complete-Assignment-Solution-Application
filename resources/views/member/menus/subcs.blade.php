@if(Auth::user()->isCS())
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

    <!-- <ul data-submenu-title="Messaging">
        <li <?php if (@$link == "msngs"){ echo 'class="active"'; } ?> >
            <a href="/messages">
                <i class="icon-feather-message-square"></i> 
                Messages
            </a>
        </li>
    </ul> -->
    <!-- End customer service subadmin menu -->
@endif