<?php
$attributes = array('class' => 'dynamic-form', 'data-reload' => 'task-list', 'data-reload2' => 'milestones-tab', 'data-reload3' => 'milestones-tab', 'data-baseurl' => base_url(), 'id' => '_milestone');
echo form_open($form_action, $attributes);
$public = "0";
?>

<?php if(isset($task)){ $public = $task->public; ?>
  <input id="id" type="hidden" name="id" value="<?php echo $task->id; ?>" />
<?php } ?>
 <div class="form-group">
        <label for="name"><?=$this->lang->line('application_task_name');?> *</label>
        <input id="name" type="text" name="name" class="form-control resetvalue" value="<?php if(isset($task)){echo $task->name;} ?>"  required/>
</div>
<div class="row">
    <div class="col-md-6">
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
    </div>
    <div class="col-md-6">
         <div class="form-group">
                <label for="status"><?=$this->lang->line('application_status');?></label>
                <?php $options = array(
                          'open'  => $this->lang->line('application_Opened'),
                          'done'    => $this->lang->line('application_done'),
                        );
                        $status = FALSE;
                        if(isset($task)){ $status = $task->status;}
                        echo form_dropdown('status', $options, $status, 'style="width:100%" class="chosen-select"'); ?>
        </div>
    </div>
</div>

 <div class="form-group">
        <label for="user"><?=$this->lang->line('application_assign_to_agent');?></label>
        <?php $users = array();
                $users['0'] = '-';

        foreach ($existinUsers as $worker):
            $users[$worker->id] = $worker->firstname.' '.$worker->lastname;
        endforeach;

        if(isset($task)){$user = $task->user_id;}else{$user = $this->user->id;}
        echo form_dropdown('user_id', $users, $user, 'style="width:100%" class="chosen-select"');?>
</div>
<?php if($project->company_id != 0){?>
 <div class="form-group">
        <label for="client"><?=$this->lang->line('application_assign_to_client');?></label>
        <?php $clients = array();
                $clients['0'] = '-';
                 foreach ($project->company->clients as $workers):
                    $clients[$workers->id] = $workers->firstname.' '.$workers->lastname;
                endforeach;
        if(isset($task)){$client = $task->client_id;}else{$client = 0;}
        echo form_dropdown('client_id', $clients, $client, 'style="width:100%" class="chosen-select"');?>
</div>
<?php } ?>
 <div class="form-group">
        <label for="milestone_id"><?=$this->lang->line('application_milestone');?></label>
        <?php   $milestones = array();
                $milestones['0'] = '-';
                 foreach ($project->project_has_milestones as $milestone):
                    $milestones[$milestone->id] = $milestone->name;
                endforeach;
        if(isset($task)){$milestone_selected = $task->milestone_id;}else{$milestone_selected = "";}

        $milestone_id = $milestone_id != null ? $milestone_id : $task->milestone_id;

        if(isset($milestone_id)){$milestone_selected = $milestone_id;}else{$milestone_selected = "";}
//        $milestone_selected = 3;
        echo form_dropdown('milestone_id', $milestones, $milestone_selected, 'style="width:100%" class="chosen-select"');?>
</div>

 <!-- <div class="form-group">
        <label for="value"><?=$this->lang->line('application_value');?></label>
        <input id="value" type="text" name="value" class="form-control decimal" value="<?php if(isset($task)){echo $task->value;} ?>" />
</div> -->
<div class="row">
    <div class="col-md-6">
            <div class="form-group">
                                      <label for="start_date"><?=$this->lang->line('application_start_date');?></label>
                                      <input class="form-control datepicker-time not-required" data-enable-time=true name="start_date" id="start_date" type="text" value="<?php if(isset($task)){ echo $task->start_date;} ?>" />
            </div>
    </div>
    <div class="col-md-6">
            <div class="form-group">
                                      <label for="due_date"><?=$this->lang->line('application_due_date');?></label>
                                      <input class="form-control datepicker-time datepicker-time-linked not-required" data-enable-time=true name="due_date" id="due_date" type="text" value="<?php if(isset($task)){echo $task->due_date;} ?>" />
            </div>
    </div>
</div>
 <div class="form-group">
                        <label for="textfield"><?=$this->lang->line('application_description');?></label>
                        <textarea class="input-block-level summernote-modal" id="textfield" name="description"><?php if(isset($task)){echo $task->description;} ?></textarea>
</div>

<div class="form-group">
<label for="textfield"><?=$this->lang->line('application_visibility');?></label>
<ul class="accesslist">

                        <li>
                        <input name="public" class="checkbox" data-labelauty="<?=$this->lang->line('application_task_public');?>" value="1" type="checkbox" <?php if($public == "1"){ ?> checked="checked" <?php } ?> />
                        </li>
</ul>
</div>

        <div class="modal-footer">
          <?php if(isset($task)){ ?>
            <a href="<?=base_url()?>projects/tasks/<?=$task->project_id;?>/delete/<?=$task->id;?>" class="btn btn-danger pull-left button-loader" ><?=$this->lang->line('application_delete');?></a>
          <?php }else{  ?>
         <a class="btn btn-default pull-left" data-dismiss="modal"><?=$this->lang->line('application_close');?></a>
        <i class="icon dripicons-loading spin-it" id="showloader" style="display:none"></i>
        <button id="send" name="send" data-keepModal="true" class="btn btn-primary send button-loader"><?=$this->lang->line('application_save_and_add');?></button>
        <?php } ?>
        <button name="send" class="btn btn-primary send button-loader"><?=$this->lang->line('application_save');?></button>
        </div>
<?php echo form_close(); ?>
