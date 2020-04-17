<div id="row">
        <?php include 'materialhandling_menu.php'; ?>

    <div class="row">
        <div class="col-md-12">
            <div class="btn-group pull-right">

                <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">

                    <?php if($selected_deposit_id):?>
                        <?php foreach($deposits as $deposit):?>
                            <?php if($deposit->id == $selected_deposit_id):?>
                                <?php echo $deposit->name?>
                            <?php endif?>
                        <?endforeach?>
                    <?php else:?>
                        <?php echo $this->lang->line('application_all_deposits');?>
                    <?php endif?>

                    <span class="caret"></span>
                </button>
                <ul class="dropdown-menu pull-right" role="menu">
                    <li><a href="<?=base_url()?>materialmanagement"><?=$this->lang->line('application_all_deposits');?></a></li>
                    <?php foreach ($deposits as $deposit):?>
                        <li>
                            <a id="deposit_id" name="deposit_id" href="<?=base_url()?>materialmanagement/filter/<?=$deposit->id?>"><?=$deposit->name?></a>
                        </li>
                    <?php endforeach;?>

                </ul>
            </div>
        </div>

    </div>

    <?php if (!$filtered) : ?>
        <div class="row" style="margin-bottom: 20px;">
            <div class="col-md-12">
                <span class="alert alert-warning hidden-xs hidden-sm" style="text-transform: initial;margin-bottom: 16px">
                    <?=$this->lang->line('application_select_deposit_notice');?>
                </span>
                <span class="alert alert-warning hidden-md hidden-lg" style="text-transform: initial; padding:6px">
                    <small><?=$this->lang->line('application_select_deposit_notice_mobile');?></small>
                </span>
            </div>
        </div>
    <?php endif; ?>

    <div class="row">
        <div class="col-md-12 col-lg-12">

            <div class="box-shadow">

                <div class="table-head">
                    <?=$this->lang->line('application_entrances_and_outputs');?>
                </div>

                <div class="table-div responsive">
                    <table style="width: 100%" id="materials" class="data table noclick" rel="<?=base_url()?>" cellspacing="0" cellpadding="0">
                        <thead>
                        <th width="25%" style='text-align:center;'>
                            <?=$this->lang->line('application_name'); ?>
                        </th>
                        <th class="hidden-xs hidden-sm" width="12%" style='text-align:center;'>
                            <?=$this->lang->line('application_deposit_area'); ?>
                        </th>
                        <th class="hidden-xs hidden-sm" width="12%" style='text-align:center;'>
                            <?=$this->lang->line('application_supplier'); ?>
                        </th>
                        <th class="hidden-xs hidden-sm" class="no-sort" width="5%" style='text-align:center;'>
                            <?=$this->lang->line('application_image'); ?>
                        </th>
                        <th class="hidden-xs hidden-sm" width="5%" class="hidden-sm hidden-xs" style='text-align:center;'>
                            <?=$this->lang->line('application_measurement'); ?>
                        </th>
                        <th class="hidden-xs hidden-sm" width="5%" class="hidden-sm hidden-xs" style='text-align:center;'>
                            <?=$this->lang->line('application_min_qty_abrv'); ?>
                        </th>
                        <th class="" width="5%" style='text-align:center;'>
                            <?=$this->lang->line('application_current_qty_abrv'); ?>
                        </th>
                        <?php if ($filtered == true) : ?>
                            <th class="hidden-xs hidden-sm" width="10%" style='text-align:center;'>
                                <?=$this->lang->line('application_last_update'); ?>
                            </th>

                            <th class="no-sort hidden-xs hidden-sm" width="15%" style="text-align:center;">
                                <?=$this->lang->line('application_action_single'); ?>
                            </th>

                            <th class="no-sort hidden-md hidden-lg" width="15%" style="text-align:center;">
                                <?=$this->lang->line('application_action_single_abrv'); ?>
                            </th>

                            <th class="no-sort hidden-xs hidden-sm" width="5%" style="text-align:center;">
                                <?=$this->lang->line('application_action_batch'); ?>
                            </th>

                            <th class="no-sort hidden-md hidden-lg" width="5%" style="text-align:center;">
                                <?=$this->lang->line('application_action_batch_abrv'); ?>
                            </th>
                        <?php endif; ?>
                        </thead>
                        <?php foreach ($all_materials as $value):?>

                            <tr id="<?=$value->id; ?>">
                                <td style='text-align:center;vertical-align:middle;'>
                                    <?=$value->description; ?>
                                </td>
                                <td class="hidden-xs hidden-sm" style='text-align:center;vertical-align:middle'>
                                    <?=$value->material_type->stock_area->name; ?>
                                </td>
                                <td class="hidden-xs hidden-sm" style='text-align:center;vertical-align:middle'>
                                    <?=$value->supplier->name; ?>
                                </td>
                                <td class="hidden-xs hidden-sm" style='text-align:center;vertical-align:middle'>
                                    <?php $value->image = $value->image != null ? $value->image : "no-pic.png"; ?>
                                    <img data-action="zoom" src="<?=base_url()."/files/materials/".$value->image;?>">
                                </td>
                                <td class="hidden-xs hidden-sm" class="hidden-sm hidden-xs" style='text-align:center;vertical-align:middle'>
                                    <?=$value->unity?>
                                </td>
                                <td class="hidden-xs hidden-sm" class="hidden-sm hidden-xs" style='text-align:center;vertical-align:middle'>
                                    <?=$value->min_qty; ?>
                                </td>
                                <td class="" style='text-align:center;vertical-align:middle'>
                                    <?php if ($value->amount->quantity >= $value->min_qty) : ?>
                                        <span style="color:green">
                                            <?=$value->amount->quantity != null ? $value->amount->quantity : 0; ?>
                                        </span>
                                    <?php else : ?>
                                        <span style="color:red">
                                            <?=$value->amount->quantity != null ? $value->amount->quantity : 0; ?>
                                        </span>
                                    <?php endif; ?>
                                </td>
                                <?php if ($filtered == true) : ?>
                                    <?php if($value->handling_last != null)  : ?>
                                        <td class="hidden-sm hidden-xs" style='text-align:center;vertical-align:middle'>
                                            <?=$value->handling_last->user->firstname; ?>
                                            <?=$this->lang->line('application_at'); ?>
                                            <?php
                                            $unix = human_to_unix($value->handling_last->updated_at);
                                            echo date($core_settings->date_format.' '.$core_settings->date_time_format, $unix)
                                            ?>
                                        </td>
                                    <?php else : ?>
                                        <td class="hidden-sm hidden-xs">
                                        </td>
                                    <?php endif; ?>
                                    <td class="hidden-sm hidden-xs" style='text-align:center;vertical-align:middle'>
                                        <a href="<?=base_url()?>materialmanagement/quick_entrance/<?=$selected_deposit_id?>/<?=$value->id?>" class="btn btn-success"><?=$this->lang->line('application_include');?> (+)</a>
                                        <a href="<?=base_url()?>materialmanagement/quick_output/<?=$selected_deposit_id?>/<?=$value->id?>" class="btn btn-danger"><?=$this->lang->line('application_withdraw');?> (–)</a>
                                    </td>

                                    <td class="hidden-md hidden-lg" style='text-align:center;vertical-align:middle'>
                                        <a href="<?=base_url()?>materialmanagement/quick_entrance/<?=$selected_deposit_id?>/<?=$value->id?>" class="btn btn-success">+</a>
                                        <a href="<?=base_url()?>materialmanagement/quick_output/<?=$selected_deposit_id?>/<?=$value->id?>" class="btn btn-danger">–</a>
                                    </td>

                                    <td class="hidden-sm hidden-xs" style='text-align:center;vertical-align:middle'>
                                        <a href="<?=base_url()?>materialmanagement/entrance_create/<?=$selected_deposit_id?>/<?=$value->id?>" data-toggle="mainmodal" class="btn btn-success">+</a>
                                        <a href="<?=base_url()?>materialmanagement/output_create/<?=$selected_deposit_id?>/<?=$value->id?>" data-toggle="mainmodal" class="btn btn-danger">–</a>
                                    </td>

                                    <td class="hidden-md hidden-lg" style='text-align:center;vertical-align:middle'>
                                        <a href="<?=base_url()?>materialmanagement/entrance_create/<?=$selected_deposit_id?>/<?=$value->id?>" data-toggle="mainmodal" class="btn btn-success">+</a>
                                        <a href="<?=base_url()?>materialmanagement/output_create/<?=$selected_deposit_id?>/<?=$value->id?>" data-toggle="mainmodal" class="btn btn-danger">–</a>
                                    </td>
                                <?php endif; ?>
                            </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
            </div>
        </div>
    </div>

</div>
