<?php   
$attributes = array('class' => 'dynamic-form', 'data-reload' => 'task-list', 'id' => '_task');
echo form_open($form_action, $attributes); 
?>

<?php if(isset($task)){ ?>
  <input id="id" type="hidden" name="id" value="<?php echo $task->id; ?>" />
<?php } ?>
<input name="public" type="hidden" value="1"/>
<input name="created_by_client" type="hidden" value="<?=$this->client->id;?>"/>
 <div class="form-group">
        <label for="name"><?=$this->lang->line('application_task_name');?> *</label>
        <input id="name" type="text" name="name" class="form-control resetvalue" value="<?php if(isset($task)){echo $task->name;} ?>"  required/>
</div>
 <div class="form-group">
        <label for="priority"><?=$this->lang->line('application_priority');?></label>
        <?php $prioritys = array();
                $prioritys['0'] = '-';
                $prioritys['1'] = $this->lang->line('application_low_priority');
                $prioritys['2'] = $this->lang->line('application_med_priority');
                $prioritys['3'] = $this->lang->line('application_high_priority');
        if(isset($task)){$priority = $task->priority;}else{$priority = "2";}
        echo form_dropdown('priority', $prioritys, $priority, 'style="width:100%" class="chosen-select"');?>
</div> 
 <div class="form-group">
        <label for="status"><?=$this->lang->line('application_status');?></label>
        <?php $options = array(
                  'open'  => $this->lang->line('application_open'),
                  'done'    => $this->lang->line('application_done'),
                );
                $status = FALSE;
                if(isset($task)){ $status = $task->status;} 
                echo form_dropdown('status', $options, $status, 'style="width:100%" class="chosen-select"'); ?>
</div>  
<!--
 <div class="form-group">
        <label for="user"><?=$this->lang->line('application_assign_to');?></label>
        <?php $users = array();
                $users['0'] = '-';
                 foreach ($project->project_has_workers as $workers):
                    $users[$workers->user_id] = $workers->user->firstname.' '.$workers->user->lastname;
                endforeach;
        if(isset($task)){$user = $task->user_id;}else{$user = $this->user->id;}
        echo form_dropdown('user_id', $users, $user, 'style="width:100%" class="chosen-select"');?>
</div> 
-->
 <div class="form-group">
        <label for="contacts"><?=$this->lang->line('application_assign_to');?></label>
        <?php $contact = array();
                $contacts['0'] = '-';
                 foreach ($project->company->clients as $workers):
                    $contacts[$workers->id] = $workers->firstname.' '.$workers->lastname;
                endforeach;
        if(isset($task)){$contact = $task->client_id;}else{$contact = $this->client->id;}
        echo form_dropdown('client_id', $contacts, $contact, 'style="width:100%" class="chosen-select"');?>
</div> 
 <div class="form-group">
        <label for="value"><?=$this->lang->line('application_value');?></label>
        <input id="value" type="text" name="value" class="form-control decimal" value="<?php if(isset($task)){echo $task->value;} ?>" />
</div>
<div class="form-group">
                          <label for="due_date"><?=$this->lang->line('application_due_date');?></label>
                          <input class="form-control datepicker not-required" name="due_date" id="due_date" type="text" value="<?php if(isset($task)){echo $task->due_date;} ?>" />
</div>

 <div class="form-group">
                        <label for="textfield"><?=$this->lang->line('application_description');?></label>
                        <textarea class="input-block-level summernote-modal"  id="textfield" name="description"><?php if(isset($task)){echo $task->description;} ?></textarea>
</div>


        <div class="modal-footer">
          <?php if(isset($task)){ ?>
            <a href="<?=base_url()?>cprojects/tasks/<?=$task->project_id;?>/delete/<?=$task->id;?>" class="btn btn-danger pull-left button-loader" ><?=$this->lang->line('application_delete');?></a>
          <?php }else{  ?>
         <a class="btn btn-default pull-left" data-dismiss="modal"><?=$this->lang->line('application_close');?></a>
        <i class="icon dripicons-loading spin-it" id="showloader" style="display:none"></i> 
        <button id="send" name="send" data-keepModal="true" class="btn btn-primary send button-loader"><?=$this->lang->line('application_save_and_add');?></button>
        <?php } ?>
        <button name="send" class="btn btn-primary send button-loader"><?=$this->lang->line('application_save');?></button>
        </div>
<?php echo form_close(); ?>