<?php $active = (int) $school['status'] === 1; ?>
<div class="row">
    <div class="col-md-7">
        <section class="panel">
            <header class="panel-heading">
                <h4 class="panel-title"><i class="fas fa-school"></i> <?=html_escape($school['name'])?></h4>
            </header>
            <div class="panel-body">
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
                <a href="<?=base_url('eduview-admin/schools/edit/' . $school['id'])?>" class="btn btn-default"><i class="fas fa-pen-nib"></i> Edit</a>
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
                <ul class="list-unstyled mb-none">
                <?php foreach ($branches as $branch): ?>
                    <li class="mb-xs"><i class="fas fa-caret-right"></i> <?=html_escape($branch['name'])?></li>
                <?php endforeach; ?>
                <?php if (empty($branches)): ?><li class="text-muted">No branches yet.</li><?php endif; ?>
                </ul>
            </div>
        </section>
    </div>
</div>
