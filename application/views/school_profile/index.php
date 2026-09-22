<?php
$sid = (int) $school['id'];
$logo = function ($type) use ($sid) {
    $f = 'uploads/app_image/school-' . $type . '-' . $sid . '.png';
    return file_exists($f) ? base_url($f) . '?v=' . filemtime($f) : base_url('uploads/app_image/' . $type . '.png');
};
$text = function ($label, $name, $value, $required = false, $type = 'text') {
    return '<div class="form-group"><label class="col-md-3 control-label">' . $label . ($required ? ' <span class="required">*</span>' : '') . '</label>'
        . '<div class="col-md-6"><input type="' . $type . '" class="form-control" name="' . $name . '" value="' . html_escape($value) . '"' . ($required ? ' required' : '') . '>'
        . '<span class="error">' . form_error($name) . '</span></div></div>';
};
?>
<div class="row">
<div class="col-md-8">
<section class="panel">
    <header class="panel-heading">
        <h4 class="panel-title"><i class="fas fa-school"></i> School Profile</h4>
    </header>
    <?php echo form_open_multipart($this->uri->uri_string(), array('class' => 'form-horizontal form-bordered')); ?>
    <div class="panel-body">
        <div class="headers-line"><i class="fas fa-info-circle"></i> School Details</div>
        <?=$text('School Name', 'name', $school['name'], true)?>
        <div class="form-group">
            <label class="col-md-3 control-label">Description</label>
            <div class="col-md-6"><textarea class="form-control" name="description" rows="2"><?=html_escape($school['description'])?></textarea></div>
        </div>
        <?=$text(translate('email'), 'email', $school['email'], true, 'email')?>
        <?=$text(translate('mobile_no'), 'phone', $school['phone'])?>
        <?=$text('Website', 'website', $school['website'])?>
        <div class="form-group">
            <label class="col-md-3 control-label">Head Office Address</label>
            <div class="col-md-6"><textarea class="form-control" name="address" rows="2"><?=html_escape($school['address'])?></textarea></div>
        </div>

        <div class="headers-line mt-lg"><i class="fas fa-coins"></i> Money &amp; Time</div>
        <?=$text(translate('currency'), 'currency', $school['currency'], true)?>
        <?=$text(translate('currency_symbol'), 'currency_symbol', $school['currency_symbol'], true)?>
        <div class="form-group">
            <label class="col-md-3 control-label"><?=translate('timezone')?> <span class="required">*</span></label>
            <div class="col-md-6">
                <?=form_dropdown('timezone', $timezones, $school['timezone'], "class='form-control' data-plugin-selectTwo data-width='100%'")?>
            </div>
        </div>

        <div class="headers-line mt-lg"><i class="far fa-image"></i> Logos <small class="text-muted">(used by all branches)</small></div>
        <div class="form-group">
            <div class="col-md-offset-3 col-md-3">
                <label class="control-label pt-none"><?=translate('system_logo')?></label>
                <input type="file" name="logo_file" class="dropify" data-allowed-file-extensions="png jpg jpeg gif webp" data-default-file="<?=$logo('logo')?>" />
            </div>
            <div class="col-md-3 mb-md">
                <label class="control-label pt-none"><?=translate('text_logo')?></label>
                <input type="file" name="text_logo" class="dropify" data-allowed-file-extensions="png jpg jpeg gif webp" data-default-file="<?=$logo('logo-small')?>" />
            </div>
        </div>
        <div class="form-group">
            <div class="col-md-offset-3 col-md-3">
                <label class="control-label pt-none"><?=translate('printing_logo')?></label>
                <input type="file" name="print_file" class="dropify" data-allowed-file-extensions="png jpg jpeg gif webp" data-default-file="<?=$logo('printing-logo')?>" />
            </div>
            <div class="col-md-3 mb-md">
                <label class="control-label pt-none"><?=translate('report_card')?></label>
                <input type="file" name="report_card" class="dropify" data-allowed-file-extensions="png jpg jpeg gif webp" data-default-file="<?=$logo('report-card-logo')?>" />
            </div>
        </div>
    </div>
    <footer class="panel-footer">
        <div class="row">
            <div class="col-md-2 col-md-offset-3">
                <button type="submit" name="submit" value="save" class="btn btn-default btn-block"><i class="fas fa-save"></i> <?=translate('save')?></button>
            </div>
        </div>
    </footer>
    <?php echo form_close(); ?>
</section>
</div>
<div class="col-md-4">
<section class="panel">
    <header class="panel-heading">
        <h4 class="panel-title"><i class="icons icon-directions"></i> <?=translate('branch')?> (<?=count($branches)?>)</h4>
    </header>
    <div class="panel-body">
        <ul class="list-unstyled mb-md">
        <?php foreach ($branches as $b): ?>
            <li class="mb-sm">
                <strong><?=html_escape($b['name'])?></strong><br>
                <small class="text-muted"><i class="fas fa-map-marker-alt"></i> <?=html_escape(trim($b['city'] . ($b['state'] ? ', ' . $b['state'] : ''), ', ') ?: '-')?></small>
            </li>
        <?php endforeach; ?>
        </ul>
        <a href="<?=base_url('branch')?>" class="btn btn-default btn-sm"><i class="fas fa-cog"></i> Manage Branches</a>
    </div>
</section>
</div>
</div>
