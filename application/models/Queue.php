<?php

class Queue extends ActiveRecord\Model {

    static $table_name = 'queue';

	static $has_many = array(
    array("tickets"),
    );
}
