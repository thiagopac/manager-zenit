<?php   
$attributes = array('class' => '', 'id' => '_type');
echo form_open($form_action, $attributes); 
if(isset($ticket)){ ?>
<input id="id" type="hidden" name="id" value="<?php echo $ticket->id; ?>" />
<?php } ?>    
<div class="form-group">
        <label for="type"><?=$this->lang->line('application_status');?></label>
        <?php $statuslist = array();
                 
                    $statuslist["open"] = $this->lang->line('application_ticket_status_open');
                    $statuslist["onhold"] = $this->lang->line('application_ticket_status_onhold');
                    $statuslist["inprogress"] = $this->lang->line('application_ticket_status_inprogress');
                    $statuslist["reopened"] = $this->lang->line('application_ticket_status_reopened');
                    $statuslist["closed"] = $this->lang->line('application_ticket_status_closed');

        echo form_dropdown('status', $statuslist, $ticket->status, 'style="width:100%" class="chosen-select"');?>
</div>    

        <div class="modal-footer">
        <input type="submit" name="send" class="btn btn-primary" value="<?=$this->lang->line('application_save');?>"/>
        <a class="btn" data-dismiss="modal"><?=$this->lang->line('application_close');?></a>
        </div>


<?php echo form_close(); ?>