<?php
$attributes = ['class' => '', 'id' => 'stockarearuleform'];
echo form_open_multipart($form_action, $attributes);
?>

    <div class="form-group">
        <label for="deposit_id">
            <?=$this->lang->line('application_deposit');?> *
        </label>
        <?php
            $deposits_arr = [];
            foreach($deposits as $d){
                $deposits_arr[$d->id] = $d->name;
            }
            echo form_dropdown('deposit_id', $deposits_arr, $rule->rule->{'deposit_id'}, 'style="width:100%" class="chosen-select"');?>
    </div>

    <div class="form-group">
        <label for="stock_area_id">
            <?=$this->lang->line('application_stock_areas');?> *
        </label>
        <?php
            $stock_area_arr = [];
            foreach($stock_areas as $s){
                $stock_area_arr[$s->id] = $s->name;
            }
            echo form_dropdown('stock_area_id', $stock_area_arr, $rule->rule->{'stock_area_id'}, 'style="width:100%" class="chosen-select"');?>
    </div>

    <div class="form-group">
        <label for="verification">
            <?=$this->lang->line('application_verification');?> *
        </label>
        <?php
            $unities = ['<' => $this->lang->line('application_less_than'),
                        '>' => $this->lang->line('application_greater_than'),
                        '=' => $this->lang->line('application_equals')];
            
            echo form_dropdown('operator', $unities, $rule->rule->{'operator'}, 'style="width:100%" class="chosen-select"');?>
    </div>

    <div class="form-group">
        <label for="quantity">
            <?=$this->lang->line('application_quantity');?> *
        </label>
        <input id="quantity" type="number" min="1" name="value" class="required form-control" value="<?php if(isset($rule)){echo $rule->rule->{'value'};}?>"  required />
    </div>

    <div class="modal-footer">
        <input type="submit" class="btn btn-primary" value="
			<?=$this->lang->line('application_save');?>"/>
        <a class="btn" data-dismiss="modal">
            <?=$this->lang->line('application_close');?>
        </a>
    </div>
<?php echo form_close(); ?>