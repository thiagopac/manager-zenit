<div id="row">

	<?php include 'settings_menu.php'; ?>

	<div class="col-md-9 col-lg-10">
	<div class="box-shadow">
		<div class="table-head">
			<?=$this->lang->line('application_bank_transfer');?>
				<?=$this->lang->line('application_settings');?>
		</div>
		<div class="table-div">
			<?php 
        $attributes = ['class' => '', 'id' => 'banktransfer'];
        echo form_open_multipart($form_action, $attributes);
        ?>
			<br>
			<div class="form-group">
				<label>
					<?=$this->lang->line('application_bank_transfer_active');?>
				</label>
				<input name="bank_transfer" type="checkbox" class="checkbox" style="width:100%;" data-labelauty="<?=$this->lang->line('application_bank_transfer_active');?>"
				 value="1" <?php if ($settings->bank_transfer == '1') {
            ?> checked="checked"
				<?php
        } ?>>

			</div>
			<div class="form-group">
				<label>
					<?=$this->lang->line('application_bank_transfer_details');?>
				</label>
				<textarea name="bank_transfer_text" class="form-control summernote"><?=$settings->bank_transfer_text;?></textarea>
			</div>


			<div class="form-group no-border">

				<input type="submit" name="send" class="btn btn-primary" value="<?=$this->lang->line('application_save');?>" />
			</div>

			<?php echo form_close(); ?>

		</div>
	</div>
	</div>