<?php
    $attributes = ['class' => '', 'id' => 'depositamount'];
    echo form_open_multipart($form_action, $attributes);
?>

<div id="row">
    <div class="table-div responsive">
        <table id="amount" class="data-no-search table" cellspacing="0" cellpadding="0">
            <thead>
            <th style="width:80px" class="hidden-xs">
                <?=$this->lang->line('application_id');?>
            </th>
            <th class="hidden-xs">
                <?=$this->lang->line('application_material');?>
            </th>
            <th class="hidden-xs">
                <?=$this->lang->line('application_stock_area');?>
            </th>
            <th class="hidden-xs">
                <?=$this->lang->line('application_quantity');?>
            </th>
            </thead>
            <?php foreach ($materials as $material):?>

                <tr id="<?=$material->id;?>">
                    <td class="hidden-xs">
                        <?=$material->id;?>
                    </td>
                    <td>
                        <?=$material->description;?>
                    </td>
                    <td>
                        <?=$material->name?>
                    </td>
                    <td>
                        <?=$material->quantity;?>
                    </td>
                </tr>
            <?php endforeach;?>
        </table>
    </div>
</div>