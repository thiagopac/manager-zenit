<?php

class Material extends ActiveRecord\Model {

    public static $table_name = 'material';

    public static $belongs_to = array(
        array('material_type', 'foreign_key' => 'material_type_id')
    );

    public static $has_many = array(
        array('material_handling', 'foreign_key' => 'material_id'),
        array('deposit_amount', 'foreign_key' => 'material_id')
    );
}
?>