<?php

class LeadHistory extends ActiveRecord\Model {
	static $table_name = 'lead_history';
	
	static $belongs_to = array(
     array('lead')
  );

    public static function get_history($lead){
        $options = ['conditions' => ['lead_id = ? ORDER BY created_at ASC', $lead->id]];
        $registries = Notification::all($options);

        return $registries;
    }

}