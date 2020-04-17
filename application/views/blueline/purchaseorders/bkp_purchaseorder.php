<?php
$attributes = array('class' => '', 'id' => '_purchaseorder');
echo form_open_multipart($form_action, $attributes);
?>
    <div class="form-group">
        <label for="name"><?=$this->lang->line('application_flow');?></label><br>
        <span style="margin-left: 10px">
            <?=$this->lang->line('application_purchase_order_flow');?>
        </span>
    </div>
    <div class="form-group">
        <label for="subject"><?=$this->lang->line('application_subject');?></label>
        <input type="text" name="subject" class="form-control" id="subject" placeholder="<?=$this->lang->line('application_subject');?>" required/>
    </div>
    <div class="form-group">
        <label for="message"><?=$this->lang->line('application_message');?></label>
        <textarea class="input-block-level summernote summernote-modal"  id="textfield" name="message"></textarea>
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
        <?php foreach ($actions as $action) : ?>
            <input type="submit" name="submit_<?=$action->destiny?>" class="btn btn-primary" value="<?=$action->name?>"/>
        <?php endforeach; ?>
        <a class="btn btn-default" data-dismiss="modal"><?=$this->lang->line('application_close');?></a>
    </div>
    </form>
<?php echo form_close(); ?>