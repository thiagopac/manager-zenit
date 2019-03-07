<?php

class Lead extends ActiveRecord\Model
{
    public static $table_name = 'leads';

    public static $belongs_to = array(
         array('lead_status', 'foreign_key' => 'status_id'),
         array('user'),
  );
    public static $has_many = array(
        array("lead_has_comments", 'foreign_key' => 'lead_id'),
    );
}
