<?php   
$attributes = array('class' => '', 'id' => 'client_form');
echo form_open_multipart($form_action, $attributes); 
?>
<div class="form-group">
        <label for="password"><?=$this->lang->line('application_password');?></label>
        <input id="password" type="password" name="password" class="form-control" minlength="6" />
</div>
<div class="form-group">
        <label for="confirm_password"><?=$this->lang->line('application_confirm_password');?></label>
        <input id="confirm_password" name="confirm_password" type="password" class="form-control" minlength="6" data-match="#password">
</div>
<div class="form-group">
                <label for="userfile"><?=$this->lang->line('application_profile_picture');?></label><div>
                <input id="uploadFile" class="form-control uploadFile" placeholder="<?=$this->lang->line('application_choose_file');?>" disabled="disabled" />
                          <div class="fileUpload btn btn-primary">
                              <span><i class="icon dripicons-upload"></i><span class="hidden-xs"> <?=$this->lang->line('application_select');?></span></span>
                              <input id="uploadBtn" type="file" name="userfile" class="upload" />
                          </div>
                  </div>
              </div> 

        <div class="modal-footer">
        <input type="submit" name="send" class="btn btn-primary" value="<?=$this->lang->line('application_save');?>"/>
        <a class="btn" data-dismiss="modal"><?=$this->lang->line('application_close');?></a>
        </div>

<?php echo form_close(); ?>