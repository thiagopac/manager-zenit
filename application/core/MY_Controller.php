<?php
class My_Controller extends CI_Controller
{
    public $user = false;
    public $client = false;
    public $core_settings = false;
    // Theme functionality
    protected $theme_view = 'application';
    protected $content_view = '';
    protected $view_data = array();

    public function __construct()
    {
        parent::__construct();

        /* XSS Filtering */
        if (!empty($_POST)) {
            $fieldList = array("description","message", "terms", "note", "smtp_pass", "password", "ticket_config_pass", "css-area");
            $ignoreXSS = array("mail_body");
            function remove_bad_tags_from($field)
            {
                $_POST[$field] = preg_replace('/(&lt;|<)\?php(.*)(\?(&gt;|>))/imx', '[php] $2 [php]', $_POST[$field]);
                $_POST[$field] = preg_replace('/((&lt;|<)(\s*|\/)script(.*?)(&gt;|>))/imx', ' [script] ', $_POST[$field]);
                $_POST[$field] = preg_replace('/((&lt;|<)(\s*)link(.*?)\/?(&gt;|>))/imx', '[link $4 ]', $_POST[$field]);
                $_POST[$field] = preg_replace('/((&lt;|<)(\s*)(\/*)(\s*)style(.*?)(&gt;|>))/imx', ' [style] ', $_POST[$field]);
            }

            foreach ($_POST as $key => $value) {
                if (in_array($key, $fieldList)) {
                    remove_bad_tags_from($key);
                } elseif (!in_array($key, $ignoreXSS)) {
                    $_POST[$key] = $this->security->xss_clean($_POST[$key]);
                }
            }
        }


        $this->view_data['core_settings'] = Setting::first();

        //Timezone
        if ($this->view_data['core_settings']->timezone != "") {
            date_default_timezone_set($this->view_data['core_settings']->timezone);
        }

        $this->view_data['datetime'] = date('Y-m-d H:i', time());
        $date = date('Y-m-d', time());

        //Languages
        if ($this->input->cookie('fc2language') != "") {
            $language = $this->input->cookie('fc2language');
        } else {
            if (isset($this->view_data['language'])) {
                $language = $this->view_data['language'];
            } else {
                if (!empty($this->view_data['core_settings']->language)) {
                    $language = $this->view_data['core_settings']->language;
                } else {
                    $language = "english";
                }
            }
        }
        $this->view_data['time24hours'] = "true";
        switch ($language) {

              case "english": $this->view_data['langshort'] = "en"; $this->view_data['timeformat'] = "h:i K"; $this->view_data['dateformat'] = "F j, Y"; $this->view_data['time24hours'] = "false"; break;
              case "portuguese": $this->view_data['langshort'] = "pt"; $this->view_data['timeformat'] = "H:i"; $this->view_data['dateformat'] = "d/m/Y"; break;
              default: $this->view_data['langshort'] = "en"; $this->view_data['timeformat'] = "h:i K"; $this->view_data['dateformat'] = "F j, Y"; $this->view_data['time24hours'] = "false"; break;

        }

        //fetch installed languages
        $installed_languages = array();
        if ($handle = opendir('application/language/')) {
            while (false !== ($entry = readdir($handle))) {
                if ($entry != "." && $entry != ".." && $entry != ".DS_Store") {
                    array_push($installed_languages, $entry);
                }
            }
            closedir($handle);
        }

        $this->lang->load('application', $language);
        if (file_exists("./application/language/".$language."/custom_lang.php")) {
            $this->lang->load('custom', $language);
        }
        $this->lang->load('messages', $language);
        $this->lang->load('event', $language);
        $this->view_data['current_language'] = $language;
        $this->view_data['installed_languages'] = $installed_languages;


        //userdata
        $this->user = $this->session->userdata('user_id') ? User::find_by_id($this->session->userdata('user_id')) : false;
        $this->client = $this->session->userdata('client_id') ? Client::find_by_id($this->session->userdata('client_id')) : false;


        if ($this->user || $this->client) {

            //check if user or client
            if ($this->user) {
                $access            = explode(",", $this->user->access);
                $update            = $this->user;
                $email                = 'u'.$this->user->id;
                $userIsSuperAdmin    = ($this->user->admin == '1') ? true : false;
                $comp_array            = false;
                //Create client access list if active user is not super admin
                if (!$userIsSuperAdmin) {
                    $comp_array = array();
                    $thisUserHasCompanies = (array) $this->user->company;
                    if (!empty($thisUserHasCompanies)) {
                        foreach ($this->user->company as $value) {
                            array_push($comp_array, $value->id);
                        }
                        $comp_array = "'".implode(',', $comp_array)."'";
                    } else {
                        $comp_array = 0;
                    }
                }


                $this->view_data['menu'] = Module::find('all', array('order' => 'sort asc', 'conditions' => array('id in (?) AND type = ?', $access, 'main')));
                $this->view_data['module_permissions'] = array();
                $notification_list = array();
                foreach ($this->view_data['menu'] as $key => $value) {
                    array_push($this->view_data['module_permissions'], $value->link);
                }

                $this->view_data['widgets']        = Module::find('all', array('conditions' => array('id in (?) AND type = ?', $access, 'widget')));
                $this->view_data['user_online']    = User::all(array('conditions' => array('last_active+(30 * 60) > ? AND status = ?', time(), "active")));
                $this->view_data['client_online']    = Client::all(array('conditions' => array('last_active+(30 * 60) > ? AND inactive = ?', time(), "0")));

                $this->view_data['sticky']            = Project::find_by_sql("select distinct(project.name), project.id, project.tracking, project.progress from project, project_worker where project.sticky = 1 AND project.id = project_worker.project_id AND project_worker.user_id=".$this->user->id);

                $this->view_data['tickets_access'] = false;
                if (in_array("tickets", $this->view_data['module_permissions'])) {
                    $this->view_data['tickets_access'] = true;
                    $this->view_data['tickets_new'] = Ticket::newTicketCount($this->user->id, $comp_array);
                }

                $notification_list = Notification::get_notifications($this->user);

                $hasUnredNotifications = 0;

                foreach ($notification_list as $notification){
                    if ($notification->status == "new"){
                        $hasUnredNotifications = $hasUnredNotifications +1;
                    }
                }

                $this->view_data["unread_notifications"] = $hasUnredNotifications;

                    krsort($notification_list);
                $this->view_data["notification_list"] = $notification_list;
                $this->view_data["notification_count"] = count($notification_list);
            } else {
                $this->theme_view = 'application_client';
                $access = $this->client->access;
                $access = explode(",", $access);
                $email = 'c'.$this->client->id;
                $this->view_data['menu'] = Module::find('all', array('order' => 'sort asc', 'conditions' => array('id in (?) AND type = ?', $access, 'client')));
                $update = Client::find($this->client->id);
            }

            //Update user last active
            $update->last_active = time();
            $update->save();

            $this->view_data['messages_new'] = PrivateMessage::find_by_sql("select count(id) as amount from private_message where `status`='New' AND recipient = '".$email."'");
        }

        /*$this->load->database();
        $sql = "select * FROM templates WHERE type='notes'";
        $query = $this->db->query($sql); */
        $this->view_data["note_templates"] = "";//$query->result();

        /* save current url */
        $url = explode('/', $this->uri->uri_string());
        $no_link = array('login', 'register', 'logout', 'language', 'forgotpass', 'postmaster', 'cronjob', 'agent', 'api');
        if (!in_array($this->uri->uri_string(), $no_link) && empty($_POST) && (!isset($url[1]) || $url[1] == "view")) {
            $link = '/'.$this->uri->uri_string();
            $cookie = array(
                       'name'   => 'fc2_link',
                       'value'  => $link,
                       'expire' => '500',
                   );

            $this->input->set_cookie($cookie);
        }
    }

