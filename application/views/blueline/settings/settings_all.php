<div id="row">
    <?php include 'settings_menu.php'; ?>

    <div class="col-md-9 col-lg-10">
        <div class="box-shadow">
            <div class="table-head">
                <?=$this->lang->line('application_settings');?>
            </div>
            <?php
            $attributes = ['class' => '', 'id' => 'settings_form'];
            echo form_open_multipart($form_action, $attributes);
            ?>
            <div class="table-div">

                <div class="form-header">
                    <?=$this->lang->line('application_personal_info');?>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>
                                <?=$this->lang->line('application_company_name');?>
                            </label>
                            <input type="text" name="company" class="form-control" value="<?=$settings->company;?>">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>
                                <?=$this->lang->line('application_contact');?>
                            </label>
                            <input type="text" name="contact" class="required form-control" value="<?=$settings->contact;?>" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>
                                <?=$this->lang->line('application_address');?>
                            </label>
                            <input type="text" name="address" class="required form-control" value="<?=$settings->address;?>" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>
                                <?=$this->lang->line('application_city');?>
                            </label>
                            <input type="text" name="city" class="required form-control" value="<?=$settings->city;?>" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>
                                <?=$this->lang->line('application_phone');?>
                            </label>
                            <input type="text" name="tel" class="required form-control" value="<?=$settings->tel;?>" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>
                                <?=$this->lang->line('application_email');?>
                            </label>
                            <input type="text" name="email" class="required form-control" value="<?=$settings->email;?>" required>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>
                                <?=$this->lang->line('application_domain');?>
                                <button type="button" class="btn-option po pull-right" data-toggle="popover" data-placement="left" data-content="Full URL to your Freelance Cockpit installation. Including subfolder i.e. http://www.yoursite.com/FC/" data-original-title="Domain URL">
                                    <i class="icon dripicons-information"></i>
                                </button>
                            </label>
                            <input type="text" name="domain" class="required form-control" value="<?=$settings->domain;?>" required>
                        </div>
                    </div>
                </div>
                <div class="form-header">
                    <?=$this->lang->line('application_branding');?>
                </div>
                <div class="form-group">
                    <label>
                        <?=$this->lang->line('application_logo');?> (max 160x200)
                        <button type="button" class="btn-option po pull-right" data-toggle="popover" data-placement="right" data-content="<div class='logo' style='padding:10px'><img src='<?=$core_settings->logo;?>'></div>" data-original-title="<?=$this->lang->line('application_logo');?>">
                            <i class="icon dripicons-preview"></i>
                        </button>
                    </label>
                    <div>
                        <input id="uploadFile" class="form-control uploadFile" placeholder="<?=$this->lang->line('application_choose_file');?>" disabled="disabled" />
                        <div class="fileUpload btn btn-primary">
                                    <span>
							<i class="icon dripicons-upload"></i>
							<span class="hidden-xs">
								<?=$this->lang->line('application_select');?>
							</span>
                                    </span>
                            <input id="uploadBtn" type="file" name="userfile" class="upload" />
                        </div>
                    </div>

                </div>
                <div class="form-group">
                    <label>
                        <?=$this->lang->line('application_logo');?>
                        <?=$this->lang->line('application_company');?> (max 160x200)
                        <button type="button" class="btn-option po " data-toggle="popover" data-placement="right" data-content="<div style='padding:10px'><img src='<?=$core_settings->company_logo;?>'></div>" data-original-title="<?=$this->lang->line('application_invoice');?> <?=$this->lang->line('application_logo');?>">
                            <i class="icon dripicons-preview"></i>
                        </button>
                    </label>
                    <div>
                        <input id="uploadFile2" class="form-control uploadFile" placeholder="<?=$this->lang->line('application_choose_file');?>" disabled="disabled" />
                        <div class="fileUpload btn btn-primary">
                                    <span>
							<i class="icon dripicons-upload"></i>
							<span class="hidden-xs">
								<?=$this->lang->line('application_select');?>
							</span>
                                    </span>
                            <input id="uploadBtn2" type="file" name="userfile2" class="upload" />
                        </div>
                    </div>

                </div>


                <div class="form-header">
                    <?=$this->lang->line('application_reference_prefix');?>
                </div>
                <div class="row">

                    <div class="col-md-2">
                        <div class="form-group">
                            <label>
                                <?=$this->lang->line('application_company');?>
                            </label>

                            <div class="input-group ">

                                <input type="text" name="company_prefix" value="<?=$settings->company_prefix;?>" class="form-control">

                            </div>

                        </div>
                    </div>

                    <div class="col-md-2">
                        <div class="form-group">
                            <label>
                                <?=$this->lang->line('application_project');?>
                            </label>

                            <div class="input-group">

                                <input type="text" name="project_prefix" value="<?=$settings->project_prefix;?>" class="form-control">

                            </div>

                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label>
                                <?=$this->lang->line('application_rated_power_measurement');?>
                            </label>

                            <div class="input-group">

                                <input type="text" name="rated_power_measurement" value="<?=$settings->rated_power_measurement;?>" class="form-control">

                            </div>

                        </div>
                    </div>

                </div>

                    <div class="form-header">
                        <?=$this->lang->line('application_formats');?>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>
                                    <?=$this->lang->line('application_date_format');?>
                                </label>
                                <?php $options = [
                                    'F j, Y' => date('F j, Y'),
                                    'Y/m/d' => date('Y/m/d'),
                                    'm/d/Y' => date('m/d/Y'),
                                    'd/m/Y' => date('d/m/Y'),
                                    'd.m.Y' => date('d.m.Y'),
                                    'd-m-Y' => date('d-m-Y'),
                                    'Y-m-d' => date('Y-m-d'),
                                    'd-m-Y' => date('Y-m-d'),
                                    'j F, Y' => date('j F, Y')
                                ];
                                echo form_dropdown('date_format', $options, $settings->date_format, 'style="width:250px" class="chosen-select"'); ?>

                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>
                                    <?=$this->lang->line('application_date_time_format');?>
                                </label>
                                <?php $options = [
                                    'g:i a' => date('g:i a'),
                                    'g:i A' => date('g:i A'),
                                    'H:i' => date('H:i'),
                                ];
                                echo form_dropdown('date_time_format', $options, $settings->date_time_format, 'style="width:250px" class="chosen-select"'); ?>

                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>
                                    <?=$this->lang->line('application_money_symbol');?>
                                </label>
                                <input type="text" name="money_symbol" value="<?=$settings->money_symbol;?>" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>
                                    <?=$this->lang->line('application_timezone');?>
                                </label>
                                <?php
                                $options = [];
                                foreach (timezone_abbreviations_list() as $abbr => $timezone) {
                                    foreach ($timezone as $val) {
                                        if (isset($val['timezone_id'])) {
                                            $options[$val['timezone_id']] = $val['timezone_id'];
                                        }
                                    }
                                }
                                echo form_dropdown('timezone', $options, $settings->timezone, 'style="width:250px" class="chosen-select"'); ?>

                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>
                                    <?=$this->lang->line('application_money_format');?>
                                </label>
                                <?php $options = [
                                    '1' => '1,234.56',
                                    '2' => '1.234,56',
                                    '3' => '1234.56',
                                    '4' => '1234,56',
                                    '5' => "1'234.56",
                                ];
                                echo form_dropdown('money_format', $options, $settings->money_format, 'style="width:100%" class="chosen-select"'); ?>

                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>
                                    <?=$this->lang->line('application_currency_position');?>
                                </label>
                                <?php $options = [
                                    '1' => '$ 100',
                                    '2' => '100 $',
                                ];
                                echo form_dropdown('money_currency_position', $options, $settings->money_currency_position, 'style="width:100%" class="chosen-select"'); ?>

                            </div>
                        </div>

                    </div>
                    <div class="form-header">
                        <?=$this->lang->line('application_push_notification_settings');?>
                    </div>
                    <div class="row">

                        <div class="col-md-12">
                            <div class="form-group">
                                <label>
                                    <?=$this->lang->line('application_push_notification_active');?>
                                </label>
                                <input name="push_active" type="checkbox" class="checkbox" data-labelauty="<?=$this->lang->line('application_push_notification_active');?>" value="1" <?php if ($settings->push_active == '1') { ?> checked="checked"
                                    <?php
                                } ?>>
                            </div>

                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>
                                    <?=$this->lang->line('application_push_notification_app_id');?>
                                </label>
                                <input type="text" name="push_app_id" class="form-control" value="<?=$settings->push_app_id;?>">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>
                                    <?=$this->lang->line('application_push_notification_rest_api_key');?>
                                </label>
                                <input type="text" name="push_rest_api_key" class="required form-control" value="<?=$settings->push_rest_api_key;?>">
                            </div>
                        </div>
                    </div>

                    <div class="form-group no-border">
                        <input type="submit" name="send" class="btn btn-primary" value="<?=$this->lang->line('application_save');?>" />

                    </div>

                    </table>

                    <?php echo form_close(); ?>
                </div>
            </div>
        </div>
    </div>