<?php

class Bank extends ActiveRecord\Model
{
    public static $table_name = 'bank';

    public static $has_many = array(
        array("supplier")
    );
}
