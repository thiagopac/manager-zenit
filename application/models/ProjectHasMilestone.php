<?php

class ProjectHasMilestone extends ActiveRecord\Model {
    static $table_name = 'project_has_milestones';
  
   static $belongs_to = array(
     array('project')
  );
   static $has_many = array(
    array('project_has_tasks', 'foreign_key' => 'milestone_id', 'order' => 'milestone_order')
    );
}
