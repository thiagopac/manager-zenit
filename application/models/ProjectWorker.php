<?php

class ProjectWorker extends ActiveRecord\Model {
    static $table_name = 'project_worker';

   	
    static $belongs_to = array(
     array('user'),
     array('project'),
  );

    public static function getDoneTasks($projectID, $userID){
       $tasks = ProjectTask::count(array('conditions' => array('status = ? AND project_id = ? AND user_id = ?', 'done', $projectID, $userID)));
        return $tasks;
    }
     public static function getTasksInProgress($projectID, $userID){
       $tasks = ProjectTask::count(array('conditions' => array('status != ? AND project_id = ? AND user_id = ?', 'done', $projectID, $userID)));
        return $tasks;
    }
    public static function getAllTasksInProject($projectID, $userID){
       $tasks = ProjectTask::find('all', array('conditions' => array('project_id = ? AND user_id = ?', $projectID, $userID)));
        return $tasks;
    }
     public static function getAllTasksTime($projectID, $userID){
       $taskTime = ProjectTask::find_by_sql("SELECT 
                sum(`time`) AS 'summary'
            FROM 
                `project_timesheet` 
            WHERE 
                `user_id` = $userID
            AND
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
