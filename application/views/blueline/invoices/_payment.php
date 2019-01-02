<?php 
$attributes = ['class' => '', 'id' => '_partial'];
echo form_open($form_action, $attributes);
?>

<input id="invoice_id" type="hidden" name="invoice_id" value="<?=$invoice->id;?>" />
<?php if (isset($payment)) {
    ?>
<input id="id" type="hidden" name="id" value="<?=$payment->id; ?>" />
<?php
} ?>

        <div class="form-group">
                <label for="name">
                        <?=$this->lang->line('application_reference_id');?>
                </label>
                <input id="name" name="reference" type="text" class="required form-control" value="<?php if (isset($payment)) {
        echo $payment->reference;
    } else {
        echo $invoice->reference . '00' . $payment_reference;
    }?>" />
        </div>
        <div class="form-group">
                <label for="value">
                        <?=$this->lang->line('application_value');?> *</label>
                <input id="value" type="text" name="amount" class="required form-control number money-format" value="<?php if (isset($payment)) {
        echo $payment->amount;
    } else {
        echo $sumRest;
    }?>" required/>
        </div>
        <div class="form-group">
                <label for="date">
                        <?=$this->lang->line('application_date');?> *</label>
                <input class="form-control datepicker" name="date" id="date" type="text" value="<?php if (isset($payment)) {
        echo $payment->date;
    } else {
        echo date('Y-m-d', time());
    }?>" required/>
        </div>
        <div class="form-group">
                <label for="client">
                        <?=$this->lang->line('application_type');?>
                </label>
                <br>
                <?php $options = [];
                $options['cash'] = $this->lang->line('application_cash');
                $options['credit_card'] = $this->lang->line('application_credit_card');
                $options['paypal'] = $this->lang->line('application_paypal');
                $options['bank_transfer'] = $this->lang->line('application_bank_transfer');
                $options['check'] = $this->lang->line('application_check');
                $options['direct_debit'] = $this->lang->line('application_direct_debit');

                if (isset($payment)) {
                    $select = $payment->type;
                } else {
                    $select = 'cash';
                }
        echo form_dropdown('type', $options, 'cash', 'style="width:100%" class="chosen-select"');?>

        </div>
        <div class="form-group">
                <label for="textfield">
                        <?=$this->lang->line('application_description');?>
                </label>
                <textarea class="input-block-level form-control" id="textfield" name="notes"><?php if (isset($payment)) {
            echo $payment->notes;
        } ?></textarea>
        </div>


        <ul class="accesslist">
                <li>
                        <input name="receipt" class="checkbox" data-labelauty="<?=$this->lang->line('application_send_receipt_to_client');?>" value="1"
                                type="checkbox" />
                </li>
        </ul>



        <div class="modal-footer">
                <input type="submit" name="send" class="btn btn-primary" value="<?=$this->lang->line('application_save');?>" />
                <a class="btn" data-dismiss="modal">
                        <?=$this->lang->line('application_close');?>
                </a>
        </div>
        <?php echo form_close(); ?>