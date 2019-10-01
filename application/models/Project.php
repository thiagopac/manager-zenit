<?php

class Project extends ActiveRecord\Model {
    static $table_name = 'project';

	static $belongs_to = array(
     array('company')
  );

	static $has_many = array(
    array("project_task", 'order' => 'task_order'),
    array("project_milestone", 'order' => 'orderindex'),
    array('project_file'),
    array('project_worker'),
    array('project_timesheet'),
    array('project_activity',
           'order'    => 'datetime DESC'),
    array('project_message'),
    array('tickets')
    );
}
