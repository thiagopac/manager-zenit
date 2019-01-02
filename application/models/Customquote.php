<?php

class Customquote extends ActiveRecord\Model {
	static $table_name = 'custom_quotations';
	
	static $belongs_to = array(
     array('user')
  );
}