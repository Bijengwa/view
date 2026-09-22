<section class="panel">
    <header class="panel-heading">
        <h4 class="panel-title"><i class="fas fa-user-shield"></i> School Superadmins</h4>
    </header>
    <div class="panel-body">
        <div class="table-responsive">
            <table class="table table-bordered table-hover table-condensed mb-none">
                <thead><tr><th>Name</th><th>Email</th><th>Phone</th><th>School</th><th>Status</th></tr></thead>
                <tbody>
                <?php foreach ($admins as $admin): ?>
                    <tr>
                        <td><?=html_escape($admin['admin_name'])?></td>
                        <td><?=html_escape($admin['email'])?></td>
                        <td><?=html_escape($admin['mobileno'])?></td>
                        <td><?=html_escape($admin['school_name'])?> <small class="text-muted">(<?=html_escape($admin['slug'])?>)</small></td>
                        <td><?=((int) $admin['status'] === 1 ? '<span class="label label-success-custom">Active</span>' : '<span class="label label-danger-custom">Inactive</span>')?></td>
                    </tr>
                <?php endforeach; ?>
                <?php if (empty($admins)): ?><tr><td colspan="5" class="text-center">No school admins yet.</td></tr><?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</section>
