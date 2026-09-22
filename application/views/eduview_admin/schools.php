<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Schools</title>
    <link rel="stylesheet" href="<?=base_url('assets/vendor/bootstrap/css/bootstrap.css')?>">
</head>
<body>
<div class="container" style="margin-top:40px">
    <?php $this->load->view('eduview_admin/nav'); ?>
    <h2>Registered Schools</h2>
    <table class="table table-bordered"><thead><tr><th>Name</th><th>Subdomain</th><th>Status</th><th>Branches</th><th>Admins</th><th>Actions</th></tr></thead><tbody>
    <?php foreach ($schools as $school): ?><tr><td><a href="<?=base_url('eduview-admin/schools/view/' . $school['id'])?>"><?=html_escape($school['name'])?></a></td><td><?=html_escape($school['subdomain'])?></td><td><?=((int) $school['status'] === 1 ? 'Active' : 'Suspended')?></td><td><?=$school['branch_count']?></td><td><?=$school['admin_count']?></td><td><a href="<?=base_url('eduview-admin/schools/edit/' . $school['id'])?>">Edit</a> <?=form_open(((int) $school['status'] === 1 ? 'eduview-admin/schools/' . $school['id'] . '/suspend' : 'eduview-admin/schools/' . $school['id'] . '/activate'), array('style' => 'display:inline'))?><button type="submit" class="btn btn-link"><?=((int) $school['status'] === 1 ? 'Suspend' : 'Activate')?></button><?=form_close()?></td></tr><?php endforeach; ?>
    </tbody></table>
</div>
</body>
</html>