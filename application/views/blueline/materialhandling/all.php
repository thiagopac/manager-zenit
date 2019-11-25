<div id="row">
    <div class="col-md-12">
        <div class="box-shadow">
            <div class="table-head">
                <?=$this->lang->line('application_entrances');?>
                <span class="pull-right">
					<a href="<?=base_url()?>materialmanagement/entrance_create" class="btn btn-primary" data-toggle="mainmodal">
						<?=$this->lang->line('application_add_entrance');?>
					</a>
				</span>
            </div>
            <div class="table-div responsive">
                <table id="entrances" class="data-no-search table" cellspacing="0" cellpadding="0">
                    <thead>
                    <th style="width:80px" class="hidden-xs">
                        <?=$this->lang->line('application_id');?>
                    </th>
                    <th class="hidden-xs">
                        <?=$this->lang->line('application_deposit');?>
                    </th>
                    <th class="hidden-xs">
                        <?=$this->lang->line('application_material');?>
                    </th>
                    <th class="hidden-xs">
                        <?=$this->lang->line('application_quantity');?>
                    </th>
                    <th class="hidden-xs">
                        <?=$this->lang->line('application_date');?>
                    </th>
                    <th class="hidden-xs">
                        <?=$this->lang->line('application_action');?>
                    </th>
                    </thead>
                    <?php foreach ($entrances as $entrance):?>

                        <tr id="<?=$entrance->id;?>">
                            <td class="hidden-xs">
                                <?=$entrance->id;?>
                            </td>
                            <td>
                                <?=$entrance->deposit->name;?>
                            </td>
                            <td>
                                <?=$entrance->material->description;?>
                            </td>
                            <td>
                                <?=$entrance->quantity;?>
                            </td>
                            <td>
                                <?=$entrance->date;?>
                            </td>

                            <td class="option" width="8%">
                                <button type="button" class="btn-option delete po" data-toggle="popover" data-placement="left" data-content="<a class='btn btn-danger po-delete ajax-silent' href='<?=base_url()?>materialmanagement/entrance_delete/<?=$entrance->id;?>'><?=$this->lang->line('application_yes_im_sure');?></a> <button class='btn po-close'><?=$this->lang->line('application_no');?></button> <input type='hidden' name='td-id' class='id' value='<?=$entrance->id;?>'>"
                                        data-original-title="<b><?=$this->lang->line('application_really_delete');?></b>">
                                    <i class="icon dripicons-cross"></i>
                                </button>
                                <a href="<?=base_url()?>materialmanagement/entrance_update/<?=$entrance->id;?>/<?=$entrance->deposit_id;?>/<?=$entrance->material_id?>/<?=$entrance->quantity?>/<?=$entrance->date?>" class="btn-option" data-toggle="mainmodal">
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

<div id="row">
    <div class="col-md-12">
        <div class="box-shadow">
            <div class="table-head">
                <?=$this->lang->line('application_outputs');?>
                <span class="pull-right">
					<a href="<?=base_url()?>materialmanagement/output_create" class="btn btn-primary" data-toggle="mainmodal">
						<?=$this->lang->line('application_add_output');?>
					</a>
				</span>
            </div>
            <div class="table-div responsive">
                <table id="outputs" class="data-no-search table" cellspacing="0" cellpadding="0">
                    <thead>
                    <th style="width:80px" class="hidden-xs">
                        <?=$this->lang->line('application_id');?>
                    </th>
                    <th class="hidden-xs">
                        <?=$this->lang->line('application_deposit');?>
                    </th>
                    <th class="hidden-xs">
                        <?=$this->lang->line('application_material');?>
                    </th>
                    <th class="hidden-xs">
                        <?=$this->lang->line('application_quantity');?>
                    </th>
                    <th class="hidden-xs">
                        <?=$this->lang->line('application_date');?>
                    </th>
                    <th class="hidden-xs">
                        <?=$this->lang->line('application_action');?>
                    </th>
                    </thead>
                    <?php foreach ($outputs as $output):?>

                        <tr id="<?=$output->id;?>">
                            <td class="hidden-xs">
                                <?=$output->id;?>
                            </td>
                            <td>
                                <?=$output->deposit->name;?>
                            </td>
                            <td>
                                <?=$output->material->description;?>
                            </td>
                            <td>
                                <?=$output->quantity;?>
                            </td>
                            <td>
                                <?=$output->date;?>
                            </td>

                            <td class="option" width="8%">
                                <button type="button" class="btn-option delete po" data-toggle="popover" data-placement="left" data-content="<a class='btn btn-danger po-delete ajax-silent' href='<?=base_url()?>materialmanagement/output_delete/<?=$output->id;?>'><?=$this->lang->line('application_yes_im_sure');?></a> <button class='btn po-close'><?=$this->lang->line('application_no');?></button> <input type='hidden' name='td-id' class='id' value='<?=$output->id;?>'>"
                                        data-original-title="<b><?=$this->lang->line('application_really_delete');?></b>">
                                    <i class="icon dripicons-cross"></i>
                                </button>
                                <a href="<?=base_url()?>materialmanagement/output_update/<?=$output->id;?>/<?=$output->deposit_id;?>/<?=$output->material_id?>/<?=$output->quantity?>/<?=$output->date?>" class="btn-option" data-toggle="mainmodal">
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