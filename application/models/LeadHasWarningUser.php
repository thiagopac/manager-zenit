<?php

class LeadHasWarningUser extends ActiveRecord\Model {
    static $table_name = 'lead_has_warning_users';

   	
    static $belongs_to = array(
     array('lead')
  );

}
