<div id="row">

    <?php include 'materialhandling_menu.php'; ?>

    <div class="col-md-12 col-lg-12">
        <div class="box-shadow">
            <div class="table-head">
                <?=$this->lang->line('application_deposits_reports');?>
            </div>

            <div class="table-div responsive">
                <table id="deposits_stock_value" class="data-no-search table noclick" cellspacing="0" cellpadding="0">
                    <thead>
                    <th style="width:80px">
                        <?=$this->lang->line('application_id');?>
                    </th>
                    <th>
                        <?=$this->lang->line('application_name');?>
                    </th>
                    <th style="width:300px">
                        <?=$this->lang->line('application_stock_value');?>
                    </th>
                    <th class="no-sort" style="width:80px">
                        <?=$this->lang->line('application_see_stock');?>
                    </th>
                    </thead>
                    <?php foreach ($deposits as $deposit):?>

                        <tr id="<?=$deposit->id;?>">
                            <td>
                                <?=$deposit->id;?>
                            </td>
                            <td>
                                <?=$deposit->name;?>
                            </td>
                            <td>
                                <?php

                                    $sum = 0;
                                    foreach ($deposit->amounts as $amount){
                                        $sum += $amount->quantity * $amount->price;
                                    }

                                    echo $core_settings->money_symbol." ".display_money($sum);
                                ?>
                            </td>
                            <td style="text-align: center">
                                <a href="<?=base_url()?>materialmanagement/deposit_stock_values/<?=$deposit->id;?>" class="btn-option" data-toggle="mainmodal">
                                    <i class="icon dripicons-preview"></i>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach;?>
                </table>
            </div>
        </div>
    </div>
</div>