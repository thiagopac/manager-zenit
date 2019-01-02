<div id="row">

	<?php include 'settings_menu.php'; ?>

	<div class="col-md-9 col-lg-10">
		<div class="box-shadow">
		<div class="table-head">
			<?=$this->lang->line('application_client');?>
				<?=$this->lang->line('application_registration');?>
		</div>
		<div class="table-div">
			<?php
        $attributes = ['class' => '', 'id' => 'paypal'];
        echo form_open_multipart($form_action, $attributes);
        ?>
			<br>
			<div class="form-group">
				<label>
					<?=$this->lang->line('application_clients_can_register');?>
				</label>
				<input name="registration" type="checkbox" class="checkbox" style="width:100%;" data-labelauty="<?=$this->lang->line('application_clients_can_register');?>"
				 value="1" <?php if ($settings->registration == '1') {
            ?> checked="checked"
				<?php
        } ?>>

			</div>

			<?php

$access = explode(',', $settings->default_client_modules);
?>


				<div class="form-group">
					<label>
						<?=$this->lang->line('application_default_client_module_access');?>
					</label>
					<ul class="accesslist">
						<?php foreach ($client_modules as $key => $value) {
    if ($value->type == 'widget' && !isset($wi)) {
        ?>
						<label>Widgets</label>
						<?php $wi = true;
    } ?>

						<li>
							<input type="checkbox" class="checkbox" id="r_<?=$value->link; ?>" name="access[]" data-labelauty="<?=$this->lang->line('application_' . $value->link); ?>"
							 value="<?=$value->id; ?>" <?php if (in_array($value->id, $access)) {
        echo 'checked="checked"';
    } ?>> </li>
						<?php
} ?>
					</ul>
				</div>



				<div class="form-group no-border">

					<input type="submit" name="send" class="btn btn-primary" value="<?=$this->lang->line('application_save');?>" />
				</div>

				<?php echo form_close(); ?>

		</div>
	</div>
	</div>
