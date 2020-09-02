<?php
$attributes = ['class' => '', 'id' => '_contact'];
echo form_open_multipart($form_action, $attributes);
?>
    <div class="form-group">
        <label for="name">
            <?=$this->lang->line('application_name');?> *
        </label>
        <input id="name" type="text" name="name" class="required form-control"  value="<?php if(isset($contact)){echo $contact->name;}?>"  required/>
    </div>
    <div class="form-group">
        <label for="street">
            <?=$this->lang->line('application_department');?>
        </label>
        <input id="department" type="text" name="department" class="form-control"  value="<?php if(isset($contact)){echo $contact->department;}?>"/>
    </div>
    <div class="form-group">
        <label for="number">
            <?=$this->lang->line('application_email');?>
        </label>
        <input id="email" type="text" name="email" class="form-control"  value="<?php if(isset($contact)){echo $contact->email;}?>"/>
    </div>
    <div class="form-group">
        <label for="city">
            <?=$this->lang->line('application_phone');?>
        </label>
        <input id="phone" type="text" name="phone" class="form-control"  value="<?php if(isset($contact)){echo $contact->phone;}?>"/>
    </div>

    <div class="modal-footer">
        <input type="submit" class="btn btn-primary" value="
			<?=$this->lang->line('application_save');?>"/>
        <a class="btn" data-dismiss="modal">
            <?=$this->lang->line('application_close');?>
        </a>
    </div>
<?php echo form_close(); ?>
<script>
    $(document).ready(function() {
        $('#phone').mask('(00)00000-0000', {reverse: false})

    });
</script>
