<?php   
$attributes = array('class' => '', 'id' => 'ticket_queue');
echo form_open_multipart($form_action, $attributes); 
?>
<div class="form-group">
        <label for="name"><?=$this->lang->line('application_name');?></label>
        <input id="name" name="name" class="required form-control" value="<?php if(isset($queue->name)){echo $queue->name;} ?>" required/>
</div>
<div class="form-group">
        <label for="description"><?=$this->lang->line('application_description');?></label>
        <input id="description" name="description" class="required form-control" value="<?php if(isset($queue->description)){echo $queue->description;} ?>" required/>
</div>
        <div class="modal-footer">
        <input type="submit" name="send" class="btn btn-primary" value="<?=$this->lang->line('application_save');?>"/>
        <a class="btn" data-dismiss="modal"><?=$this->lang->line('application_close');?></a>
        </div>

<?php echo form_close(); ?>