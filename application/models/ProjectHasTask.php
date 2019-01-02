<?php

class ProjectHasTask extends ActiveRecord\Model
{
    public static $table_name = 'project_has_tasks';

    public static $belongs_to = [
     ['user'],
     ['project'],
     ['invoice'],
     ['project_has_milestone', 'foreign_key' => 'milestone_id'],
     ['client', 'class_name' => 'client', 'foreign_key' => 'client_id'],
     ['creator', 'class_name' => 'client', 'foreign_key' => 'created_by_client'],
  ];
    public static $has_many = [
    ['project_has_timesheets'],
    ['task_has_comments', 'foreign_key' => 'task_id'],
    ];

    /**
       ** Get sum of payments grouped by Month for statistics
       ** return object
       **/
    public static function getDueTaskStats($projectID, $from, $to)
    {
        $dueTaskStats = ProjectHasTask::find_by_sql("SELECT 
                `due_date`,
                count(`id`) AS 'tasksDue'
            FROM 
                `project_has_tasks` 
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
        $dueTaskStats = ProjectHasTask::find_by_sql("SELECT 
                `start_date`,
                count(`id`) AS 'tasksDue'
            FROM 
                `project_has_tasks` 
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
        $doneTasks = ProjectHasTask::find_by_sql("SELECT 
                `id`
            FROM 
                `project_has_tasks` 
            WHERE 
                `progress` = 100 
            AND
                 `project_id` = $projectID
            ");

        return $doneTasks;
    }

    public static function getClientTasks($projectID, $clientID)
    {
        $clientTasks = ProjectHasTask::find_by_sql("SELECT 
                *
            FROM 
                `project_has_tasks` 
            WHERE 
                `public` = 1
            AND
                 `project_id` = $projectID
            ORDER BY 
                `task_order`

            ");

        return $clientTasks;
    }
}
