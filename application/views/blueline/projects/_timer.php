<?php   
$attributes = array('class' => '', 'id' => '_timer');
echo form_open($form_action, $attributes); 
if(isset($project)){ ?>
<input id="id" type="hidden" name="id" value="<?php echo $project->id; ?>" />
<?php } ?>

<div class="form-group">
<div class="row">

  <div class="col-xs-3">
  <label><?=$this->lang->line('application_hours');?></label>
    <input type="numbers" class="form-control" name="hours" >
  </div>
</div>
<div class="row">
  <div class="col-xs-3">
  <label><?=$this->lang->line('application_minutes');?></label>
    <input type="numbers" class="form-control" name="minutes" >
  </div>

</div>
</div> 

         
<div class="modal-footer">
        <input type="submit" name="send" class="btn btn-primary" value="<?=$this->lang->line('application_save');?>"/>
        <a class="btn btn-default" data-dismiss="modal"><?=$this->lang->line('application_close');?></a>
        </div>


<?php echo form_close(); ?>