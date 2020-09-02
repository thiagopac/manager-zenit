<?php

class IntranetHomeFixed extends ActiveRecord\Model {

    static $table_name = 'intranet_home_fixed';

    static $has_many = array(
        array('intranet_file')
    );

}