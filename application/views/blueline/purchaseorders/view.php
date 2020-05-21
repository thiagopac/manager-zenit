<div id="message-nano-wrapper" class="nano ">
    <div class="nano-content">
        <div class="header">
            <div class="message-content-menu">
                <button class="message-reply-button btn btn-success" <?=count($actions) > 0 && $purchase_order->finished != 1 ? '' : 'disabled'; ?> role="button"><i class="icon dripicons-forward"></i> <?=$this->lang->line('application_actions'); ?></button>
<!--                    <a class="btn btn-danger" href="--><?//=base_url()?><!--purchaseorders/delete/--><?//=end($conversation)->id?><!--" role="button"><i class="icon dripicons-trash"></i> --><?//=$this->lang->line('application_delete'); ?><!--</a>-->
            </div>

            <h1 class="page-title"><a class="icon glyphicon glyphicon-chevron-right trigger-message-close"></a><br><span class="dot"></span><?=$value->subject; ?>
                <span class="grey"><?=$purchase_order->subject?></span>
            </h1>
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

                <div class="container-fluid">
                    <label><?=$this->lang->line('application_actions'); ?></label>

                    <div class="form-group">
                        <label for="history_text"><?=$this->lang->line('application_considerations');?></label>
                        <input type="text" name="history_text" class="form-control" id="history_text" placeholder=""/>
                    </div>

                    <div class="form-group">
                        <label for="history_files"><?=$this->lang->line('application_attach_files');?></label>
                        <input name="files[]" type="file" access="false" multiple="true" class="form-control" id="files">
                    </div>

                    <div class="textarea-footer message-footer">

                        <?php foreach ($actions as $action) : ?>
                            <?php if ($action->progress == true) : ?>
                                <button name="submit_1" class="btn btn-success button-loader"><?=$action->name?></button>
                            <?php elseif ($action->progress == false && $action->jump == false) : ?>
                                <button name="submit_0" class="btn btn-danger button-loader"><?=$action->name?></button>
                            <?php elseif ($action->jump == true) : ?>

                            <?php endif; ?>

                        <?php endforeach; ?>

                        <!--<div class="pull-right small-upload"><input id="uploadFile" class="form-control uploadFile" placeholder="" disabled="disabled" />
                            <div class="fileUpload btn btn-primary">
                                <span><i class="icon dripicons-upload"></i><span class="hidden-xs"></span></span>
                                <input id="uploadBtn" type="file" name="userfile" class="upload" />
                            </div>
                        </div>-->
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
                                <?php if ($reg->history_text != null) : ?>
                                    <p><b><?=$this->lang->line('application_considerations');?>:</b> <?=$reg->history_text;?></p>
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
        jQuery(document).ready(function($) {

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

        });
    </script>
