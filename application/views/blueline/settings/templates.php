<script type="text/javascript" src="<?=base_url()?>assets/blueline/js/plugins/ckeditor/ckeditor.js"></script>
<div id="row">

    <?php include 'settings_menu.php'; ?>

    <div class="col-md-9 col-lg-10">
        <div class="box-shadow">
            <div class="table-head">
                <?=$this->lang->line('application_' . $template . '_email_template');?>

                <div class="btn-group pull-right">
                    <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                        <?php if ($template) {
                            echo $this->lang->line('application_' . $template . '_email_template');
                        }?>
                        <span class="caret"></span>
                    </button>
                    <ul class="dropdown-menu pull-right" role="menu">
                        <?php foreach ($template_files as $value) {
                            ?>
                            <li>
                                <a href="<?=base_url()?>settings/templates/<?=$value; ?>">
                                    <?=$this->lang->line('application_' . $value . '_email_template'); ?>
                                </a>
                            </li>
                            <?php
                        } ?>
                </div>
            </div>
            <?php
            $attributes = ['class' => '', 'id' => 'template_form'];
            echo form_open_multipart($form_action, $attributes);
            ?>
            <div class="table-div">
                <br>

                <?php if (isset($settings->{$template . '_mail_subject'})) {
                    ?>
                    <div class="form-group">
                        <label>
                            <?=$this->lang->line('application_subject'); ?>
                        </label>
                        <input type="text" name="<?=$template; ?>_mail_subject" class="required no-margin form-control" value="<?=$settings->{$template . '_mail_subject'}; ?>">
                    </div>
                    <?php
                } ?>

                <div class="form-group filled">
                    <label>
                        <?=$this->lang->line('application_mail_body');?>
                    </label>
                    <textarea class="required ckeditor" name="mail_body">
                                        <?=$email;?>
                                    </textarea>
                </div>
                <div class="form-group">
                    <label>
                        <?=$this->lang->line('application_short_tags');?>
                    </label>
                    <small style="padding-left:10px">
                        <br/>
                        <?php switch ($template) {
                            case 'reminder':
                                $tags = ['company',
                                    'logo',
                                    'company_logo',
                                    'first_name',
                                    'last_name',
                                    'title',
                                    'message',
                                    'datetime',
                                    'icon',
                                    'button_text'
                                ];
                                break;
                            case 'pw_reset_link':
                                $tags = ['company',
                                    'logo',
                                    'company_logo',
                                    'first_name',
                                    'last_name',
                                    'link'
                                ];
                                break;
                            case 'pw_reset':
                                $tags = ['company',
                                    'logo',
                                    'company_logo',
                                    'first_name',
                                    'last_name',
                                    'link'
                                ];
                                break;
                            case 'notification':
                                $tags = ['company',
                                    'logo',
                                    'company_logo',
                                    'first_name',
                                    'last_name',
                                    'link'
                                ];
                                break;
                            case 'create_account':
                                $tags = ['company',
                                    'logo',
                                    'company_logo',
                                    'first_name',
                                    'last_name',
                                    'company_reference',
                                    'link'
                                ];
                                break;
                            case 'credentials':
                                $tags = ['company',
                                    'logo',
                                    'company_logo',
                                    'first_name',
                                    'last_name',
                                    'username',
                                    'client_company',
                                    'link'
                                ];
                                break;
                            case 'ticket_notification':
                                $tags = ['company',
                                    'logo',
                                    'company_logo',
                                    'ticket_number',
                                    'ticket_created_date',
                                    'ticket_status',
                                    'ticket_link',
                                    'ticket_body',
                                    'ticket_subject'
                                ];
                                break;

                            default:
                                $tags = ['company',
                                    'logo',
                                    'company_logo',
                                    'client_link',
                                    'client_contact',
                                    'client_company',
                                    'due_date',
                                    'invoice_id',
                                ];

                                break;
                        }
                        foreach ($tags as $tag) : ?>
                            <span class="tag">{<?=$tag?>}</span>
                        <?php endforeach; ?>

                    </small>
                </div>
                <div class="form-group no-border">
                    <input type="submit" name="send" class="btn btn-primary" value="<?=$this->lang->line('application_save');?>" />
                    <a href="<?=base_url()?>settings/settings_reset/email_<?=$template;?>" class="btn btn-danger tt pull-right" title="">
                        <i class="icon dripicons-retweet"></i>
                        <?=$this->lang->line('application_reset_default');?>
                    </a>
                </div>

                <?php echo form_close(); ?>
            </div>
        </div>
    </div>