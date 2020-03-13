<div id="row">

    <?php include 'materialhandling_menu.php'; ?>

    <div class="col-md-12 col-lg-12">
        <div class="box-shadow">
            <div class="table-head">
                <?=$this->lang->line('application_material_rules');?>
                <span class="pull-right">
					<a href="<?=base_url()?>materialmanagement/material_rule_create" class="btn btn-primary" data-toggle="mainmodal">
						<?=$this->lang->line('application_add_material_rule');?>
					</a>
				</span>
            </div>
            <div class="table-div responsive">
                <table id="material_rules" class="data-no-search table" cellspacing="0" cellpadding="0">
                    <thead>
                    <th style="width:25px" class="">
                        <?=$this->lang->line('application_id');?>
                    </th>
                    <th class="">
                        <?=$this->lang->line('application_deposit');?>
                    </th>
                    <th class="">
                        <?=$this->lang->line('application_material');?>
                    </th>
                    <th class="">
                        <?=$this->lang->line('application_verification');?>
                    </th>
                    <th class="">
                        <?=$this->lang->line('application_value');?>
                    </th>
                    <th class="no-sort">
                        <?=$this->lang->line('application_action');?>
                    </th>
                    </thead>
                    <?php foreach ($material_rules as $rule):?>

                        <tr id="<?=$rule->id;?>">
                            <td class="">
                                <?=$rule->id;?>
                            </td>
                            <td>
                                <?=$rule->rule->{'deposit_id'}?>
                            </td>
                            <td>
                                <?=$rule->rule->{'material_id'}?>
                            </td>
                            <td>
                                <?=$rule->rule->{'operator'}?>
                            </td>
                            <td>
                                <?=$rule->rule->{'value'}?>
                            </td>
                            <td class="option" width="8%">
                                <button type="button" class="btn-option delete po" data-toggle="popover" data-placement="left" data-content="<a class='btn btn-danger po-delete ajax-silent' href='<?=base_url()?>materialmanagement/rule_delete/<?=$rule->id;?>'><?=$this->lang->line('application_yes_im_sure');?></a> <button class='btn po-close'><?=$this->lang->line('application_no');?></button> <input type='hidden' name='td-id' class='id' value='<?=$rule->id;?>'>"
                                        data-original-title="<b><?=$this->lang->line('application_really_delete');?></b>">
                                    <i class="icon dripicons-cross"></i>
                                </button>
                                <a href="<?=base_url()?>materialmanagement/material_rule_update/<?=$rule->id;?>" class="btn-option" data-toggle="mainmodal">
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
                <?=$this->lang->line('application_stock_area_rules');?>
                <span class="pull-right">
                    <a href="<?=base_url()?>materialmanagement/stock_area_rule_create" class="btn btn-primary" data-toggle="mainmodal">
						<?=$this->lang->line('application_add_stock_area_rule');?>
					</a>
				</span>
            </div>
            <div class="table-div responsive">
                <table id="stock_area_rules" class="data-no-search table" cellspacing="0" cellpadding="0">
                    <thead>
                    <th style="width:25px" class="">
                        <?=$this->lang->line('application_id');?>
                    </th>
                    <th class="">
                        <?=$this->lang->line('application_deposit');?>
                    </th>
                    <th class="">
                        <?=$this->lang->line('application_area');?>
                    </th>
                    <th class="">
                        <?=$this->lang->line('application_verification');?>
                    </th>
                    <th class="">
                        <?=$this->lang->line('application_value');?>
                    </th>
                    <th class="no-sort">
                        <?=$this->lang->line('application_action');?>
                    </th>
                    </thead>
                    <?php foreach ($stock_area_rules as $rule):?>

                        <tr id="<?=$rule->id;?>">
                            <td class="">
                                <?=$rule->id;?>
                            </td>
                            <td>
                                <?=$rule->rule->{'deposit_id'}?>
                            </td>
                            <td>
                                <?=$rule->rule->{'stock_area_id'}?>
                            </td>
                            <td>
                                <?=$rule->rule->{'operator'}?>
                            </td>
                            <td>
                                <?=$rule->rule->{'value'}?>
                            </td>
                            <td class="option" width="8%">
                                <button type="button" class="btn-option delete po" data-toggle="popover" data-placement="left" data-content="<a class='btn btn-danger po-delete ajax-silent' href='<?=base_url()?>materialmanagement/rule_delete/<?=$rule->id;?>'><?=$this->lang->line('application_yes_im_sure');?></a> <button class='btn po-close'><?=$this->lang->line('application_no');?></button> <input type='hidden' name='td-id' class='id' value='<?=$rule->id;?>'>"
                                        data-original-title="<b><?=$this->lang->line('application_really_delete');?></b>">
                                    <i class="icon dripicons-cross"></i>
                                </button>
                                <a href="<?=base_url()?>materialmanagement/stock_area_rule_update/<?=$rule->id;?>" class="btn-option" data-toggle="mainmodal">
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