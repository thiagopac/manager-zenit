<?php

class ProjectTimesheet extends ActiveRecord\Model {
    static $table_name = 'project_timesheet';
  
   static $belongs_to = array(
     array('user'),
     array('project'),
     array('project_task'),
     array('client'),
  );

}