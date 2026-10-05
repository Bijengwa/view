<?php
$active = (int) $school['status'] === 1;
$school_logo_path = 'uploads/app_image/school-logo-' . (int) $school['id'] . '.png';
$school_logo = file_exists($school_logo_path)
    ? base_url($school_logo_path) . '?v=' . filemtime($school_logo_path)
    : base_url('uploads/app_image/logo.png');
?>
<div class="row">
    <div class="col-md-7">
        <section class="panel">
            <header class="panel-heading">
                <h4 class="panel-title"><i class="fas fa-school"></i> <?=html_escape($school['name'])?></h4>
            </header>
            <div class="panel-body">
                <div class="text-center mb-md">
                    <img src="<?=$school_logo?>" alt="<?=html_escape($school['name'])?> logo" style="max-width: 180px; max-height: 140px; object-fit: contain;">
                </div>
                <table class="table table-bordered table-condensed mb-none">
                    <tr><th width="30%">Subdomain</th><td><?=html_escape($school['subdomain'])?></td></tr>
                    <tr><th>Status</th><td><?=($active ? '<span class="label label-success-custom">Active</span>' : '<span class="label label-danger-custom">Suspended</span>')?></td></tr>
                    <tr><th>Email</th><td><?=html_escape($school['email'])?></td></tr>
                    <tr><th>Phone</th><td><?=html_escape($school['phone'])?></td></tr>
                    <tr><th>Website</th><td><?=html_escape($school['website'])?></td></tr>
                    <tr><th>Address</th><td><?=nl2br(html_escape($school['address']))?></td></tr>
                    <tr><th>Created</th><td><?=html_escape($school['created_at'])?></td></tr>
                </table>
            </div>
            <footer class="panel-footer">
                <a href="<?=base_url('eduview-admin/schools')?>" class="btn btn-default"><i class="fas fa-arrow-left"></i> Back</a>
            </footer>
        </section>
    </div>
    <div class="col-md-5">
        <section class="panel">
            <header class="panel-heading">
                <h4 class="panel-title"><i class="fas fa-code-branch"></i> Branches (<?=count($branches)?>)</h4>
            </header>
            <div class="panel-body">
                <p><a href="<?=base_url('eduview-admin/schools/' . $school['id'] . '/branches/create')?>" class="btn btn-default btn-sm"><i class="fas fa-plus-circle"></i> Add Branch</a></p>
                <ul class="list-unstyled mb-none">
                <?php foreach ($branches as $branch): ?>
                    <li class="mb-xs"><i class="fas fa-caret-right"></i> <?=html_escape($branch['name'])?>
                        <a href="<?=base_url('eduview-admin/branches/' . $branch['id'] . '/edit')?>" class="btn btn-default btn-circle icon"><i class="fas fa-pen-nib"></i></a>
                        <?=form_open('eduview-admin/branches/' . $branch['id'] . '/delete', array('style' => 'display:inline'))?><button type="submit" class="btn btn-danger btn-circle icon" onclick="return confirm('Delete this branch?');"><i class="fas fa-trash"></i></button><?=form_close()?></li>
                <?php endforeach; ?>
                <?php if (empty($branches)): ?><li class="text-muted">No branches yet.</li><?php endif; ?>
                </ul>
            </div>
        </section>
    </div>
</div>
