<?php
$attributes = array('class' => '', 'id' => '_assign');
echo form_open($form_action, $attributes);
if(isset($project)){ ?>
<input id="id" type="hidden" name="id" value="<?php echo $project->id; ?>" />
<?php } ?>

<div class="form-group">
        <label for="users"><?=$this->lang->line('application_assign_to_agents');?></label>
        <?php $options = array();
                $user = array();
                foreach ($users as $value):
                $options[$value->id] = $value->firstname.' '.$value->lastname;
                endforeach;
        if(isset($project)){}else{$user = "";}
        foreach ($project->project_has_workers as $workers):
            $user[$workers->user_id] = $workers->user_id;
        endforeach;
        echo form_dropdown('user_id[]', $options, $user, 'style="width:100%" class="chosen-select" data-placeholder="'.$this->lang->line('application_select_agents').'" multiple tabindex="3"');?>
</div>


<div class="modal-footer">
    <input type="submit" name="send" class="btn btn-primary" value="<?=$this->lang->line('application_save');?>"/>
    <a class="btn btn-default" data-dismiss="modal"><?=$this->lang->line('application_close');?></a>
</div>


<?php echo form_close(); ?>
