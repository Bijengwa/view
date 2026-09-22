<?php $main_menu = isset($main_menu) ? $main_menu : ''; ?>
<aside id="sidebar-left" class="sidebar-left">
    <div class="sidebar-header">
        <div class="sidebar-title">Main</div>
    </div>

    <div class="nano">
        <div class="nano-content">
            <nav id="menu" class="nav-main" role="navigation">
                <ul class="nav nav-main">
                    <li class="<?php if ($main_menu == 'home') echo 'nav-active'; ?>">
                        <a href="<?=base_url('eduview-admin/home')?>">
                            <i class="fas fa-home"></i><span>Home</span>
                        </a>
                    </li>
                    <li class="<?php if ($main_menu == 'schools') echo 'nav-active'; ?>">
                        <a href="<?=base_url('eduview-admin/schools')?>">
                            <i class="fas fa-school"></i><span>Schools</span>
                        </a>
                    </li>
                    <li class="<?php if ($main_menu == 'register_school') echo 'nav-active'; ?>">
                        <a href="<?=base_url('eduview-admin/schools/create')?>">
                            <i class="fas fa-plus-circle"></i><span>Register School</span>
                        </a>
                    </li>
                    <li class="<?php if ($main_menu == 'school_admins') echo 'nav-active'; ?>">
                        <a href="<?=base_url('eduview-admin/school-admins')?>">
                            <i class="fas fa-user-shield"></i><span>School Admins</span>
                        </a>
                    </li>
                    <li class="nav-parent <?php if ($main_menu == 'settings') echo 'nav-active nav-expanded'; ?>">
                        <a><i class="fas fa-cog"></i><span>Settings</span></a>
                        <ul class="nav nav-children">
                            <li class="<?php if ($main_menu == 'settings') echo 'nav-active'; ?>">
                                <a href="<?=base_url('eduview-admin/settings')?>">
                                    <span><i class="fas fa-caret-right" aria-hidden="true"></i> Account</span>
                                </a>
                            </li>
                            <li>
                                <a href="<?=base_url('eduview-admin/logout')?>">
                                    <span><i class="fas fa-caret-right" aria-hidden="true"></i> Logout</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
</aside>
