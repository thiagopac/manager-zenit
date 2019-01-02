<?php

class ProjectHasFile extends ActiveRecord\Model {
    static $table_name = 'project_has_files';

    static $has_many = array(
    array('messages', 'foreign_key' => 'media_id')
    );

    static $belongs_to = array(
     array('user'),
     array('client')
  	);
}
