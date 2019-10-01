<div class="row">

	<div class="col-md-12">
		<h2>
			<?=$company->name;?>
		</h2>
	</div>
</div>
<div class="row">
	<div class="col-md-3 marginbottom20">
	<div class="box-shadow">
		<div class="table-head">
			<?=$this->lang->line('application_company_details');?>
				<span class="pull-right">
					<a href="<?=base_url()?>clients/company/update/<?=$company->id;?>/view" class="btn btn-primary" data-toggle="mainmodal">
						<i class="icon-edit"></i>
						<?=$this->lang->line('application_edit');?>
					</a>
		</div>
		<div class="subcont">
			<ul class="details col-md-12">
				<li>
					<span>
						<?=$this->lang->line('application_company_name');?>:</span>
					<?php echo $company->name = empty($company->name) ? '-' : $company->name; ?>
				</li>
				<li>
					<span>
						<?=$this->lang->line('application_primary_contact');?>:</span>
					<?php if (is_object($company->client)) {
    echo $company->client->firstname . ' ' . $company->client->lastname;
} else {
    echo '-';
} ?>
				</li>
				<li>
					<span>
						<?=$this->lang->line('application_email');?>:</span>
					<?php if (is_object($company->client) && $company->client->email != '') {
    echo $company->client->email;
} else {
    echo '-';
} ?>
				</li>

				<!-- WEBSITE DO CLIENTE / APAGADO -->
				<!-- <li>
					<span>
						<?=$this->lang->line('application_website');?>:</span>
					<?php echo $company->website = empty($company->website) ? '-' : '<a target="_blank" href="http://' . $company->website . '">' . $company->website . '</a>' ?>
				</li> -->

				<li>
					<span>
						<?=$this->lang->line('application_phone');?>:</span>
					<?php echo $company->phone = empty($company->phone) ? '-' : $company->phone; ?>
				</li>
				<li>
					<span>
						<?=$this->lang->line('application_mobile');?>:</span>
					<?php echo $company->mobile = empty($company->mobile) ? '-' : $company->mobile; ?>
				</li>


			</ul>
			<span class="visible-xs"></span>
			<ul class="details col-md-12">

				<!-- IMPOSTO SOBRE O VALOR AGREGADO - IVA / APAGADO -->
				<!-- <?php if ($company->vat != '') { ?>
				<li>
					<span>
						<?=$this->lang->line('application_vat'); ?>:</span>
					<?php echo $company->vat; ?>
				</li>
				<?php } ?> -->

					<li>
						<span>
							<?=$this->lang->line('application_address');?>:</span>
						<?php echo $company->address = empty($company->address) ? '-' : $company->address; ?>
					</li>
					<li>
						<span>
							<?=$this->lang->line('application_zip_code');?>:</span>
						<?php echo $company->zipcode = empty($company->zipcode) ? '-' : $company->zipcode; ?>
					</li>
					<li>
						<span>
							<?=$this->lang->line('application_city');?>:</span>
						<?php echo $company->city = empty($company->city) ? '-' : $company->city; ?>
					</li>
					<li>
						<span>
							<?=$this->lang->line('application_province');?>:</span>
						<?php echo $company->province = empty($company->province) ? '-' : $company->province; ?>
					</li>
					<li>
						<span>
							<?=$this->lang->line('application_country');?>:</span>
						<?php echo $company->country = empty($company->country) ? '-' : $company->country; ?>
					</li>

			</ul>
			<br clear="all">
		</div>
		</div>
		<br clear="all">
		<div class="box-shadow">
		<?php $attributes = ['class' => 'note-form', 'id' => '_notes'];
                echo form_open(base_url() . 'client/notes/' . $company->id, $attributes); ?>
		<div class="table-head">
			<?=$this->lang->line('application_notes');?>
				<span class=" pull-right">
					<a id="send" name="send" class="btn btn-primary">
						<?=$this->lang->line('application_save');?>
					</a>
				</span>
				<span id="changed" class="pull-right label label-warning">
					<?=$this->lang->line('application_unsaved');?>
				</span>
		</div>

		<textarea class="input-block-level summernote-note" name="note" id="textfield"><?=$company->note;?></textarea>
		</form>
