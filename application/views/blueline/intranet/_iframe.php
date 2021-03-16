<?php
$attributes = ['class' => '', 'id' => '_iframe'];
echo form_open_multipart($form_action, $attributes);
?>
    <div class="form-group">
        <label>
            Nome *
        </label>
        <input id="name" type="text" name="name" class="required form-control"  value="<?php if(isset($iframe)){echo $iframe->name;}?>"  required/>
    </div>
    <div class="form-group">
        <label>
            Descrição *
        </label>
        <input id="description" type="text" name="description" class="required form-control"  value="<?php if(isset($iframe)){echo $iframe->description;}?>"  required/>
    </div>
    <div class="form-group">
        <label>
            Link *
        </label>
        <input id="link" type="text" name="link" class="required form-control"  value="<?php if(isset($iframe)){echo $iframe->link;}?>"  required/>
    </div>
    <div class="form-group">
        <label>
            Ordenação
        </label>
        <input id="ordered" type="number" name="ordered" class="form-control"  value="<?php if(isset($iframe)){echo $iframe->ordered;}?>"/>
    </div>
    <div class="form-group">
        <label>Ativo</label>
        <?php $options = [
            '1' => "Sim",
            '0' => "Não"
        ]; ?>

        <?php
        if (isset($iframe)) {
            $active = $iframe->active;
        } else {
            $active = '0';
        }
        echo form_dropdown('active', $options, $active, 'style="width:100%" class="chosen-select"'); ?>
    </div>


    <div class="modal-footer">
        <input type="submit" class="btn btn-primary" value="
			<?=$this->lang->line('application_save');?>"/>
        <a class="btn" data-dismiss="modal">
            <?=$this->lang->line('application_close');?>
        </a>
    </div>
<?php echo form_close(); ?>
