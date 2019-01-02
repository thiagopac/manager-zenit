<?php

class TaskHasComment extends ActiveRecord\Model {
   static $table_name = 'task_has_comments';
  
   static $belongs_to = array(
     array('user'),
     array('client'),
     array('project_has_task', 'foreign_key' => 'task_id'),
  );

}