<?php   
$attributes = array('class' => '', 'id' => 'backup_form');
echo form_open_multipart($form_action, $attributes); 
?>
<div class="alert alert-warning"><?=$this->lang->line('application_restore_notice');?></div><br/>
     
<div class="form-group">
                <label for="userfile"><?=$this->lang->line('application_backup_file_zip');?></label><div>
                <input id="uploadFile" class="form-control uploadFile" placeholder="<?=$this->lang->line('application_choose_file');?>" disabled="disabled" />
                          <div class="fileUpload btn btn-primary">
                              <span><i class="icon dripicons-upload"></i><span class="hidden-xs"> <?=$this->lang->line('application_select');?></span></span>
                              <input id="uploadBtn" type="file" name="userfile" class="upload" />
                          </div>
                  </div>
              </div>       

        <div class="modal-footer">
        <input type="submit" name="send" class="btn btn-primary" value="<?=$this->lang->line('application_restore_backup');?>"/>
        <a class="btn" data-dismiss="modal"><?=$this->lang->line('application_close');?></a>
        </div>

<?php echo form_close(); ?>