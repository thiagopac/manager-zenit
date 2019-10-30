<?php

class TerrainStatus extends ActiveRecord\Model {
    static $table_name = 'terrain_status';
    
    static $has_many = array(
    	array('terrain', 'foreign_key' => 'status_id'),
        array('terrain_status_receiver'),
    );
}
