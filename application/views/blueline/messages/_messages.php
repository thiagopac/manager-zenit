<?php
$attributes = array('class' => '', 'id' => '_message');
echo form_open_multipart($form_action, $attributes);
?><div class="form-group">
        <label for="name"><?=$this->lang->line('application_to');?></label><br>
        <?php $options = array();
                foreach ($users as $value):
                    if($value->id != $this->user->id){
                $options[$this->lang->line('application_agents')]["u".$value->id] = $value->firstname.' '.$value->lastname;
                }
                endforeach;
                foreach ($client as $value):
                $options[$this->lang->line('application_client')]["c".$value->id] = $value->firstname.' '.$value->lastname.' ['.$value->company->name.']';
                endforeach;
        echo form_dropdown('recipient', $options, '', 'style="width:100%" class="chosen-select"');?>
</div>

<div class="form-group">
                          <label for="subject"><?=$this->lang->line('application_subject');?></label>
                          <input type="text" name="subject" class="form-control" id="subject" placeholder="<?=$this->lang->line('application_subject');?>" required/>
</div>
 <div class="form-group">
                        <label for="message"><?=$this->lang->line('application_message');?></label>
                        <textarea class="input-block-level summernote-modal"  id="textfield" name="message"></textarea>
</div>
<div class="form-group">
<label><?=$this->lang->line('application_attachment');?></label>
                <div><input id="uploadFile" class="form-control uploadFile" placeholder="<?=$this->lang->line('application_choose_file');?>" disabled="disabled" />
                          <div class="fileUpload btn btn-primary">
                              <span><i class="icon dripicons-upload"></i><span class="hidden-xs"> <?=$this->lang->line('application_select');?></span></span>
                              <input id="uploadBtn" type="file" name="userfile" class="upload" />
                          </div>
            </div>
        </div>


        <div class="modal-footer">
        <input type="submit" name="send" class="btn btn-primary" value="<?=$this->lang->line('application_send');?>"/>
        <a class="btn btn-default" data-dismiss="modal"><?=$this->lang->line('application_close');?></a>
        </div>

</form>
<?php echo form_close(); ?>
