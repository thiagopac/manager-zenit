<?php   
$attributes = array('class' => '', 'id' => '_quotation');
echo form_open($form_action, $attributes); 
?>
<div class="form-group">
        <label for="status"><?=$this->lang->line('application_status');?></label>
        <?php $options = array();
                $options['New'] = $this->lang->line('application_New');
                $options['Reviewed'] = $this->lang->line('application_Reviewed');
                $options['Accepted'] = $this->lang->line('application_Accepted');
        echo form_dropdown('status', $options, $quotations->status, 'style="width:100%" class="chosen-select"');?>
</div>       
<div class="form-group">
        <label for="worker"><?=$this->lang->line('application_worker');?></label>
        <?php $options = array();
                $options['0'] = 'Not assigned';
                foreach ($users as $value):  
                $options[$value->id] = $value->firstname.' '.$value->lastname;
                endforeach;
        $user = $quotations->user_id;
        echo form_dropdown('user_id', $options, $user, 'style="width:100%" class="chosen-select"');?>
</div>
        <div class="modal-footer">
        <input type="submit" name="send" class="btn btn-primary" value="<?=$this->lang->line('application_save');?>"/>
        <a class="btn" data-dismiss="modal"><?=$this->lang->line('application_close');?></a>
        </div>

<?php echo form_close(); ?>