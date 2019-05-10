<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

include_once(dirname(__FILE__).'/../third_party/functions.php');

class Dashboard extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $access = false;
        $this->view_data['update'] = false;
        if ($this->client) {
            redirect('cprojects');
        } elseif ($this->user) {
            if (in_array('dashboard', $this->view_data['module_permissions'])) {
                $access = true;
            }
            if (!$access && !empty($this->view_data['menu'][0])) {
                redirect($this->view_data['menu'][0]->link);
            } elseif (empty($this->view_data['menu'][0])) {
                $this->view_data['error'] = 'true';
                $this->session->set_flashdata('message', 'error: You have no access to any modules!');
                redirect('login');
            }
        } else {
            redirect('login');
        }

        if (in_array('projects', $this->view_data['module_permissions'])) {
            $sql = 'SELECT * FROM project_has_tasks WHERE status != "done" AND user_id = "' . $this->user->id . '" ORDER BY project_id';

            if ($this->user->admin == 0) {
                $taskquery = ProjectHasTask::find('all', ['conditions' => ['status != ? and user_id = ?', 'done', $this->user->id], 'order' => 'project_id desc']);
            }else{
                $taskquery = ProjectHasTask::find('all', ['conditions' => ['status != ? and start_date != ? and due_date != ?', 'done', '', ''], 'order' => 'project_id asc']);
            }

            $this->view_data['tasks'] = $taskquery;
        }
    }

    public function year($year = false)
    {
        $this->index($year);
    }

    public function index($year = false) {

        //Calendar
        if ($this->user->admin == 0) {
            $comp_array = [];
            $thisUserHasNoCompanies = (is_object($this->user->companies)) ? (array) $this->user->companies : [];
            if (!empty($thisUserHasNoCompanies)) {
                $this->view_data['clientcounter'] = 0;
                foreach ($this->user->companies as $value) {
                    array_push($comp_array, $value->id);
                    $this->view_data['clientcounter']++;
                }
                $projects_by_client_admin = Project::find('all', ['conditions' => ['company_id in (?)', $comp_array]]);

                //merge projects by client admin and assigned to projects
                $result = array_merge($projects_by_client_admin, $this->user->projects);
                //duplicate objects will be removed
                $result = array_map('unserialize', array_unique(array_map('serialize', $result)));
                //array is sorted on the bases of id
                sort($result);

                $projects = $result;

                //get new tickets
                $options = ['conditions' => ['status != ? AND company_id in (?)', 'closed', $comp_array], 'limit' => 5];
                $options2 = ['conditions' => ['status != ? AND company_id in (?)', 'closed', $comp_array]];
                $this->view_data['ticket'] = Ticket::find('all', $options);
                $this->view_data['ticketcounter'] = Ticket::count($options2);
                $options3 = ['conditions' => ['user_id in (?)', $this->user->id]];
                $userProjects = ProjectHasWorker::find_by_('all', $options3);
                $projectIds = [];
                foreach ($userProjects as $value) {
                    array_push($projectIds, $value->project_id);
                }

                $this->view_data['recent_activities'] = (empty($projectIds)) ? [] : ProjectHasActivity::find('all', ['conditions' => ['project_id in (?)', $projectIds], 'order' => 'datetime desc', 'limit' => 10]);
            } else {
                $projects = $this->user->projects;
                $options = ['conditions' => ['status != ? AND user_id in (?)', 'closed', $this->user->id], 'limit' => 5];
                $options2 = ['conditions' => ['status != ? AND user_id in (?)', 'closed', $this->user->id]];

                $this->view_data['ticket'] = Ticket::find('all', $options);
                $this->view_data['ticketcounter'] = Ticket::count($options2);
                $this->view_data['clientcounter'] = 0;
                $options3 = ['conditions' => ['user_id in (?)', $this->user->id]];
                $userProjects = ProjectHasWorker::find_by_('all', $options3);
                $projectIds = [];
                if (is_array($userProjects)) {
                    foreach ($userProjects as $value) {
                        array_push($projectIds, $value->project_id);
                    }
                }

                $this->view_data['recent_activities'] = (empty($projectIds)) ? [] : ProjectHasActivity::find('all', ['conditions' => ['project_id in (?)', $projectIds], 'order' => 'datetime desc', 'limit' => 10]);
            }
        } else {
            $projects = Project::all();
            $options = ['conditions' => ['status != ?', 'closed'], 'limit' => 5];
            $options2 = ['conditions' => ['status != ?', 'closed']];

            $this->view_data['ticket'] = Ticket::find('all', $options);
            $this->view_data['ticketcounter'] = Ticket::count($options2);
            $this->view_data['clientcounter'] = Company::count(['conditions' => ['inactive=?', '0']]);
            $this->view_data['recent_activities'] = ProjectHasActivity::find('all', ['order' => 'datetime desc', 'limit' => 10]);
        }
        $project_events = '';
        foreach ($projects as $value) {
            $descr = preg_replace("/\r|\n/", '', $value->description);
            $project_events .= "{
                          title: '" . $this->lang->line('application_project') . ': ' . addslashes($value->name) . "',
                          start: '" . $value->start . "',
                          end: '" . $value->end . "',
                          url: '" . base_url() . 'projects/view/' . $value->id . "',
                          className: 'project-event',
                          description: '" . addslashes($descr) . "',
                          bgColor: '".$value->color."',
                      },";
        }

        //events
        $events = Event::all();

        $event_list = '';
        $event_count_for_today = 0;
        foreach ($events as $value) {
            if (substr($value->start, 0, 10) == date('Y-m-d', time())) {
                $event_count_for_today++;
            }

            $event_list .= "{
                          title: '" . addslashes($value->title) . "',
                          start: '" . $value->start . "',
                          end: '" . $value->end . "',
                          url: '" . base_url() . 'calendar/edit_event/' . $value->id . "',
                          className: '" . $value->classname . "',
                          modal: 'true',
                          description: '" . addslashes(preg_replace("/\r|\n/", '', $value->description)) . "',

                      },";
        }

        /*$reminders = Reminder::find('all', ['conditions' => ['user_id = ?', $this->user->id]]);

        foreach ($reminders as $value) {
            $datetime = new DateTime($value->datetime);
            $event_list .= "{
								title: '[" . addslashes($this->lang->line('application_reminder')) . '] ' . addslashes($value->title) . "',
								start: '" . $datetime->format('Y-m-d H:i') . "',
								end: '" . $datetime->format('Y-m-d H:i') . "',
								url: '" . base_url() . 'leads/search/' . $value->source_id . "',
								className: 'bgColor2',
								modal: 'false',
								description: '" . addslashes(preg_replace("/\r|\n/", '', strip_tags($value->body))) . "',

							},";
        }*/

        $this->view_data['project_events'] = $project_events;
        $this->view_data['events_list'] = $event_list;
        $this->view_data['event_count_for_today'] = $event_count_for_today;

        $this->content_view = 'dashboard/dashboard';
    }

    public function taskfilter($filter){

        if ($this->user->admin == 0) {

            switch ($filter) {
                case 'all':
                    $taskquery = ProjectHasTask::find('all', ['conditions' => ['user_id = ? and status != ? and start_date != ? and due_date != ?', $this->user->id, 'done', '', ''], 'order' => 'project_id asc']);
                    break;
                case 'delayed':
                    $taskquery = ProjectHasTask::find('all', ['conditions' => ['user_id = ? and status != ? and start_date != ? and due_date != ? and NOW() > due_date', $this->user->id, 'done', '', ''], 'order' => 'project_id asc']);
                    break;
                case 'today':
                    $taskquery = ProjectHasTask::find('all', ['conditions' => ['user_id = ? and status != ? and start_date != ? and due_date != ? and due_date BETWEEN NOW() AND NOW() + INTERVAL 1 DAY', $this->user->id, 'done', '', ''], 'order' => 'project_id asc']);
                    break;
                case 'two':
                    $taskquery = ProjectHasTask::find('all', ['conditions' => ['user_id = ? and status != ? and start_date != ? and due_date != ? and due_date BETWEEN NOW() AND NOW() + INTERVAL 2 DAY', $this->user->id, 'done', '', ''], 'order' => 'project_id asc']);
                    break;
                case 'week':
                    $taskquery = ProjectHasTask::find('all', ['conditions' => ['user_id = ? and status != ? and start_date != ? and due_date != ? and due_date BETWEEN NOW() AND NOW() + INTERVAL 1 WEEK', $this->user->id, 'done', '', ''], 'order' => 'project_id asc']);
                    break;
                case 'weekahead':
                    $taskquery = ProjectHasTask::find('all', ['conditions' => ['user_id = ? and status != ? and start_date != ? and due_date != ? and due_date BETWEEN NOW() + INTERVAL 1 WEEK AND NOW() + INTERVAL 1 YEAR', $this->user->id, 'done', '', ''], 'order' => 'project_id asc']);
                    break;
            }

        } else {

            switch ($filter) {
                case 'all':
                    $taskquery = ProjectHasTask::find('all', ['conditions' => ['status != ? and start_date != ? and due_date != ?', 'done', '', ''], 'order' => 'project_id asc']);
                    break;
                case 'delayed':
                    $taskquery = ProjectHasTask::find('all', ['conditions' => ['status != ? and start_date != ? and due_date != ? and NOW() > due_date', 'done', '', ''], 'order' => 'project_id asc']);
                    break;
                case 'today':
                    $taskquery = ProjectHasTask::find('all', ['conditions' => ['status != ? and start_date != ? and due_date != ? and due_date BETWEEN NOW() AND NOW() + INTERVAL 1 DAY', 'done', '', ''], 'order' => 'project_id asc']);
                    break;
                case 'two':
                    $taskquery = ProjectHasTask::find('all', ['conditions' => ['status != ? and start_date != ? and due_date != ? and due_date BETWEEN NOW() AND NOW() + INTERVAL 2 DAY', 'done', '', ''], 'order' => 'project_id asc']);
                    break;
                case 'week':
                    $taskquery = ProjectHasTask::find('all', ['conditions' => ['status != ? and start_date != ? and due_date != ? and due_date BETWEEN NOW() AND NOW() + INTERVAL 1 WEEK', 'done', '', ''], 'order' => 'project_id asc']);
                    break;
                case 'weekahead':
                    $taskquery = ProjectHasTask::find('all', ['conditions' => ['status != ? and start_date != ? and due_date != ? and due_date BETWEEN NOW() + INTERVAL 1 WEEK AND NOW() + INTERVAL 1 YEAR', 'done', '', ''], 'order' => 'project_id asc']);
                    break;
            }
        }
        

        $this->view_data['tasks'] = $taskquery;
        $this->view_data['active_task_filter'] = $filter;

        $this->content_view = 'dashboard/dashboard';
    }

}
