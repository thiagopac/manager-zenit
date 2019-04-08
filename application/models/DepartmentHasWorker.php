<?php

class DepartmentHasWorker extends ActiveRecord\Model {

    static $belongs_to = array(
        array('department')
    );

    static $table_name = 'department_has_workers';
}
