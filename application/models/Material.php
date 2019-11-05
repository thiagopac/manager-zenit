<?php

class Material extends ActiveRecord\Model{

    public static $table_name = 'material';

    public static $belongs_to = array(
        array('stock_area', 'foreign_key' => 'stock_area_id')
    );
}
?>