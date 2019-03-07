<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Calendar extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $access = false;
        if ($this->client) {
            if ($this->input->cookie('fc2_link') != '') {
                $link = $this->input->cookie('fc2_link');
                $link = str_replace('/tickets/', '/ctickets/', $link);
                redirect($link);
            } else {
                redirect('cprojects');
            }
        } elseif ($this->user) {
            foreach ($this->view_data['menu'] as $key => $value) {
                if ($value->link == 'calendar') {
                    $access = true;
                }
            }
            if (!$access) {
                redirect('login');
            }
        } else {
            redirect('login');
        }
        $this->view_data['submenu'] = [
                        $this->lang->line('application_all') => 'projects/filter/all',
                        $this->lang->line('application_open') => 'projects/filter/open',
                        $this->lang->line('application_closed') => 'projects/filter/closed'
                        ];
    }

    public function index()
    {
        if ($this->user->admin == 0) {
            $comp_array = [];
            $thisUserHasNoCompanies = (array) $this->user->companies;
            if (!empty($thisUserHasNoCompanies)) {
                foreach ($this->user->companies as $value) {
                    array_push($comp_array, $value->id);
                }
                $projects_by_client_admin = Project::find('all', ['conditions' => ['company_id in (?)', $comp_array]]);

                //merge projects by client admin and assigned to projects
                $result = array_merge($projects_by_client_admin, $this->user->projects);
                //duplicate objects will be removed
                $result = array_map('unserialize', array_unique(array_map('serialize', $result)));
                //array is sorted on the bases of id
                sort($result);

                $projects = $result;
            } else {
                $projects = $this->user->projects;
            }
        } else {
            $projects = Project::all();
        }
        $project_events = '';
        foreach ($projects as $value) {
          // var_dump($value);
          // exit;
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
        foreach ($events as $value) {
            $event_list .= "{
                          title: '" . addslashes($value->title) . "',
                          start: '" . $value->start . "',
                          end: '" . $value->end . "',
                          url: '" . base_url() . 'calendar/edit_event/' . $value->id . "',
                          className: '" . $value->classname . " ',
                          modal: 'true',
                          description: '" . addslashes(preg_replace("/\r|\n/", '', $value->description)) . "',
                      },";
        }

        $task_list = '';
        foreach ($projects as $project) {

            foreach ($project->project_has_tasks as $pht) {

                if ($pht->start_date == null || $pht->user_id != $this->user->id){
                    continue;
                }

                $descr = preg_replace("/\r|\n/", '', $pht->name);
                $task_list .= "{
                          title: '" . $this->lang->line('application_task') . ': ' . addslashes($pht->name) . ' (' . $project->name . ') ' . "',
                          start: '" . $pht->start_date . "',
                          end: '" . $pht->due_date . "',
                          url: '" . base_url() . 'projects/tasks/' . $project->id .'/update/' . $pht->id . "',
                          className: 'project-event',
                          modal: 'true',
                          description: '" . addslashes($descr) . "',
                          bgColor: '".$project->color."',
                      },";

            }
        }

        $reminders = Reminder::find('all', ['conditions' => ['user_id = ?', $this->user->id]]);

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

        $this->view_data['core_settings'] = Setting::first();
        $this->view_data['project_events'] = $project_events;
        $this->view_data['events_list'] = $event_list;
        $this->view_data['tasks_list'] = $task_list;
        $this->content_view = 'calendar/full';
    }

    public function create()
    {
        if ($_POST) {
            unset($_POST['send']);
            $_POST['title'] = htmlspecialchars($_POST['title']);
            $_POST['start'] = new DateTime($_POST['start']);
            $_POST['start'] = $_POST['start']->format('Y-m-d H:i');
            $_POST['end'] = new DateTime($_POST['end']);
            $_POST['end'] = $_POST['end']->format('Y-m-d H:i');
            $_POST['description'] = htmlspecialchars($_POST['description']);
            $_POST['user_id'] = $this->user->id;
            $Event = Event::create($_POST);
            if (!$Event) {
                $this->session->set_flashdata('message', 'error:' . $this->lang->line('messages_create_event_error'));
            } else {
                $this->session->set_flashdata('message', 'success:' . $this->lang->line('messages_create_event_success'));
            }
            redirect('calendar');
        } else {
            $this->theme_view = 'modal';
            $this->view_data['title'] = $this->lang->line('application_create_event');
            $this->view_data['form_action'] = 'calendar/create';
            $this->content_view = 'calendar/_event';
        }
    }

    public function edit_event($id = false)
    {
        if ($_POST) {
            unset($_POST['send']);
            $event = Event::find_by_id($_POST['id']);
            unset($_POST['id']);
            $_POST['title'] = htmlspecialchars($_POST['title']);
            $_POST['start'] = new DateTime($_POST['start']);
            $_POST['start'] = $_POST['start']->format('Y-m-d H:i');
            $_POST['end'] = new DateTime($_POST['end']);
            $_POST['end'] = $_POST['end']->format('Y-m-d H:i');
            $_POST['description'] = htmlspecialchars($_POST['description']);
            $event = $event->update_attributes($_POST);
            if (!$event) {
                $this->session->set_flashdata('message', 'error:' . $this->lang->line('messages_create_event_error'));
            } else {
                $this->session->set_flashdata('message', 'success:' . $this->lang->line('messages_create_event_success'));
            }
            redirect('calendar');
        } else {
            $this->view_data['event'] = Event::find_by_id($id);
            $this->theme_view = 'modal';
            $this->view_data['title'] = $this->lang->line('application_update_event');
            $this->view_data['form_action'] = 'calendar/edit_event';
            $this->content_view = 'calendar/_event';
        }
    }

    public function delete($id = false)
    {
        $event = Event::find_by_id($id);
        $event->delete();
        if (!$event) {
            $this->session->set_flashdata('message', 'error:' . $this->lang->line('messages_delete_event_error'));
        } else {
            $this->session->set_flashdata('message', 'success:' . $this->lang->line('messages_delete_event_success'));
        }
        redirect('calendar');
    }

    public function integrate()
    {
        if (empty($this->user->token)) {
            $token = bin2hex(openssl_random_pseudo_bytes(16));
            $this->user->token = $token;
            $this->user->save();
        }
        $this->theme_view = 'modal';
        $this->view_data['title'] = $this->lang->line('application_integrate');
        $this->content_view = 'calendar/_integrate';
    }
}
