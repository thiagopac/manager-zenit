<?php
$attributes = ['class' => '', 'id' => '_supplier'];
echo form_open_multipart($form_action, $attributes);
?>

<?php if (isset($supplier)) {
    ?>
<input id="id" type="hidden" name="id" value="<?=$supplier->id; ?>" />
<?php
} ?>
<?php if (isset($view)) {
        ?>
<input id="view" type="hidden" name="view" value="true" />
<?php
    } ?>

<div class="form-group">
        <label for="name"><?=$this->lang->line('application_name');?> *</label>
        <input id="name" type="text" name="name" class="required form-control" value="<?php if (isset($supplier)) {
        echo $supplier->name;
    } ?>"  required/>
</div>

<div class="form-group">
    <label for="name"><?=$this->lang->line('application_corporate_name');?> *</label>
    <input id="corporate_name" type="text" name="corporate_name" class="required form-control" value="<?php if (isset($supplier)) {
        echo $supplier->corporate_name;
    } ?>" />
</div>

<div class="form-group">
    <label for="name">
        <?=$this->lang->line('application_registered_number');?> *
    </label>
    <input id="registered_number" type="text" name="registered_number" class=" form-control" value="<?php if (isset($supplier)) {
        echo $supplier->registered_number;
    } ?>" />
</div>

<div class="form-group">
    <label for="name">
        <?=$this->lang->line('application_state_registration');?> *
    </label>
    <input id="state_registration" type="text" name="state_registration" class=" form-control" value="<?php if (isset($supplier)) {
        echo $supplier->state_registration;
    } ?>" />
</div>

<div class="form-group">
    <label for="name">
        <?=$this->lang->line('application_municipal_registration');?> *
    </label>
    <input id="municipal_registration" type="text" name="municipal_registration" class=" form-control" value="<?php if (isset($supplier)) {
        echo $supplier->municipal_registration;
    } ?>" />
</div>

<div class="form-group">
    <label for="address">
        <?=$this->lang->line('application_address');?> *
    </label>
    <input id="address" type="text" name="address" class=" form-control" value="<?php if (isset($supplier)) {
        echo $supplier->address;
    }?>" />
</div>

<div class="form-group">
    <label for="address">
        <?=$this->lang->line('application_neighborhood');?> *
    </label>
    <input id="neighborhood" type="text" name="neighborhood" class=" form-control" value="<?php if (isset($supplier)) {
        echo $supplier->neighborhood;
    }?>" />
</div>

<div class="form-group">
    <label for="phone">
        <?=$this->lang->line('application_city');?>
    </label>
    <input id="city" type="text" name="city" class="form-control" value="<?php if (isset($supplier)) {
        echo $supplier->city;
    }?>" />
</div>

<div class="form-group">
    <label for="state">
        <?=$this->lang->line('application_state');?> *
    </label>
    <?php
    $settings = Setting::first();
    $statesList = $settings->list_states();

    echo form_dropdown('state', $statesList, $supplier->state, 'style="width:100%" class="chosen-select"');?>
</div>

<div class="form-group">
    <label for="zipcode">
        <?=$this->lang->line('application_zip_code');?>
    </label>
    <input id="zipcode" type="text" name="zipcode" class="form-control" value="<?php if (isset($supplier)) {
        echo $supplier->zipcode;
    }?>" />
</div>

 <div class="form-group">
        <label for="website"><?=$this->lang->line('application_website');?></label>
         <div class="input-group"> <div class="input-group-addon">HTTP://</div>
        <input id="website" type="text" name="website" class="form-control" value="<?php if (isset($supplier)) { echo $supplier->website;} ?>" />
        </div>
</div>

<div class="form-group">
    <label for="phone">
        <?=$this->lang->line('application_contact');?>
    </label>
    <input id="contact" type="text" name="contact" class="form-control" value="<?php if (isset($supplier)) {
        echo $supplier->contact;
    }?>" />
</div>

<div class="form-group">
    <label for="phone">
        <?=$this->lang->line('application_phone');?>
    </label>
    <input id="phone" type="text" name="phone" class="form-control" value="<?php if (isset($supplier)) {
        echo $supplier->phone;
    }?>" />
</div>

<div class="form-group">
    <label for="phone">
        <?=$this->lang->line('application_email');?>
    </label>
    <input id="email" type="text" name="email" class="form-control" value="<?php if (isset($supplier)) {
        echo $supplier->email;
    }?>" />
</div>

<div class="form-group">
    <label for="phone">
        <?=$this->lang->line('application_payment_condition');?>
    </label>
    <input id="payment_condition" type="text" name="payment_condition" class="form-control" value="<?php if (isset($supplier)) {
        echo $supplier->payment_condition;
    }?>" />
</div>


<div class="form-group">
    <label for="users"><?=$this->lang->line('application_segments');?></label>
    <?php
    $options = array();
    $cats = array();

    foreach ($categories as $value):
        $options[$value->id] = $value->name;
    endforeach;

    if ($sup_cats != null){
        foreach ($sup_cats as $cat):
            $cats[$cat->id] = $cat->id;
        endforeach;
    }

    echo form_dropdown('supplier_categories[]', $options, $cats, 'style="width:100%" class="chosen-select" data-placeholder="'.$this->lang->line('application_select').'" multiple tabindex="3"');?>
</div>

<div class="form-group">
    <label for="phone">
        <?=$this->lang->line('application_supplier_deadline');?>
    </label>
    <input id="supplier_deadline" type="text" name="supplier_deadline" class="form-control" value="<?php if (isset($supplier)) {
        echo $supplier->supplier_deadline;
    }?>" />
</div>

<div class="form-group">
    <label for="contact"><?=$this->lang->line('application_bank'); ?></label>
    <?php $options = [];
    $options['0'] = '-';
    foreach ($banks as $bank):
        $options[$bank->id] = $bank->name;
    endforeach;
    echo form_dropdown('bank_id', $options, $supplier->bank_id, 'style="width:100%" class="chosen-select"'); ?>
</div>

<div class="form-group">
    <label for="phone">
        <?=$this->lang->line('application_branch');?>
    </label>
    <input id="branch" type="text" name="branch" class="form-control" value="<?php if (isset($supplier)) {
        echo $supplier->branch;
    }?>" />
</div>

<div class="form-group">
    <label for="phone">
        <?=$this->lang->line('application_account');?>
    </label>
    <input id="account" type="text" name="account" class="form-control" value="<?php if (isset($supplier)) {
        echo $supplier->account;
    }?>" />
</div>

        <div class="modal-footer">
        <input type="submit" name="send" class="btn btn-primary" value="<?=$this->lang->line('application_save');?>"/>
        <a class="btn" data-dismiss="modal"><?=$this->lang->line('application_close');?></a>
        </div>
<?php echo form_close(); ?>
<script>
    $(document).ready(function() {

        $('#registered_number').mask('00.000.000/0000-00', {reverse: false})
        $('#state_registration').mask('000000000.00-00', {reverse: false})
        $('#municipal_registration').mask('00.000/00-0', {reverse: false})

    });
</script>