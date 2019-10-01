<?php

class ProjectFile extends ActiveRecord\Model {
    static $table_name = 'project_file';

    static $has_many = array(
    array('project_message', 'foreign_key' => 'media_id')
    );

    static $belongs_to = array(
     array('user'),
     array('client')
  	);
}
