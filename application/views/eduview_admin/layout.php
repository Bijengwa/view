<!doctype html>
<html class="fixed sidebar-left-sm <?php echo (isset($theme_config['dark_skin']) && $theme_config['dark_skin'] == 'true' ? 'dark' : 'sidebar-light'); ?>">
<?php $this->load->view('layout/header.php'); ?>
<body>
    <section class="body">
        <?php $this->load->view('eduview_admin/topbar'); ?>
        <div class="inner-wrapper">
            <?php $this->load->view('eduview_admin/nav'); ?>
            <section role="main" class="content-body">
                <header class="page-header">
                    <a class="page-title-icon" href="<?=base_url('eduview-admin/home')?>"><i class="fas fa-home"></i></a>
                    <h2><?=html_escape($title)?></h2>
                </header>
                <?php $this->load->view($sub_page); ?>
            </section>
        </div>
    </section>

    <?php $this->load->view('layout/script.php'); ?>

    <?php
    $alertclass = '';
    foreach (array('success', 'error', 'info') as $type) {
        if ($this->session->flashdata('alert-message-' . $type)) {
            $alertclass = $type;
            break;
        }
    }
    $alert_message = $alertclass != '' ? $this->session->flashdata('alert-message-' . $alertclass) : '';
    if (!empty($page_alert)) {
        list($alertclass, $alert_message) = $page_alert;
    }
    if ($alertclass != ''):
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
