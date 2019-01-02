<?php

class ProjectHasTimesheet extends ActiveRecord\Model {
    static $table_name = 'project_has_timesheets';
  
   static $belongs_to = array(
     array('user'),
     array('project'),
     array('project_has_task'),
     array('client'),
  );

}