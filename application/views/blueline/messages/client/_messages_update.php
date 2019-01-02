<?php   
$attributes = array('class' => '', 'id' => '_quotation');
echo form_open($form_action, $attributes); 
?>
     <input id="id" type="hidden" name="id" value="<?=$id;?>" />

<div class="form-group">
        <label for="status"><?=$this->lang->line('application_status');?></label><br />
        <?php   $options = array(); 
                $options['New'] = $this->lang->line('application_New');
                $options['Read'] = $this->lang->line('application_Read');
                $options['Replied'] = $this->lang->line('application_Replied');
        echo form_dropdown('status', $options);?>
</div>

<div class="form-group">
        <?php echo form_submit( 'send', $this->lang->line('application_send')); ?>
</div>

<?php echo form_close(); ?>