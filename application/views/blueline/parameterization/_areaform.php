<?php
$attributes = ['class' => '', 'id' => 'area_form'];
echo form_open_multipart($form_action, $attributes);
?>
    <div class="form-group">
        <label for="name">
            <?=$this->lang->line('application_name');?> *
        </label>
        <input id="name" type="text" name="name" class="required form-control"  value="<?php if(isset($area)){echo $area->name;}?>"  required/>
    </div>
    <div class="form-group">
        <label for="area_id"><?=$this->lang->line('application_area');?></label>
        <?php   //$areas = array();
        $departments['0'] = '-';

        foreach ($bd_departments as $department):
            $departments[$department->id] = $department->name;
        endforeach;

        if(isset($area)){$department_selected = $area->department_id;}else{$department_selected = department_id;}
        echo form_dropdown('department_id', $departments, $department_selected, 'style="width:100%" class="chosen-select"');?>
    </div>
    <div class="form-group">
        <label for="textfield"><?=$this->lang->line('application_description');?></label>
        <textarea class="input-block-level summernote-modal"  id="description" name="description"><?php if(isset($area)){echo $area->description;} ?></textarea>
    </div>
    <div class="modal-footer">
        <input type="submit" class="btn btn-primary" value="
			<?=$this->lang->line('application_save');?>"/>
        <a class="btn" data-dismiss="modal">
            <?=$this->lang->line('application_close');?>
        </a>
    </div>
<?php echo form_close(); ?>