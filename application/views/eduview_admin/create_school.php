<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Register School</title>
    <link rel="stylesheet" href="<?=base_url('assets/vendor/bootstrap/css/bootstrap.css')?>">
</head>
<body>
<div class="container" style="max-width:760px;margin:40px auto">
    <?php $this->load->view('eduview_admin/nav'); ?>
    <h2>Register School</h2>
    <?=form_open('eduview-admin/schools/create')?>
    <h4>School profile</h4>
    <div class="form-group"><label>Name</label><input class="form-control" name="school_name" required></div>
    <div class="form-group"><label>Subdomain</label><input class="form-control" name="school_subdomain" pattern="[a-z0-9-]+" required><small>Example: greenvalley</small></div>
    <div class="form-group"><label>Email</label><input class="form-control" type="email" name="school_email" required></div>
    <div class="form-group"><label>Phone</label><input class="form-control" name="school_phone"></div>
    <div class="form-group"><label>Address</label><textarea class="form-control" name="school_address"></textarea></div>
    <div class="form-group"><label>Website</label><input class="form-control" name="school_website"></div>
    <h4>School superadmin</h4>
    <div class="form-group"><label>Name</label><input class="form-control" name="admin_name" required></div>
    <div class="form-group"><label>Email</label><input class="form-control" type="email" name="admin_email" required></div>
    <div class="form-group"><label>Phone</label><input class="form-control" name="admin_phone"></div>
    <div class="form-group"><label>Temporary password</label><input class="form-control" type="password" name="admin_password" minlength="8" required></div>
    <div class="form-group"><label>Confirm password</label><input class="form-control" type="password" name="admin_password_confirmation" minlength="8" required></div>
    <button class="btn btn-success" type="submit">Create school and admin</button>
    <?=form_close()?>
</div>
</body>
</html>