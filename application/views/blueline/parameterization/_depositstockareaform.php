<?php
$attributes = ['class' => '', 'id' => 'depositstockareaform'];
echo form_open_multipart($form_action, $attributes);
?>
    <div class="form-group">
        <label for="deposit_id">
            <?=$this->lang->line('application_deposits');?> *
        </label>
        <?php
            $deposit_arr = [];
            foreach($deposits as $d){
                $deposit_arr[$d->id] = $d->name;
            }
            echo form_dropdown('deposit_id', $deposit_arr, $deposit_stock_area->deposit_id, 'style="width:100%" class="chosen-select"');?>
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
            echo form_dropdown('stock_area_id', $stock_area_arr, $deposit_stock_area->stock_area_id, 'style="width:100%" class="chosen-select"');?>
    </div>

    <div class="form-group">
        <label for="capacity">
            <?=$this->lang->line('application_capacity');?> *
        </label>
        <input id="capacity" type="number" min="1" name="capacity" class="required form-control"  value="<?php if(isset($deposit_stock_area)){echo $deposit_stock_area->capacity;}?>"  required/>
    </div>

    <div class="modal-footer">
        <input type="submit" class="btn btn-primary" value="
			<?=$this->lang->line('application_save');?>"/>
        <a class="btn" data-dismiss="modal">
            <?=$this->lang->line('application_close');?>
        </a>
    </div>
<?php echo form_close(); ?>