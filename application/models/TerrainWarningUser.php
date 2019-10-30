<?php

class TerrainWarningUser extends ActiveRecord\Model {
    static $table_name = 'terrain_warning_user';

   	
    static $belongs_to = array(
     array('terrain')
  );

}
