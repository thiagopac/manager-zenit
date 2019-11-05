<?php

class DepositStockArea extends ActiveRecord\Model{

    public static $table_name = 'deposit_stock_area';

    public static $belongs_to = array(
        array('deposit', 'foreign_key', 'deposit_id'),
        array('stock_area', 'foreign_key', 'stock_area_id')
    );

    // public static $has_many = array(
    //     array("deposit", 'foreign_key' => 'deposit_id'),
    //     array("stock_area", 'foreign_key' => 'stock_area_id')
    // );
}
?>