    public function _output($output)
    {
        // set the default content view
        if ($this->content_view !== false && empty($this->content_view)) {
            $this->content_view = $this->router->class . '/' . $this->router->method;
        }
        //render the content view
        $yield = file_exists(APPPATH . 'views/' . $this->view_data['core_settings']->template . '/' . $this->content_view . EXT) ? $this->load->view($this->view_data['core_settings']->template . '/' . $this->content_view, $this->view_data, true) : false;

        //render the theme
        if ($this->theme_view) {
            echo $this->load->view($this->view_data['core_settings']->template . '/' .'theme/' . $this->theme_view, array('yield' => $yield), true);
        } else {
            echo $yield;
        }

        echo $output;
    }

//    Debug para php + javascript
    function debug_to_console( $data ) {
        $output = $data;
        if ( is_array( $output ) )
            $output = implode( ',', $output);

        echo "<script>console.log( 'Debug Objects: " . $output . "' );</script>";
    }

    function my_array_unique($array, $keep_key_assoc = false){
        $duplicate_keys = array();
        $tmp = array();

        foreach ($array as $key => $val){
            // convert objects to arrays, in_array() does not support objects
            if (is_object($val))
                $val = (array)$val;

            if (!in_array($val, $tmp))
                $tmp[] = $val;
            else
                $duplicate_keys[] = $key;
        }

        foreach ($duplicate_keys as $key)
            unset($array[$key]);

        return $keep_key_assoc ? $array : array_values($array);
    }
}
