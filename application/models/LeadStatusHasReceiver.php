<?php

class LeadStatusHasReceiver extends ActiveRecord\Model {
    static $table_name = 'lead_status_has_receivers';

   	
    static $belongs_to = array(
     array('user'),
     array('lead_status'),
  );

}
