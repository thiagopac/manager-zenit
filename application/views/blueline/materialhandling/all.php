<div id="row">

    <?php include 'materialhandling_menu.php'; ?>

    <div>
        <div class="btn-group pull-right" style="margin-bottom: 15px; margin-right: 20px;">

<!--            --><?php //if($selected_deposit_id):?>
<!--                <a href="--><?//=base_url()?><!--materialmanagement/deposit_amount/--><?//=$selected_deposit_id?><!--" class="btn btn-primary margin-right-3" data-toggle="mainmodal">-->
<!--                    --><?//=$this->lang->line('application_deposit_amount');?>
<!--                </a>-->
<!--            --><?php //endif?>

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
                    <li><a id="deposit_id" name="deposit_id" href="<?=base_url()?>materialmanagement/filter/<?=$deposit->id?>"><?=$deposit->name?></a></li>
                <?php endforeach;?>

            </ul>
        </div>
    </div>


    <div class="col-md-9 col-lg-10">

        <?php if ($selected_deposit_id == null) : ?>
            <div class="alert alert-warning"><?=$this->lang->line('application_select_deposit_notice');?></div><br/>
        <?php endif; ?>

        <div class="box-shadow">

        <div class="table-head">
            <?=$this->lang->line('application_entrances_and_outputs');?>
            <!--<span class="pull-right">
                    <?php /*if($selected_deposit_id):*/?>
                        <a href="<?/*=base_url()*/?>materialmanagement/entrance_create/<?/*=$selected_deposit_id*/?>" class="btn btn-success" data-toggle="mainmodal">
                            <?/*=$this->lang->line('application_add_entrance_batch');*/?> (+)
                        </a>

                        <a href="<?/*=base_url()*/?>materialmanagement/output_create/<?/*=$selected_deposit_id*/?>" class="btn btn-danger" data-toggle="mainmodal">
                            <?/*=$this->lang->line('application_add_output_batch');*/?> (–)
                        </a>

                    <?php /*endif*/?>
            </span>-->
        </div>

        <div class="table-div responsive">
            <table id="materials" class="data table" rel="<?=base_url()?>" cellspacing="0" cellpadding="0">
                <thead>
                <th style='text-align:center;'>
                    <?=$this->lang->line('application_name'); ?>
                </th>
                <th style='text-align:center;'>
                    <?=$this->lang->line('application_deposit_area'); ?>
                </th>
                <th style='text-align:center;'>
                    <?=$this->lang->line('application_supplier'); ?>
                </th>
                <th style='text-align:center;'>
                    <?=$this->lang->line('application_image'); ?>
                </th>
                <th class="hidden-sm hidden-xs" style='text-align:center;'>
                    <?=$this->lang->line('application_measurement'); ?>
                </th>
                <th class="hidden-sm hidden-xs" style='text-align:center;'>
                    <?=$this->lang->line('application_min_qty'); ?>
                </th>
                <th style='text-align:center;'>
                    <?=$this->lang->line('application_current_qty'); ?>
                </th>
                <?php if ($filtered == true) : ?>
                    <th class="hidden-sm hidden-xs" style='text-align:center;'>
                        <?=$this->lang->line('application_last_update'); ?>
                    </th>
                    <th style="width: 200px;text-align:center;">
                        <?=$this->lang->line('application_action'); ?>
                    </th>
                <?php endif; ?>
                    </thead>
                <?php foreach ($all_materials as $value):?>

                    <tr id="<?=$value->id; ?>">
                        <td style='text-align:center;vertical-align:middle'>
                            <?=$value->description; ?>
                        </td>
                        <td style='text-align:center;vertical-align:middle'>
                            <?=$value->material_type->stock_area->name; ?>
                        </td>
                        <td style='text-align:center;vertical-align:middle'>
                            <?=$value->supplier->name; ?>
                        </td>
                        <td style='text-align:center;vertical-align:middle'>
                            <?php $value->image = $value->image != null ? $value->image : "no-pic.png"; ?>
                            <img data-action="zoom" src="<?=base_url()."/files/materials/".$value->image;?>">
                        </td>
                        <td class="hidden-sm hidden-xs" style='text-align:center;vertical-align:middle'>
                            <?=$this->lang->line("application_$value->unity"); ?>
                        </td>
                        <td class="hidden-sm hidden-xs" style='text-align:center;vertical-align:middle'>
                            <?=$value->min_qty; ?>
                        </td>
                        <td style='text-align:center;vertical-align:middle'>
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
                                <td>
                                </td>
                            <?php endif; ?>
                        <td style='text-align:center;vertical-align:middle'>
                            <a href="<?=base_url()?>materialmanagement/quick_entrance/<?=$selected_deposit_id?>/<?=$value->id?>" class="btn btn-success"><?=$this->lang->line('application_include');?> (+)</a>
                            <a href="<?=base_url()?>materialmanagement/quick_output/<?=$selected_deposit_id?>/<?=$value->id?>" class="btn btn-danger"><?=$this->lang->line('application_withdraw');?> (–)</a>
                        </td>
                        <?php endif; ?>
                    </tr>
                <?php endforeach; ?>
            </table>
        </div>
    </div>
    </div>
</div>
