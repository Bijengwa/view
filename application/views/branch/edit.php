<?php
$fields = array(
    array(translate('branch_name'), 'branch_name', $data->name, true, 'text'),
    array(translate('email'), 'email', $data->email, false, 'email'),
    array(translate('mobile_no'), 'mobileno', $data->mobileno, false, 'text'),
    array(translate('city'), 'city', $data->city, false, 'text'),
    array('Region', 'state', $data->state, false, 'text'),
);
?>
<section class="panel">
	<div class="tabs-custom">
		<ul class="nav nav-tabs">
			<li>
				<a href="<?=base_url('branch')?>"><i class="fas fa-list-ul"></i> <?=translate('branch_list')?></a>
			</li>
			<li class="active">
				<a href="#edit" data-toggle="tab"><i class="far fa-edit"></i> <?=translate('edit_branch')?></a>
			</li>
		</ul>
		<div class="tab-content">
			<div class="tab-pane active" id="edit">
				<?php echo form_open($this->uri->uri_string(), array('class' => 'form-horizontal form-bordered validate')); ?>
					<input type="hidden" name="branch_id" value="<?=$data->id?>">
					<?php foreach ($fields as $i => $f): list($label, $name, $value, $req, $type) = $f; ?>
					<div class="form-group<?=($i === 0 ? ' mt-md' : '')?>">
						<label class="col-md-3 control-label"><?=$label?><?=($req ? ' <span class="required">*</span>' : '')?></label>
						<div class="col-md-6">
							<input type="<?=$type?>" class="form-control" name="<?=$name?>" value="<?=html_escape(set_value($name, $value))?>" />
							<span class="error"><?=form_error($name)?></span>
						</div>
					</div>
					<?php endforeach; ?>
					<div class="form-group">
						<label class="col-md-3 control-label"><?=translate('address')?></label>
						<div class="col-md-6 mb-md">
							<textarea rows="3" class="form-control" name="address"><?=html_escape(set_value('address', $data->address))?></textarea>
							<span class="help-block">School name, currency, timezone and logos are edited in <a href="<?=base_url('school_profile')?>">School Profile</a>.</span>
						</div>
					</div>
					<footer class="panel-footer mt-lg">
						<div class="row">
							<div class="col-md-2 col-md-offset-3">
								<button type="submit" class="btn btn-default btn-block" name="submit" value="save">
									<i class="fas fa-save"></i> <?=translate('update')?>
								</button>
							</div>
						</div>
					</footer>
				<?php echo form_close(); ?>
			</div>
		</div>
	</div>
</section>
