<section class="panel">
    <header class="panel-heading">
        <h4 class="panel-title"><i class="fas fa-code-branch"></i> <?=html_escape($school['name'])?> - <?=html_escape($title)?></h4>
    </header>
    <div class="panel-body">
        <?=form_open($form_action, array('class' => 'form-horizontal form-bordered'))?>
            <div class="form-group"><label class="col-md-3 control-label">Branch Name <span class="required">*</span></label><div class="col-md-6"><input type="text" name="branch_name" class="form-control" value="<?=html_escape($branch['name'])?>" required></div></div>
            <div class="form-group"><label class="col-md-3 control-label">Email</label><div class="col-md-6"><input type="email" name="email" class="form-control" value="<?=html_escape($branch['email'])?>"></div></div>
            <div class="form-group"><label class="col-md-3 control-label">Mobile</label><div class="col-md-6"><input type="text" name="mobileno" class="form-control" value="<?=html_escape($branch['mobileno'])?>"></div></div>
            <div class="form-group"><label class="col-md-3 control-label">City</label><div class="col-md-6"><input type="text" name="city" class="form-control" value="<?=html_escape($branch['city'])?>"></div></div>
            <div class="form-group"><label class="col-md-3 control-label">Region</label><div class="col-md-6"><input type="text" name="state" class="form-control" value="<?=html_escape($branch['state'])?>"></div></div>
            <div class="form-group"><label class="col-md-3 control-label">Address</label><div class="col-md-6"><textarea name="address" class="form-control"><?=html_escape($branch['address'])?></textarea></div></div>
            <div class="panel-footer"><button type="submit" class="btn btn-default"><i class="fas fa-save"></i> Save</button> <a href="<?=base_url('eduview-admin/schools/view/' . $school['id'])?>" class="btn btn-default">Cancel</a></div>
        <?=form_close()?>
    </div>
</section>