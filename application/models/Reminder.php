<?php

class Reminder extends ActiveRecord\Model
{
    public static $table_name = 'reminder';
  
    public static $belongs_to = array(
     array('user'),
  );
}
