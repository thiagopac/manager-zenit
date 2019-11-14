<?php

class Material extends ActiveRecord\Model {

    public static $table_name = 'material';

    public static $belongs_to = array(
        array('material_type', 'foreign_key' => 'material_type_id')
    );
}
?>