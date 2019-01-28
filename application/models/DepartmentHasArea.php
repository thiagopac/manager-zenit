<?php

class DepartmentHasArea extends ActiveRecord\Model {
    static $table_name = 'department_has_areas';
  
   static $belongs_to = array(
     array('project')
  );
   static $has_many = array(
    array('project_has_milestones', 'foreign_key' => 'area_id', 'order' => 'area_order')
    );
}
