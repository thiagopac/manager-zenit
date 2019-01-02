<?php   
$attributes = array('class' => '', 'id' => '_company');
echo form_open_multipart($form_action, $attributes); 
?>

<div class="form-group">
        <label for="reference"><?=$this->lang->line('application_reference_id');?> *</label>
        <input id="reference" type="text" name="reference" class="required form-control"  value="<?php echo $client_reference; ?>"   readonly="readonly"  required/>
</div>
<div class="form-group">
        <label for="name"><?=$this->lang->line('application_company');?> <?=$this->lang->line('application_name');?> *</label>
        <input id="name" type="text" name="name" class="required form-control" value="<?php if(isset($client)){echo $client->company;} ?>"  required/>
</div>
<div class="form-group">
        <label for="website"><?=$this->lang->line('application_website');?> </label>
        <input id="website" type="text" name="website" class="required form-control" value="<?php if(isset($company)){echo $company->website;} ?>" />
</div>
<div class="form-group">
        <label for="phone"><?=$this->lang->line('application_phone');?> *</label>
        <input id="phone" type="text" name="phone" class="required form-control" value="<?php if(isset($client)){echo $client->phone;}?>" required/>
</div>
<div class="form-group">
        <label for="mobile"><?=$this->lang->line('application_mobile');?></label>
        <input id="mobile" type="text" name="mobile" class="form-control" value="" />
</div>
<div class="form-group">
        <label for="address"><?=$this->lang->line('application_address');?> *</label>
        <input id="address" type="text" name="address" class="required form-control" value="<?php if(isset($client)){echo $client->address;}?>" required/>
</div>
<div class="form-group">
        <label for="zipcode"><?=$this->lang->line('application_zip_code');?> *</label>
        <input id="zipcode" type="text" name="zipcode" class="required form-control" value="<?php if(isset($client)){echo $client->zip;}?>" required/>
</div>
<div class="form-group">
        <label for="city"><?=$this->lang->line('application_city');?> *</label>
        <input id="city" type="text" name="city" class="required form-control" value="<?php if(isset($client)){echo $client->city;}?>" required/>
</div>
        <div class="modal-footer">
        <input type="submit" name="send" class="btn btn-primary" value="<?=$this->lang->line('application_save');?>"/>
        <a class="btn" data-dismiss="modal"><?=$this->lang->line('application_close');?></a>
        </div>

<?php echo form_close(); ?>