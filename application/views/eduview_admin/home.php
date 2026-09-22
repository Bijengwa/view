<?php
$total_schools = count($schools);
$active_schools = count(array_filter($schools, function ($s) { return (int) $s['status'] === 1; }));
$total_admins = array_sum(array_map(function ($s) { return (int) $s['admin_count']; }, $schools));
$total_branches = array_sum(array_map(function ($s) { return (int) $s['branch_count']; }, $schools));
$widgets = array(
    array('icon' => 'fas fa-school', 'label' => 'Registered Schools', 'value' => $total_schools, 'note' => 'All schools'),
    array('icon' => 'fas fa-check-circle', 'label' => 'Active Schools', 'value' => $active_schools, 'note' => 'Currently active'),
    array('icon' => 'fas fa-code-branch', 'label' => 'Branches', 'value' => $total_branches, 'note' => 'All campuses'),
    array('icon' => 'fas fa-user-shield', 'label' => 'School Admins', 'value' => $total_admins, 'note' => 'Active admins'),
);
?>
<div class="row">
    <div class="col-md-12">
        <div class="panel">
            <div class="row widget-row-in">
            <?php foreach ($widgets as $w): ?>
                <div class="col-lg-3 col-sm-6">
                    <div class="panel-body">
                        <div class="widget-col-in row">
                            <div class="col-md-6 col-sm-6 col-xs-6"> <i class="<?=$w['icon']?>"></i>
                                <h5 class="text-muted"><?=$w['label']?></h5>
                            </div>
                            <div class="col-md-6 col-sm-6 col-xs-6">
                                <h3 class="counter text-right mt-md text-primary"><?=$w['value']?></h3>
                            </div>
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <div class="box-top-line line-color-primary">
                                    <span class="text-muted text-uppercase"><?=$w['note']?></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>

<section class="panel">
    <header class="panel-heading">
        <h4 class="panel-title"><i class="fas fa-list-ul"></i> Recent Schools</h4>
    </header>
    <div class="panel-body">
        <div class="table-responsive">
            <table class="table table-bordered table-hover table-condensed mb-none">
                <thead><tr><th>Name</th><th>Subdomain</th><th>Branches</th><th>Admins</th><th>Status</th></tr></thead>
                <tbody>
                <?php foreach (array_slice($schools, 0, 5) as $school): ?>
                    <tr>
                        <td><a href="<?=base_url('eduview-admin/schools/view/' . $school['id'])?>"><?=html_escape($school['name'])?></a></td>
                        <td><?=html_escape($school['subdomain'])?></td>
                        <td><?=(int) $school['branch_count']?></td>
                        <td><?=(int) $school['admin_count']?></td>
                        <td><?=((int) $school['status'] === 1 ? '<span class="label label-success-custom">Active</span>' : '<span class="label label-danger-custom">Suspended</span>')?></td>
                    </tr>
                <?php endforeach; ?>
                <?php if (empty($schools)): ?><tr><td colspan="5" class="text-center">No schools yet.</td></tr><?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</section>
