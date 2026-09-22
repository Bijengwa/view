<header class="header">
    <div class="logo-env">
        <a href="<?=base_url('eduview-admin/home')?>" class="logo">
            <img src="<?=$this->application_model->getBranchImage('', 'logo-small')?>" height="40">
        </a>
        <div class="visible-xs toggle-sidebar-left" data-toggle-class="sidebar-left-opened" data-target="html" data-fire-event="sidebar-left-opened">
            <i class="fa fa-bars" aria-label="Toggle sidebar"></i>
        </div>
    </div>

    <div class="header-left hidden-xs">
        <ul class="header-menu">
            <li>
                <div class="header-menu-icon sidebar-toggle" data-toggle-class="sidebar-left-collapsed" data-target="html" data-fire-event="sidebar-left-toggle">
                    <i class="fas fa-bars" aria-label="Toggle sidebar"></i>
                </div>
            </li>
            <li>
                <div class="header-menu-icon s-expand">
                    <i class="fas fa-expand"></i>
                </div>
            </li>
        </ul>
    </div>

    <div class="header-right">
        <span class="separator"></span>
        <div id="userbox" class="userbox">
            <a href="#" data-toggle="dropdown">
                <figure class="profile-picture">
                    <img src="<?=get_image_url('staff', '')?>" alt="user-image" class="img-circle" height="35">
                </figure>
            </a>
            <div class="dropdown-menu">
                <ul class="dropdown-user list-unstyled">
                    <li class="user-p-box">
                        <div class="dw-user-box">
                            <div class="u-img">
                                <img src="<?=get_image_url('staff', '')?>" alt="user">
                            </div>
                            <div class="u-text">
                                <h4><?=html_escape($this->session->userdata('name'))?></h4>
                                <p class="text-muted">Platform Admin</p>
                            </div>
                        </div>
                    </li>
                    <li role="separator" class="divider"></li>
                    <li><a href="<?=base_url('eduview-admin/settings')?>"><i class="fas fa-cog"></i> Settings</a></li>
                </ul>
            </div>
        </div>
    </div>
</header>
