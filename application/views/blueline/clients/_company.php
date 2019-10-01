<?php
$attributes = ['class' => '', 'id' => '_company'];
echo form_open_multipart($form_action, $attributes);
?>

<?php if (isset($company)) {
    ?>
<input id="id" type="hidden" name="id" value="<?=$company->id; ?>" />
<?php
} ?>
<?php if (isset($view)) {
        ?>
<input id="view" type="hidden" name="view" value="true" />
<?php
    } ?>

<div class="form-group">

        <label for="reference"><?=$this->lang->line('application_reference_id');?> *</label>
        <?php if (!empty($core_settings->company_prefix)) {
        ?>
       <div class="input-group"> <div class="input-group-addon"><?=$core_settings->company_prefix; ?></div> <?php
    } ?>
        <input id="reference" type="text" name="reference" class="required form-control"  value="<?php if (isset($company)) {
        echo $company->reference;
    } else {
        echo $core_settings->company_reference;
    } ?>"   readonly="readonly"  />
        <?php if (!empty($core_settings->company_prefix)) {
        ?></div> <?php
    } ?>
</div>

<?php if (isset($company)) {
        ?>
<div class="form-group">
        <label for="contact"><?=$this->lang->line('application_primary_contact'); ?></label>
        <?php $options = [];
        $options['0'] = '-';
        foreach ($company->client as $value):
                $options[$value->id] = $value->firstname . ' ' . $value->lastname;
        endforeach;
        if (is_object($company->client)) {
            $client = $company->client->id;
        } else {
            $client = '0';
        }
        echo form_dropdown('client_id', $options, $client, 'style="width:100%" class="chosen-select"'); ?>
</div>
<?php
    } ?>

<div class="form-group">
        <label for="name"><?=$this->lang->line('application_name');?> *</label>
        <input id="name" type="text" name="name" class="required form-control" value="<?php if (isset($company)) {
        echo $company->name;
    } ?>"  required/>
</div>

<!-- WEBSITE DO CLIENTE / ESCONDIDO -->
<!-- <div class="form-group">
        <label for="website"><?=$this->lang->line('application_website');?></label>
         <div class="input-group"> <div class="input-group-addon">http://</div>
        <input id="website" type="text" name="website" class="form-control" value="<?php if (isset($company)) {
        echo $company->website;
    } ?>" />
        </div>
</div> -->

<div class="form-group">
        <label for="phone"><?=$this->lang->line('application_phone');?></label>
        <input id="phone" type="text" name="phone" class="form-control" value="<?php if (isset($company)) {
        echo $company->phone;
    }?>" />
</div>
<div class="form-group">
        <label for="mobile"><?=$this->lang->line('application_mobile');?></label>
        <input id="mobile" type="text" name="mobile" class="form-control" value="<?php if (isset($company)) {
        echo $company->mobile;
    }?>" />
</div>
<div class="form-group">
        <label for="address"><?=$this->lang->line('application_address');?></label>
        <input id="address" type="text" name="address" class="form-control" value="<?php if (isset($company)) {
        echo $company->address;
    }?>" />
</div>
<div class="form-group">
        <label for="zipcode"><?=$this->lang->line('application_zip_code');?></label>
        <input id="zipcode" type="text" name="zipcode" class="form-control" value="<?php if (isset($company)) {
        echo $company->zipcode;
    }?>" />
</div>
<div class="form-group">
        <label for="city"><?=$this->lang->line('application_city');?></label>
        <input id="city" type="text" name="city" class="form-control" value="<?php if (isset($company)) {
        echo $company->city;
    }?>" />
</div>

<div class="form-group">
    <label for="province">
        <?=$this->lang->line('application_province');?>
    </label>
    <?php
    $settings = Setting::first();
    $statesList = $settings->list_states();

    echo form_dropdown('province', $statesList, $company->province, 'style="width:100%" class="chosen-select"');?>
</div>
<div class="form-group">
    <label for="country">
        <?=$this->lang->line('application_country');?>
    </label>
    <?php
    $settings = Setting::first();
    $countriesList = $settings->list_countries();

    echo form_dropdown('country', $countriesList, $company->country,'style="width:100%" class="chosen-select"');?>
</div>

<!-- IMPOSTO SOBRE O VALOR AGREGADO - IVA / ESCONDIDO -->
<!-- <div class="form-group">
        <label for="vat"><?=$this->lang->line('application_vat');?></label>
        <input id="vat" type="text" name="vat" class="form-control" value="<?php if (isset($company)) {
        echo $company->vat;
    }?>" />
</div> -->

 <div class="form-group">
        <label for="terms"><?=$this->lang->line('application_terms');?></label>
        <textarea id="terms" name="terms" class="textarea summernote-modal form-control" style="height:100px"><?php if (isset($company)) {
        echo $company->terms;
    }?></textarea>
 </div>

        <div class="modal-footer">
        <input type="submit" name="send" class="btn btn-primary" value="<?=$this->lang->line('application_save');?>"/>
        <a class="btn" data-dismiss="modal"><?=$this->lang->line('application_close');?></a>
        </div>
<?php echo form_close(); ?>
