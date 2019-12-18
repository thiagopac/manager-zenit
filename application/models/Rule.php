<?php

class Rule extends ActiveRecord\Model {

    public static $table_name = 'rule';

    public static $belongs_to = [
        ['user', 'foreign_key' => 'user_id']
    ];
}
?>