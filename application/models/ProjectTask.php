<?php

class ProjectTask extends ActiveRecord\Model
{
    public static $table_name = 'project_task';

    public static $belongs_to = [
     ['user'],
     ['project'],
     ['project_milestone', 'foreign_key' => 'milestone_id'],
     ['client', 'class_name' => 'client', 'foreign_key' => 'client_id'],
     ['creator', 'class_name' => 'client', 'foreign_key' => 'created_by_client'],
  ];
    public static $has_many = [
    ['project_timesheet'],
    ['task_comment', 'foreign_key' => 'task_id'],
    ];

    /**
       ** Get sum of payments grouped by Month for statistics
       ** return object
       **/
    public static function getDueTaskStats($projectID, $from, $to)
    {
        $dueTaskStats = ProjectTask::find_by_sql("SELECT 
                `due_date`,
                count(`id`) AS 'tasksDue'
            FROM 
                `project_task` 
            WHERE 
                `due_date` BETWEEN '$from' AND '$to' 
            AND
            	 `project_id` = $projectID
            Group BY 
                SUBSTR(`due_date`, -5), due_date;
            ");

        return $dueTaskStats;
    }

    public static function getStartTaskStats($projectID, $from, $to)
    {
        $dueTaskStats = ProjectTask::find_by_sql("SELECT 
                `start_date`,
                count(`id`) AS 'tasksDue'
            FROM 
                `project_task` 
            WHERE 
                `start_date` BETWEEN '$from' AND '$to' 
            AND
                 `project_id` = $projectID
            Group BY 
                SUBSTR(`start_date`, -5), `start_date`;
            ");

        return $dueTaskStats;
    }

    public static function getDoneTasks($projectID)
    {
        $doneTasks = ProjectTask::find_by_sql("SELECT 
                `id`
            FROM 
                `project_task` 
            WHERE 
                `progress` = 100 
            AND
                 `project_id` = $projectID
            ");

        return $doneTasks;
    }

    public static function getClientTasks($projectID, $clientID)
    {
        $clientTasks = ProjectTask::find_by_sql("SELECT 
                *
            FROM 
                `project_task` 
            WHERE 
                `public` = 1
            AND
                 `project_id` = $projectID
            ORDER BY 
                `task_order`

            ");

        return $clientTasks;
    }

    public static function createTaskReference($len=10, $abc="aAbBcCdDeEfFgGhHiIjJkKlLmMnNoOpPqQrRsStTuUvVwWxXyYzZ0123456789") {

        $letters = str_split($abc);
        $str = "";
        for ($i=0; $i<$len; $i++) {
            $str .= $letters[rand(0, count($letters)-1)];
        };

        return strtoupper($str);
    }
}
