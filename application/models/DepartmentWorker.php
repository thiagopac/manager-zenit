<?php

class DepartmentWorker extends ActiveRecord\Model {

    static $table_name = 'department_worker';

    static $belongs_to = array(
        array('department')
    );
}