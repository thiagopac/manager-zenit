<?php

class Deposit extends ActiveRecord\Model{

    public static $table_name = 'deposit';

    public $amounts = array();

    public static $has_many = array(
        array('deposit_stock_area', 'foreign_key' => 'deposit_id'),
        array('stock_area', 'through' => 'deposit_stock_area'),
        array('material_handling', 'foreing_key', 'deposit_id'),
        array('deposit_amount', 'foreing_key', 'deposit_id')
    );
}
?>