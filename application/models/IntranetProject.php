<?php

class IntranetProject extends ActiveRecord\Model {

    static $table_name = 'intranet_project';

    static $has_many = array(
        array('intranet_procedures_post')
    );

}