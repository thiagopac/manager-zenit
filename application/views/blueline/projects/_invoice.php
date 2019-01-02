<?php   
$attributes = array('class' => '', 'id' => '_invoices');
echo form_open($form_action, $attributes); 
?>

<?php if(isset($invoice)){ ?>
<input id="id" type="hidden" name="id" value="<?=$invoice->id;?>" />
<?php } ?>
<?php if(isset($view)){ ?>
<input id="view" type="hidden" name="view" value="true" />
<?php } ?>
<input id="company_id" type="hidden" name="company_id" value="<?=$project->company_id;?>" />
<input id="project_id" type="hidden" name="project_id" value="<?=$project->id;?>" />
<input id="status" name="status" type="hidden" value="Open"> 
 <div class="form-group">
        <label for="reference"><?=$this->lang->line('application_reference_id');?> *</label>
        <?php if(!empty($core_settings->invoice_prefix)){ ?>
       <div class="input-group"> <div class="input-group-addon"><?=$core_settings->invoice_prefix;?></div> <?php } ?>
        <input id="reference" type="text" name="reference" class="form-control"  value="<?php if(isset($invoice)){echo $invoice->reference;} else{ echo $core_settings->invoice_reference; } ?>" />
        <?php if(!empty($core_settings->invoice_prefix)){ ?> </div><?php } ?>
 </div>

<?php if(isset($invoice)){ ?>
 <div class="form-group">
        <label for="status"><?=$this->lang->line('application_status');?></label>
        <?php $options = array(
                  'Open'  => $this->lang->line('application_Open'),
                  'Sent'    => $this->lang->line('application_Sent'),
                  'Paid' => $this->lang->line('application_Paid'),
                  'PartiallyPaid' => $this->lang->line('application_PartiallyPaid'),
                  'Canceled' => $this->lang->line('application_Canceled'),

                );
                echo form_dropdown('status', $options, $invoice->status, 'style="width:100%" class="chosen-select"'); ?>

 </div>
<?php } ?>
<?php if(isset($invoice)){ if($invoice->status == "Paid"){ ?>
 <div class="form-group">
        <label for="paid_date"><?=$this->lang->line('application_payment_date');?></label>
        <input id="paid_date" type="text" name="paid_date" class="datepicker form-control" value="<?php if(isset($invoice)){echo $invoice->paid_date;} ?>"  required/>
 </div>
 <?php }} ?>
 <div class="form-group">
        <label for="issue_date"><?=$this->lang->line('application_issue_date');?> *</label>
        <input id="issue_date" type="text" name="issue_date" class="required datepicker form-control" value="<?php if(isset($invoice)){echo $invoice->issue_date;} ?>"  required/>
 </div>
 <div class="form-group">
        <label for="due_date"><?=$this->lang->line('application_due_date');?> *</label>
        <input id="due_date" type="text" name="due_date" class="required datepicker-linked form-control" value="<?php if(isset($invoice)){echo $invoice->due_date;} ?>"  required/>
 </div>
 <div class="form-group">
        <label for="currency"><?=$this->lang->line('application_currency');?></label>
        <input id="currency" type="text" name="currency" list="currencylist" class="required form-control no-numbers" value="<?php if(isset($invoice)){ echo $invoice->currency; }else { echo $core_settings->currency; } ?>" required/>
        <datalist id="currencylist">
          <option value="AUD"></option>
          <option value="BRL"></option>
          <option value="CAD"></option>
          <option value="CZK"></option>
          <option value="DKK"></option>
          <option value="EUR"></option>
          <option value="HKD"></option>
          <option value="HUF"></option>
          <option value="ILS"></option>
          <option value="JPY"></option>
          <option value="MYR"></option>
          <option value="MXN"></option>
          <option value="NOK"></option>
          <option value="NZD"></option>
          <option value="PHP"></option>
          <option value="PLN"></option>
          <option value="GBP"></option>
          <option value="SGD"></option>
          <option value="SEK"></option>
          <option value="CHF"></option>
          <option value="TWD"></option>
          <option value="THB"></option>
          <option value="TRY"></option>
          <option value="USD"></option>
        </datalist>
 </div>
 <div class="form-group">
        <label for="currency"><?=$this->lang->line('application_discount');?></label>
        <input class="form-control" name="discount" id="appendedInput" type="text" value="<?php if(isset($invoice)){ echo $invoice->discount;} ?>"/>
 </div>
 <div class="form-group">
        <label for="terms"><?=$this->lang->line('application_terms');?></label>
        <textarea id="terms" name="terms" class="textarea required summernote-modal form-control" style="height:100px"><?php if(isset($invoice)){echo $invoice->terms;}else{ echo $core_settings->invoice_terms; }?></textarea>
 </div>
  <div class="form-group">
        <label for="terms"><?=$this->lang->line('application_custom_tax');?></label>
        <input class="form-control" name="tax" type="text" value="<?php if(isset($invoice)){ echo $invoice->tax;}else{echo $core_settings->tax;} ?>" />
 </div>
    <div class="form-group">
        <label for="terms"><?=$this->lang->line('application_second_tax');?></label>
        <input class="form-control" name="second_tax" type="text" value="<?php if(isset($invoice)){ echo $invoice->second_tax;} ?>"/>
 </div>

<div class="form-group">
  <label><?=$this->lang->line('application_convert_tasks_into_invoice_items');?></label>
  <a href="#" id="toggle_all_checkboxes" data-all-toggled="true" class="btn btn-primary btn-xs"><?=$this->lang->line('application_all');?></a>
  <a href="#" id="toggle_class_checkboxes" data-toggle-class="done" class="btn btn-primary btn-xs"><?=$this->lang->line('application_select_done_only');?></a>

  <ul class="accesslist checkboxlist">
    
    <?php 
      $tasks = $project->project_has_tasks;
      function cmp($a, $b)
      {
          return strcmp($a->invoice_id, $b->invoice_id);
      }

      usort($tasks, "cmp");
      foreach ($tasks as $value) { 
          $seconds = $value->time_spent;
          $H = floor($seconds / 3600);
          $i = ($seconds / 60) % 60;
          $s = $seconds % 60;
          $hours = sprintf('%0.2f', $H+($i/60));
          $sum = sprintf('%0.2f', $hours*$value->value);
          ?>
          <?php if($value->invoice_id == 0){ ?>
          <li class="<?php echo ($value->progress == 100 || $value->status == "done") ? 'done' : "";?>">          
            
            <input type="checkbox" class="checkbox" id="r_<?=$value->id;?>" name="tasks[]" data-labelauty="[ <?=display_money($sum)?> ] <?=htmlspecialchars($value->name);?>" value="<?=$value->id;?>" <?php if(($value->progress == 100 || $value->status == "done") && $value->invoice_id == 0){ echo 'checked="checked"';}?>>  
          </li>
        <?php }?>
    <?php } ?>
  </ul>
</div>

        <div class="modal-footer">
        <input type="submit" name="send" class="btn btn-primary" value="<?=$this->lang->line('application_save');?>"/>
        <a class="btn" data-dismiss="modal"><?=$this->lang->line('application_close');?></a>
        </div>


<?php echo form_close(); ?>