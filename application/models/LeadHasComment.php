<?php

class LeadHasComment extends ActiveRecord\Model
{
    public static $table_name = 'lead_has_comments';
  
    public static $belongs_to = array(
     array('user'),
     array('lead'),
  );
}
