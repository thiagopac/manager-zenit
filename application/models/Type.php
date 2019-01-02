<?php

class Type extends ActiveRecord\Model {

	static $has_many = array(
    array("tickets"),
    );
}
