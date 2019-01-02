<?php   
$attributes = array('class' => '', 'id' => '_expense');
echo form_open_multipart($form_action, $attributes); 
?>

<?php if(isset($expense)){ ?>
<input id="id" type="hidden" name="id" value="<?=$expense->id;?>" />
<?php } ?>

 <div class="form-group">
        <label for="type"><?=$this->lang->line('application_type');?></label>
        <?php $options = array();
                $options['payment'] = $this->lang->line('application_payment');
                $options['recurring_payment'] = $this->lang->line('application_recurring_payment');
                $options['refund'] = $this->lang->line('application_refund');

                
        if(isset($expense)){$type = $expense->type;}else{$type = "payment";}
        echo form_dropdown('type', $options, $type, 'style="width:100%" class="chosen-select toggle-expenses-recurring"');?>
 </div>   
  <div class="form-group">
        <label for="category"><?=$this->lang->line('application_category');?></label>
        <input id="category" type="text" list="categorylist" name="category" class="required form-control" value="<?php if(isset($expense)){ echo $expense->category; } ?>" required/>
        <datalist id="categorylist">
        <?php foreach ($categories as $value):  ?>
                <option value="<?=$value->category?>">
        <?php endforeach; ?>
        <option value="Accommodation">
        <option value="Accountancy Fees">
        <option value="Advertising and Promotion">
        <option value="Auto Expenses">
        <option value="Cell Phone">
        <option value="Computer Hardware">
        <option value="Computer Software">
        <option value="Insurance">
        <option value="Leasing Payments">
        <option value="Office Costs">
        <option value="Postage">
        <option value="Staff Training">
        <option value="Subscriptions">
        <option value="Web Hosting">
        <option value="Travel">
        <option value="Materials">
        <option value="Rent">
        </datalist>

 </div> 
   <div class="form-group">
        <label for="terms"><?=$this->lang->line('application_description');?></label>
        <input class="form-control" name="description" type="text" value="<?php if(isset($expense)){ echo $expense->description;}?>"  required/>
 </div>

  <div class="form-group">
        <label for="status"><?=$this->lang->line('application_status');?></label>
        <?php $options = array(
                  'Open'  => $this->lang->line('application_Open'),
                  'Paid' => $this->lang->line('application_Paid'),
                  'Canceled' => $this->lang->line('application_Canceled'),

                );
                echo form_dropdown('status', $options, $expense->status, 'style="width:100%" class="chosen-select"'); ?>

 </div>

 <div class="form-group">
        <label for="date"><?=$this->lang->line('application_date');?></label>
        <input id="date" type="text" name="date" class="datepicker form-control" value="<?php if(isset($expense)){echo $expense->date;}else{echo date('Y-m-d');} ?>"  required/>
 </div>

  <div class="form-group hidden-element <?php echo ($type != 'recurring_payment') ? 'hide' : '';?> ">
        <label for="date"><?=$this->lang->line('application_recurring_frequency');?></label>
          <?php $options = array(
                  '+7 day'  => $this->lang->line('application_weekly'),
                  '+14 day' => $this->lang->line('application_every_other_week'),
                  '+1 month' => $this->lang->line('application_monthly'),
                  '+3 month' => $this->lang->line('application_quarterly'),
                  '+6 month' => $this->lang->line('application_semi_annually'),
                  '+1 year' => $this->lang->line('application_annually'),
                );
                if(isset($expense)){$selected = $expense->recurring;}else{$selected = '+1 month';} 
                echo form_dropdown('recurring', $options, $selected, 'style="width:100%" class="chosen-select"'); ?>
 </div>

  <div class="form-group hidden-element <?php echo ($type != 'recurring_payment') ? 'hide' : '';?>">
        <label for="recurring_until"><?=$this->lang->line('application_end_date');?></label>
        <input id="recurring_until" type="text" name="recurring_until" class="datepicker form-control" value="<?php if(isset($expense)){echo $expense->recurring_until;}else{echo "";} ?>" />
 </div>

 <div class="row">
    <div class="col-md-6">
         <div class="form-group">
                <label for="value"><?=$this->lang->line('application_value');?></label>
                <input class="form-control decimal" name="value" id="value" type="text" value="<?php if(isset($expense)){ echo $expense->value;} ?>" required/>
         </div>
    </div>
    <div class="col-md-3">
         <div class="form-group">
            <label for="currency"><?=$this->lang->line('application_currency');?></label>
            <input id="currency" type="text" name="currency" class="required form-control" value="<?php if(isset($expense)){ echo $expense->currency; }else { echo $core_settings->currency; } ?>" required/>
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
        
                <label for="vat"><?=$this->lang->line('application_tax_included');?></label>
                <div class="input-group">
                        <input class="form-control" name="vat" type="text" value="<?php if(isset($expense)){ echo $expense->vat;}else{$core_settings->tax;} ?>"/>
                <div class="input-group-addon input-group-addon--right">%</div>
                </div>
         </div>
    </div>
