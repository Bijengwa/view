<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>EduView Platform Administration</title>
    <link rel="stylesheet" href="<?=base_url('assets/vendor/bootstrap/css/bootstrap.css')?>">
</head>
<body>
<div class="container" style="max-width:520px;margin:80px auto">
    <h2>EduView Platform Administration</h2>
    <p>Platform operations login</p>
    <?=form_open('eduview-admin/login')?>
        <div class="form-group"><label>Email</label><input class="form-control" type="email" name="email" required></div>
        <div class="form-group"><label>Password</label><input class="form-control" type="password" name="password" required></div>
        <button class="btn btn-primary" type="submit">Sign in</button>
    <?=form_close()?>
</div>
</body>
</html>