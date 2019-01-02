<div id="row">

	<?php include 'settings_menu.php'; ?>

	<div class="col-md-9 col-lg-10">

		<div class="box-shadow">
		<div class="table-head">
			<?=$this->lang->line('application_cronjob');?>
				<?=$this->lang->line('application_settings');?>
		</div>
		<div class="table-div settings">
		<div class="row">
		<div class="col-md-6">
			<div class="form-header">
				<?=$this->lang->line('application_main_cronjob');?>
			</div>
			<?php
        $attributes = ['class' => '', 'id' => 'cronjob'];
        echo form_open_multipart($form_action, $attributes);
        ?>
			<br>
			<div class="form-group tt">
				<label>
					<?=$this->lang->line('application_cronjob_active');?>
						<a class="cursor po " data-toggle="popover" data-placement="right" data-content="<?=$this->lang->line('application_cronjob_help');?> <a target='_blank' href='https://luxsys.helpscoutdocs.com/article/16-cronjob-configuration'>More help!</a>"
						 data-original-title="<?=$this->lang->line('application_cronjob_active');?>">
							<i class="icon dripicons-question"></i>
						</a>
				</label>
				<input name="cronjob" type="checkbox" class="checkbox" data-labelauty="<?=$this->lang->line('application_cronjob_active');?>"
				 value="1" <?php if ($settings->cronjob == '1') {
            ?> checked="checked"
				<?php
        } ?>>
			</div>


			<div class="form-group tt" title="<?=$this->lang->line('application_autobackup_help');?>">
				<label>
					<?=$this->lang->line('application_autobackup');?>
				</label>
				<input name="autobackup" type="checkbox" class="checkbox" data-labelauty="<?=$this->lang->line('application_autobackup');?>"
				 value="1" <?php if ($settings->autobackup == '1') {
            ?> checked="checked"
				<?php
        } ?>>
			</div>


			<div class="form-group">

				<label>
					<?=$this->lang->line('application_cronjob_address');?>
						<a class="cursor po" href="#" data-toggle="popover" data-placement="right" rel="popover" data-content="<?=$this->lang->line('application_cronjob_address_help');?>"
						 data-original-title="<?=$this->lang->line('application_cronjob_address');?>">
							<i class="icon dripicons-question"></i>
						</a>
				</label>
				<br>
				<small style="padding-left:10px">
					<span class="tag">
						<?=base_url()?>cronjob</span>
				</small>
			</div>


			<div class="form-group">
				<label>
					<?=$this->lang->line('application_last_cronjob_run');?>
				</label>
				<br>
				<small style="padding-left:10px">
					<span class="tag tag--grey">
						<?php if (!empty($settings->last_cronjob)) {
            echo date('Y-m-d H:i', $settings->last_cronjob);
        } else {
            echo '-';
        }?>
					</span>
				</small>
			</div>
			<div class="form-group no-border">
				<small style="padding-left:10px" class="highlight-text">Se os cronjobs não estiverem ativos na hospedagem, utilizar um serviço gratuito como
					<a href="http://www.easycron.com?ref=18097" target="_blank">EasyCron</a>
				</small>
			</div>

			<div class="form-group no-border">
				<input type="submit" name="send" class="btn btn-primary" value="<?=$this->lang->line('application_save');?>" />
			</div>

			<?php echo form_close(); ?>
		</div>
		<div class="col-md-6">
			<div class="form-header">
				<?=$this->lang->line('application_notifications_cronjob');?>
			</div>
			<?php
        $attributes = ['class' => '', 'id' => 'cronjob'];
        echo form_open_multipart($form_action2, $attributes);
        ?>
			<br>
			<div class="form-group tt">
				<label>
					<?=$this->lang->line('application_notifications_cronjob');?>
						<a class="cursor po " data-toggle="popover" data-placement="right" data-content="<?=$this->lang->line('application_notification_cronjob_help');?> "
						 data-original-title="<?=$this->lang->line('application_notifications_cronjob');?>">
							<i class="icon dripicons-question"></i>
						</a>
				</label>
				<input name="notifications" type="checkbox" class="checkbox" data-labelauty="<?=$this->lang->line('application_notifications_cronjob');?>"
				 value="1" <?php if ($settings->notifications == '1') {
            ?> checked="checked"
				<?php
        } ?>>
			</div>


			<div class="form-group">

				<label>
					<?=$this->lang->line('application_cronjob_address');?>
						<a class="cursor po" href="#" data-toggle="popover" data-placement="right" rel="popover" data-content="<?=$this->lang->line('application_cronjob_address_help');?>"
						 data-original-title="<?=$this->lang->line('application_cronjob_address');?>">
							<i class="icon dripicons-question"></i>
						</a>
				</label>
				<br>
				<small style="padding-left:10px">
					<span class="tag">
						<?=base_url()?>notifications</span>
				</small>
			</div>

			<div class="form-group">
				<label>
					<?=$this->lang->line('application_last_cronjob_run');?>
				</label>
				<br>
				<small style="padding-left:10px">
					<span class="tag tag--grey">
						<?php if (!empty($settings->last_notification)) {
            echo date('Y-m-d H:i', $settings->last_notification);
        } else {
            echo '-';
        }?>
					</span>
				</small>
			</div>
			<div class="form-group no-border">
				<input type="submit" name="send" class="btn btn-primary" value="<?=$this->lang->line('application_save');?>" />
			</div>
			<?php echo form_close(); ?>

		</div>

	</div>
	</div>
   </div>
  </div>
</div>
