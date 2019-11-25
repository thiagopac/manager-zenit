<?php

class MaterialHandling extends ActiveRecord\Model {

    public static $table_name = 'material_handling';

    public static $belongs_to = array(
        array('material', 'foreign_key' => 'material_id'),
        array('deposit', 'foreing_key' => 'deposit_id')
    );
}
?>