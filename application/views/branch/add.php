<section class="panel">
	<div class="tabs-custom">
		<ul class="nav nav-tabs">
			<li class="<?=(empty($validation_error) ? 'active' : '') ?>">
				<a href="#list" data-toggle="tab"><i class="fas fa-list-ul"></i> <?=translate('branch_list')?></a>
			</li>
			<li class="<?=(!empty($validation_error) ? 'active' : '') ?>">
				<a href="#create" data-toggle="tab"><i class="far fa-edit"></i> <?=translate('create_branch')?></a>
			</li>
		</ul>
		<div class="tab-content">
			<div id="list" class="tab-pane <?=(empty($validation_error) ? 'active' : '')?>">
				<div class="mb-md">
					<table class="table table-bordered table-hover table-condensed mb-none table-export">
						<thead>
							<tr>
								<th width="50"><?=translate('sl')?></th>
								<th><?=translate('branch_name')?></th>
								<th><?=translate('email')?></th>
								<th><?=translate('mobile_no')?></th>
								<th><?=translate('city')?></th>
								<th>Region</th>
								<th><?=translate('address')?></th>
								<th class="no-sort"><?=translate('action')?></th>
							</tr>
						</thead>
						<tbody>
							<?php 
								$count = 1;
								if (is_school_context()) {
									$this->db->where('school_profile_id', get_loggedin_school_profile_id());
								}
								$branchs = $this->db->get('branch')->result();
								foreach($branchs as $row):
							?>
							<tr>
								<td><?php echo $count++; ?></td>
								<td><?=html_escape($row->name)?></td>
								<td><?=html_escape($row->email)?></td>
								<td><?=html_escape($row->mobileno)?></td>
								<td><?=html_escape($row->city)?></td>
								<td><?=html_escape($row->state)?></td>
								<td><?=html_escape($row->address)?></td>
								<td class="min-w-c">

									<!--update link-->
									<a href="<?=base_url('branch/edit/'.$row->id)?>" class="btn btn-default btn-circle icon">
										<i class="fas fa-pen-nib"></i>
									</a>
									<!-- delete link -->
									<?php echo btn_delete('branch/delete_data/' . $row->id);?>
								</td>
							</tr>
							<?php endforeach; ?>
						</tbody>
					</table>
				</div>
			</div>
			<div class="tab-pane <?=(!empty($validation_error) ? 'active' : '')?>" id="create">
				<?php echo form_open($this->uri->uri_string(), array('class' => 'form-horizontal form-bordered validate')); ?>
					<div class="form-group mt-md">
						<label class="col-md-3 control-label"><?=translate('branch_name')?> <span class="required">*</span></label>
						<div class="col-md-6">
							<input type="text" class="form-control" name="branch_name" value="<?=set_value('branch_name')?>" placeholder="e.g. Mwanza Campus" />
							<span class="error"><?=form_error('branch_name') ?></span>
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-3 control-label"><?=translate('email')?></label>
						<div class="col-md-6">
							<input type="email" class="form-control" name="email" value="<?=set_value('email')?>" placeholder="Leave empty to use the school email">
							<span class="error"><?=form_error('email') ?></span>
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-3 control-label"><?=translate('mobile_no')?></label>
						<div class="col-md-6">
							<input type="text" class="form-control" name="mobileno" value="<?=set_value('mobileno')?>">
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-3 control-label"><?=translate('city')?></label>
						<div class="col-md-6">
							<input type="text" class="form-control" name="city" value="<?=set_value('city')?>">
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-3 control-label">Region</label>
						<div class="col-md-6">
							<input type="text" class="form-control" name="state" value="<?=set_value('state')?>" placeholder="e.g. Mwanza">
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-3 control-label"><?=translate('address')?></label>
						<div class="col-md-6 mb-md">
							<textarea rows="3" class="form-control" name="address"><?=set_value('address')?></textarea>
							<span class="help-block">School name, currency, timezone and logos come from the School Profile.</span>
						</div>
					</div>
					<footer class="panel-footer mt-lg">
						<div class="row">
							<div class="col-md-2 col-md-offset-3">
								<button type="submit" class="btn btn-default btn-block" name="submit" value="save">
									<i class="fas fa-plus-circle"></i> <?=translate('save')?>
								</button>
							</div>
						</div>
					</footer>
				<?php echo form_close();?>
			</div>
		</div>
	</div>
</section>