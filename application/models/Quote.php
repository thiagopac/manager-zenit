<?php

class Quote extends ActiveRecord\Model {
	static $table_name = 'quotations';
	
	static $belongs_to = array(
     array('user')
  );
}