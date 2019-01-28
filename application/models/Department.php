<?php

class Department extends ActiveRecord\Model {

    static $table_name = 'departments';

	static $has_many = array(
    array("department_has_areas", 'order' => 'orderindex')
    );

}