</div>
	</div>

	<div class="col-md-9">
		<?php if (!array_key_exists(0, $company->client)) {
                    ?>
		<div class="alert alert-warning">
			<?=$this->lang->line('application_client_has_no_contacts'); ?>
				<a href="<?=base_url()?>clients/create/<?=$company->id; ?>" data-toggle="mainmodal">
					<?=$this->lang->line('application_add_new_contact'); ?>
				</a>
		</div>
		<?php
                } ?>
			<div class="data-table-marginbottom">
				<div class="box-shadow">
					<div class="table-head">
						<?=$this->lang->line('application_contacts');?>
							<span class="pull-right">
								<a href="<?=base_url()?>clients/create/<?=$company->id;?>" class="btn btn-primary" data-toggle="mainmodal">
									<?=$this->lang->line('application_add_new_contact');?>
								</a>
							</span>
					</div>

					<div class="table-div responsive">
						<table id="contacts" class="data-no-search table" rel="<?=base_url()?>" cellspacing="0" cellpadding="0">
							<thead>
								<th style="width:10px"></th>
								<th>
									<?=$this->lang->line('application_name');?>
								</th>
								<th class="hidden-xs">
									<?=$this->lang->line('application_email');?>
								</th>
								<th class="hidden-xs">
									<?=$this->lang->line('application_phone');?>
								</th>
								<th class="hidden-xs">
									<?=$this->lang->line('application_mobile');?>
								</th>
                                    <!-- REDES SOCIAIS NA GRADE DE CONTATO AO CLIENTE / ESCONDIDO -->
