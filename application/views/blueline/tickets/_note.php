<?php 
$attributes = ['class' => '', 'id' => '_article'];
echo form_open_multipart($form_action, $attributes); ?>
<?php if (isset($ticket)) {
    ?>
<input id="ticket_id" type="hidden" name="ticket_id" value="<?php echo $ticket->id; ?>" />
<?php
} ?>
 <input type="hidden" name="note" value="1" />  

<div class="form-group">
        <label for="message"><?=$this->lang->line('application_message');?></label>
        <textarea id="message" name="message" rows="6" class=" textarea summernote-modal"></textarea>
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

<ul class="accesslist">
<li> <input type="checkbox" class="checkbox" id="r_internal" name="internal" value="0" data-labelauty="<?=$this->lang->line('application_note_visible_to_client');?>"></li>
</ul>  

        <div class="modal-footer">
        <input type="submit" name="send" class="btn btn-primary" value="<?=$this->lang->line('application_save');?>"/>
        <a class="btn" data-dismiss="modal"><?=$this->lang->line('application_close');?></a>
        </div>

<?php echo form_close(); ?>