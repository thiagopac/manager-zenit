<div id="row">

    <?php include 'materialhandling_menu.php'; ?>

    <div class="col-md-12 col-lg-12">
        <div class="box-shadow">
            <div class="table-head">
                <?=$this->lang->line('application_deposit_stock_areas');?>
                <span class="pull-right">
					<a href="<?=base_url()?>materialmanagement/deposit_stock_area_create" class="btn btn-primary" data-toggle="mainmodal">
						<?=$this->lang->line('application_add_deposit_stock_area');?>
					</a>
				</span>
            </div>
            <div class="table-div responsive">
                <table id="deposit_stock_areas" class="data-no-search table" cellspacing="0" cellpadding="0">
                    <thead>
                    <th style="width:80px" class="hidden-xs">
                        <?=$this->lang->line('application_deposits');?>
                    </th>
                    <th class="hidden-xs">
                        <?=$this->lang->line('application_stock_areas');?>
                    </th>
                    <th class="hidden-xs">
                        <?=$this->lang->line('application_capacity');?>
                    </th>
                    <th class="hidden-xs">
                        <?=$this->lang->line('application_action');?>
                    </th>
                    </thead>
                    <?php foreach ($deposit_stock_areas as $deposit_stock_area):?>

                        <tr id="<?=$deposit_stock_area->deposit_id;?>">
                            
                            <td class="hidden-xs">
                                <?=$deposit_stock_area->deposit->name;?>
                            </td>

                            <td class="hidden-xs">
                                <?=$deposit_stock_area->stock_area->name;?>
                            </td>

                            <td class="hidden-xs">
                                <?=$deposit_stock_area->capacity;?>
                            </td>

                            <td class="option" width="8%">
                                <button type="button" class="btn-option delete po" data-toggle="popover" data-placement="left" data-content="<a class='btn btn-danger po-delete ajax-silent' href='<?=base_url()?>materialmanagement/deposit_stock_area_delete/<?=$deposit_stock_area->id;?>'><?=$this->lang->line('application_yes_im_sure');?></a> <button class='btn po-close'><?=$this->lang->line('application_no');?></button> <input type='hidden' name='td-id' class='id' value='<?=$deposit_stock_area->id;?>'>"
                                        data-original-title="<b><?=$this->lang->line('application_really_delete');?></b>">
                                    <i class="icon dripicons-cross"></i>
                                </button>
                                <a href="<?=base_url()?>materialmanagement/deposit_stock_area_update/<?=$deposit_stock_area->deposit_id;?>/<?=$deposit_stock_area->stock_area_id;?>" class="btn-option" data-toggle="mainmodal">
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