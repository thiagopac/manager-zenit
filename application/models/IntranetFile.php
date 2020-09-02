<?php

class IntranetFile extends ActiveRecord\Model {

    static $table_name = 'intranet_file';

    static $belongs_to = array(
        array('intranet_home_post')
    );

}