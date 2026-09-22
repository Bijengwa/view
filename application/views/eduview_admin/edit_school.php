<?php
$fields = array(
    array('Name', 'school_name', 'name', 'text', true),
    array('Subdomain', 'school_subdomain', 'subdomain', 'text', true),
    array('Email', 'school_email', 'email', 'email', true),
    array('Phone', 'school_phone', 'phone', 'text', false),
    array('Address', 'school_address', 'address', 'textarea', false),
    array('Website', 'school_website', 'website', 'text', false),
);
?>
<section class="panel">
    <header class="panel-heading">
        <h4 class="panel-title"><i class="fas fa-pen-nib"></i> Edit School</h4>
    </header>
    <?=form_open('eduview-admin/schools/edit/' . $school['id'], array('class' => 'form-horizontal form-bordered'))?>
    <div class="panel-body">
        <?php foreach ($fields as $f): list($label, $name, $col, $type, $req) = $f; $val = html_escape(set_value($name, $school[$col])); ?>
        <div class="form-group">
            <label class="col-md-3 control-label"><?=$label?><?=($req ? ' <span class="required">*</span>' : '')?></label>
            <div class="col-md-6">
                <?php if ($type === 'textarea'): ?>
                    <textarea class="form-control" name="<?=$name?>" rows="2"><?=$val?></textarea>
                <?php else: ?>
                    <input type="<?=$type?>" class="form-control" name="<?=$name?>" value="<?=$val?>"<?=($name === 'school_subdomain' ? ' pattern="[a-z0-9-]+"' : '')?><?=($req ? ' required' : '')?>>
                <?php endif; ?>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
    <footer class="panel-footer">
        <div class="row">
            <div class="col-md-2 col-md-offset-3">
                <button type="submit" class="btn btn-default btn-block"><i class="fas fa-save"></i> Save Changes</button>
            </div>
        </div>
    </footer>
    <?=form_close()?>
</section>
