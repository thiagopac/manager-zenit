<?php

class Terrain extends ActiveRecord\Model
{
    public static $table_name = 'terrain';

    public static $belongs_to = array(
        array('terrain_status', 'foreign_key' => 'status_id'),
        array('user'),
    );

    public static $has_many = array(
        array("terrain_comment", 'foreign_key' => 'terrain_id'),
        array("terrain_history", 'foreign_key' => 'terrain_id'),
        array("terrain_warning_user", 'foreign_key' => 'terrain_id'),
    );
}
