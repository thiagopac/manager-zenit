<?php

class IntranetHomePost extends ActiveRecord\Model {

    static $table_name = 'intranet_home_post';

    static $has_many = array(
        array('intranet_file', 'conditions' => 'deleted != 1')
    );

}