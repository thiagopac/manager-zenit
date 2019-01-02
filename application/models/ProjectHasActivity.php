<?php

class ProjectHasActivity extends ActiveRecord\Model {
    static $table_name = 'project_has_activities';
  
   static $belongs_to = array(
     array('user'),
     array('client'),
     array('project'),

  );
}
