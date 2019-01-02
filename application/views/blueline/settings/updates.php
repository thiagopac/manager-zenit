<div id="row">

	<?php include 'settings_menu.php'; ?>

	<div class="col-md-9 col-lg-10">
		<div class='alert alert-warning'>
			<?=$this->lang->line('application_always_make_backup');?>
		</div>
		<div class='alert alert-info'>You are running version
			<?=$core_settings->version;?>
		</div>
		<?php if ($writable == 'FALSE') : ?>
		<div class='alert alert-danger'>No write permissions to the following folders
			<b>/application/</b> and
			<b>/assets/</b>
			<br> Please change the permissions of those folders temporary to 777 in order to install the updates. Change the permissions
			back to 755 after you have installed all updates.</div>
		<?php endif; ?>

		<?php if ($version_mismatch != 'FALSE') : ?>
			<div class='alert alert-danger'>Your database version does not match with file version!</div>
		<?php endif; ?>

		<?php if (!function_exists('zip_open')) : ?>
		<div class='alert alert-danger'>Your server is missing the
			<strong>php_zip</strong> extension! The installation of updates might not work so please contact your hosting provider in order
			to activate it.</div>
		<?php endif; ?>

		<?php if (phpversion() < '5.6') : ?>
		<div class='alert alert-danger'>
			Your servers <b>PHP version is too old</b> (<?=phpversion()?>). In order to install the latest updates you need to have <b>PHP 5.6</b> or higher.<br>
			Please contact your hosting provider in order to ugrade your PHP version!
		</div>
		<?php endif; ?>

		<?php if ($curl_error) : ?>
		<div class='alert alert-danger'>Could not connect to update server. Please check if php_curl extension is enabled!</div>
		<?php endif; ?>

		<div class="box-shadow">
			<div class="table-head">
				<?=$this->lang->line('application_system_updates');?>
					<span class="pull-right">
						<a href="<?=base_url()?>settings/updates" class="btn btn-primary">
							<i class="icon dripicons-retweet"></i>
							<?=$this->lang->line('application_check_for_updates');?>
						</a>
						<a href="<?=base_url()?>settings/mysql_backup" class="btn btn-primary">
							<i class="icon dripicons-download"></i>
							<?=$this->lang->line('application_backup_database');?>
						</a>
					</span>
			</div>
			<div class="table-div">
				<table id="updates" class="table" cellspacing="0" cellpadding="0">
					<thead>
						<th>
							<?=$this->lang->line('application_update');?>
						</th>
						<th>
							<?=$this->lang->line('application_release_date');?>
						</th>
						<th>
							<?=$this->lang->line('application_info');?>
						</th>
						<th>
							<?=$this->lang->line('application_action');?>
						</th>
					</thead>
					<?php  $first = false; $supported = true;
                        foreach ($lists as $key => $file):
                        if ($file->version > $core_settings->version) {
                            $updatenews = '';
                            if (isset($file->updatenews)) {
                                $updatenews = $file->updatenews;
                            }
                            if (isset($file->supported)) {
                                $supported = $file->supported;
                            } ?>

					<tr>
						<td>
							<?php echo 'Core ' . $file->version; ?>
							<?=($file->beta == 1) ? '<b>Beta</b>' : ''?>
						</td>
						<td>
							<?=$file->date; ?>
						</td>
						<td>
							<a href="<?=base_url()?>settings/updateinfo/<?=str_replace('.', '-', $file->version)?>" data-toggle="mainmodal">
								<?=$this->lang->line('application_view_changelog'); ?>
							</a>
						</td>

						<td class="option">
						<?php if ($first) {
                                echo $this->lang->line('application_previous_update_required');
                            } else {
                                ?>

							<a <?=(array_key_exists($file->file, $downloaded_updates) || phpversion() < '5.6') ? 'class="btn btn-xs disabled" disabled="disabled"' : 'href="update_download/' . str_replace('.', '-', $file->version) . '" class="btn btn-xs btn-success button-loader"'; ?>>
								<?=$this->lang->line('application_download'); ?>
							</a>
							<a <?=(array_key_exists($file->file, $downloaded_updates) && $writable == 'TRUE') ? 'href="update_install/' . str_replace('.', '-', $file->version) . '/' . $updatenews . '" class="btn btn-xs btn-success button-loader"' : 'class="btn btn-xs btn-option disabled" disabled="disabled"'; ?>>
								<?=$this->lang->line('application_install'); ?>
							</a>

					<?php
                            } ?>
						</td>
					</tr>

					<?php $first = true;
                        } endforeach;
                    if (!$first) {
                        ?>
						<tr>
							<td colspan="4">
								<?=$this->lang->line('application_system_up_to_date'); ?>
							</td>
						</tr>
				<?php
                    } ?>
				</table>

				<?php if ($supported == null) {
                        ?>
				<div class='alert alert-warning'>Your support has been expired.
					<a href="http://codecanyon.net/item/freelance-cockpit-2-project-management/4203727" target="_blank">Please renew your support.</a>
				</div>
				<?php
                    } ?>

			</div>
		</div>
	</div>
</div>
