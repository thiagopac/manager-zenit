<?php

class TerrainHistory extends ActiveRecord\Model {
	static $table_name = 'terrain_history';
	
	static $belongs_to = array(
     array('terrain')
  );

    public static function get_history($terrain){
        $options = ['conditions' => ['terrain_id = ? ORDER BY created_at ASC', $terrain->id]];
        $registries = TerrainHistory::all($options);

        return $registries;
    }

}