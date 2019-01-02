<?php   
$attributes = array('class' => '', 'id' => '_invoices');
echo form_open($form_action, $attributes); 
?>

<?php if(isset($estimate)){ ?>
<input id="id" type="hidden" name="id" value="<?=$estimate->id;?>" />
<?php } ?>
<?php if(isset($view)){ ?>
<input id="view" type="hidden" name="view" value="true" />
<?php } ?>
<input id="status" name="status" type="hidden" value="Open"> 
 <div class="form-group">
        <label for="reference"><?=$this->lang->line('application_reference_id');?> *</label>
        <div class="input-group">
        <div class="input-group-addon"><?=$core_settings->estimate_prefix;?></div>
            <input id="reference" type="text" name="estimate_reference" class="form-control"  value="<?php if(isset($estimate)){echo $estimate->estimate_reference;} else{ echo $core_settings->estimate_reference; } ?>" />
        </div>
 </div>
 <div class="form-group">
        <label for="client"><?=$this->lang->line('application_client');?></label>
        <?php $options = array();
                $options['0'] = '-';
                foreach ($companies as $value):  
                $options[$value->id] = $value->name;
                endforeach;
        if(isset($estimate)){$client = $estimate->company_id; $project = $estimate->project_id;}else{$client = ""; $project = "";}
        echo form_dropdown('company_id', $options, $client, 'style="width:100%" data-destination="getProjects" class="chosen-select getProjects"');?>
 </div>   
  <div class="form-group">
        <label for="project"><?=$this->lang->line('application_projects');?></label>
        <select name="project_id" id="getProjects" style="width:100%" class="chosen-select">
            <option value="0">-</option>
            <?php foreach ($companies as $comp): ?>
                <optgroup label="<?=$comp->name?>" id="optID_<?=$comp->id?>" <?php if($client != $comp->id){ ?>disabled="disabled"<?php } ?>>
                  <?php foreach ($comp->projects as $pro): ?>
                    <option value="<?=$pro->id?>" <?php if($project == $pro->id){ ?>selected="selected"<?php } ?>><?=$pro->name?></option>
                    <?php endforeach; ?>
                </optgroup>
           <?php endforeach; ?>
        </select>

 </div> 
<?php if(isset($estimate)){ ?>
 <div class="form-group">
        <label for="status"><?=$this->lang->line('application_status');?></label>
        <?php $options = array(
                  'Open'  => $this->lang->line('application_Open'),
                  'Sent'    => $this->lang->line('application_Sent'),
                  'Accepted' => $this->lang->line('application_Accepted'),
                  'Declined' => $this->lang->line('application_Declined'),
                  'Invoiced' => $this->lang->line('application_Invoiced'),
                  'Revised' => $this->lang->line('application_Revised')
                );
                echo form_dropdown('estimate_status', $options, $estimate->estimate_status, 'style="width:100%" class="chosen-select"'); ?>

 </div>
<?php } ?>
 <div class="form-group">
        <label for="issue_date"><?=$this->lang->line('application_issue_date');?> *</label>
        <input id="issue_date" type="text" name="issue_date" class="required datepicker form-control" value="<?php if(isset($estimate)){echo $estimate->issue_date;} ?>"  required/>
 </div>
 <div class="form-group">
        <label for="due_date"><?=$this->lang->line('application_due_date');?> *</label>
        <input id="due_date" type="text" name="due_date" class="required datepicker form-control" value="<?php if(isset($estimate)){echo $estimate->due_date;} ?>"  required/>
 </div>
 <div class="form-group">
        <label for="currency"><?=$this->lang->line('application_currency');?></label>
        <input id="currency" type="text" name="currency" class="required form-control" value="<?php if(isset($estimate)){ echo $estimate->currency; }else { echo $core_settings->currency; } ?>" required/>
 </div>
 <div class="form-group">
        <label for="currency"><?=$this->lang->line('application_discount');?></label>
        <input class="form-control" name="discount" id="appendedInput" type="text" value="<?php if(isset($estimate)){ echo $estimate->discount;} ?>"/>
 </div>
 <div class="form-group">
        <label for="terms"><?=$this->lang->line('application_terms');?></label>
        <textarea id="terms" name="terms" class="textarea summernote-modal form-control" style="height:100px"><?php if(isset($estimate)){echo $estimate->terms;}else{ echo $core_settings->estimate_terms; }?></textarea>
 </div>
  <div class="form-group">
        <label for="tax"><?=$this->lang->line('application_custom_tax');?></label>
        <input class="form-control" name="tax" type="text" value="<?php if(isset($estimate)){ echo $estimate->tax;}else{echo $core_settings->tax;} ?>"/>
 </div>
   <div class="form-group">
        <label for="second_tax"><?=$this->lang->line('application_second_tax');?></label>
        <input class="form-control" name="second_tax" type="text" value="<?php if(isset($estimate)){ echo $estimate->second_tax;} ?>"/>
 </div>

        <div class="modal-footer">
        <input type="submit" name="send" class="btn btn-primary" value="<?=$this->lang->line('application_save');?>"/>
        <a class="btn" data-dismiss="modal"><?=$this->lang->line('application_close');?></a>
        </div>


<?php echo form_close(); ?>