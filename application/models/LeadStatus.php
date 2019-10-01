<?php

class LeadStatus extends ActiveRecord\Model {
    static $table_name = 'lead_status';
    
    static $has_many = array(
    	array('lead', 'foreign_key' => 'status_id'),
        array('lead_status_receiver'),
    );

  
}
