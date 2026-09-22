<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Edit School</title>
    <link rel="stylesheet" href="<?=base_url('assets/vendor/bootstrap/css/bootstrap.css')?>">
</head>
<body>
<div class="container" style="max-width:760px;margin:40px auto">
    <?php $this->load->view('eduview_admin/nav'); ?>
    <h2>Edit School</h2>
    <?=form_open('eduview-admin/schools/edit/' . $school['id'])?>
    <div class="form-group"><label>Name</label><input class="form-control" name="school_name" value="<?=html_escape($school['name'])?>" required></div>
    <div class="form-group"><label>Subdomain</label><input class="form-control" name="school_subdomain" pattern="[a-z0-9-]+" value="<?=html_escape($school['subdomain'])?>" required></div>
    <div class="form-group"><label>Email</label><input class="form-control" type="email" name="school_email" value="<?=html_escape($school['email'])?>" required></div>
    <div class="form-group"><label>Phone</label><input class="form-control" name="school_phone" value="<?=html_escape($school['phone'])?>"></div>
    <div class="form-group"><label>Address</label><textarea class="form-control" name="school_address"><?=html_escape($school['address'])?></textarea></div>
    <div class="form-group"><label>Website</label><input class="form-control" name="school_website" value="<?=html_escape($school['website'])?>"></div>
    <button class="btn btn-primary" type="submit">Save changes</button>
    <?=form_close()?>
</div>
</body>
</html>