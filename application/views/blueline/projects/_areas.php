<?php   
$attributes = array('class' => 'dynamic-form', 'data-reload' => 'task-list', 'data-reload2' => 'milestones-tab', 'data-baseurl' => base_url(), 'id' => '_milestone');
echo form_open($form_action, $attributes); 

?>

<?php if(isset($area)){  ?>
  <input id="id" type="hidden" name="id" value="<?php echo $area->id; ?>" />
<?php } ?>
 <div class="form-group">
        <label for="name"><?=$this->lang->line('application_name');?> *</label>
        <input id="name" type="text" name="name" class="form-control resetvalue" value="<?php if(isset($area)){echo $area->name;} ?>"  required/>
</div>
    <div class="form-group">
        <label for="department_id"><?=$this->lang->line('application_department');?></label>
        <?php  $departments = array();
        foreach ($bd_departments as $department):
            $departments[$department->id] = $department->name;
        endforeach;
        if(isset($area)){$department_selected = $area->department_id;}else{$department_selected = "";}
        if(isset($department_id)){$department_selected = $department_id;}else{$department_selected = "";}
        //        $milestone_selected = 3;
        echo form_dropdown('department_id', $departments, $department_selected, 'style="width:100%" class="chosen-select"');?>
    </div>

<div class="form-group">
        <label for="textfield"><?=$this->lang->line('application_description');?></label>
        <textarea class="input-block-level summernote-modal"  id="textfield" name="description"><?php if(isset($area)){echo $area->description;} ?></textarea>
</div>
        <div class="modal-footer">
          <?php if(isset($area)){ ?>
            <a href="<?=base_url()?>projects/areas/<?=$area->project_id;?>/delete/<?=$area->id;?>" class="btn btn-danger pull-left button-loader" ><?=$this->lang->line('application_delete');?></a>
          <?php }else{  ?>
         <a class="btn btn-default pull-left" data-dismiss="modal"><?=$this->lang->line('application_close');?></a>
        <i class="icon dripicons-loading spin-it" id="showloader" style="display:none"></i> 
        <button id="send" name="send" data-keepModal="true" class="btn btn-primary send button-loader"><?=$this->lang->line('application_save_and_add');?></button>
        <?php } ?>
        <button name="send" class="btn btn-primary send button-loader"><?=$this->lang->line('application_save');?></button>
        </div>
<?php echo form_close(); ?>