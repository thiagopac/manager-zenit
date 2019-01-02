<?php   
$attributes = array('class' => '', 'id' => '_item');
echo form_open($form_action, $attributes); 
?>

<?php if(isset($items)){ ?>
<input id="id" type="hidden" name="id" value="<?=$items->id;?>" />
<?php } ?>
 <div class="form-group">
        <label for="name"><?=$this->lang->line('application_name');?></label>
        <input id="name" name="name" type="text" class="required form-control"  value="<?php if(isset($items)){ echo $items->name; } ?>"  required/>
</div>
 <div class="form-group">
        <label for="value"><?=$this->lang->line('application_value');?></label>
        <input id="value" type="text" name="value" class="required form-control number"  value="<?php if(isset($items)){ echo $items->value; } ?>"  required/>
</div>
 <div class="form-group">
        <label for="type"><?=$this->lang->line('application_type');?></label>
        <input id="type" type="text" name="type" class="required form-control"  value="<?php if(isset($items)){ echo $items->type; } ?>"  required/>
</div>
 <div class="form-group">
        <label for="description"><?=$this->lang->line('application_description');?></label>
        <textarea id="description" class="form-control" name="description"><?php if(isset($items)){ echo $items->description; } ?></textarea>
 </div>

        <div class="modal-footer">
        <input type="submit" name="send" class="btn btn-primary" value="<?=$this->lang->line('application_save');?>"/>
        <a class="btn" data-dismiss="modal"><?=$this->lang->line('application_close');?></a>
        </div>
<?php echo form_close(); ?>