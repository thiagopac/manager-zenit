<?php

class ProjectActivity extends ActiveRecord\Model {
    static $table_name = 'project_activity';
  
   static $belongs_to = array(
     array('user'),
     array('client'),
     array('project'),

  );
}
