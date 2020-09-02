<?php
$attributes = ['class' => '', 'id' => '_project'];
echo form_open_multipart($form_action, $attributes);
?>
    <div class="form-group">
        <label for="name">
            <?=$this->lang->line('application_name');?> *
        </label>
        <input id="name" type="text" name="name" class="required form-control"  value="<?php if(isset($project)){echo $project->name;}?>"  required/>
    </div>

    <div class="modal-footer">
        <input type="submit" class="btn btn-primary" value="
			<?=$this->lang->line('application_save');?>"/>
        <a class="btn" data-dismiss="modal">
            <?=$this->lang->line('application_close');?>
        </a>
    </div>
<?php echo form_close(); ?>
