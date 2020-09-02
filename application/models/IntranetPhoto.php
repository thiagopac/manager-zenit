<?php

class IntranetPhoto extends ActiveRecord\Model {

    static $table_name = 'intranet_photo';

    static $belongs_to = array(
        array('intranet_project')
    );

}