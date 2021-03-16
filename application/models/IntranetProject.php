<?php

class IntranetProject extends ActiveRecord\Model {

    static $table_name = 'intranet_project';

    static $has_many = array(
        array('intranet_procedures_post', 'conditions' => 'deleted != 1'),
        array('intranet_media_post', 'conditions' => 'deleted != 1'),
        array('intranet_photo', 'conditions' => 'deleted != 1'),
        array('intranet_video', 'conditions' => 'deleted != 1')
    );

}