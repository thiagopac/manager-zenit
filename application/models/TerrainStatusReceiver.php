<?php

class TerrainStatusReceiver extends ActiveRecord\Model {
    static $table_name = 'terrain_status_receiver';

   	
    static $belongs_to = array(
     array('user'),
     array('terrain_status'),
  );

}
