<?php

class DepositStockArea extends ActiveRecord\Model{

    public static $table_name = 'depoisit_stock_area';

    public static $belongs_to = array(
        array('deposit', 'foreign_key', 'deposit_id'),
        array('stock_area', 'foreign_key', 'stock_area_id')
    );
}
?>