<?php 
$attributes = ['class' => '', 'id' => 'user_form'];
echo form_open_multipart($form_action, $attributes);
?>
        <input type="hidden" name="created" value="<?=date('Y-m-d H:i:s')?>"/>

<div class="form-group">
        <label for="username"><?= $this->lang->line('application_username'); ?> *</label>
        <input id="username" type="text" name="username" class="required form-control"  value="Admin"  required/>
</div>
<div class="form-group">
        <label for="firstname"><?= $this->lang->line('application_firstname'); ?> *</label>
        <input id="firstname" type="text" name="firstname" class="required form-control"  value=""  required/>
</div>
<div class="form-group">
        <label for="lastname"><?= $this->lang->line('application_lastname'); ?> *</label>
        <input id="lastname" type="text" name="lastname" class="required form-control"  value=""  required/>
</div>
<div class="form-group">
        <label for="email"><?= $this->lang->line('application_email'); ?> *</label>
        <input id="email" type="email" name="email" class="required email form-control" value=""  required/>
</div>
<div class="form-group">
        <label for="password"><?= $this->lang->line('application_password'); ?> *</label>
        <input id="password" type="password" name="password" class="required form-control "  minlength="6" required/>
</div>
<div class="form-group">
        <label for="password"><?= $this->lang->line('application_confirm_password'); ?> *</label>
        <input id="confirm_password" type="password" name="confirm_password" class="required form-control" data-match="#password" required/>
</div>


<div class="form-group">
        <label for="title"><?= $this->lang->line('application_user_role'); ?> *</label>
        <input id="title" type="text" name="title" class="required form-control"  value="Administrator"  required/>
</div>

        <div class="modal-footer">
        <input type="submit" name="send" class="btn btn-primary" value="<?= $this->lang->line('application_save'); ?>"/>
        </div>

<?php echo form_close(); ?>