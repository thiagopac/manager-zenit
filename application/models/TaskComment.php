<?php

class TaskComment extends ActiveRecord\Model {
   static $table_name = 'task_comment';
  
   static $belongs_to = array(
     array('user'),
     array('client'),
     array('project_task', 'foreign_key' => 'task_id'),
  );

}