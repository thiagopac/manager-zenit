<?php
$attributes = array('class' => '', 'id' => '_purchaseorder');
echo form_open_multipart($form_action, $attributes);
?>
<div id="form-render-wrap"></div>

<div class="modal-footer">
    <?php foreach ($actions as $action) : ?>
        <?php if ($action->progress == true) : ?>
            <button name="submit_1" class="btn btn-success button-loader"><?=$action->name?></button>
        <?php else : ?>
            <button name="submit_0" class="btn btn-danger button-loader"><?=$action->name?></button>
        <?php endif; ?>

    <?php endforeach; ?>
    <a class="btn btn-default" data-dismiss="modal"><?=$this->lang->line('application_close');?></a>
</div>
<?php echo form_close(); ?>
<script>
    jQuery(function() {
        var formData = JSON.parse(<?=$form?>),
            formRenderOpts = {
                dataType: 'json',
                formData: formData
            };

        var renderedForm = $('#form-render-wrap');
        renderedForm.formRender(formRenderOpts);

        // console.log(renderedForm.html());

        console.log(JSON.parse(<?=$form?>));
    });
</script>