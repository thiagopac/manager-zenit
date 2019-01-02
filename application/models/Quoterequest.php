<?php

class Quoterequest extends ActiveRecord\Model {
	static $table_name = 'custom_quotation_requests';
	
	static $belongs_to = array(
     array('customquote', 'class_name' => 'Customquote', 'foreign_key' => 'custom_quotation_id'),
     array('user')
  );
}