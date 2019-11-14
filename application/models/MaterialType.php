<?php

class MaterialType extends ActiveRecord\Model {

    public static $table_name = 'material_type';

    public static $has_many = array(
        array('material', 'foreign_key' => 'material_type_id')
    );

    public static $belongs_to = array(
        array('stock_area', 'foreign_key' => 'stock_area_id')
    );
}
?>