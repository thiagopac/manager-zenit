<?php

class LeadComment extends ActiveRecord\Model
{
    public static $table_name = 'lead_comment';
  
    public static $belongs_to = array(
     array('user'),
     array('lead'),
  );
}
