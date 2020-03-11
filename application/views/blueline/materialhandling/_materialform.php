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
        <label for="material_type_id">
            <?=$this->lang->line('application_type');?> *
        </label>
        <?php
            $material_type_arr = [];
            foreach($material_types as $m){
                $material_type_arr[$m->id] = $m->name;
            }
            echo form_dropdown('material_type_id', $material_type_arr, $material->material_type_id, 'style="width:100%" class="chosen-select"');?>
    </div>

    <div class="form-group">
        <label for="price"><?=$this->lang->line('application_price');?></label>
        <div class="input-group"> <div class="input-group-addon"><?=$core_settings->money_symbol?></div>
            <input id="price" type="text" name="price" class="form-control" value="<?php if (isset($material)) { echo $material->price;} ?>" />
        </div>
    </div>

    <div class="form-group">
        <label for="description">
            <?=$this->lang->line('application_min_qty');?> *
        </label>
        <input id="min_qty" type="number" name="min_qty" class="required form-control"  value="<?php if(isset($material)){echo $material->min_qty;}?>"  required/>
    </div>

    <div class="modal-footer">
        <input type="submit" class="btn btn-primary" value="
			<?=$this->lang->line('application_save');?>"/>
        <a class="btn" data-dismiss="modal">
            <?=$this->lang->line('application_close');?>
        </a>
    </div>
<?php echo form_close(); ?>

<script>
    $(document).ready(function() {

        $("#price").inputmask('decimal', {
            'alias': 'numeric',
            'autoGroup': true,
            'digits': 2,
            'radixPoint': ",",
            'digitsOptional': false,
            'allowMinus': false,
            'rightAlign': false,
            'unmaskAsNumber': true,
            'placeholder': '',
            'removeMaskOnSubmit': true
        })

        // $("#price").mask('#.##0,00', {reverse: true});

    });
</script>
