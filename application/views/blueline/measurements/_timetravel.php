<?php
$attributes = array('class' => '', 'id' => '_timetravel');
echo form_open_multipart($form_action, $attributes);
?>
<div class="form-group">
        <label for="name">
            Justificativa para a alteração do fluxo *
        </label>
        <textarea id="Justificativa" name="Justificativa" class="required form-control" required></textarea>
    </div>
<div class="form-group">
        <label>Etapa destino</label>
        <?php $options = array();
                foreach ($steps_in_flow as $key => $value):
                    $options[$key] = $value;
                endforeach;
        echo form_dropdown('next_step_id', $options, null, 'style="width:100%" class="chosen-select" data-placeholder="'."Selecione a etapa desejada".'" tabindex="2"');?>
</div>

    <div class="modal-footer">
        <input name="travel" id="travel" type="submit" class="btn btn-primary" value="
			<?=$this->lang->line('application_save');?>"/>
        <a class="btn" data-dismiss="modal">
            <?=$this->lang->line('application_close');?>
        </a>
    </div>
<?php echo form_close(); ?>
<?php
//var_dump($form) ?>
<script>

    $(document).ready(function() {

    });
</script>