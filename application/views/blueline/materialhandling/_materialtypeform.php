<?php
$attributes = ['class' => '', 'id' => 'materialtype_form'];
echo form_open_multipart($form_action, $attributes);
?>

    <div class="form-group">
        <label for="name">
            <?=$this->lang->line('application_name');?> *
        </label>
        <input id="name" type="text" name="name" class="required form-control"  value="<?php if(isset($material_type)){echo $material_type->name;}?>"  required/>
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
            echo form_dropdown('stock_area_id', $stock_area_arr, $material_type->stock_area_id, 'style="width:100%" class="chosen-select"');?>
    </div>

    <div class="modal-footer">
        <input type="submit" class="btn btn-primary" value="
			<?=$this->lang->line('application_save');?>"/>
        <a class="btn" data-dismiss="modal">
            <?=$this->lang->line('application_close');?>
        </a>
    </div>
<?php echo form_close(); ?>