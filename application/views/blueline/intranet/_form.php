<?php
$attributes = ['class' => '', 'id' => '_form'];
echo form_open_multipart($form_action, $attributes);
?>
    <div class="form-group">
        <label>
            Nome *
        </label>
        <input id="name" type="text" name="name" class="required form-control"  value="<?php if(isset($form)){echo $form->name;}?>"  required/>
    </div>
    <div class="form-group">
        <label>
            Descrição *
        </label>
        <input id="description" type="text" name="description" class="required form-control"  value="<?php if(isset($form)){echo $form->description;}?>"  required/>
    </div>
    <div class="form-group">
        <label>
            ID do formulário no Auditor *
        </label>
        <input id="auditor_form_id" type="text" name="auditor_form_id" class="required form-control"  value="<?php if(isset($form)){echo $form->auditor_form_id;}?>"  required/>
    </div>
    <div class="form-group">
        <label>
            Ordenação
        </label>
        <input id="ordered" type="number" name="ordered" class="form-control"  value="<?php if(isset($form)){echo $form->ordered;}?>"/>
    </div>
    <div class="form-group">
        <label>Ativo</label>
        <?php $options = [
            '1' => "Sim",
            '0' => "Não"
        ]; ?>

        <?php
        if (isset($form)) {
            $active = $form->active;
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
