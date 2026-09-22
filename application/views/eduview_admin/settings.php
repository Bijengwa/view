<div class="row">
    <div class="col-md-8">
        <section class="panel">
            <header class="panel-heading">
                <h4 class="panel-title"><i class="fas fa-user-cog"></i> Account Settings</h4>
            </header>
            <?=form_open('eduview-admin/settings', array('class' => 'form-horizontal form-bordered'))?>
            <div class="panel-body">
                <div class="form-group">
                    <label class="col-md-3 control-label">Name <span class="required">*</span></label>
                    <div class="col-md-7">
                        <input type="text" class="form-control" name="name" value="<?=html_escape(set_value('name', $account['name']))?>" required>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label">Login Email <span class="required">*</span></label>
                    <div class="col-md-7">
                        <div class="input-group">
                            <span class="input-group-addon"><i class="far fa-envelope"></i></span>
                            <input type="email" class="form-control" name="email" value="<?=html_escape(set_value('email', $account['username']))?>" required>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label">New Password</label>
                    <div class="col-md-7">
                        <input type="password" class="form-control" name="new_password" minlength="8" autocomplete="new-password">
                        <span class="help-block">Leave empty to keep the current password.</span>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label">Confirm Password</label>
                    <div class="col-md-7">
                        <input type="password" class="form-control" name="confirm_password" minlength="8" autocomplete="new-password">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label">Current Password <span class="required">*</span></label>
                    <div class="col-md-7">
                        <input type="password" class="form-control" name="current_password" required autocomplete="current-password">
                        <span class="help-block">Needed to save any change.</span>
                    </div>
                </div>
            </div>
            <footer class="panel-footer">
                <div class="row">
                    <div class="col-md-3 col-md-offset-3">
                        <button type="submit" class="btn btn-default btn-block"><i class="fas fa-save"></i> Save Changes</button>
                    </div>
                </div>
            </footer>
            <?=form_close()?>
        </section>
    </div>
    <div class="col-md-4">
        <section class="panel">
            <header class="panel-heading">
                <h4 class="panel-title"><i class="fas fa-sign-out-alt"></i> Session</h4>
            </header>
            <div class="panel-body">
                <p class="text-muted">Signed in as <strong><?=html_escape($account['username'])?></strong></p>
                <a href="<?=base_url('eduview-admin/logout')?>" class="btn btn-danger btn-block"><i class="fas fa-sign-out-alt"></i> Logout</a>
            </div>
        </section>
    </div>
</div>
