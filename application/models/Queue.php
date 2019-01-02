<?php

class Queue extends ActiveRecord\Model {

	static $has_many = array(
    array("tickets"),
    );
}
