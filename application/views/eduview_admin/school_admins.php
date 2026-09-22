<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>School Admins</title>
    <link rel="stylesheet" href="<?=base_url('assets/vendor/bootstrap/css/bootstrap.css')?>">
</head>
<body>
<div class="container" style="margin-top:40px">
    <?php $this->load->view('eduview_admin/nav'); ?>
    <h2>School Superadmins</h2>
    <table class="table table-bordered"><thead><tr><th>Name</th><th>Email</th><th>Phone</th><th>School</th><th>Status</th></tr></thead><tbody>
    <?php foreach ($admins as $admin): ?><tr><td><?=html_escape($admin['admin_name'])?></td><td><?=html_escape($admin['email'])?></td><td><?=html_escape($admin['mobileno'])?></td><td><?=html_escape($admin['school_name'])?> <small>(<?=html_escape($admin['slug'])?>)</small></td><td><?=((int) $admin['status'] === 1 ? 'Active' : 'Inactive')?></td></tr><?php endforeach; ?>
    </tbody></table>
</div>
</body>
</html>