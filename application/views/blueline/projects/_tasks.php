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
    <input id="name" type="text" name="name" class="form-control resetvalue" value="<?php if(isset($task)){echo $task->name;} ?>" <?=$this->user->admin == 0 ? "disabled" : "";?> required/>
</div>


<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label for="milestone_id"><?=$this->lang->line('application_milestone');?></label>
            <?php   $milestones = array();
            //    $milestones['0'] = '-';
            foreach ($project->project_has_milestones as $milestone):
                $milestones[$milestone->id] = $milestone->name;
            endforeach;
            if(isset($task)){$milestone_selected = $task->milestone_id;}else{$milestone_selected = "";}

            $milestone_id = $milestone_id != null ? $milestone_id : $task->milestone_id;

            if(isset($milestone_id)){$milestone_selected = $milestone_id;}else{$milestone_selected = "";}
            $disabled = $this->user->admin == 0 ? 'disabled' : '';
            echo form_dropdown('milestone_id', $milestones, $milestone_selected, "style='width:100%' class='chosen-select' $disabled ");?>
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group">
            <label for="scheduled_time"><?=$this->lang->line('application_scheduled_time');?> </label>
            <input id="scheduled_time" type="number" min="0" max="99" size="2" name="scheduled_time" class="form-control resetvalue" <?=$this->user->admin == 0 ? "disabled" : "";?> value="<?php if(isset($task)){echo $task->scheduled_time;} ?>" />
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

    $disabled = $this->user->admin == 0 ? 'disabled' : '';

    echo form_dropdown('user_id', $users, $user, "style='width:100%' class='chosen-select' $disabled ");?>
</div>

<div class="form-group">
    <label for="sucessors_ids"><?=$this->lang->line('application_sucessor_tasks');?></label>
    <?php
    $options = array();
    $sucessor = array();

    foreach ($tasks as $value):
        $options[$value->id] = $value->name;
    endforeach;

    if(isset($task)){}else{$sucessor = "";}

    $disabled = $this->user->admin == 0 ? 'disabled' : '';

    $label = $this->lang->line('application_select_tasks');

    echo form_dropdown('sucessors_ids[]', $options, $sucessors, "style='width:100%' class='chosen-select' $disabled data-placeholder='$label' multiple tabindex='3'");
    ?>
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

                $disabled = $this->user->admin == 0 ? 'disabled' : '';

                echo form_dropdown('priority', $prioritys, $priority, "style='width:100%' class='chosen-select' $disabled ");?>
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
                        echo form_dropdown('status', $options, $status, "style='width:100%' class='chosen-select' ");?>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
            <div class="form-group">
                                      <label for="start_date"><?=$this->lang->line('application_start_date');?></label>
                                      <input class="form-control datepicker-time not-required" data-enable-time=true name="start_date" id="start_date" type="text" value="<?php if(isset($task)){ echo $task->start_date;} ?>" <?=$this->user->admin == 0 ? "disabled" : "";?> />
            </div>
    </div>
    <div class="col-md-6">
            <div class="form-group">
                                      <label for="due_date"><?=$this->lang->line('application_due_date');?></label>
                                      <input class="form-control datepicker-time datepicker-time-linked not-required" data-enable-time=true name="due_date" id="due_date" type="text" value="<?php if(isset($task)){echo $task->due_date;} ?>"  <?=$this->user->admin == 0 ? "disabled" : "";?>/>
            </div>
    </div>
</div>
 <div class="form-group">
                        <label for="textfield"><?=$this->lang->line('application_description');?></label>
                        <textarea class="input-block-level summernote-modal" id="textfield" name="description"><?php if(isset($task)){echo $task->description;} ?></textarea>
</div>

        <div class="modal-footer">
          <?php if(isset($task)){ ?>
            <a href="<?=base_url()?>projects/tasks/<?=$task->project_id;?>/delete/<?=$task->id;?>" class="btn btn-danger pull-left button-loader <?=$this->user->admin == 0 ? "hidden" : "";?>" ><?=$this->lang->line('application_delete');?></a>
          <?php }else{  ?>
         <a class="btn btn-default pull-left" data-dismiss="modal"><?=$this->lang->line('application_close');?></a>
        <i class="icon dripicons-loading spin-it" id="showloader" style="display:none"></i>
        <button id="send" name="send" data-keepModal="true" class="btn btn-primary send button-loader"><?=$this->lang->line('application_save_and_add');?></button>
        <?php } ?>
        <button name="send" class="btn btn-primary send button-loader"><?=$this->lang->line('application_save');?></button>
        </div>
<?php echo form_close(); ?>

<script>
jQuery(document).ready(function($) {

    $('#start_date').on("change",function() {
        var date = new Date(this.value);

        var intScheduleTime = parseInt($('#scheduled_time').val());

        var finalDate = date.addbizDays(intScheduleTime);

        var options = {year: 'numeric', month: 'numeric', day: 'numeric', hour: 'numeric', minute: 'numeric' };

        $('.datepicker-time-linked').val(finalDate.toLocaleString("pt-BR", options));
    });


    Date.prototype.addDays = function(days) {
        var date = new Date(this.valueOf());
        date.setDate(date.getDate() + days);
        return date;
    }


    Date.prototype.addbizDays=function(n){
        var D=this;
        var num=Math.abs(n);
        var tem,count=0;
        var dir= (n<0)? -1: 1;
        while(count< num){
            D= new Date(D.setDate(D.getDate()+dir));
            tem=D.getDay();
            if(tem!=0 && tem!=6) ++count;
        }
        return D;
    }


});

</script>
