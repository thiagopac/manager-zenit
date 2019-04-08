<div id="row">

	<?php include 'settings_menu.php'; ?>

	<div class="col-md-9 col-lg-10">
		<div class="box-shadow">
		<div class="table-head">
			<?=$this->lang->line('application_agents');?>
				<span class="pull-right">
					<a href="<?=base_url()?>settings/user_create" class="btn btn-primary" data-toggle="mainmodal">
						<?=$this->lang->line('application_create_agent');?>
					</a>
				</span>
		</div>
		<div class="table-div responsive">
			<table id="users" class="data-no-search table" cellspacing="0" cellpadding="0">
				<thead>
					<th style="width:10px"></th>
					<th class="hidden-xs">
						<?=$this->lang->line('application_username');?>
					</th>
					<th>
						<?=$this->lang->line('application_full_name');?>
					</th>
					<th class="hidden-xs">
						<?=$this->lang->line('application_user_role');?>
					</th>
					<th class="hidden-sm hidden-xs hidden-md hidden-lg">
						<?=$this->lang->line('application_email');?>
					</th>
					<th class="hidden-xs">
						<?=$this->lang->line('application_status');?>
					</th>
					<th class="hidden-xs">
						<?=$this->lang->line('application_super_admin');?>
					</th>
					<th class="hidden-sm hidden-xs hidden-md">
						<?=$this->lang->line('application_last_login');?>
					</th>
					<th>
						<?=$this->lang->line('application_action');?>
					</th>
				</thead>
				<?php foreach ($users as $user):?>

				<tr id="<?=$user->id;?>">
					<td style="width:10px">
						<img class="minipic" src="<?=$user->userpic?>" />
					</td>
					<td class="hidden-xs">
						<?=$user->username;?>
					</td>
					<td>
						<?php echo $user->firstname . ' ' . $user->lastname;?>
					</td>
					<td class="hidden-xs">
						<?=$user->title;?>
					</td>
					<td class="hidden-sm hidden-xs hidden-md hidden-lg">
						<p class="truncate">
							<?=$user->email;?>
						</p>
					</td>
					<td class="hidden-xs">
						<span class="label label-<?php if ($user->status == 'active') {
    echo 'success ';
} else {
    echo 'important ';
} ?>">
							<?=$this->lang->line('application_' . $user->status);?>
						</span>
					</td>
					<td class="hidden-xs">
						<span class="label label-<?php if ($user->admin == '1') {
    echo 'success ';
} else {
    echo '';
} ?>">
							<?php if ($user->admin) {
    echo $this->lang->line('application_yes');
} else {
    echo $this->lang->line('application_no');
}?>
						</span>
					</td>
					<td class="hidden-xs hidden-md hidden-sm">
						<span>
							<?php if (!empty($user->last_login)) {
    echo date($core_settings->date_format . ' ' . $core_settings->date_time_format, $user->last_login);
} else {
    echo '-';
}?>
						</span>
					</td>

					<td class="option" width="8%">
						<button type="button" class="btn-option delete po" data-toggle="popover" data-placement="left" data-content="<a class='btn btn-danger po-delete ajax-silent' href='<?=base_url()?>settings/user_delete/<?=$user->id;?>'><?=$this->lang->line('application_yes_im_sure');?></a> <button class='btn po-close'><?=$this->lang->line('application_no');?></button> <input type='hidden' name='td-id' class='id' value='<?=$user->id;?>'>"
						 data-original-title="<b><?=$this->lang->line('application_really_delete');?></b>">
							<i class="icon dripicons-cross"></i>
						</button>
						<a href="<?=base_url()?>settings/user_update/<?=$user->id;?>" class="btn-option" data-toggle="mainmodal">
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