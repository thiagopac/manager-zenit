<div id="row">

	<?php include 'settings_menu.php'; ?>

	<div class="col-md-9 col-lg-10">
		<div class="box-shadow">
		<div class="table-head">
			<?=$this->lang->line('application_calendar');?>
				<?=$this->lang->line('application_settings');?>
		</div>
		<div class="table-div">
			<br>
			<span class="highlight-text">
				<?=$this->lang->line('application_google_calendar_integration_help');?>:
					<a href="http://luxsys.helpscoutdocs.com/article/20-google-calendar-integration" target="_blank">Google Calendar Integration</a>
			</span>

			<?php 
        $attributes = ['class' => '', 'id' => 'calendar'];
        echo form_open_multipart($form_action, $attributes);
        ?>
			<br>
			<div class="form-group">

				<label>
					<?=$this->lang->line('application_calendar_google_api_key');?>
				</label>
				<input type="text" name="calendar_google_api_key" class="form-control" value="<?=$settings->calendar_google_api_key;?>">
			</div>
			<div class="form-group">
				<label>
					<?=$this->lang->line('application_calendar_google_event_address');?>
				</label>
				<input type="text" name="calendar_google_event_address" class="form-control" value="<?=$settings->calendar_google_event_address;?>">
			</div>


			<div class="form-group no-border">

				<input type="submit" name="send" class="btn btn-primary" value="<?=$this->lang->line('application_save');?>" />
			</div>

			<?php echo form_close(); ?>

		</div>
	</div>
	</div>