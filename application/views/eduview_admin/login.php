<!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width,initial-scale=1" name="viewport">
    <title>EduView Platform Admin - Login</title>
    <link rel="shortcut icon" href="<?=base_url('assets/images/favicon.png')?>">
    <link href="<?=is_secure('fonts.googleapis.com/css?family=Signika:300,400,600,700')?>" rel="stylesheet">
    <link rel="stylesheet" href="<?=base_url('assets/vendor/bootstrap/css/bootstrap.css')?>">
    <link rel="stylesheet" href="<?=base_url('assets/vendor/font-awesome/css/all.min.css')?>">
    <script src="<?=base_url('assets/vendor/jquery/jquery.js')?>"></script>
    <link rel="stylesheet" href="<?=base_url('assets/vendor/sweetalert/sweetalert-custom.css')?>">
    <script src="<?=base_url('assets/vendor/sweetalert/sweetalert.min.js')?>"></script>
    <link rel="stylesheet" href="<?=base_url('assets/login_page/css/style.css')?>">
    <script type="text/javascript">var base_url = '<?=base_url()?>';</script>
</head>
<body>
    <div class="auth-main">
        <div class="container">
            <div class="slideIn">
                <div class="col-lg-4 col-lg-offset-1 col-md-4 col-md-offset-1 col-sm-12 col-xs-12 no-padding fitxt-center">
                    <div class="image-area">
                        <div class="content">
                            <div class="image-hader">
                                <h2>Welcome To</h2>
                            </div>
                            <div class="center img-hol-p">
                                <img src="<?=$this->application_model->getBranchImage('', 'logo')?>" height="60" alt="EduView">
                            </div>
                            <div class="address">
                                <p>EduView Platform Administration</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6 col-lg-offset-right-1 col-md-6 col-md-offset-right-1 col-sm-12 col-xs-12 no-padding">
                    <div class="sign-area">
                        <div class="sign-hader">
                            <img src="<?=$this->application_model->getBranchImage('', 'logo')?>" height="54" alt="">
                            <h2>Platform Admin</h2>
                        </div>
                        <?=form_open('eduview-admin/login')?>
                            <div class="form-group">
                                <div class="input-group input-group-icon">
                                    <span class="input-group-addon">
                                        <span class="icon"><i class="far fa-envelope"></i></span>
                                    </span>
                                    <input type="email" class="form-control" name="email" value="<?=html_escape(set_value('email'))?>" placeholder="Email" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group input-group-icon">
                                    <span class="input-group-addon">
                                        <span class="icon"><i class="fas fa-unlock-alt"></i></span>
                                    </span>
                                    <input type="password" class="form-control input-rounded" name="password" placeholder="Password" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-block btn-round">
                                    <i class="fas fa-sign-in-alt"></i> Login
                                </button>
                            </div>
                            <div class="sign-footer">
                                <p>&copy; <?=date('Y')?> EduView</p>
                            </div>
                        <?=form_close()?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="<?=base_url('assets/vendor/bootstrap/js/bootstrap.js')?>"></script>
    <script src="<?=base_url('assets/login_page/js/jquery.backstretch.min.js')?>"></script>
    <script src="<?=base_url('assets/login_page/js/custom.js')?>"></script>
    <?php
    $alertclass = '';
    foreach (array('success', 'error', 'info') as $type) {
        if ($this->session->flashdata('alert-message-' . $type)) {
            $alertclass = $type;
            break;
        }
    }
    if ($alertclass != ''):
        $alert_message = $this->session->flashdata('alert-message-' . $alertclass);
    ?>
    <script type="text/javascript">
        swal({
            toast: true,
            position: 'top-end',
            type: '<?=$alertclass?>',
            title: <?=json_encode($alert_message)?>,
            confirmButtonClass: 'btn btn-default',
            buttonsStyling: false,
            timer: 8000
        });
    </script>
    <?php endif; ?>
</body>
</html>
