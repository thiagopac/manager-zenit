
 <?php 
$attributes = array('class' => '', 'id' => 'payment-form');
echo form_open($form_action, $attributes); 
?>
<input type="hidden" name="invoice_id" value="<?= $invoices->id;?>">
        

        <div class="payment-help"><?=$this->lang->line('application_you_can_pay_with');?>: Mastercard, Visa, American Express, JCB, Discover, Diners Club.</div>

        <div class="form-group">
        <label><?=$this->lang->line('application_card_number');?></label>
        <input type="number" size="20" autocomplete="off" name="x_card_num" class="form-control card-number input-medium" placeholder="<?=$this->lang->line('application_enter_without_spaces');?>" required>
        </div>

        <div class="row">
              <div class="col-xs-6 col-md-4">
                    <div class="form-group">
                        <label><?=$this->lang->line('application_month');?> (MM)</label>
                        <input type="number" name="x_card_month" size="2" min="1" max="12" class="form-control card-expiry-month" placeholder="<?=$this->lang->line('application_month');?>" required>
                    </div>
              </div>
              <div class="col-xs-6 col-md-4">
                      <div class="form-group">
                          <label><?=$this->lang->line('application_year');?> (YYYY)</label>
                          <input type="number" name="x_card_year" size="2" min="10" max="99" class="form-control card-expiry-year" placeholder="<?=$this->lang->line('application_year');?>" required>
                      </div>
              </div>
              <div class="col-xs-12 col-md-4">
                      <div class="form-group">
                            <label>CVC</label>
                            <input type="text" size="4" autocomplete="off" name="x_card_code" class="form-control card-cvc input-mini" placeholder="CVC code" required>
                      </div>
              </div>
        </div>
        
        <div class="form-group">
        <label for="value"><?=$this->lang->line('application_payment');?> *</label>
        <input id="value" type="text" name="sum" class="required form-control number money-format"  value="<?= $sum;?>" required/>
        </div>
        
        <div class="modal-footer">
        <button type="submit" class="btn btn-primary" id="submitBtn"><?=$this->lang->line('application_send');?></button>
        <a class="btn" data-dismiss="modal"><?=$this->lang->line('application_close');?></a>
        </div>

<?php echo form_close(); ?>



