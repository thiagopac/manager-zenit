<?php

class Company extends ActiveRecord\Model {

    static $table_name = 'company';

	static $has_many = array(
	array('client', 'conditions' => 'inactive != 1'),
    array('project'),
    array("company_admin"),
    array('user', 'through' => 'company_admin')
    );

    static $belongs_to = array(
    array('client', 'conditions' => 'inactive != 1')
    );
}