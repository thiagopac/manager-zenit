<?php

class TerrainComment extends ActiveRecord\Model
{
    public static $table_name = 'terrain_comment';
  
    public static $belongs_to = array(
     array('user'),
     array('terrain'),
  );
}
