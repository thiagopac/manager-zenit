<div id="message-nano-wrapper" class="nano ">
    <div class="nano-content">
        <div class="header">
            <div class="message-content-menu">
                <button class="message-reply-button btn btn-success" <?=count($actions) > 0 && $purchase_order->finished != 1 ? '' : 'disabled'; ?> role="button">
                    <i class="icon dripicons-forward"></i> <?=$this->lang->line('application_actions'); ?>
                </button>
<!--                    <a class="btn btn-danger" href="--><?//=base_url()?><!--purchaseorders/delete/--><?//=end($conversation)->id?><!--" role="button"><i class="icon dripicons-trash"></i> --><?//=$this->lang->line('application_delete'); ?><!--</a>-->
            </div>

            <h1 class="page-title"><a class="icon glyphicon glyphicon-chevron-right trigger-message-close"></a><br><span class="dot"></span><?=$value->subject; ?>
                <span class="grey">[<?=$this->lang->line('application_purchase_order');?> <?=$purchase_order->id?>] - <?=$purchase_order->subject?></span>
            </h1>
            <!--<div class="btn-group pull-right">
                <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    PDF <span class="caret"></span>
                </button>
                <ul class="dropdown-menu">
                    <li><a href="https://ownergy.com.br/zenit/invoices/preview/1275">Download</a></li>
                    <li><a href="https://ownergy.com.br/zenit/invoices/preview/1275/show" target="_blank">Preview</a></li>
                </ul>
            </div>-->
            <?php $unix = human_to_unix($purchase_order->created_at); ?>
            <p class="subtitle"><?=$this->lang->line('application_claimant'); ?>: <?=$purchase_order->user->firstname?>, <?=$this->lang->line('application_started_on'); ?> <?php  echo date($core_settings->date_format . ' ' . $core_settings->date_time_format, $unix); ?></p>
        </div>

        <div class="message-container">

            <div class="container-fluid" style="width:100%;margin: 0px;padding: 0px;">
                <ul class="list-unstyled multi-steps" style="cursor: pointer">
                    <?php if ($purchase_order->canceled != true) : ?>
                        <?php foreach ($steps as $step) : ?>
                            <li title="<?=implode('&#xD;', array_column($step->members, 'name'))?>" class="<?=$purchase_order->step == $step->id && $purchase_order->finished != 1 ? 'is-active' : ''; ?>"><?=$step->name; ?></li>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <?php foreach ($history->steps as $step) : ?>
                            <li class="danger canceled"><?=$step->name; ?></li>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </ul>
            </div>
            <br />
            <div class="message-content-reply">
                <?php
                $attributes = ['class' => 'ajaxform', 'id' => 'replyform'];
                echo form_open_multipart('purchaseorders/reply', $attributes); ?>

                <input type="hidden" name="id" value="<?=$id;?>">
                <input type="hidden" name="current_step" value="<?=$current_step->id;?>">

                <div class="container-fluid">
                    <label><?=$this->lang->line('application_actions'); ?></label>

                    <div id="form-render-wrap"></div>

                    <div class="textarea-footer message-footer">

                        <p><?=$this->lang->line('application_current_step');?>: <label class="badge badge-success"><?=$current_step->name?></label></p>

                        <?php foreach ($actions as $action) : ?>
                            <?php if ($action->progress == true) : ?>
                                <button name="submit_1" class="btn btn-success button-loader"><?=$action->name?></button>
                            <?php elseif ($action->progress == false && $action->jump == false) : ?>
                                <button name="submit_0" class="btn btn-danger button-loader"><?=$action->name?></button>
                            <?php elseif ($action->jump == true) : ?>

                            <?php endif; ?>

                        <?php endforeach; ?>

                    </div>
                </div>
                <?php echo form_close(); ?>
            </div>

            <div>
                <h3><?=$this->lang->line('application_purchase_order_history');?></h3>
                <ul id="comments-ul" class="comments">
                    <?php foreach ($history->steps as $reg) : ?>
                        <li class="comment-item">
                            <div class="comment-pic"><i class="icon dripicons-checkmark"></i></div>
                            <div class="comment-content">
                                <h5><span style="font-weight: 500"><?=$reg->name?>:</span> <span style="font-weight: 300"><?=$reg->message?></span></h5>
                                <p><?=$this->lang->line('application_made_by');?> <b><?=User::find($reg->user_id)->firstname.' '.User::find($reg->user_id)->lastname?></b> <?=$this->lang->line('application_at'); ?> <b><?=date($core_settings->date_format . '</b> à\s <b>' . $core_settings->date_time_format, human_to_unix($reg->date)).'</b>';?></p>
                                <?php if ($reg->history_data != null) : ?>
                                    <?php foreach ($reg->history_data as $reg_data) :?>
                                        <p><b><?=implode(' ',(explode('_', $reg_data->label)));?>:</b>
                                            <?php
                                            if ($reg_data->className == "form-control mask-money"){
                                                $reg_data->value = $core_settings->money_symbol.''.display_money($reg_data->value);
                                                // echo('echo');
                                            }else if ($reg_data->className == "form-control mask-date"){
                                                $reg_data->value = date($core_settings->date_format, human_to_unix($reg_data->value.' 00:00'));
                                            }else if($reg_data->type == "file"){ ?>
                                                <a href="<?=base_url()?>files/purchaseorders/<?=$reg_data->value?>" target="_blank"><i class="dripicons dripicons-document" style="font-size: 22px"></i>
                                                    <small>(.<?=explode('.', $reg_data->value)[1] ?>)</small>
                                                </a>
                                            <?php
                                            } 
                                            if($reg_data->type != 'file'){
                                                echo($reg_data->value);
                                            }
                                            ?>

                                            </p>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                                <?php if ($reg->history_files != null) : ?>
                                    <p><b><?=$this->lang->line('application_attached_files');?>:</b>
                                    <p>
                                        <?php foreach ($reg->history_files as $file) : ?>

                                            <a href="<?=base_url()?>files/purchaseorders/<?=$file?>" target="_blank"><i class="dripicons dripicons-document" style="font-size: 22px"></i>
                                                <small>(.<?=explode('.', $file)[1] ?>)</small>
                                            </a>
                                        <?php endforeach; ?>
                                    </p>
                                    </p>
                                <?php endif; ?>
                            </div>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>

            <div>
                <h3><?=$this->lang->line('application_purchase_order_data');?></h3>
                <table class="data-no-search table noclick">
                    <thead style="background:#ececec">
                        <th style="width: 35%"><?=$this->lang->line('application_field_question');?></th>
                        <th><?=$this->lang->line('application_field_filled');?></th>
                    </thead>
                    <?php foreach ($form as $field) : ?>
                        <?php $fieldname = $field->name; ?>
                        <tr>
                            <?php if ($response->$fieldname != null) :  ?>
                                <?php if (!is_array($response->$fieldname)) :  ?>
                                    <td><strong><?=$field->label?></strong></td>
                                    <?php if ($field->className == 'form-control mask-money') : ?>
                                        <td>
                                            <?=$core_settings->money_symbol?><?=display_money($response->$fieldname)?>
                                        </td>
                                    <?php elseif ($field->className == 'form-control mask-date') : ?>
                                        <td>
                                            <?=date($core_settings->date_format, human_to_unix($response->$fieldname.' 00:00'))?>
                                        </td>
                                    <?php else : ?>
                                        <td><?=$response->$fieldname?></td>
                                    <?php endif; ?>
                                <?php else : ?>
                                    <td><strong><?=$field->label?></strong></td>
                                    <td><?php foreach ($response->$fieldname as $field) : ?>
                                            <a href="<?=base_url()?>files/purchaseorders/<?=$field?>" target="_blank"><i class="dripicons dripicons-document" style="font-size: 22px"></i>
                                            <small>(.<?=explode('.', $field)[1] ?>)</small>
                                            </a>
                                        <?php endforeach; ?>
                                    </td>
                                <?php endif; ?>
                            <?php endif; ?>
                        </tr>
                    <?php endforeach; ?>
                </table>
            </div>

        </div>
    </div>

    <br><br>
    <script>

        jQuery(function() {

            var formData = <?=$step_form?>,
                formRenderOpts = {
                    dataType: 'json',
                    formData: formData
                };

            var renderedForm = $('#form-render-wrap');
            renderedForm.formRender(formRenderOpts);

        });

        jQuery(document).ready(function($) {

            $("button[name='submit_0'").click(function () {
                $(this.form).find(':input[required]:visible').each(function() {
                    $(this).removeAttr('required')
                });
            })

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

            $('.nano').nanoScroller();
            $('.trigger-message-close').on('click', function() {
                $('body').removeClass('show-message');
                $('#main .message-list li').removeClass('active');
                messageIsOpen = false;
                $('body').removeClass('show-main-overlay');
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

        });
    </script>