</div>
  <div class="form-group">
        <label for="project"><?=$this->lang->line('application_assign_to_agent');?></label>
        <?php $options = array();
                foreach ($users as $value):  
                $options[$value->id] = $value->firstname." ".$value->lastname;
                endforeach;
        if(isset($expense) && is_object($expense->project)){$user = $expense->user_id;}else{$user = $this->user->id;}
        echo form_dropdown('user_id', $options, $user, 'style="width:100%" class="chosen-select"');?>
 </div> 
  <div class="form-group">
        <label for="project"><?=$this->lang->line('application_linked_to_project');?></label>
        <?php $options = array();
                $options['0'] = $this->lang->line('application_no');
                foreach ($projects as $value):  
                $options[$value->id] = $value->name;
                endforeach;
        if(isset($expense) && is_object($expense->project)){$project = $expense->project->id;}else{$project = "0";}
        echo form_dropdown('project_id', $options, $project, 'style="width:100%" class="chosen-select switcher" data-switcher="rebill" ');?>
 </div> 
 <div class="form-group">
        <label for="type"><?=$this->lang->line('application_rebill');?></label>
        <?php $options = array();
                $options['0'] = $this->lang->line('application_no');
                $options['1'] = $this->lang->line('application_yes');
                
        if(isset($expense)){
            $rebill = $expense->rebill; 
            if($rebill == 2){
                $options['2'] = $this->lang->line('application_rebilled_on_invoice')." #".$expense->invoice->reference;
                $disabled = "disabled";
            }else{$disabled = "";}
            
        }else{$rebill = "0"; $disabled = "disabled";}
        echo form_dropdown('rebill', $options, $rebill, 'id="rebill" style="width:100%" class="chosen-select" '.$disabled);?>
 </div>  

 <div class="form-group">
        <label for="reference"><?=$this->lang->line('application_receipt_reference');?></label>
        <input id="reference" type="text" name="reference" class="form-control"  value="<?php if(isset($expense)){echo $expense->reference;} ?>"  />
 </div>

 <div class="form-group">
                <label for="userfile"><?=$this->lang->line('application_attachment');?></label>
                <div>
                    <input id="uploadFile" type="text" name="dummy" class="form-control uploadFile" placeholder="<?php if(isset($expense) && !empty($expense->attachment)){ echo $expense->attachment; }else{ echo $this->lang->line('application_choose_file');} ?>" disabled="disabled" />
                          <div class="fileUpload btn btn-primary">
                              <span><i class="icon dripicons-upload"></i><span class="hidden-xs"> <?=$this->lang->line('application_select');?></span></span>
                              <input id="uploadBtn" type="file" data-switcher="attachment_description" name="userfile" class="upload switcher" accept="capture=camera" />
                          </div>
                  </div>
              </div> 
 <div class="form-group">
        <label for="attachment_description"><?=$this->lang->line('application_attachment_description');?></label>
        <input id="attachment_description" type="text" name="attachment_description" class="form-control"  value="<?php if(isset($expense) && !empty($expense->attachment)){echo $expense->attachment_description.'"';} else{ echo '" disabled="disabled"';}?>  />
 </div>
 <?php if(isset($expense) && is_object($expense->user)){ ?>
  <div class="form-group" style="font-size: 11px; margin: 23px 3px 3px;">
    <?=$this->lang->line('application_created_by')." ".$expense->user->firstname." ".$expense->user->lastname; ?> 
 </div>
<?php }?>
 <?php if(isset($expense) && is_object($expense->expense)){ ?>
  <div class="form-group" style="font-size: 11px; margin: 23px 3px 3px;">
    <label><?=$this->lang->line('application_recurring_expense');?></label>
    <a data-toggle="mainmodal" href="<?=base_url()?>expenses/update/<?=$expense->expense->id?>"> #<?=$expense->expense->id ?> </a>
 </div>
<?php }?>
        <div class="modal-footer">
        <input type="submit" name="send" class="btn btn-primary" value="<?=$this->lang->line('application_save');?>"/>
        <a class="btn" data-dismiss="modal"><?=$this->lang->line('application_close');?></a>
        </div>


<?php echo form_close(); ?>