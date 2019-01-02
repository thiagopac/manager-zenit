<?php   
$attributes = array('class' => '', 'id' => '_ticket');
echo form_open_multipart($form_action, $attributes); 
if(isset($ticket)){ ?>
<input id="id" type="hidden" name="id" value="<?php echo $ticket->id; ?>" />
<?php } ?>

 <div class="form-group">
        <label for="type"><?=$this->lang->line('application_type');?></label>
        <?php $options = array();
                foreach ($types as $value):  
                $options[$value->id] = $value->name;
                endforeach;
        if(isset($ticket) && is_object($ticket->type)){$type = $ticket->type->id;}else{$type = $settings->ticket_default_type;}
        echo form_dropdown('type_id', $options, $type, 'style="width:100%" class="chosen-select"');?>
</div> 

 <div class="form-group">
        <label for="queue"><?=$this->lang->line('application_queue');?></label>
        <?php $options = array();
                foreach ($queues as $value):  
                $options[$value->id] = $value->name;
                endforeach;
        if(isset($ticket) && is_object($ticket->queue)){$queue = $ticket->queue->id;}else{$queue = "";}
        echo form_dropdown('queue_id', $options, $queue, 'style="width:100%" class="chosen-select"');?>
</div> 

 <div class="form-group">
        <label for="client"><?=$this->lang->line('application_client');?></label>
        <?php $options = array();
                $options['0'] = '-';
                foreach ($clients as $value):  
                $options[$value->id] = $value->firstname.' '.$value->lastname.' ['.$value->company->name.']';
                endforeach;
        if(isset($ticket) && is_object($ticket->company)){$client = $ticket->company->id;}else{$client = "";}
        echo form_dropdown('client_id', $options, $client, 'style="width:100%" class="chosen-select"');?>
</div> 

 <div class="form-group">
        <label for="user"><?=$this->lang->line('application_assign_to');?></label>
        <?php $options = array();
                $options['0'] = '-';
                foreach ($users as $value):  
                $options[$value->id] = $value->firstname.' '.$value->lastname;
                endforeach;
        if(isset($ticket) && is_object($ticket->user)){$user = $ticket->user->id;}else{$user = "";}
        echo form_dropdown('user_id', $options, $user, 'style="width:100%" class="chosen-select"');?>
</div> 

  <div class="form-group">
        <label for="project"><?=$this->lang->line('application_projects');?></label>
        <select name="project_id" id="getProjects" style="width:100%" class="chosen-select">
            <option value="0">-</option>
            <?php foreach ($companies as $comp): ?>
                <optgroup label="<?=$comp->name?>" id="optID_<?=$comp->id?>"    >
                  <?php foreach ($comp->projects as $pro): ?>
                    <option value="<?=$pro->id?>" <?php if($project == $pro->id){ ?>selected="selected"<?php } ?>><?=$pro->name?></option>
                    <?php endforeach; ?>
                </optgroup>
           <?php endforeach; ?>
        </select>

 </div> 

 <div class="form-group">
        <label for="subject"><?=$this->lang->line('application_subject');?> *</label>
        <input id="subject" type="text" name="subject" class="form-control" value="<?php if(isset($ticket)){echo $ticket->subject;} ?>"  required/>
</div> 

 <div class="form-group">
        <label for="text"><?=$this->lang->line('application_message');?> *</label>
        <textarea id="text" name="text" rows="9" class="form-control summernote-modal"></textarea>
</div> 

<div class="form-group">
                <label for="userfile"><?=$this->lang->line('application_attachment');?></label><div>
                <input id="uploadFile" class="form-control uploadFile" placeholder="<?=$this->lang->line('application_choose_file');?>" disabled="disabled" />
                          <div class="fileUpload btn btn-primary">
                              <span><i class="icon dripicons-upload"></i><span class="hidden-xs"> <?=$this->lang->line('application_select');?></span></span>
                              <input id="uploadBtn" type="file" name="userfile" class="upload" />
                          </div>
                  </div>
              </div>

 <div class="form-group">
        <label><?=$this->lang->line('application_notifications');?></label>
        <ul class="accesslist">
            <li> <input type="checkbox" class="checkbox" id="r_notify" name="notify_agent" value="yes" data-labelauty="<?=$this->lang->line('application_notify_agent');?>" checked="checked"></li>
            <li> <input type="checkbox" class="checkbox" id="c_notify" name="notify_client" value="yes" data-labelauty="<?=$this->lang->line('application_notify_client');?>" checked="checked"></li>
        </ul>           
</div> 
        <div class="modal-footer">
        <input type="submit" name="send" class="btn btn-primary" value="<?=$this->lang->line('application_save');?>"/>
        <a class="btn" data-dismiss="modal"><?=$this->lang->line('application_close');?></a>
        </div>


<?php echo form_close(); ?>