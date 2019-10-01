<?php

class Event extends ActiveRecord\Model {

    static $table_name = 'event';

	static $belongs_to = array(
     array('user')
  );

}