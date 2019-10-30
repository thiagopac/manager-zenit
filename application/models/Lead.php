<?php

class Lead extends ActiveRecord\Model
{
    public static $table_name = 'lead';

    public static $belongs_to = array(
        array('lead_status', 'foreign_key' => 'status_id'),
        array('user'),
    );

    public static $has_many = array(
        array("lead_comment", 'foreign_key' => 'lead_id'),
        array("lead_history", 'foreign_key' => 'lead_id'),
        array("lead_warning_user", 'foreign_key' => 'lead_id'),
    );
}
