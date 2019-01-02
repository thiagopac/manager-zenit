<div id="row">

	<?php include 'settings_menu.php'; ?>

	<div class="col-md-9 col-lg-10">
		<div class="box-shadow">
		<div class="table-head">
			<?=$this->lang->line('application_paypal');?>
				<?=$this->lang->line('application_settings');?>
		</div>
		<div class="table-div">
			<?php 
        $attributes = ['class' => '', 'id' => 'paypal'];
        echo form_open_multipart($form_action, $attributes);
        ?>
			<br>

			<div class="form-group">
				<label>
					<?=$this->lang->line('application_paypal_active');?>
				</label>
				<input name="paypal" type="checkbox" class="checkbox" style="width:100%;" data-labelauty="<?=$this->lang->line('application_paypal_active');?>"
				 value="1" <?php if ($settings->paypal == '1') {
            ?> checked="checked"
				<?php
        } ?>>

			</div>
			<div class="form-group">
				<label>
					<?=$this->lang->line('application_paypal_account');?>
				</label>
				<input type="text" name="paypal_account" class="form-control" value="<?=$settings->paypal_account;?>">
			</div>
			<div class="form-group">
				<label>
					<?=$this->lang->line('application_paypal_currency');?>
				</label>

				<select name="paypal_currency" class="formcontrol chosen-select ">
					<?php if ($settings->paypal_currency != '') {
            ?>
					<option value="<?=$settings->paypal_currency; ?>" selected="">
						<?=$settings->paypal_currency; ?>
					</option>
					<?php
        } ?>
						<option value="USD" title="$">USD</option>
						<option value="AUD" title="$">AUD</option>
						<option value="BRL" title="R$">BRL</option>
						<option value="GBP" title="£">GBP</option>
						<option value="CAD" title="$">CAD</option>
						<option value="CZK" title="">CZK</option>
						<option value="DKK" title="">DKK</option>
						<option value="EUR" title="€">EUR</option>
						<option value="HKD" title="$">HKD</option>
						<option value="HUF" title="">HUF</option>
						<option value="ILS" title="₪">ILS</option>
						<option value="JPY" title="¥">JPY</option>
						<option value="MXN" title="$">MXN</option>
						<option value="TWD" title="NT$">TWD</option>
						<option value="NZD" title="$">NZD</option>
						<option value="NOK" title="">NOK</option>
						<option value="PHP" title="P">PHP</option>
						<option value="PLN" title="">PLN</option>
						<option value="SGD" title="$">SGD</option>
						<option value="SEK" title="">SEK</option>
						<option value="CHF" title="">CHF</option>
						<option value="THB" title="฿">THB</option>
						<option value="TRY" title="TRY">TRY</option>
						<option value="AED" title="AED">AED</option>
						
				</select>
			</div>
			<div class="form-group">
				<label>
					<?=$this->lang->line('application_paypal_ipn_address');?>
						<a class="cursor po " data-toggle="popover" data-placement="right" data-content="<?=$this->lang->line('application_paypal_ipn_help');?> <a target='_blank' href='https://luxsys.helpscoutdocs.com/article/15-paypal-ipn\'>More help!</a>"
						 data-original-title="<?=$this->lang->line('application_paypal_ipn_address');?>">
							<i class="icon dripicons-question"></i>
						</a>
				</label>
				<br>
				<small style="padding-left:10px">
					<span class="tag">
						<?=base_url()?>paypalipn</span>
				</small>
			</div>
			<div class="form-group no-border">

				<input type="submit" name="send" class="btn btn-primary" value="<?=$this->lang->line('application_save');?>" />
			</div>

			<?php echo form_close(); ?>

		</div>
	</div>
	</div>