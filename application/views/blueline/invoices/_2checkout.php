<?php 

$attributes = array('class' => '', 'id' => 'tcoCCForm', 'onsubmit'=>"return false");
echo form_open($form_action, $attributes); 
?>
<input type="hidden" name="id" value="<?= $invoices->id;?>">
<input type="hidden" name="sum" value="<?= $sum;?>">
 <input id="sellerId" type="hidden" value="<?=$seller_id;?>" />
 <input id="publishableKey" type="hidden" value="<?=$publishable_key;?>" />
 <input id="token" name="token" type="hidden" value="" />

        <div id="payment-errors" class="payment-errors"></div>

        <div class="payment-help"><?=$this->lang->line('application_you_can_pay_with');?>: Mastercard, Visa, American Express, JCB, Discover, Diners Club.</div>

        <div class="form-group">
            <label><?=$this->lang->line('application_card_number');?></label>
            <input type="text" size="20" autocomplete="off" id="ccNo" value="" class="form-control input-medium" placeholder="<?=$this->lang->line('application_enter_without_spaces');?>" required >
        </div>

       
        <div class="row">
              <div class="col-xs-6 col-md-4">
                    <div class="form-group">
                        <label><?=$this->lang->line('application_month');?> (MM)</label>
                        <input type="text" size="2" id="expMonth" class="form-control" placeholder="<?=$this->lang->line('application_month');?>" required>
                    </div>
              </div>
              <div class="col-xs-6 col-md-4">
                      <div class="form-group">
                            <label><?=$this->lang->line('application_year');?> (YYYY)</label>
                            <input type="text" size="4" id="expYear"  class="form-control" placeholder="<?=$this->lang->line('application_year');?>" required>
                      </div>
              </div>
              <div class="col-xs-12 col-md-4">
                      <div class="form-group">
                            <label>CVC</label>
                            <input id="cvv" type="text" size="6" autocomplete="off" class="form-control card-cvc input-mini" placeholder="CVC code" required>
                       </div>
               </div>
        </div>

         <div class="form-group">
        <label for="value"><?=$this->lang->line('application_payment');?> *</label>
        <input id="value" type="text" name="sum" class="required form-control number money-format decimal"  value="<?= $sum;?>" required/>
        </div>
        
        <div class="modal-footer">
        <button type="submit" class="btn btn-primary" id="submitBtn" ><?=$this->lang->line('application_send');?></button>
        <a class="btn" data-dismiss="modal"><?=$this->lang->line('application_close');?></a>
        </div>

<?php echo form_close(); ?>


<script>
$(document).ready(function() {
    // Called when token created successfully.
    var successCallback = function(data) {
        var myForm = document.getElementById('tcoCCForm');

        // Set the token as the value for the token input
        myForm.token.value = data.response.token.token;

        // IMPORTANT: Here we call `submit()` on the form element directly instead of using jQuery to prevent and infinite token request loop.
        myForm.submit();
    };

    // Called when token creation fails.
    var errorCallback = function(data) {
        if (data.errorCode === 200) {
            tokenRequest();
        } else {
            alert(data.errorMsg);
        }
    };

    var tokenRequest = function() {
        // Setup token request arguments
        var args = {
            sellerId: "<?=$seller_id;?>",
            publishableKey: "<?=$publishable_key;?>",
            ccNo: $("#ccNo").val(),
            cvv: $("#cvv").val(),
            expMonth: $("#expMonth").val(),
            expYear: $("#expYear").val()
        };

        // Make the token request
        TCO.requestToken(successCallback, errorCallback, args);
    };

    $(function() {
        // Pull in the public encryption key for our environment
        TCO.loadPubKey('sandbox');

        $("#tcoCCForm").submit(function(e) {
            // Call our token request function
            tokenRequest();

            // Prevent form from submitting
            return false;
        });
    });
});
</script>



