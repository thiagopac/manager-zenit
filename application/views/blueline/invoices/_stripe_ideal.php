
 <?php 
$attributes = array('class' => '', 'id' => 'payment-ideal-form');
echo form_open($form_action, $attributes); 
?>
<input type="hidden" name="id" value="<?= $invoices->id;?>">
<input type="hidden" class="redirect" value="<?=base_url()?><?=(is_object($this->client)) ? "c" : "";?>invoices/idealpay/<?=$invoices->id;?>">
<input type="hidden" name="type" value="ideal">
      
      <div id="source-updates">
</div>

       
        <div class="row">
              <div class="col-xs-12 col-md-12">
                    <div class="form-group">
                        <label><?=$this->lang->line('application_fullname');?></label>
                        <input type="text" name="owner-name" class="form-control owner-name" placeholder="<?=$this->lang->line('application_fullname');?>">
                    </div>
              </div>
        </div>


         <div class="form-group">
        <label for="value"><?=$this->lang->line('application_payment');?> *</label>
        <input id="value" type="text" name="sum" class="required form-control decimal sum"  value="<?= $sum;?>" required/>
        </div>

        
        <div class="modal-footer">
        <button type="submit" class="btn btn-primary" id="submitBtn"><?=$this->lang->line('application_send');?></button>
        <a class="btn" data-dismiss="modal"><?=$this->lang->line('application_close');?></a>
        </div>

<?php echo form_close(); ?>



<script type="text/javascript">

$(document).ready(function() {

    $("#payment-ideal-form").submit(function(event) {
        $('#submitBtn').attr('disabled', 'disabled');
        return false;
    }); 
    $("#payment-ideal-form").change(function() {
        $('#submitBtn').removeAttr("disabled");
    });

}); 
</script> 


<script type="text/javascript">
Stripe.setPublishableKey('<?php echo $public_key; ?>');
</script>
 <script type="text/javascript" src="<?=base_url()?>assets/blueline/js/plugins/buy.js"></script>
