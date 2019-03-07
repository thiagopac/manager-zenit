<?php

class LeadStatus extends ActiveRecord\Model {
    static $table_name = 'lead_status';
    
    static $has_many = array(
    	array('leads', 'foreign_key' => 'status_id')
    );

  
}
