<?php

class Project extends ActiveRecord\Model {
	static $belongs_to = array(
     array('company')
  );

	static $has_many = array(
    array("project_has_tasks", 'order' => 'task_order'),
    array("project_has_milestones", 'order' => 'orderindex'),
    array('project_has_files'),
    array('project_has_workers'),
    array('project_has_invoices'),
    array('project_has_timesheets'),
    array('project_has_activities',
           'order'    => 'datetime DESC'),
    array('messages'),
    array('tickets')
    );

      public static function OverdueByDate($userId, $comp_array, $date){
            $filter = "";
            if($comp_array != FALSE)
            {
              $filter = "company_id in (".$comp_array.") AND ";
            }
            $projects = Project::find_by_sql("SELECT 
              * 
              FROM 
                `projects`
              WHERE 
                $filter

                `progress` != '100' 
              AND 
                `end` < '$date' 
              ORDER BY 
                `end`
            ");

        return $projects;
      }

      public static function get_categories(){
          $categories = Project::find_by_sql("SELECT 
              `category` 
              FROM 
                `projects`
              GROUP BY 
                `category`
            ");

        return $categories;
      }

      public static function getAllTasksTime($projectID){
       $taskTime = ProjectHasTask::find_by_sql("SELECT 
                sum(`time`) AS 'summary'
            FROM 
                `project_has_timesheets` 
            WHERE
               `project_id` = $projectID
            ");
        $tracking = $taskTime[0]->summary;
        $tracking = ($tracking) ? $tracking : 0;
        $tracking = floor($tracking/60);
    $tracking_hours = floor($tracking/60);
    $tracking_minutes = $tracking-($tracking_hours*60);
    $CI =& get_instance();
    $time_spent = $tracking_hours." ".$CI->lang->line('application_hours')." ".$tracking_minutes." ".$CI->lang->line('application_minutes');

        return $time_spent;
    }
}
