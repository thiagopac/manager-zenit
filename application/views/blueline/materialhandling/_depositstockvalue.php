<?php
    $attributes = ['class' => '', 'id' => 'stock_value'];
    echo form_open_multipart($form_action, $attributes);
?>

<div id="row">
    <div class="table-div responsive">
        <table id="stock_value" class="data-no-search table" cellspacing="0" cellpadding="0">
            <thead>
            <th>
                <?=$this->lang->line('application_material');?>
            </th>
            <th>
                <?=$this->lang->line('application_stock_quantity');?>
            </th>
            <th>
                <?=$this->lang->line('application_unit_price');?>
            </th>
            <th>
                <?=$this->lang->line('application_total_value');?>
            </th>
            </thead>
            <?php foreach ($materials as $material):?>

                <tr id="<?=$material->id;?>">
                    <td>
                        <?=$material->description;?>
                    </td>
                    <td style="text-align: center">
                        <?=$material->quantity?>
                    </td>
                    <td>
                        <?=$core_settings->money_symbol." ".display_money($material->price);?>
                    </td>
                    <td>
                        <?=$core_settings->money_symbol." ".display_money($material->quantity * $material->price);?>
                    </td>
                </tr>
            <?php endforeach;?>
        </table>
    </div>
</div>