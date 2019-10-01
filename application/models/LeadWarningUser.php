<?php

class LeadWarningUser extends ActiveRecord\Model {
    static $table_name = 'lead_warning_user';

   	
    static $belongs_to = array(
     array('lead')
  );

}
