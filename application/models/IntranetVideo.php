<?php

class IntranetVideo extends ActiveRecord\Model {

    static $table_name = 'intranet_video';

    static $belongs_to = array(
        array('intranet_project')
    );
}