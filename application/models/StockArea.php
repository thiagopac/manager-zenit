<?php

class StockArea extends ActiveRecord\Model{

    public static $table_name = 'stock_area';

    public static $has_many = array(
        array('deposit_stock_area', 'foreign_key' => 'stock_area_id'),
        array('material_type', 'foreign_key' => 'stock_area_id')
    );
}
?>