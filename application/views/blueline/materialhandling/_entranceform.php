<?php
$attributes = ['class' => '', 'id' => 'entranceform'];
echo form_open_multipart($form_action, $attributes);
?>
    <?php if(!$deposit_id): ?>
        <div class="form-group">
            <label for="deposit_id">
                <?=$this->lang->line('application_deposit');?> *
            </label>
            
            <?php
                $deposit_arr = [];
                foreach($deposits as $d){
                    $deposit_arr[$d->id] = $d->name;
                }
                echo form_dropdown('deposit_id', $deposit_arr, $entrance->deposit_id, 'style="width:100%" class="chosen-select"');
            ?>
        </div>
    <?php else:?>
        <input type="hidden" name="deposit_id" value="<?=$deposit_id?>" />
    <?php endif?>

    <!--<div class="form-group">
        <label for="material">
            <?/*=$this->lang->line('application_material');*/?> *
        </label>
        <?php
    /*            $material_arr = [];
                foreach($materials as $m){
                    $material_arr[$m->id] = $m->description;
                }
                echo form_dropdown('material_id', $material_arr, $material_id, 'style="width:100%" class="chosen-select" readonly');
            */?>
    </div>-->

    <div class="form-group">
        <label for="quantity">
            <?=$this->lang->line('application_material');?> *
        </label>
        <input type="text" readonly class="form-control" value="<?php echo Material::find($material_id)->description;?>" />
    </div>

    <input type="hidden" name="material_id" value="<?=$material_id?>" />

    <div class="form-group">
        <label for="quantity">
            <?=$this->lang->line('application_quantity');?> *
        </label>
        <input id="quantity" type="number" min="1" name="quantity" class="required form-control" value="<?php if(isset($entrance)){echo $entrance->quantity;}?>"  required />
    </div>

    <!--<div class="form-group">
        <label for="date">
            <?/*=$this->lang->line('application_date');*/?> *
        </label>
        <input id="date" type="datetime-local" name="date" class="form-control" data-enable-time="true" value="<?php /*if(isset($entrance)){echo $entrance->date;}*/?>"  required />
    </div>-->

    <div class="form-group hidden">
        <input id="id" type="number" name="id" class="required form-control" value="<?php if(isset($entrance)){echo $entrance->id;}?>" />
    </div>

    <div class="modal-footer">
        <input type="submit" class="btn btn-primary" value="
			<?=$this->lang->line('application_save');?>"/>
        <a class="btn" data-dismiss="modal">
            <?=$this->lang->line('application_close');?>
        </a>
    </div>
<?php echo form_close(); ?>