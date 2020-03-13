<?php

class Material extends ActiveRecord\Model {

    public static $table_name = 'material';

    public $amount;
    public $handling_in;
    public $handling_out;
    public $handling_last;

    public static $belongs_to = array(
        array('material_type', 'foreign_key' => 'material_type_id'),
        array('supplier', 'foreign_key' => 'supplier_id')
    );

    public static $has_many = array(
        array('material_handling', 'foreign_key' => 'material_id'),
        array('deposit_amount', 'foreign_key' => 'material_id')
    );
}
?>