<!--								<th class="hidden-xs">-->
<!--									--><?//=$this->lang->line('application_social_media');?>
<!--								</th>-->
								<th class="hidden-xs">
									<?=$this->lang->line('application_last_login');?>
								</th>
								<th>
									<?=$this->lang->line('application_action');?>
								</th>
							</thead>
							<?php foreach ($company->client as $value):?>

							<tr id="<?=$value->id;?>">
								<td style="width:10px" class="sorting_disabled">
									<img class="minipic" src="<?=$value->userpic?>" />
								</td>
								<td>
									<?=$value->firstname;?>
										<?=$value->lastname;?>
								</td>
								<td class="hidden-xs">
									<?=$value->email;?>
								</td>
								<td class="hidden-xs">
									<?=$value->phone;?>
								</td>
								<td class="hidden-xs">
									<?=$value->mobile;?>
								</td>

								<td class="hidden-xs">
									<?php if (!empty($value->last_login)) {
                    echo date($core_settings->date_format . ' ' . $core_settings->date_time_format, $value->last_login);
                } else {
                    echo '-';
                } ?>
								</td>

								<td class="option" style="text-align:left; text-wrap:nowrap " width="9%">
									<a href="<?=base_url()?>clients/credentials/<?=$value->id;?>" class="btn-option tt" title="<?=$this->lang->line('application_email_login_details');?>"
									data-toggle="mainmodal">
										<i class="icon dripicons-mail"></i>
									</a>
									<button type="button" class="btn-option delete po" data-toggle="popover" data-placement="left" data-content="<a class='btn btn-danger po-delete ajax-silent' href='<?=base_url()?>clients/delete/<?=$value->id;?>'><?=$this->lang->line('application_yes_im_sure');?></a> <button class='btn po-close'><?=$this->lang->line('application_no');?></button> <input type='hidden' name='td-id' class='id' value='<?=$value->id;?>'>"
									data-original-title="<b><?=$this->lang->line('application_really_delete');?></b>">
										<i class="icon dripicons-cross"></i>
									</button>
									<a href="<?=base_url()?>clients/update/<?=$value->id;?>" title="<?=$this->lang->line('application_edit');?>" class="btn-option"
									data-toggle="mainmodal">
										<i class="icon dripicons-gear"></i>
									</a>
								</td>
							</tr>

							<?php endforeach;?>
						</table>
					</div>
				</div>
			</div>
	</div>

	<div class="col-md-9">
		<?php if (!array_key_exists(0, $company->users)) {
                    ?>
		<div class="alert alert-warning">
			<?=$this->lang->line('application_client_has_no_admins'); ?>
				<?php if ($this->user->admin == 1) {
                        ?>
				<a href="<?=base_url()?>clients/assign/<?=$company->id; ?>" data-toggle="mainmodal">
					<?=$this->lang->line('application_assign_admin'); ?>
				</a>
				<?php
                    } ?>
		</div>
		<?php
                } ?>
			<div class="data-table-marginbottom">
				<div class="box-shadow">
					<div class="table-head">
						<?=$this->lang->line('application_client_admins');?>
							<?php if ($this->user->admin == 1) {
                    ?>
							<span class="pull-right">
								<a href="<?=base_url()?>clients/assign/<?=$company->id; ?>" class="btn btn-primary" data-toggle="mainmodal">
									<?=$this->lang->line('application_assign_admin'); ?>
								</a>
							</span>
							<?php
                } ?>
					</div>
					<div class="table-div responsive">
						<table id="clientadmins" class="data-no-search table" rel="<?=base_url()?>" cellspacing="0" cellpadding="0">
							<thead>
								<th style="width:10px"></th>
								<th>
									<?=$this->lang->line('application_name');?>
								</th>
								<th class="hidden-xs">
									<?=$this->lang->line('application_email');?>
								</th>
								<th class="hidden-xs">
									<?=$this->lang->line('application_last_login');?>
								</th>
								<?php if ($this->user->admin == 1) {
                    ?>
								<th>
									<?=$this->lang->line('application_action'); ?>
								</th>
								<?php
                } ?>
							</thead>
							<?php foreach ($company->users as $value):?>

							<tr id="<?=$value->id;?>">
								<td style="width:10px" class="sorting_disabled">
									<img class="minipic" src="<?=$value->userpic?>" />
								</td>
								<td>
									<?=$value->firstname;?>
										<?=$value->lastname;?>
								</td>
								<td class="hidden-xs">
									<?=$value->email;?>
								</td>
								<td class="hidden-xs">
									<?php if (!empty($value->last_login)) {
                    echo date($core_settings->date_format . ' ' . $core_settings->date_time_format, $value->last_login);
                } else {
                    echo '-';
                } ?>
								</td>
								<?php if ($this->user->admin == 1) {
                    ?>
								<td class="option" style="text-align:center; text-wrap:nowrap " width="4%">
									<button type="button" class="btn-option delete po" data-toggle="popover" data-placement="left" data-content="<a class='btn btn-danger po-delete ajax-silent' href='<?=base_url()?>clients/removeassigned/<?=$value->id; ?>/<?=$company->id?>'><?=$this->lang->line('application_yes_im_sure'); ?></a> <button class='btn po-close'><?=$this->lang->line('application_no'); ?></button> <input type='hidden' name='td-id' class='id' value='<?=$value->id; ?>'>"
									data-original-title="<b><?=$this->lang->line('application_really_delete'); ?></b>">
										<i class="icon dripicons-cross"></i>
									</button>
								</td>
								<?php
                } ?>
							</tr>

							<?php endforeach;?>
						</table>
					</div>
				</div>
			</div>
	</div>

	<?php if ($project_access == true) {
                    ?>
	<div class="col-md-9">
		<div class="data-table-marginbottom">
			<div class="box-shadow">
				<div class="table-head">
					<?=$this->lang->line('application_projects'); ?>
				</div>
				<div class="table-div responsive">
					<table id="projects" class="data-no-search table" rel="<?=base_url()?>" cellspacing="0" cellpadding="0">
						<thead>
							<th class="hidden-xs" style="width:70px">
								<?=$this->lang->line('application_project_id'); ?>
							</th>
							<th>
								<?=$this->lang->line('application_name'); ?>
							</th>
							<th>
								<?=$this->lang->line('application_progress'); ?>
							</th>
						</thead>
						<?php foreach ($company->projects as $value):?>

						<tr id="<?=$value->id; ?>">
							<td class="hidden-xs" style="width:70px">
								<?=$core_settings->project_prefix; ?>
									<?=$value->reference; ?>
							</td>
							<td>
								<?=$value->name; ?>
							</td>
							<td class="hidden-xs">
								<div class="progress progress-striped active progress-medium tt <?php if ($value->progress == ' 100 ') {
                        ?>progress-success<?php
                    } ?>" title="<?=$value->progress; ?>%">
									<div class="bar" style="width:<?=$value->progress; ?>%"></div>
								</div>
							</td>
						</tr>

						<?php endforeach; ?>
					</table>
					<?php if (!$company->projects) {
                        ?>
					<div class="no-files">
						<i class="icon dripicons-lightbulb"></i>
						<br>

						<?=$this->lang->line('application_no_projects_yet'); ?>
					</div>
					<?php
                    } ?>
				</div>
			</div>
		</div>
	</div>
	<?php
                } ?>
		<?php if ($invoice_access == true) {
                    ?>
		<div class="col-md-9">
			<div class="data-table-marginbottom">
				<div class="box-shadow">
					<div class="table-head">
						<?=$this->lang->line('application_invoices'); ?>
					</div>
					<div class="table-div responsive">
						<table id="invoices" class="data-no-search table" rel="<?=base_url()?>" cellspacing="0" cellpadding="0">
							<thead>
								<th width="70px">
									<?=$this->lang->line('application_invoice_id'); ?>
								</th>
								<th class="hidden-xs">
									<?=$this->lang->line('application_issue_date'); ?>
								</th>
								<th class="hidden-xs">
									<?=$this->lang->line('application_due_date'); ?>
								</th>
								<th>
									<?=$this->lang->line('application_status'); ?>
								</th>
							</thead>
							<?php foreach ($invoices as $value):?>

							<tr id="<?=$value->id; ?>">
								<td>
									<?=$core_settings->invoice_prefix; ?>
										<?=$value->reference; ?>
								</td>
								<td class="hidden-xs">
									<span class="label">
										<?php $unix = human_to_unix($value->issue_date);
                    echo date($core_settings->date_format, $unix); ?>
									</span>
								</td>
								<td class="hidden-xs">
									<span class="label <?php if ($value->status == ' Paid ') {
                        echo 'label-success';
                    }
                    if ($value->due_date <= date('Y-m-d') && $value->status != 'Paid ') {
                        echo 'label-important tt" title="' . $this->lang->line('application_overdue');
                    } ?>">
										<?php $unix = human_to_unix($value->due_date);
                    echo date($core_settings->date_format, $unix); ?>
									</span>
								</td>
								<td>
									<span class="label <?php $unix = human_to_unix($value->sent_date);
                    if ($value->status == ' Paid ') {
                        echo 'label-success';
                    } elseif ($value->status == 'Sent ') {
                        echo 'label-warning tt" title="' . date($core_settings->date_format, $unix);
                    } ?>">
										<?=$this->lang->line('application_' . $value->status); ?>
									</span>
								</td>
							</tr>
							<?php endforeach; ?>
						</table>
						<?php if (!$company->invoices) {
                        ?>
						<div class="no-files">
							<i class="icon dripicons-document"></i>
							<br>

							<?=$this->lang->line('application_no_invoices_yet'); ?>
						</div>
						<?php
                    } ?>
					</div>
				</div>
			</div>
		</div>
		<?php
                } ?>
</div>
