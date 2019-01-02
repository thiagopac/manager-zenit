<?php   
$attributes = array('class' => '', 'id' => '_article');
echo form_open_multipart($form_action, $attributes); ?>
   
<div class="form-group">
        <label for="subject"><?=$this->lang->line('application_subject');?> *</label>
        <input id="subject" type="text" name="subject" class="required form-control" value="" required/>
</div>    
<div class="form-group">
        <label for="text"><?=$this->lang->line('application_message');?></label>
        <textarea id="text" name="text" rows="6" class=" textarea summernote-modal"></textarea>
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

        <div class="modal-footer">
        <input type="submit" name="send" class="btn btn-primary input-loader" value="<?=$this->lang->line('application_save');?>"/>
        <a class="btn" data-dismiss="modal"><?=$this->lang->line('application_close');?></a>
        </div>

<?php echo form_close(); ?>