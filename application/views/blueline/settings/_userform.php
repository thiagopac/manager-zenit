<?php 
$attributes = ['class' => '', 'id' => 'user_form'];
echo form_open_multipart($form_action, $attributes);
?>

<div class="form-group">
        <label for="username"><?=$this->lang->line('application_username');?> *</label>
        <input id="username" type="text" name="username" class="required form-control"  value="<?php if (isset($user)) {
    echo $user->username;
} ?>"  required/>
</div>
<div class="form-group">
        <label for="firstname"><?=$this->lang->line('application_firstname');?> *</label>
        <input id="firstname" type="text" name="firstname" class="required form-control"  value="<?php if (isset($user)) {
    echo $user->firstname;
} ?>"  required/>
</div>
<div class="form-group">
        <label for="lastname"><?=$this->lang->line('application_lastname');?> *</label>
        <input id="lastname" type="text" name="lastname" class="required form-control"  value="<?php if (isset($user)) {
    echo $user->lastname;
} ?>"  required/>
</div>
<div class="form-group">
        <label for="email"><?=$this->lang->line('application_email');?> *</label>
        <input id="email" type="email" name="email" class="required email form-control" value="<?php if (isset($user)) {
    echo $user->email;
} ?>"  required/>
</div>
<div class="form-group">
        <label for="password"><?=$this->lang->line('application_password');?> <?php if (!isset($user)) {
    echo '*';
} ?></label>
        <input id="password" type="password" name="password" class="form-control "  minlength="6" <?php if (!isset($user)) {
    echo 'required';
} ?>/>
</div>
<div class="form-group">
        <label for="password"><?=$this->lang->line('application_confirm_password');?> <?php if (!isset($user)) {
    echo '*';
} ?></label>
        <input id="confirm_password" type="password" name="confirm_password" class="form-control" data-match="#password" />
</div>

<div class="form-group">
                <label for="userfile"><?=$this->lang->line('application_profile_picture');?></label>
                <div>
                    <input id="uploadFile" type="text" name="dummy" class="form-control uploadFile" placeholder="<?=$this->lang->line('application_choose_file');?>" disabled="disabled" />
                          <div class="fileUpload btn btn-primary">
                              <span><i class="icon dripicons-upload"></i><span class="hidden-xs"> <?=$this->lang->line('application_select');?></span></span>
                              <input id="uploadBtn" type="file" name="userfile" class="upload" />
                          </div>
                  </div>
              </div> 

<div class="form-group">
        <label for="signature"><?=$this->lang->line('application_signature');?></label>
        <input id="signature" name="signature" class="form-control" value="<?php if (isset($user)) {
    echo $user->signature;
} ?>"/>

</div>

    <div class="form-group">
        <label for="push_active"><?=$this->lang->line('application_push_notification_receive'); ?></label>
        <?php $options = [
            '1' => $this->lang->line('application_yes'),
            '0' => $this->lang->line('application_no')
        ]; ?>

        <?php
        if (isset($user)) {
            $push_active = $user->push_active;
        } else {
            $push_active = '0';
        }
        echo form_dropdown('push_active', $options, $push_active, 'style="width:100%" class="chosen-select"'); ?>
    </div>

<?php if (!isset($agent)) {
    ?>
<div class="form-group">
        <label for="title"><?=$this->lang->line('application_user_role'); ?> *</label>
        <input id="title" type="text" name="title" class="required form-control"  value="<?php if (isset($user)) {
        echo $user->title;
    } ?>"  required/>
</div>
<div class="form-group">
        <label for="status"><?=$this->lang->line('application_ticket_queue'); ?></label>   
        <?php $options = [];
    foreach ($queues as $value):
                $options[$value->id] = $value->name;
    endforeach;

    if (isset($user->queue)) {
        $queue = $user->queue;
    } else {
        $queue = '';
    }
    echo form_dropdown('queue', $options, $queue, 'style="width:100%" class="chosen-select"'); ?>
</div>
<div class="form-group">
        <label for="status"><?=$this->lang->line('application_status'); ?></label>   
        <?php $options = [
                                'active' => $this->lang->line('application_active'),
                                'inactive' => $this->lang->line('application_inactive')
                               ]; ?>

        <?php 
        if (isset($user)) {
            $status = $user->status;
        } else {
            $status = 'active';
        }
    echo form_dropdown('status', $options, $status, 'style="width:100%" class="chosen-select"'); ?>
</div>
<div class="form-group">
        <label for="admin"><?=$this->lang->line('application_super_admin'); ?></label>        
        <?php $options = [
                                '1' => $this->lang->line('application_yes'),
                                '0' => $this->lang->line('application_no')
                               ]; ?>

        <?php 
        if (isset($user)) {
            $admin = $user->admin;
        } else {
            $admin = '0';
        }
    echo form_dropdown('admin', $options, $admin, 'style="width:100%" class="chosen-select"'); ?>
</div>
<div class="form-group">
    <label for="admin"><?=$this->lang->line('application_departments_worker_has_functions'); ?></label>
    <?php
    $options = array();
    $department = array();

    foreach ($departments as $value):
        $options[$value->id] = $value->name;
    endforeach;

    if(isset($worker_departments)){}else{$department = "";}

    foreach ($worker_departments as $value):
        $department[$value->department_id] = $value->department_id;
    endforeach;

    echo form_dropdown('department_id[]', $options, $department, 'style="width:100%" class="chosen-select" data-placeholder="'.$this->lang->line('application_select_departments').'" multiple tabindex="3"');
    ?>
</div>

<?php
} ?> 
<?php if (!isset($agent) && $this->user->admin == '1') {
        $access = [];
        if (isset($user)) {
            $access = explode(',', $user->access);
        } ?>


<div class="form-group">
<label><?=$this->lang->line('application_module_access'); ?></label>
<ul class="accesslist">

  <?php foreach ($modules as $key => $value) {
            if ($value->type == 'widget' && !isset($wi)) {
                ?>
     <label>Widgets</label>
    <?php $wi = true;
            } ?>

<li> <input type="checkbox" class="checkbox" id="r_<?=$value->link; ?>" name="access[]" data-labelauty="<?=$this->lang->line('application_' . $value->link); ?>" value="<?=$value->id; ?>" <?php if (in_array($value->id, $access)) {
                echo 'checked="checked"';
            } ?>>  </li>
<?php
        } ?>
</ul>
</div>
<?php
    } ?>


        <div class="modal-footer">
        <input type="submit" name="send" class="btn btn-primary" value="<?=$this->lang->line('application_save');?>"/>
        <a class="btn" data-dismiss="modal"><?=$this->lang->line('application_close');?></a>
        </div>

<?php echo form_close(); ?>