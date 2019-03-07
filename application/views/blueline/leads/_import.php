<?php 
$attributes = array('class' => '', 'id' => '_import');
echo form_open_multipart($form_action, $attributes);
if (isset($lead)) {
    ?>
<input id="id" type="hidden" name="id" value="<?php echo $lead->id; ?>" />
<?php
} ?>    

<div class="alert alert-info"><?=$this->lang->line('application_import_leads_info');?></div>


<div class="form-group">
        <label for="userfile">.CSV <?=$this->lang->line('application_file');?></label><div>
        <input id="uploadFile" class="form-control uploadFile" placeholder="<?=$this->lang->line('application_choose_file');?>" disabled="disabled" />
                  <div class="fileUpload btn btn-primary">
                      <span><i class="icon dripicons-upload"></i><span class="hidden-xs"> <?=$this->lang->line('application_select');?></span></span>
                      <input id="uploadBtn" type="file" name="userfile" class="upload" accept=".csv" />
                  </div>
          </div>
</div>
<div class="form-group">
        <label for="status_id"><?=$this->lang->line('application_status');?></label>
        <?php $options = array();
                 foreach ($status as $stat):
                    $options[$stat->id] = $stat->name;
                endforeach;
        if (isset($lead) && is_object($lead)) {
            $status_id = $lead->status_id;
        } else {
            $status_id = "";
        }
        echo form_dropdown('status_id', $options, $status_id, 'style="width:100%" class="chosen-select"');?>
</div>   
 <div class="form-group">
        <label for="source"><?=$this->lang->line('application_source');?> *</label>
        <input id="source" type="text" list="sourcelist" name="source" class="required form-control" value="<?php if (isset($lead)) {
            echo $lead->source;
        } ?>" required/>
        <datalist id="sourcelist">
        <?php foreach ($sources as $value):  ?>
                <option value="<?=$value->source?>">
        <?php endforeach; ?>
        <option value="Facebook">
        <option value="Google">
        </datalist>

 </div>  

<ul class="accesslist">
<li> <input type="checkbox" class="checkbox" id="private" name="private" value="1" data-labelauty="<?=$this->lang->line('application_private_lead');?>" <?php if (isset($lead) && $lead->private != 0) {
            echo "checked";
        } ?>>  </li>
</ul>       

        <div class="modal-footer">
        <button type="submit" id="send" name="send" class="btn btn-primary send button-loader"><?=$this->lang->line('application_import_leads');?></button>
        <a class="btn" data-dismiss="modal"><?=$this->lang->line('application_close');?></a>
        </div>


<?php echo form_close(); ?>