<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?=html_escape($school['name'])?></title>
    <link rel="stylesheet" href="<?=base_url('assets/vendor/bootstrap/css/bootstrap.css')?>">
</head>
<body>
<div class="container" style="max-width:800px;margin:40px auto">
    <?php $this->load->view('eduview_admin/nav'); ?>
    <h2><?=html_escape($school['name'])?></h2>
    <dl class="dl-horizontal">
        <dt>Subdomain</dt><dd><?=html_escape($school['subdomain'])?></dd>
        <dt>Status</dt><dd><?=((int) $school['status'] === 1 ? 'Active' : 'Suspended')?></dd>
        <dt>Email</dt><dd><?=html_escape($school['email'])?></dd>
        <dt>Phone</dt><dd><?=html_escape($school['phone'])?></dd>
        <dt>Website</dt><dd><?=html_escape($school['website'])?></dd>
        <dt>Address</dt><dd><?=nl2br(html_escape($school['address']))?></dd>
        <dt>Created</dt><dd><?=html_escape($school['created_at'])?></dd>
    </dl>
    <h3>Branches</h3>
    <ul><?php foreach ($branches as $branch): ?><li><?=html_escape($branch['name'])?></li><?php endforeach; ?></ul>
</div>
</body>
</html>