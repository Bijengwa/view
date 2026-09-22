<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?=html_escape($title)?></title>
    <link rel="stylesheet" href="<?=base_url('assets/vendor/bootstrap/css/bootstrap.css')?>">
</head>
<body>
<div class="container" style="margin-top:40px">
    <?php $this->load->view('eduview_admin/nav'); ?>
    <div class="clearfix"><h2>EduView Platform Administration</h2></div>
    <div class="row">
        <div class="col-sm-4"><div class="well"><strong><?=count($schools)?></strong><br>Registered schools</div></div>
        <div class="col-sm-4"><div class="well"><strong><?=count(array_filter($schools, function ($school) { return (int) $school['status'] === 1; }))?></strong><br>Active schools</div></div>
        <div class="col-sm-4"><div class="well"><strong><?=array_sum(array_map(function ($school) { return (int) $school['admin_count']; }, $schools))?></strong><br>School admins</div></div>
    </div>
</div>
</body>
</html>