<?php

class DepartmentArea extends ActiveRecord\Model {

    static $table_name = 'department_area';

    static $belongs_to = array(
        array('department')
    );

   static $has_many = array(
    array('project_milestone', 'foreign_key' => 'area_id', 'order' => 'area_order')
    );
}