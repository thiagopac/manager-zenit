<?php

class Expense extends ActiveRecord\Model {
    static $belongs_to = array(
    array('project'),
    array('user'),
    array('invoice'),
    array('expense')
    );

    static $has_many = array(
    array('expenses'),
 	);

}