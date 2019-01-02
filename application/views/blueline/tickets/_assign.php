<?php   
$attributes = array('class' => '', 'id' => '_assign');
echo form_open($form_action, $attributes); 
if(isset($ticket)){ ?>
<input id="id" type="hidden" name="id" value="<?php echo $ticket->id; ?>" />
<?php } ?>

<div class="form-group">
        <label for="user"><?=$this->lang->line('application_assign_to');?></label>
        <?php $workers = array();
                 foreach ($users as $worker):
                    $workers[$worker->id] = $worker->firstname.' '.$worker->lastname;
                endforeach;
        echo form_dropdown('user_id', $workers, $ticket->user_id, 'style="width:100%" class="chosen-select"');?>
</div>    
<div class="form-group">
        <label for="subject"><?=$this->lang->line('application_subject');?> *</label>
        <input id="subject" type="text" name="subject" class="form-control" value="<?=$this->lang->line('application_notification_ticket_assign_subject');?>"  required/>
</div>        
<div class="form-group">
        <label for="message"><?=$this->lang->line('application_message');?> *</label>
        <textarea id="message" name="message" rows="6" class="summernote-modal"></textarea>
</div>         
<ul class="accesslist">
<li> <input type="checkbox" class="checkbox" id="r_notify" name="notify" value="yes" data-labelauty="<?=$this->lang->line('application_notify_agent');?>"></li>
</ul>  

        <div class="modal-footer">
        <input type="submit" name="send" class="btn btn-primary" value="<?=$this->lang->line('application_save');?>"/>
        <a class="btn" data-dismiss="modal"><?=$this->lang->line('application_close');?></a>
        </div>


<?php echo form_close(); ?>