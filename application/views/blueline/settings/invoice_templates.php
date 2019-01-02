<div id="row">

	<?php include 'settings_menu.php'; ?>

	<div class="col-md-9 col-lg-10">
	<div class="box-shadow">
		<div class="table-head">
			<?=$this->lang->line('application_pdf_settings');?>
		</div>
		<?php 
$attributes = ['class' => '', 'id' => 'template_form'];
echo form_open_multipart($form_action, $attributes);
?>
		<div class="table-div">
			<br>

			<div class="form-group">
				<label>Image path</label>
				<input name="pdf_path" type="checkbox" class="checkbox" style="width:100%;" data-labelauty="<?=$this->lang->line('application_pdf_path');?>"
				 value="1" <?php if ($settings->pdf_path == '1') {
    ?> checked="checked"
				<?php
} ?>>

			</div>

			<div class="form-group">
				<label>
					<?=$this->lang->line('application_pdf_font');?>
				</label>
				<?php $options = [];
            if ($handle = opendir('assets/' . $settings->template . '/fonts/')) {
                while (false !== ($entry = readdir($handle))) {
                    if ($entry != '.' && $entry != '..' && $entry != 'index.html') {
                        $apart = explode('.', $entry);
                        if ($apart[1] == 'ttf' || $apart[1] == 'TTF') {
                            $apart2 = explode('-', $apart[0]);
                            if (isset($apart2[1])) {
                                if (@$apart2[1] == 'Regular' || @$apart2[1] == 'regular') {
                                    $options[$apart2[0]] = ucwords($apart2[0]);
                                }
                            }
                        }
                    }
                }
                closedir($handle);
            }
            echo form_dropdown('pdf_font', $options, $settings->pdf_font, 'style="width:250px" class="chosen-select"'); ?>

			</div>
			<div class="form-group no-border">
				<input type="submit" name="send" class="btn btn-primary" value="<?=$this->lang->line('application_save');?>" />

			</div>

			<?php echo form_close(); ?>
		</div>
		</div>
	</div>

	<div class="col-md-9 col-lg-10">
	<div class="box-shadow">		
		<div class="table-head">
			<?=$this->lang->line('application_invoice_template');?>
		</div>

		<div class="table-div">
			<div class="row">
				<?php foreach ($invoice_template_files as $value): ?>
				<div class="col-md-3">
					<div class="template_container">
						<?php 
    $image = 'assets/blueline/images/invoice_' . $value . '.png';
    if (!is_file($image)) {
        $image = 'assets/blueline/images/invoice_no_preview.png';
    }
        ?>
						<img class="img-responsive" src="<?=base_url()?><?=$image?>" />

						<?php if ($active_template == $value) {
            ?>
						<div class="template_container_bottom active">
							<?=$this->lang->line('application_active'); ?>
						</div>
						<?php
        } else {
            ?>
							<div class="template_container_bottom">
								<a href="<?=base_url()?>settings/invoice_templates/invoice/<?=$value?>">
									<?=$this->lang->line('application_activate'); ?>
								</a>
							</div>
							<?php
        } ?>
					</div>
				</div>
				<?php endforeach;?>
			</div>


		</div>
	</div>
		<div class="box-shadow">
		<div class="table-head">
			<?=$this->lang->line('application_estimate_template');?>
		</div>

		<div class="table-div">
			<div class="row">
				<?php foreach ($estimate_template_files as $value): ?>
				<div class="col-md-3">
					<div class="template_container">
						<?php 
    $image = 'assets/blueline/images/invoice_' . $value . '.png';
    if (!is_file($image)) {
        $image = 'assets/blueline/images/invoice_no_preview.png';
    }
        ?>
						<img class="img-responsive" src="<?=base_url()?><?=$image?>" />
						<?php if ($active_estimate_template == $value) {
            ?>
						<div class="template_container_bottom active">
							<?=$this->lang->line('application_active'); ?>
						</div>
						<?php
        } else {
            ?>
							<div class="template_container_bottom">
								<a href="<?=base_url()?>settings/invoice_templates/estimate/<?=$value?>">
									<?=$this->lang->line('application_activate'); ?>
								</a>
							</div>
							<?php
        } ?>
					</div>
				</div>
				<?php endforeach;?>
			</div>


		</div>
	</div>

	</div>