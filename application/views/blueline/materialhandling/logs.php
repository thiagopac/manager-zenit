<div id="row">
        <?php include 'materialhandling_menu.php'; ?>

    <div class="col-md-12 col-lg-12">

        <div class="box-shadow">

            <div class="table-head">
                <?=$this->lang->line('application_entrances');?>
                <span class="pull-right">
                    <?php if($selected_deposit_id):?>
                        <a href="<?=base_url()?>materialmanagement/entrance_create/<?=$selected_deposit_id?>" class="btn btn-primary" data-toggle="mainmodal">
                            <?=$this->lang->line('application_add_entrance');?>
                        </a>
                    <?php endif?>
				</span>
            </div>

            <div class="table-div responsive">
                <table id="entrances" class="data table" cellspacing="0" cellpadding="0">
                    <thead>
                    <th style="text-align:center;width:80px">
                        <?=$this->lang->line('application_id');?>
                    </th>
                    <th style='text-align:center;'>
                        <?=$this->lang->line('application_deposit');?>
                    </th>
                    <th style='text-align:center;'>
                        <?=$this->lang->line('application_material');?>
                    </th>
                    <th style='text-align:center;'>
                        <?=$this->lang->line('application_quantity');?>
                    </th>
                    <th class="" style='text-align:center;'>
                        <?=$this->lang->line('application_last_update'); ?>
                    </th>
                    <th class="no-sort" style='text-align:center;'>
                        <?=$this->lang->line('application_action');?>
                    </th>
                    </thead>
                    <?php foreach ($entrances as $entrance):?>

                        <tr id="<?=$entrance->id;?>">
                            <td style='text-align:center;'>
                                <?=$entrance->id;?>
                            </td>
                            <td style='text-align:center;'>
                                <?=$entrance->deposit->name;?>
                            </td>
                            <td style='text-align:center;'>
                                <?=$entrance->material->description;?>
                            </td>
                            <td style='text-align:center;'>
                                <?=$entrance->quantity;?>
                            </td>
                            <td class="" style='text-align:center;vertical-align:middle'>
                                <?=$entrance->user->firstname; ?>
                                <?=$this->lang->line('application_at'); ?>
                                <?php
                                $unix = human_to_unix($entrance->updated_at);
                                echo date($core_settings->date_format.' '.$core_settings->date_time_format, $unix)
                                ?>
                            </td>

                            <td class="option" width="8%">
                                <button type="button" class="btn-option delete po" data-toggle="popover" data-placement="left" data-content="<a class='btn btn-danger po-delete ajax-silent' href='<?=base_url()?>materialmanagement/entrance_delete/<?=$entrance->id;?>'><?=$this->lang->line('application_yes_im_sure');?></a> <button class='btn po-close'><?=$this->lang->line('application_no');?></button> <input type='hidden' name='td-id' class='id' value='<?=$entrance->id;?>'>"
                                        data-original-title="<b><?=$this->lang->line('application_really_delete');?></b>">
                                    <i class="icon dripicons-cross"></i>
                                </button>
                                <a href="<?=base_url()?>materialmanagement/entrance_update/<?=$entrance->id;?>/<?=$entrance->deposit_id;?>/<?=$entrance->material_id?>/<?=$entrance->quantity?>" class="btn-option" data-toggle="mainmodal">
                                    <i class="icon dripicons-gear"></i>
                                </a>
                            </td>
                        </tr>

                    <?php endforeach;?>
                </table>

            </div>
        </div>
    </div>

    <div class="col-md-12 col-lg-12">

        <div class="box-shadow">

            <div class="table-head">
                <?=$this->lang->line('application_outputs');?>
                <span class="pull-right">
                    <?php if($selected_deposit_id):?>
                        <a  href="<?=base_url()?>materialmanagement/output_create/<?=$selected_deposit_id?>" class="btn btn-primary" data-toggle="mainmodal">
                            <?=$this->lang->line('application_add_output');?>
                        </a>
                    <?php endif?>
				</span>
            </div>

            <div class="table-div responsive">
                <table id="outputs" class="data table" cellspacing="0" cellpadding="0">
                    <thead>
                    <th style="text-align:center;width:80px">
                        <?=$this->lang->line('application_id');?>
                    </th>
                    <th style='text-align:center;'>
                        <?=$this->lang->line('application_deposit');?>
                    </th>
                    <th style='text-align:center;'>
                        <?=$this->lang->line('application_material');?>
                    </th>
                    <th style='text-align:center;'>
                        <?=$this->lang->line('application_quantity');?>
                    </th>
                    <th style='text-align:center;'>
                        <?=$this->lang->line('application_last_update');?>
                    </th>
                    <th class="no-sort" style='text-align:center;'>
                        <?=$this->lang->line('application_action');?>
                    </th>
                    </thead>
                    <?php foreach ($outputs as $output):?>

                        <tr id="<?=$output->id;?>">
                            <td style='text-align:center;'>
                                <?=$output->id;?>
                            </td>
                            <td style='text-align:center;'>
                                <?=$output->deposit->name;?>
                            </td>
                            <td style='text-align:center;'>
                                <?=$output->material->description;?>
                            </td>
                            <td style='text-align:center;'>
                                <?=$output->quantity;?>
                            </td>
                            <td class="" style='text-align:center;vertical-align:middle'>
                                <?=$output->user->firstname; ?>
                                <?=$this->lang->line('application_at'); ?>
                                <?php
                                $unix = human_to_unix($output->updated_at);
                                echo date($core_settings->date_format.' '.$core_settings->date_time_format, $unix)
                                ?>
                            </td>

                            <td class="option" width="8%">
                                <button type="button" class="btn-option delete po" data-toggle="popover" data-placement="left" data-content="<a class='btn btn-danger po-delete ajax-silent' href='<?=base_url()?>materialmanagement/output_delete/<?=$output->id;?>'><?=$this->lang->line('application_yes_im_sure');?></a> <button class='btn po-close'><?=$this->lang->line('application_no');?></button> <input type='hidden' name='td-id' class='id' value='<?=$output->id;?>'>"
                                        data-original-title="<b><?=$this->lang->line('application_really_delete');?></b>">
                                    <i class="icon dripicons-cross"></i>
                                </button>
                                <a href="<?=base_url()?>materialmanagement/output_update/<?=$output->id;?>/<?=$output->deposit_id;?>/<?=$output->material_id?>/<?=$output->quantity?>" class="btn-option" data-toggle="mainmodal">
                                    <i class="icon dripicons-gear"></i>
                                </a>
                            </td>
                        </tr>

                    <?php endforeach;?>
                </table>
            </div>
        </div>
    </div>
</div>
