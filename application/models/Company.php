<?php

class Company extends ActiveRecord\Model {
	static $has_many = array(
	array('clients', 'conditions' => 'inactive != 1'),
    array('invoices'),
    array('projects'),
    array('subscriptions'),
    array("company_has_admins"),
    array('users', 'through' => 'company_has_admins')
    );

    static $belongs_to = array(
    array('client', 'conditions' => 'inactive != 1')
    );
}