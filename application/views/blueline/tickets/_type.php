<?php   
$attributes = array('class' => '', 'id' => '_type');
echo form_open($form_action, $attributes); 
if(isset($ticket)){ ?>
<input id="id" type="hidden" name="id" value="<?php echo $ticket->id; ?>" />
<?php } ?>    
<div class="form-group">
        <label for="type"><?=$this->lang->line('application_type');?></label>
        <?php $typelist = array();
                 foreach ($types as $type):
                    $typelist[$type->id] = $type->name;
                endforeach;
        echo form_dropdown('type_id', $typelist, $ticket->type_id, 'style="width:100%" class="chosen-select"');?>
</div>    

        <div class="modal-footer">
        <input type="submit" name="send" class="btn btn-primary" value="<?=$this->lang->line('application_save');?>"/>
        <a class="btn" data-dismiss="modal"><?=$this->lang->line('application_close');?></a>
        </div>


<?php echo form_close(); ?>