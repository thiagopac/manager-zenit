<?php 
$attributes = array('class' => '', 'id' => '_company');
echo form_open_multipart($form_action, $attributes);
?>

<?php if (isset($lead)) {
    ?>
<input id="id" type="hidden" name="id" value="<?=$lead->id; ?>" />
<?php
} ?>
	<?php if (isset($view)) {
        ?>
	<input id="view" type="hidden" name="view" value="true" />
	<?php
    } ?>

		<div class="form-group">

			<label for="reference">
				<?=$this->lang->line('application_reference_id');?> *</label>
			<?php if (!empty($core_settings->company_prefix)) {
        ?>
			<div class="input-group">
				<div class="input-group-addon">
					<?=$core_settings->company_prefix; ?>
				</div>
				<?php
    } ?>
					<input id="reference" type="text" name="reference" class="required form-control" value="<?=$core_settings->company_reference;?>"
					/>
					<?php if (!empty($core_settings->company_prefix)) {
        ?>
			</div>
			<?php
    } ?>
		</div>

		<div class="form-group">
			<label for="name">
				<?=$this->lang->line('application_company');?>
			</label>
			<input id="name" type="text" name="name" class="required form-control" value="<?php if (isset($lead)) {
        echo $lead->company;
    } ?>" />
		</div>
		<div class="form-group">
			<label for="name">
				<?=$this->lang->line('application_firstname');?> *</label>
			<input id="name" type="text" name="firstname" class="form-control" value="<?php if (isset($lead)) {
        $name = explode(" ", $lead->name);
        echo $name[0];
    } ?>" required/>
		</div>
		<div class="form-group">
			<label for="name">
				<?=$this->lang->line('application_lastname');?> *</label>
			<input id="name" type="text" name="lastname" class="form-control" value="<?php if (isset($lead)) {
        echo (array_key_exists(1, $name)) ? $name[1] : " ";
    } ?>" required/>
		</div>
		<div class="form-group">
			<label for="name">
				<?=$this->lang->line('application_email');?> *</label>
			<input id="name" type="text" name="email" class="form-control" value="<?php if (isset($lead)) {
        echo $lead->email;
    } ?>" required/>
		</div>
		<div class="form-group">
			<label for="name">
				<?=$this->lang->line('application_password');?> *</label>
			<input id="name" type="text" name="password" class="form-control" value="" required/>
		</div>
		<div class="form-group">
			<label for="website">
				<?=$this->lang->line('application_website');?>
			</label>
			<div class="input-group">
				<input id="website" type="text" name="website" class="form-control" value="<?php if (isset($lead)) {
        echo $lead->website;
    } ?>" />
			</div>
		</div>
		<div class="form-group">
			<label for="phone">
				<?=$this->lang->line('application_phone');?>
			</label>
			<input id="phone" type="text" name="phone" class="form-control" value="<?php if (isset($lead)) {
        echo $lead->phone;
    }?>" />
		</div>
		<div class="form-group">
			<label for="mobile">
				<?=$this->lang->line('application_mobile');?>
			</label>
			<input id="mobile" type="text" name="mobile" class="form-control" value="<?php if (isset($lead)) {
        echo $lead->mobile;
    }?>" />
		</div>
		<div class="form-group">
			<label for="address">
				<?=$this->lang->line('application_address');?>
			</label>
			<input id="address" type="text" name="address" class="form-control" value="<?php if (isset($lead)) {
        echo $lead->address;
    }?>" />
		</div>
		<div class="form-group">
			<label for="zipcode">
				<?=$this->lang->line('application_zip_code');?>
			</label>
			<input id="zipcode" type="text" name="zipcode" class="form-control" value="<?php if (isset($lead)) {
        echo $lead->zipcode;
    }?>" />
		</div>
		<div class="form-group">
			<label for="city">
				<?=$this->lang->line('application_city');?>
			</label>
			<input id="city" type="text" name="city" class="form-control" value="<?php if (isset($lead)) {
        echo $lead->city;
    }?>" />
		</div>
		<div class="form-group">
			<label for="country">
				<?=$this->lang->line('application_country');?>
			</label>
			<input id="country" type="text" name="country" class="form-control" value="<?php if (isset($lead)) {
        echo $lead->country;
    }?>" />
		</div>
		<div class="form-group">
			<label for="province">
				<?=$this->lang->line('application_province');?>
			</label>
			<input id="province" type="text" name="province" class="form-control" value="<?php if (isset($lead)) {
        echo $lead->state;
    }?>" />
		</div>
		<div class="form-group">
			<label for="vat">
				<?=$this->lang->line('application_vat');?>
			</label>
			<input id="vat" type="text" name="vat" class="form-control" value="" />
		</div>

		<div class="form-group">
			<label for="terms">
				<?=$this->lang->line('application_terms');?>
			</label>
			<textarea id="terms" name="terms" class="textarea summernote-modal form-control" style="height:100px"></textarea>
		</div>
		<div class="row">
			<div class="col-md-6">
				<div class="form-group">
					<label for="twitter">Twitter</label>
					<input id="twitter" type="text" name="twitter" class="form-control" value="<?php if (property_exists($lead, 'twitter')) {
        echo $lead->twitter;
    }?>" />
				</div>
				<div class="form-group">
					<label for="skype">Skype</label>
					<input id="skype" type="text" name="skype" class="form-control" value="<?php if (property_exists($lead, 'skype')) {
        echo $lead->skype;
    }?>" />
				</div>
				<div class="form-group">
					<label for="linkedin">LinkedIn</label>
					<input id="linkedin" type="text" name="linkedin" class="form-control" value="<?php if (property_exists($lead, 'linkedin')) {
        echo $lead->linkedin;
    }?>" />
				</div>
				<div class="form-group">
					<label for="facebook">Facebook</label>
					<input id="facebook" type="text" name="facebook" class="form-control" value="<?php if (property_exists($lead, 'facebook')) {
        echo $lead->facebook;
    }?>" />
				</div>
			</div>
			<div class="col-md-6">
				<div class="form-group">
					<label for="instagram">Instagram</label>
					<input id="instagram" type="text" name="instagram" class="form-control" value="<?php if (property_exists($lead, 'instagram')) {
        echo $lead->instagram;
    }?>" />
				</div>
				<div class="form-group">
					<label for="googleplus">Google Plus</label>
					<input id="googleplus" type="text" name="googleplus" class="form-control" value="<?php if (property_exists($lead, 'googleplus')) {
        echo $lead->googleplus;
    }?>" />
				</div>
				<div class="form-group">
					<label for="youtube">Youtube</label>
					<input id="youtube" type="text" name="youtube" class="form-control" value="<?php if (property_exists($lead, 'youtube')) {
        echo $lead->youtube;
    }?>" />
				</div>
				<div class="form-group">
					<label for="pinterest">Pinterest</label>
					<input id="pinterest" type="text" name="pinterest" class="form-control" value="<?php if (property_exists($lead, 'pinterest')) {
        echo $lead->pinterest;
    }?>" />
				</div>
			</div>
		</div>

		<div class="form-group">
			<label>
				<?=$this->lang->line('application_module_access');?>
			</label>
			<ul class="accesslist">
				<?php foreach ($modules as $key => $value) {
        ?>
				<li>
					<input type="checkbox" class="checkbox" id="r_<?=$value->link; ?>" name="access[]" value="<?=$value->id; ?>" <?php if (in_array($value->id, $access)) {
            echo 'checked="checked"';
        } ?> data-labelauty="
					<?=$this->lang->line('application_'.$value->link); ?>"> </li>
				<?php
    } ?>
			</ul>
		</div>

		<div class="modal-footer">
			<input type="submit" name="send" class="btn btn-primary" value="<?=$this->lang->line('application_save');?>" />
			<a class="btn" data-dismiss="modal">
				<?=$this->lang->line('application_close');?>
			</a>
		</div>
		<?php echo form_close(); ?>