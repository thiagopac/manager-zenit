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
        foreach ($company->clients as $value):
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
    <label for="province"><?=$this->lang->line('application_province');?></label>
    <input id="province" type="text" maxlength="2" name="province" class="form-control" value="<?php if (isset($company)) {
        echo $company->province;
    }?>" />
</div>
<div class="form-group">
        <label for="country"><?=$this->lang->line('application_country');?></label>
        <input id="country" type="text" name="country" class="form-control" value="<?php if (isset($company)) {
        echo $company->country;
    }?>" />
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

<!-- REDES SOCIAIS DO CLIENTE / ESCONDIDO -->
<!-- <div class="row">
    <div class="col-md-6">
        <div class="form-group">
                <label for="twitter">Twitter</label>
                <input id="twitter" type="text" name="twitter" class="form-control" value="<?php if (isset($company)) {
        echo $company->twitter;
    }?>" />
        </div>
        <div class="form-group">
                <label for="skype">Skype</label>
                <input id="skype" type="text" name="skype" class="form-control" value="<?php if (isset($company)) {
        echo $company->skype;
    }?>" />
        </div>
        <div class="form-group">
                <label for="linkedin">LinkedIn</label>
                <input id="linkedin" type="text" name="linkedin" class="form-control" value="<?php if (isset($company)) {
        echo $company->linkedin;
    }?>" />
        </div>
        <div class="form-group">
                <label for="facebook">Facebook</label>
                <input id="facebook" type="text" name="facebook" class="form-control" value="<?php if (isset($company)) {
        echo $company->facebook;
    }?>" />
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
                <label for="instagram">Instagram</label>
                <input id="instagram" type="text" name="instagram" class="form-control" value="<?php if (isset($company)) {
        echo $company->instagram;
    }?>" />
        </div>
        <div class="form-group">
                <label for="googleplus">Google Plus</label>
                <input id="googleplus" type="text" name="googleplus" class="form-control" value="<?php if (isset($company)) {
        echo $company->googleplus;
    }?>" />
        </div>
        <div class="form-group">
                <label for="youtube">Youtube</label>
                <input id="youtube" type="text" name="youtube" class="form-control" value="<?php if (isset($company)) {
        echo $company->youtube;
    }?>" />
        </div>
        <div class="form-group">
                <label for="pinterest">Pinterest</label>
                <input id="pinterest" type="text" name="pinterest" class="form-control" value="<?php if (isset($company)) {
        echo $company->pinterest;
    }?>" />
        </div>
    </div>
</div> -->

        <div class="modal-footer">
        <input type="submit" name="send" class="btn btn-primary" value="<?=$this->lang->line('application_save');?>"/>
        <a class="btn" data-dismiss="modal"><?=$this->lang->line('application_close');?></a>
        </div>
<?php echo form_close(); ?>
