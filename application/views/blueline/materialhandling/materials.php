<style>
    #materials_paginate{
        visibility: hidden;
    }
</style>
<div id="row">
    <?php include 'materialhandling_menu.php'; ?>

    <div class="col-md-12 col-lg-12">
        <div class="box-shadow">
            <div class="table-head">
                <div class="pull-left" style="display: inline-flex"><?=trim($this->lang->line('application_materials'));?>
                    <div style="margin-left: 10px">
                        <?php foreach (range('A', 'Z') as $char) : ?>
                            <span><a <?=$current_char == $char ? 'style="color:red;text-decoration: underline"' : ''; ?> href="<?=base_url()?>materialmanagement/materials/<?=$char?>"><?=$char?></a></span>
                        <?php endforeach; ?>
                    </div>
                </div>
                <span class="pull-right" style="margin-right: 160px">
					<a href="<?=base_url()?>materialmanagement/material_create" class="btn btn-primary" data-toggle="mainmodal">
						<?=$this->lang->line('application_add_material');?>
					</a>
				</span>
            </div>
            <div class="table-div responsive">
                <table id="materials" class="data-natural table noclick" data-page-length="<?=count($materials)?>" cellspacing="0" cellpadding="0">
                    <thead>
                    <th style="width:80px;text-align:center;" class="hidden-xs hidden-sm">
                        <?=$this->lang->line('application_id');?>
                    </th>
                    <th style='text-align:center;'>
                        <?=$this->lang->line('application_name');?>
                    </th>
                    <th class="hidden-xs hidden-sm" style='text-align:center;'>
                        <?=$this->lang->line('application_supplier');?>
                    </th>
                    <th class="no-sort hidden-xs hidden-sm" style='text-align:center;' class="hidden-xs hidden-sm">
                        <?=$this->lang->line('application_image');?>
                    </th>
                    <th class="hidden-xs hidden-sm" style='text-align:center;' class="hidden-xs hidden-sm">
                        <?=$this->lang->line('application_type');?>
                    </th>
                    <th class="hidden-xs hidden-sm" style='text-align:center;' class="hidden-xs hidden-sm">
                        <?=$this->lang->line('application_price');?>
                    </th>
                    <th class="hidden-xs hidden-sm" style='text-align:center;' class="hidden-xs hidden-sm">
                        <?=$this->lang->line('application_min_qty');?>
                    </th>
                    <th class="no-sort" style='text-align:center;'>
                        <?=$this->lang->line('application_action');?>
                    </th>
                    </thead>
                    <?php foreach ($materials as $material):?>

                        <tr id="<?=$material->id;?>">
                            <td class="hidden-xs" style='text-align:center;vertical-align:middle'>
                                <?=$material->id;?>
                            </td>
                            <td style='text-align:center;vertical-align:middle'>
                                <?=$material->description;?>
                            </td>
                            <td style='text-align:center;vertical-align:middle' class="hidden-xs hidden-sm">
                                <?=$material->supplier->name;?>
                            </td>
                            <td style='text-align:center;vertical-align:middle' class="hidden-xs hidden-sm">
                                <?php $material->image = $material->image != null ? $material->image : "no-pic.png"; ?>
                                <img data-action="zoom" src="<?=base_url()."/files/materials/".$material->image;?>" height="40">
                            </td>
                            <td style='text-align:center;vertical-align:middle' class="hidden-xs hidden-sm">
                                <?=$material->material_type->name;?>
                            </td>
                            <td style='text-align:center;vertical-align:middle' class="hidden-xs hidden-sm">
                                <?=$core_settings->money_symbol?> <?=display_money($material->price)?>
                            </td>
                            <td style='text-align:center;vertical-align:middle' class="hidden-xs hidden-sm">
                                <?=$material->min_qty;?>
                            </td>
                            <td class="option" width="8%" style='text-align:center;vertical-align:middle'>
                                <button type="button" class="btn-option delete po" data-toggle="popover" data-placement="left" data-content="<a class='btn btn-danger po-delete ajax-silent' href='<?=base_url()?>materialmanagement/material_delete/<?=$material->id;?>'><?=$this->lang->line('application_yes_im_sure');?></a> <button class='btn po-close'><?=$this->lang->line('application_no');?></button> <input type='hidden' name='td-id' class='id' value='<?=$material->id;?>'>"
                                        data-original-title="<b><?=$this->lang->line('application_really_delete');?></b>">
                                    <i class="icon dripicons-cross"></i>
                                </button>
                                <a href="<?=base_url()?>materialmanagement/material_update/<?=$material->id;?>" class="btn-option" data-toggle="mainmodal">
                                    <i class="icon dripicons-gear"></i>
                                </a>
                            </td>
                        </tr>

                    <?php endforeach;?>
                </table>
                <div>
                    <div style="text-align: left; margin-bottom: 10px;">
                        <?php foreach (range('A', 'Z') as $char) : ?>
                                <span><a <?=$current_char == $char ? 'style="color:red;text-decoration: underline"' : ''; ?> href="<?=base_url()?>materialmanagement/materials/<?=$char?>"><?=$char?></a></span>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>