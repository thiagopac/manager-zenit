<?php   
$attributes = array('class' => '', 'id' => '_close');
echo form_open_multipart($form_action, $attributes); ?>
<?php if(isset($ticket)){ ?>
<input id="ticket_id" type="hidden" name="ticket_id" value="<?php echo $ticket->id; ?>" />
<?php } ?>

    
<div class="form-group">
        <label for="subject"><?=$this->lang->line('application_subject');?> *</label>
        <input id="subject" type="text" name="subject" class="required form-control" value="<?=$this->lang->line('application_close');?>" required/>
</div>    
<div class="form-group">
        <label for="message"><?=$this->lang->line('application_message');?> *</label>
        <textarea id="message" name="message" rows="6" class="textarea summernote-modal"></textarea>
</div>    


        <div class="modal-footer">
        <input type="submit" name="send" class="btn btn-primary" value="<?=$this->lang->line('application_save');?>"/>
        <a class="btn" data-dismiss="modal"><?=$this->lang->line('application_close');?></a>
        </div>

<?php echo form_close(); ?>