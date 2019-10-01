<?php

class ProjectMilestone extends ActiveRecord\Model {
    static $table_name = 'project_milestone';
  
   static $belongs_to = array(
     array('project')
  );
   static $has_many = array(
    array('project_task', 'foreign_key' => 'milestone_id', 'order' => 'milestone_order')
    );
}
