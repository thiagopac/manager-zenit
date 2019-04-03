<?php   
$attributes = array('class' => '', 'id' => '_tags');
echo form_open_multipart($form_action, $attributes);
if (isset($tag)) { ?>

<input id="id" type="hidden" name="id" value="<?=$tag->id; ?>" />

<?php } ?>
<div class="form-group">
        <label for="name"><?=$this->lang->line('application_name');?></label>
        <input id="name" name="name" class="required form-control" value="<?php if(isset($tag->name)){echo $tag->name;} ?>" required/>
</div>
        <div class="modal-footer">
        <input type="submit" name="send" class="btn btn-primary" value="<?=$this->lang->line('application_save');?>"/>
        <a class="btn" data-dismiss="modal"><?=$this->lang->line('application_close');?></a>
        </div>

<?php echo form_close(); ?>