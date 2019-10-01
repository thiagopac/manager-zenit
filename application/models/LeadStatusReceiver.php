<?php

class LeadStatusReceiver extends ActiveRecord\Model {
    static $table_name = 'lead_status_receiver';

   	
    static $belongs_to = array(
     array('user'),
     array('lead_status'),
  );

}
