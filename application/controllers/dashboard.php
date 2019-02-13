<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

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

        //Events
        $events = [];
        $date = date('Y-m-d', time());
        $eventcount = 0;

        if (in_array('messages', $this->view_data['module_permissions'])) {
            $sql = 'SELECT pm.id, pm.`status`, pm.subject, pm.message, pm.`time`, pm.`recipient`, cl.`userpic` as userpic_c, us.`userpic` as userpic_u, us.`email` as email_u , cl.`email` as email_c , CONCAT(us.firstname," ", us.lastname) as sender_u, CONCAT(cl.firstname," ", cl.lastname) as sender_c
							FROM privatemessages pm
							LEFT JOIN clients cl ON CONCAT("c",cl.id) = pm.sender
							LEFT JOIN users us ON CONCAT("u",us.id) = pm.sender
							WHERE pm.recipient = "u' . $this->user->id . '"AND pm.status != "deleted"
							ORDER BY pm.`time` DESC LIMIT 6';
            $query = Privatemessage::find_by_sql($sql);
            $this->view_data['message'] = array_filter($query);
        }
        if (in_array('projects', $this->view_data['module_permissions'])) {
            $sql = 'SELECT * FROM project_has_tasks WHERE status != "done" AND user_id = "' . $this->user->id . '" ORDER BY project_id';
            $taskquery = ProjectHasTask::find('all', ['conditions' => ['status != ? and user_id = ?', 'done', $this->user->id], 'order' => 'project_id desc']);
            $this->view_data['tasks'] = $taskquery;
        }
    }

    public function year($year = false)
    {
        $this->index($year);
    }

    public function index($year = false)
    {
        if (!$year) {
            $year = date('Y', time());
        }
        $currentYearMonth = date('Y-m', time());
        $thismonth = date('m');
        $yearMonth = $year . '-' . $thismonth;

        // View Values
        $this->view_data['month'] = date('M');
        $this->view_data['year'] = $year;
        $this->view_data['firstlogin'] = ($this->user->email == 'local@localhost') ? true : false;

        // Projects Stats
        $this->view_data['projects_open'] = Project::count(['conditions' => ['progress < ?', 100]]);
        $this->view_data['projects_all'] = Project::count();

        //Format main statistic labels and values
        $line1 = '';
        $line2 = '';
        $labels = '';
        $untilMonth = $thismonth;
        if ($year != date('Y', time())) {
            $untilMonth = 12;
        }
        if ($untilMonth <= 2) {
            $untilMonth = 3;
        }

        for ($i = 01; $i <= $untilMonth; $i++) {
            $monthname = date_format(date_create_from_format('Y-m-d', '2016-' . $i . '-01'), 'M');
            $monthname = $this->lang->line('application_' . $monthname);
            $num = '0';
            $num2 = '0';
            foreach ($this->view_data['stats'] as $value):
                  $act_month = explode('-', $value->paid_date);
            if ($act_month[1] == $i) {
                $num = sprintf('%02.2d', $value->summary);
            }
            endforeach;
            foreach ($this->view_data['stats_expenses'] as $value):
                  $act_month = explode('-', $value->date_month);
            if ($act_month[1] == $i) {
                $num2 = sprintf('%02.2d', $value->summary);
            }
            endforeach;
            $i = sprintf('%02.2d', $i);
            $labels .= '"' . $monthname . '"';
            $line1 .= $num;
            $line2 .= $num2;
            if ($i != '12') {
                $line1 .= ',';
                $line2 .= ',';
                $labels .= ',';
            }
        }
        $this->view_data['labels'] = $labels;
        $this->view_data['line1'] = $line1;
        $this->view_data['line2'] = $line2;

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
                          className: 'project-event ".$value->category."',
                          description: '" . addslashes($descr) . "'
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
        }

        $this->view_data['project_events'] = $project_events;
        $this->view_data['events_list'] = $event_list;
        $this->view_data['event_count_for_today'] = $event_count_for_today;*/

        $this->content_view = 'dashboard/dashboardV2';
    }
}
