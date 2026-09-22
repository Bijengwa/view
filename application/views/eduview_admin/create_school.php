<?php
if (!function_exists('ev_field')) {
function ev_field($label, $name, $type = 'text', $required = false, $extra = '') {
    $req = $required ? ' <span class="required">*</span>' : '';
    $input = $type === 'textarea'
        ? '<textarea class="form-control" name="' . $name . '" rows="2"' . ($required ? ' required' : '') . '>' . html_escape(set_value($name)) . '</textarea>'
        : '<input type="' . $type . '" class="form-control" name="' . $name . '"' . ($type !== 'password' ? ' value="' . html_escape(set_value($name)) . '"' : '') . ($required ? ' required' : '') . ' ' . $extra . '>';
    return '<div class="form-group"><label class="col-md-3 control-label">' . $label . $req . '</label><div class="col-md-6">' . $input . '</div></div>';
}
}
?>
<section class="panel">
    <header class="panel-heading">
        <h4 class="panel-title"><i class="fas fa-plus-circle"></i> Register School</h4>
    </header>
    <?=form_open('eduview-admin/schools/create', array('class' => 'form-horizontal form-bordered'))?>
    <div class="panel-body">
        <div class="headers-line"><i class="fas fa-school"></i> School Profile</div>
        <?=ev_field('Name', 'school_name', 'text', true)?>
        <div class="form-group">
            <label class="col-md-3 control-label">Subdomain <span class="required">*</span></label>
            <div class="col-md-6">
                <input type="text" class="form-control" name="school_subdomain" pattern="[a-z0-9-]+" value="<?=html_escape(set_value('school_subdomain'))?>" required>
                <span class="help-block">Example: greenvalley</span>
            </div>
        </div>
        <?=ev_field('Email', 'school_email', 'email', true)?>
        <?=ev_field('Phone', 'school_phone')?>
        <?=ev_field('Address', 'school_address', 'textarea')?>
        <?=ev_field('Website', 'school_website')?>

        <div class="headers-line mt-lg"><i class="fas fa-user-shield"></i> School Superadmin</div>
        <?=ev_field('Name', 'admin_name', 'text', true)?>
        <?=ev_field('Email', 'admin_email', 'email', true)?>
        <?=ev_field('Phone', 'admin_phone')?>
        <?=ev_field('Temporary Password', 'admin_password', 'password', true, 'minlength="8"')?>
        <?=ev_field('Confirm Password', 'admin_password_confirmation', 'password', true, 'minlength="8"')?>
    </div>
    <footer class="panel-footer">
        <div class="row">
            <div class="col-md-3 col-md-offset-3">
                <button type="submit" class="btn btn-default btn-block"><i class="fas fa-plus-circle"></i> Create School and Admin</button>
            </div>
        </div>
    </footer>
    <?=form_close()?>
</section>
