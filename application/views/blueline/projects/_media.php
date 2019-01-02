<?php   
$attributes = array('class' => 'dynamic-form', 'data-reload' => 'media', 'id' => '_media');
echo form_open_multipart($form_action, $attributes); 
?>
<?php if(isset($media)){ ?>
<input id="id" type="hidden" name="id" value="<?php echo $media->id; ?>" />
<?php } ?>
<input id="date" type="hidden" name="date" value="<?php echo $datetime; ?>" />

<div class="form-group">
        <label for="name"><?=$this->lang->line('application_name');?> *</label>
        <input id="name" type="text" name="name" class="required form-control" value="<?php if(isset($media)){echo $media->name;} ?>"  required/>
</div>
<div class="form-group">
        <label for="description"><?=$this->lang->line('application_description');?></label>
        <input id="description" type="text" name="description" class="form-control" value="<?php if(isset($media)){echo $media->description;} ?>" />
</div>
<div class="form-group">
        <label for="phase"><?=$this->lang->line('application_phase');?></label>
        <?php $options = explode(',', $project->phases); 
                $options2 = array();
                foreach ($options as $value): 
                $options2[$value] = $value;
                endforeach;
                $phase = FALSE;
                if(isset($media)){ $phase = $media->phase;} 
                echo form_dropdown('phase', $options2, $phase, 'style="width:100%" class="chosen-select"'); ?>
</div> 
<?php if(!isset($media)){ ?>

<div class="form-group">
                <label for="userfile"><?=$this->lang->line('application_file');?></label><div>
                <input id="uploadFile" class="form-control uploadFile" placeholder="<?=$this->lang->line('application_choose_file');?>" disabled="disabled" />
                          <div class="fileUpload btn btn-primary">
                              <span><i class="icon dripicons-upload"></i><span class="hidden-xs"> <?=$this->lang->line('application_select');?></span></span>
                              <input id="uploadBtn" type="file" name="userfile" class="upload" />
                          </div>
                  </div>
              </div>

<?php } ?>  

        <div class="modal-footer">
        <button type="submit" id="send" name="send" class="btn btn-primary send button-loader"><?=$this->lang->line('application_save');?></button>
        <a class="btn btn-default" data-dismiss="modal"><?=$this->lang->line('application_close');?></a>
        </div>

<?php echo form_close(); ?>