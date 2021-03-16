<?php

class IntranetMediaPost extends ActiveRecord\Model {

    static $table_name = 'intranet_media_post';

    static $belongs_to = array(
        array('intranet_project')
    );

}