<?php
$attributes = array('class' => '', 'id' => '_measurement');
echo form_open_multipart($form_action, $attributes);
?>
<div id="form-render-wrap"></div>

<div class="modal-footer">
    <a class="btn btn-danger" data-dismiss="modal"><?=$this->lang->line('application_close');?></a>
    <?php foreach ($actions as $action) : ?>
        <?php if ($action->progress == true) : ?>
            <input type="submit" name="submit_1" class="btn btn-success button-loader" value="<?=$action->name?>" />
        <?php else : ?>
            <input type="submit" name="submit_0" class="btn btn-danger button-loader" <?=$action->name?> />
        <?php endif; ?>

    <?php endforeach; ?>
</div>
<?php echo form_close(); ?>
<?php
//var_dump($form) ?>
<script>
    jQuery(function() {

        var formData = <?=$form?>,
            formRenderOpts = {
                dataType: 'json',
                formData: formData
            };

        var renderedForm = $('#form-render-wrap');
        renderedForm.formRender(formRenderOpts);

        //console.log(<?//=$form?>//);
    });

    $(document).ready(function() {

        $('input[data-effect="hide"]').parent().hide();

        const affectators = $('[data-affect]');

        $(affectators).on('change', function() {
            if ($(this).data('result') == 'unhide'){
                if ($(this).data('condition') == this.value) {
                    $("#form-render-wrap").find("[id='" + $(this).data('affect') + "']").parent().show();
                }else{
                    $("#form-render-wrap").find("[id='" + $(this).data('affect') + "']").parent().hide();
                }
            }
        });

        $(".mask-money").inputmask('decimal', {
            'prefix' : 'R$ ',
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

        function checkForm() {
            // here, "this" is an input element
            var isValidForm = true;
            $(this.form).find(':input[required]:visible').each(function() {
                if (!this.value.trim()) {
                    isValidForm = false;
                }
            });
            // $(this.form).find('.button-loader').prop('disabled', !isValidForm);
            isValidForm == false ? toastr.error('Você precisa preencher todos os campos obrigatórios') : '';

            return isValidForm;
        }

        $('.button-loader').closest('form')
        // indirectly bind the handler to form
            .submit(function() {
                return checkForm.apply($(this).find(':input')[0]);
            })
            // look for input elements
            .find(':input[required]:visible')
            // bind the handler to input elements
            .keyup(checkForm)
            // immediately fire it to initialize buttons state
            .keyup();


    });
</script>