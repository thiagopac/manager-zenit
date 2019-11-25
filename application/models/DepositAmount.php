<?php
class DepositAmount extends ActiveRecord\Model {

    public static $table_name = "deposit_amount";

    public static $belongs_to = array(
        array('deposit', 'foreign_key' => 'deposit_id'),
        array('material', 'foreign_key' => 'material_id')
    );
}
?>