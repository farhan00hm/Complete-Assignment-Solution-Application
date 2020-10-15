@if(Auth::user()->isSys())
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

    <ul data-submenu-title="Discounts">
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
                    <a href="/discount-codes/un-redeemed">Unredeemed</a>
                </li>
                <li>
                    <a href="/discount-codes/redeemed">Redeemed</a>
                </li>
            </ul>   
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

    <!-- End system subadmin menu -->
@endif