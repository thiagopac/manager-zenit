<?php
$attributes = ['class' => '', 'id' => 'deposit_form'];
echo form_open_multipart($form_action, $attributes);
?>
    <div class="form-group">
        <label for="name">
            <?=$this->lang->line('application_name');?> *
        </label>
        <input id="name" type="text" name="name" class="required form-control"  value="<?php if(isset($deposit)){echo $deposit->name;}?>"  required/>
    </div>
    <div class="form-group">
        <label for="street">
            <?=$this->lang->line('application_street');?> *
        </label>
        <input id="street" type="text" name="street" class="required form-control"  value="<?php if(isset($deposit)){echo $deposit->street;}?>"  required/>
    </div>
    <div class="form-group">
        <label for="number">
            <?=$this->lang->line('application_number');?> *
        </label>
        <input id="number" type="text" name="number" class="required form-control"  value="<?php if(isset($deposit)){echo $deposit->number;}?>"  required/>
    </div>
    <div class="form-group">
        <label for="city">
            <?=$this->lang->line('application_city');?> *
        </label>
        <input id="city" type="text" name="city" class="required form-control"  value="<?php if(isset($deposit)){echo $deposit->city;}?>"  required/>
    </div>

    <div class="form-group">
    <label for="state">
        <?=$this->lang->line('application_federal_state');?> *
    </label>
    <?php
    $settings = Setting::first();
    $statesList = $settings->list_states();

    echo form_dropdown('state', $statesList, $deposit->state, 'style="width:100%" class="chosen-select"');?>
</div>
    <div class="modal-footer">
        <input type="submit" class="btn btn-primary" value="
			<?=$this->lang->line('application_save');?>"/>
        <a class="btn" data-dismiss="modal">
            <?=$this->lang->line('application_close');?>
        </a>
    </div>
<?php echo form_close(); ?>