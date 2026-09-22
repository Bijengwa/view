<section class="panel">
    <header class="panel-heading">
        <h4 class="panel-title"><i class="fas fa-school"></i> Registered Schools</h4>
    </header>
    <div class="panel-body">
        <div class="mb-md">
            <a href="<?=base_url('eduview-admin/schools/create')?>" class="btn btn-default btn-sm"><i class="fas fa-plus-circle"></i> Register School</a>
        </div>
        <div class="table-responsive">
            <table class="table table-bordered table-hover table-condensed mb-none">
                <thead><tr><th>Name</th><th>Subdomain</th><th>Status</th><th>Branches</th><th>Admins</th><th>Action</th></tr></thead>
                <tbody>
                <?php foreach ($schools as $school): $active = (int) $school['status'] === 1; ?>
                    <tr>
                        <td><a href="<?=base_url('eduview-admin/schools/view/' . $school['id'])?>"><?=html_escape($school['name'])?></a></td>
                        <td><?=html_escape($school['subdomain'])?></td>
                        <td><?=($active ? '<span class="label label-success-custom">Active</span>' : '<span class="label label-danger-custom">Suspended</span>')?></td>
                        <td><?=(int) $school['branch_count']?></td>
                        <td><?=(int) $school['admin_count']?></td>
                        <td class="min-w-c">
                            <a href="<?=base_url('eduview-admin/schools/view/' . $school['id'])?>" class="btn btn-circle btn-default icon" title="View"><i class="far fa-eye"></i></a>
                            <?=form_open('eduview-admin/schools/' . $school['id'] . ($active ? '/suspend' : '/activate'), array('style' => 'display:inline'))?>
                                <button type="submit" class="btn btn-circle <?=($active ? 'btn-danger' : 'btn-default')?> icon" title="<?=($active ? 'Suspend' : 'Activate')?>"><i class="fas <?=($active ? 'fa-ban' : 'fa-check')?>"></i></button>
                            <?=form_close()?>
                        </td>
                    </tr>
                <?php endforeach; ?>
                <?php if (empty($schools)): ?><tr><td colspan="6" class="text-center">No schools yet.</td></tr><?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</section>
