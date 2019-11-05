<?php
$attributes = ['class' => '', 'id' => 'material_form'];
echo form_open_multipart($form_action, $attributes);
?>

    <div class="form-group">
        <label for="description">
            <?=$this->lang->line('application_description');?> *
        </label>
        <input id="description" type="text" name="description" class="required form-control"  value="<?php if(isset($material)){echo $material->description;}?>"  required/>
    </div>

    <div class="form-group">
        <label for="unity">
            <?=$this->lang->line('application_unity');?> *
        </label>
        <?php
            $unities = ['unity' => $this->lang->line('application_unity'),
                        'piece' => $this->lang->line('application_piece'),
                        'package' => $this->lang->line('application_package'),
                        'coil' => $this->lang->line('application_coil'),
                        'box' => $this->lang->line('application_box'),
                        'meter' => $this->lang->line('application_meter'),
                        'kilo' => $this->lang->line('application_kilo')];

            echo form_dropdown('unity', $unities, $material->unity, 'style="width:100%" class="chosen-select"');?>
    </div>

    <div class="form-group">
        <label for="stock_area_id">
            <?=$this->lang->line('application_area');?> *
        </label>
        <?php
            $stock_areas_arr = [];
            foreach($stock_areas as $s){
                $stock_areas_arr[$s->id] = $s->name;
            }
            echo form_dropdown('stock_area_id', $stock_areas_arr, $material->stock_area_id, 'style="width:100%" class="chosen-select"');?>
    </div>

    <div class="modal-footer">
        <input type="submit" class="btn btn-primary" value="
			<?=$this->lang->line('application_save');?>"/>
        <a class="btn" data-dismiss="modal">
            <?=$this->lang->line('application_close');?>
        </a>
    </div>
<?php echo form_close(); ?>