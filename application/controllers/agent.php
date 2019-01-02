<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Agent extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        if ($this->client) {
        } elseif ($this->user) {
        } else {
            redirect('login');
        }
    }

    public function index()
    {
        if ($this->client) {
            $user = Client::find($this->client->id);
            if ($_POST) {
                $config['upload_path'] = './files/media/';
                $config['encrypt_name'] = true;
                $config['allowed_types'] = 'gif|jpg|jpeg|png';
                $config['max_width'] = '180';
                $config['max_height'] = '180';

                $this->load->library('upload', $config);

                if ($this->upload->do_upload()) {
                    $data = ['upload_data' => $this->upload->data()];

                    $_POST['userpic'] = $data['upload_data']['file_name'];
                }
                unset($_POST['send'], $_POST['userfile'], $_POST['file-name']);

                if (!empty($_POST['password'])) {
                    $attr['password'] = $user->set_password($_POST['password']);
                }
                if (!empty($_POST['userpic'])) {
                    $attr['userpic'] = $_POST['userpic'];
                }
                $user->update_attributes($attr);
                $this->session->set_flashdata('message', 'success:' . $this->lang->line('messages_password_changed'));
                redirect('');
            } else {
                $this->view_data['user'] = $user;
                $this->theme_view = 'modal';
                $this->view_data['title'] = $this->lang->line('application_change_password');
                $this->view_data['form_action'] = 'agent/';
                $this->content_view = 'settings/_clientform';
            }
        } elseif ($this->user) {
            $user = User::find($this->user->id);

            if ($_POST) {
                $config['upload_path'] = './files/media/';
                $config['encrypt_name'] = true;
                $config['allowed_types'] = 'gif|jpg|jpeg|png';
                $config['max_width'] = '180';
                $config['max_height'] = '180';

                $this->load->library('upload', $config);

                if ($this->upload->do_upload()) {
                    $data = ['upload_data' => $this->upload->data()];

                    $_POST['userpic'] = $data['upload_data']['file_name'];
                }

                unset($_POST['send'], $_POST['userfile'], $_POST['file-name'], $_POST['access']);

                $_POST = array_map('htmlspecialchars', $_POST);
                $attr = [
                            'username' => $_POST['username'],
                            'firstname' => $_POST['firstname'],
                            'lastname' => $_POST['lastname'],
                            'email' => $_POST['email'],
                            'signature' => $_POST['signature']
                            ];
                if (isset($_POST['title'])) {
                    $attr['title'] = $_POST['title'];
                }
                if (isset($_POST['created'])) {
                    $attr['created'] = $_POST['created'];
                }
                if (!empty($_POST['userpic'])) {
                    $attr['userpic'] = $_POST['userpic'];
                }
                if (!empty($_POST['password'])) {
                    $attr['password'] = $_POST['password'];
                }
                $user->update_attributes($attr);
                $this->session->set_flashdata('message', 'success:' . $this->lang->line('messages_changes_saved'));
                redirect('');
            } else {
                $this->view_data['user'] = $user;
                $this->theme_view = 'modal';
                $this->view_data['title'] = $this->lang->line('application_enter_your_personal_details');
                $this->view_data['agent'] = true;
                $this->view_data['form_action'] = 'agent/';
                $this->content_view = 'settings/_userform';
            }
        }
    }

    public function language($lang = false)
    {
        $folder = 'application/language/';
        $languagefiles = scandir($folder);
        if (in_array($lang, $languagefiles)) {
            $cookie = [
                   'name' => 'fc2language',
                   'value' => $lang,
                   'expire' => '31536000',
               ];

            $this->input->set_cookie($cookie);
        }
        if ($this->input->cookie('fc2_link') != '') {
            redirect($this->input->cookie('fc2_link'));
        } else {
            redirect('');
        }
    }

    public function token()
    {
        $token = bin2hex(openssl_random_pseudo_bytes(16));

        if ($this->user) {
            $user = User::find_by_id($this->user->id);
            $user->token = $token;
            $user->save();
        }
        if ($this->client) {
            $client = Client::find_by_id($this->client->id);
            $client->token = $token;
            $client->save();
        }
        json_response(
                        'success',
                        $this->lang->line('application_token_has_been_created'),
                        ['token' => $token]
                    );
    }

    public function welcome($step = false)
    {
        $this->view_data['user'] = $user;
        $this->theme_view = 'modal';
        switch ($step) {
            case '1':

                $this->view_data['title'] = $this->lang->line('application_enter_your_personal_details');
                $this->view_data['form_action'] = 'agent';
                $this->content_view = 'auth/_mysettings';
                break;

            default:
                $this->view_data['title'] = $this->lang->line('application_welcome');
                $this->view_data['form_action'] = 'agent/welcome/1';
                $this->content_view = 'auth/_firstlogin';
                break;
        }
    }
}
