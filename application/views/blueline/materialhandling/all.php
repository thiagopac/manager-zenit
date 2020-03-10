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
            <span class="pull-right">
                    <?php if($selected_deposit_id):?>
                        <a href="<?=base_url()?>materialmanagement/entrance_create/<?=$selected_deposit_id?>" class="btn btn-success" data-toggle="mainmodal">
                            <?=$this->lang->line('application_add_entrance_batch');?> (+)
                        </a>

                        <a href="<?=base_url()?>materialmanagement/output_create/<?=$selected_deposit_id?>" class="btn btn-danger" data-toggle="mainmodal">
                            <?=$this->lang->line('application_add_output_batch');?> (–)
                        </a>

                    <?php endif?>
				</span>
        </div>

        <div class="table-div responsive">
            <table id="materials" class="data-no-search table noclick" rel="<?=base_url()?>" cellspacing="0" cellpadding="0">
                <thead>
                <th class="hidden-xs" style="width:70px">
                    <?=$this->lang->line('application_type'); ?>
                </th>
                <th>
                    <?=$this->lang->line('application_name'); ?>
                </th>
                <th class="hidden-sm hidden-xs">
                    <?=$this->lang->line('application_unity'); ?>
                </th>
                <th class="hidden-sm hidden-xs">
                    <?=$this->lang->line('application_min_qty'); ?>
                </th>
                <th>
                    <?=$this->lang->line('application_current_qty'); ?>
                </th>
                <?php if ($filtered == true) : ?>
                    <th class="hidden-sm hidden-xs">
                        <?=$this->lang->line('application_last_update'); ?>
                    </th>
                    <th style="width: 200px;">
                        <?=$this->lang->line('application_action'); ?>
                    </th>
                <?php endif; ?>
                    </thead>
                <?php foreach ($all_materials as $value):?>

                    <tr id="<?=$value->id; ?>">
                        <td class="hidden-xs" style="width:70px">
                            <?=$value->material_type_id?>
                        </td>
                        <td>
                            <?=$value->description; ?>
                        </td>
                        <td class="hidden-sm hidden-xs">
                            <?=$this->lang->line("application_$value->unity"); ?>
                        </td>
                        <td class="hidden-sm hidden-xs">
                            <?=$value->min_qty; ?>
                        </td>
                        <td>
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
                                <td class="hidden-sm hidden-xs">
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
                        <td>
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

    <!--<div class="col-md-9 col-lg-10">
        
        <div class="box-shadow">
            
            <div class="table-head">
                <?/*=$this->lang->line('application_entrances');*/?>
                <span class="pull-right">
                    <?php /*if($selected_deposit_id):*/?>
                        <a href="<?/*=base_url()*/?>materialmanagement/entrance_create/<?/*=$selected_deposit_id*/?>" class="btn btn-primary" data-toggle="mainmodal">
                            <?/*=$this->lang->line('application_add_entrance');*/?>
                        </a>
                    <?php /*endif*/?>
				</span>
            </div>

            <div class="table-div responsive">
                <table id="entrances" class="data-no-search table" cellspacing="0" cellpadding="0">
                    <thead>
                    <th style="width:80px" class="hidden-xs">
                        <?/*=$this->lang->line('application_id');*/?>
                    </th>
                    <th class="hidden-xs">
                        <?/*=$this->lang->line('application_deposit');*/?>
                    </th>
                    <th class="hidden-xs">
                        <?/*=$this->lang->line('application_material');*/?>
                    </th>
                    <th class="hidden-xs">
                        <?/*=$this->lang->line('application_quantity');*/?>
                    </th>
                    <th class="hidden-xs">
                        <?/*=$this->lang->line('application_date');*/?>
                    </th>
                    <th class="hidden-xs">
                        <?/*=$this->lang->line('application_action');*/?>
                    </th>
                    </thead>
                    <?php /*foreach ($entrances as $entrance):*/?>

                        <tr id="<?/*=$entrance->id;*/?>">
                            <td class="hidden-xs">
                                <?/*=$entrance->id;*/?>
                            </td>
                            <td>
                                <?/*=$entrance->deposit->name;*/?>
                            </td>
                            <td>
                                <?/*=$entrance->material->description;*/?>
                            </td>
                            <td>
                                <?/*=$entrance->quantity;*/?>
                            </td>
                            <td>
                                <?/*=$entrance->date;*/?>
                            </td>

                            <td class="option" width="8%">
                                <button type="button" class="btn-option delete po" data-toggle="popover" data-placement="left" data-content="<a class='btn btn-danger po-delete ajax-silent' href='<?/*=base_url()*/?>materialmanagement/entrance_delete/<?/*=$entrance->id;*/?>'><?/*=$this->lang->line('application_yes_im_sure');*/?></a> <button class='btn po-close'><?/*=$this->lang->line('application_no');*/?></button> <input type='hidden' name='td-id' class='id' value='<?/*=$entrance->id;*/?>'>"
                                        data-original-title="<b><?/*=$this->lang->line('application_really_delete');*/?></b>">
                                    <i class="icon dripicons-cross"></i>
                                </button>
                                <a href="<?/*=base_url()*/?>materialmanagement/entrance_update/<?/*=$entrance->id;*/?>/<?/*=$entrance->deposit_id;*/?>/<?/*=$entrance->material_id*/?>/<?/*=$entrance->quantity*/?>" class="btn-option" data-toggle="mainmodal">
                                    <i class="icon dripicons-gear"></i>
                                </a>
                            </td>
                        </tr>

                    <?php /*endforeach;*/?>
                </table>
            
            </div>
        </div>
    </div>-->

    <!--<div class="col-md-9 col-lg-10">
    
        <div class="box-shadow">
        
            <div class="table-head">
                <?/*=$this->lang->line('application_outputs');*/?>
                <span class="pull-right">
                    <?php /*if($selected_deposit_id):*/?>
                        <a  href="<?/*=base_url()*/?>materialmanagement/output_create/<?/*=$selected_deposit_id*/?>" class="btn btn-primary" data-toggle="mainmodal">
                            <?/*=$this->lang->line('application_add_output');*/?>
                        </a>
                    <?php /*endif*/?>
				</span>
            </div>
            
            <div class="table-div responsive">
                <table id="outputs" class="data-no-search table" cellspacing="0" cellpadding="0">
                    <thead>
                    <th style="width:80px" class="hidden-xs">
                        <?/*=$this->lang->line('application_id');*/?>
                    </th>
                    <th class="hidden-xs">
                        <?/*=$this->lang->line('application_deposit');*/?>
                    </th>
                    <th class="hidden-xs">
                        <?/*=$this->lang->line('application_material');*/?>
                    </th>
                    <th class="hidden-xs">
                        <?/*=$this->lang->line('application_quantity');*/?>
                    </th>
                    <th class="hidden-xs">
                        <?/*=$this->lang->line('application_date');*/?>
                    </th>
                    <th class="hidden-xs">
                        <?/*=$this->lang->line('application_action');*/?>
                    </th>
                    </thead>
                    <?php /*foreach ($outputs as $output):*/?>

                        <tr id="<?/*=$output->id;*/?>">
                            <td class="hidden-xs">
                                <?/*=$output->id;*/?>
                            </td>
                            <td>
                                <?/*=$output->deposit->name;*/?>
                            </td>
                            <td>
                                <?/*=$output->material->description;*/?>
                            </td>
                            <td>
                                <?/*=$output->quantity;*/?>
                            </td>
                            <td>
                                <?/*=$output->date;*/?>
                            </td>

                            <td class="option" width="8%">
                                <button type="button" class="btn-option delete po" data-toggle="popover" data-placement="left" data-content="<a class='btn btn-danger po-delete ajax-silent' href='<?/*=base_url()*/?>materialmanagement/output_delete/<?/*=$output->id;*/?>'><?/*=$this->lang->line('application_yes_im_sure');*/?></a> <button class='btn po-close'><?/*=$this->lang->line('application_no');*/?></button> <input type='hidden' name='td-id' class='id' value='<?/*=$output->id;*/?>'>"
                                        data-original-title="<b><?/*=$this->lang->line('application_really_delete');*/?></b>">
                                    <i class="icon dripicons-cross"></i>
                                </button>
                                <a href="<?/*=base_url()*/?>materialmanagement/output_update/<?/*=$output->id;*/?>/<?/*=$output->deposit_id;*/?>/<?/*=$output->material_id*/?>/<?/*=$output->quantity*/?>" class="btn-option" data-toggle="mainmodal">
                                    <i class="icon dripicons-gear"></i>
                                </a>
                            </td>
                        </tr>

                    <?php /*endforeach;*/?>
                </table>
            </div>
        </div>
    </div>-->
</div>