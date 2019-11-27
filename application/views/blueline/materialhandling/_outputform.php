<?php
$attributes = ['class' => '', 'id' => 'outputform'];
echo form_open_multipart($form_action, $attributes);
?>
    <?php if(!$deposit_id): ?>
        <div class="form-group">
            <label for="deposit">
                <?=$this->lang->line('application_deposit');?> *
            </label>
            
            <?php
                $deposit_arr = [];
                foreach($deposits as $d){
                    $deposit_arr[$d->deposit_id] = $d->name;
                }
                echo form_dropdown('deposit_id', $deposit_arr, $output->deposit_id, 'style="width:100%" class="chosen-select"');
            ?>
        </div>
    <?php else:?>
        <input type="hidden" value="<?=$deposit_id?>" />
    <?php endif?>

    <div class="form-group">
        <label for="material">
            <?=$this->lang->line('application_material');?> *
        </label>
        <?php
            $material_arr = [];
            foreach($materials as $m){
                $material_arr[$m->material_id] = $m->description;
            }
            echo form_dropdown('material_id', $material_arr, $output->material_id, 'style="width:100%" class="chosen-select"');
        ?>
    </div>

    <div class="form-group">
        <label for="quantity">
            <?=$this->lang->line('application_quantity');?> *
        </label>
        <input id="quantity" type="number" min="1" name="quantity" class="required form-control" value="<?php if(isset($output)){echo $output->quantity;}?>"  required />
    </div>

    <div class="form-group">
        <label for="date">
            <?=$this->lang->line('application_date');?> *
        </label>
        <input id="date" type="date" name="date" class="required form-control" value="<?php if(isset($output)){echo $output->date;}?>"  required />
    </div>

    <div class="form-group hidden">
        <input id="id" type="number" name="id" class="required form-control" value="<?php if(isset($output)){echo $output->id;}?>" />
    </div>

    <div class="modal-footer">
        <input type="submit" class="btn btn-primary" value="
			<?=$this->lang->line('application_save');?>"/>
        <a class="btn" data-dismiss="modal">
            <?=$this->lang->line('application_close');?>
        </a>
    </div>
<?php echo form_close(); ?>