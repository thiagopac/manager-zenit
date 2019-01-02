<div id="row">

	<?php include 'settings_menu.php'; ?>

	<div class="col-md-9 col-lg-10">
	<div class="box-shadow">
		<div class="table-head">
			<?=$this->lang->line('application_database_backups');?>
				<span class="pull-right">
					<a href="mysql_restore" class="btn btn-primary " data-toggle="mainmodal">
						<i class="icon dripicons-upload"></i>
						<?=$this->lang->line('application_restore_database');?>
					</a>
					<a href="<?=base_url()?>settings/mysql_backup" class="btn btn-primray">
						<i class="icon dripicons-stack"></i>
						<?=$this->lang->line('application_backup_database');?>
					</a>
				</span>
		</div>
		<div class="table-div settings">
			<table id="backup" class="table" cellspacing="0" cellpadding="0">
				<thead>
					<th>
						<?=$this->lang->line('application_date');?>
					</th>
					<th>
						<?=$this->lang->line('application_info');?>
					</th>
					<th>
						<?=$this->lang->line('application_action');?>
					</th>
				</thead>
				<?php if (isset($backups)) {
    arsort($backups);
    foreach ($backups as $file):
         $filename = explode('_', $file); ?>

				<tr>
					<td>
						<?php echo str_replace('.zip', '', $filename[1]); ?>
						<?php echo str_replace('.zip', '', $filename[2]); ?>
					</td>
					<td>
						<?php echo str_replace('-', ' ', $filename[0]); ?>
					</td>
					<td class="option" style="width:8%">
						<a class="btn-option tt" href="<?=base_url()?>settings/mysql_download/<?=str_replace('.zip', '', $file); ?>" title="<?=$this->lang->line('application_download'); ?>">
							<i class="icon dripicons-download"></i>
						</a>
					</td>
				</tr>

				<?php endforeach;
} else {
    ?>
				<tr>
					<td colspan="4">
						<?=$this->lang->line('application_no_backups'); ?>
					</td>
				</tr>
				<?php
} ?>
			</table>
		</div>
	</div>
</div>
</div>