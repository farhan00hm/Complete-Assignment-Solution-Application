<div class="dashboard-sidebar">
    <div class="dashboard-sidebar-inner" data-simplebar>
        <div class="dashboard-nav-container">
            <div class="dashboard-nav">
                <div class="dashboard-nav-inner">
                    <!-- Dashboard menu -->
                    <ul data-submenu-title="">
                        <li <?php if (@$link == "dash"){ echo 'class="active"'; } ?> >
                            <a href="/dashboard"><i class="icon-material-outline-dashboard"></i>
                                Dashboard
                            </a>
                        </li>
                    </ul>

                    <!-- Admin and subadmin menu -->
                    @include('member.menus.admin')
                    @include('member.menus.subd')
                    @include('member.menus.subcs')
                    @include('member.menus.subp')
                    @include('member.menus.subauth')
                    @include('member.menus.subsys')

                    <!-- Student and Professional menu -->
                    @include('member.menus.student')

                    <!-- Solution expert menu -->
                    @include('member.menus.fl')

                    <ul data-submenu-title="Account">
                        <li <?php if (@$link == "stngs"){ echo 'class="active"'; } ?> >
                            <a href="/settings">
                                <i class="icon-material-outline-settings"></i>
                                Settings
                            </a>
                        </li>
                        <li>
                            <a href="/logout">
                                <i class="icon-material-outline-power-settings-new"></i> Logout
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
