<?php

class Department extends ActiveRecord\Model {

	static $has_many = array(
        array("department_has_areas", 'order' => 'orderindex'),
        array("department_has_workers")
    );

}