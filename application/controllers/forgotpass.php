<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Forgotpass extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $this->view_data['error'] = 'false';
        $this->theme_view = 'login';
        $this->content_view = 'auth/forgotpass';
        $timestamp = time();
        $valid_until = $timestamp + 86400;
        $reset_ids = [];
        $resets_to_delete = PwReset::find('all', ['conditions' => ['timestamp < ?', $valid_until]]);
        foreach ($resets_to_delete as $reset) {
            $reset_ids[] = $reset->id;
        }
        if (!empty($reset_ids)) {
            PwReset::table()->delete(['id' => $reset_ids]);
        }

        if ($_POST) {
            $user = User::find_by_email(trim(htmlspecialchars($_POST['email'])));
            $usertrue = '1';
            if (!$user) {
                $user = Client::find_by_email(trim(htmlspecialchars($_POST['email'])));
                $usertrue = '0';
            }
            if (($user && $usertrue == '1' && $user->status == 'active') || ($user && $usertrue == '0' && $user->inactive == '0')) {
                $token = hash('sha256', md5($timestamp . $user->id . $user->firstname));
                $contact_name = $user->firstname . ' ' . $user->lastname;
                $username = ($usertrue == '1') ? $user->username : $user->email;

                $this->load->library('parser');
                $this->load->helper('file');
                $attributes = ['email' => $user->email, 'timestamp' => $timestamp, 'token' => $token, 'user' => $usertrue];
                PwReset::create($attributes);
                $data['core_settings'] = Setting::first();
                $this->email->from($data['core_settings']->email, $data['core_settings']->company);
                $this->email->to($user->email);

                $this->email->subject($data['core_settings']->pw_reset_link_mail_subject);
                $parse_data = [
                                'link' => base_url() . 'forgotpass/token/' . $token,
                                'company' => $data['core_settings']->company,
                                'client_contact' => $contact_name,
                                'first_name' => $user->firstname,
                                'last_name' => $user->lastname,
                                'username' => $username,
                                'logo' => '<img src="' . base_url() . '' . $data['core_settings']->logo . '" alt="' . $data['core_settings']->company . '"/>',
                                'invoice_logo' => '<img src="' . base_url() . '' . $data['core_settings']->invoice_logo . '" alt="' . $data['core_settings']->company . '"/>'
                                ];
                $email = read_file('./application/views/' . $data['core_settings']->template . '/templates/email_pw_reset_link.html');
                $message = $this->parser->parse_string($email, $parse_data);
                $this->email->message($message);
                $this->email->send();
                $this->session->set_flashdata('message', 'success:' . $this->lang->line('messages_password_reset_email'));
                redirect('login');
            } else {
                $this->session->set_flashdata('message', 'success:' . $this->lang->line('messages_password_reset_email_error'));

                redirect('login');
            }
        }
    }

    public function token($token = false)
    {
        $result = PwReset::find_by_token($token);
        if ($result) {
            $lees = $result->timestamp + (24 * 60 * 60);
            if (time() < $lees) {
                if (isset($_POST['password'])) {
                    $new_password = $_POST['password'];
                    if ($result->user == '1') {
                        $user = User::find_by_email($result->email);
                        $user->set_password($new_password);
                        $user->save();
                        $contact_name = $user->firstname . ' ' . $user->lastname;
                        $first_name = $user->firstname;
                        $last_name = $user->lastname;
                    } else {
                        $client = Client::find_by_email($result->email);
                        $client->password = $client->set_password($new_password);
                        $client->save();
                        $contact_name = $client->firstname . ' ' . $client->lastname;
                        $first_name = $client->firstname;
                        $last_name = $client->lastname;
                    }

                    $data['core_settings'] = Setting::first();
                    $this->email->from($data['core_settings']->email, $data['core_settings']->company);
                    $this->email->to($result->email);
                    $this->load->library('parser');
                    $this->load->helper('file');
                    $this->email->subject($data['core_settings']->pw_reset_mail_subject);
                    $parse_data = ['link' => base_url(),
                                    'company' => $data['core_settings']->company,
                                    'client_contact' => $contact_name,
                                    'first_name' => $first_name,
                                    'last_name' => $last_name,
                                    'logo' => '<img src="' . base_url() . '' . $data['core_settings']->logo . '" alt="' . $data['core_settings']->company . '"/>',
                                    'invoice_logo' => '<img src="' . base_url() . '' . $data['core_settings']->invoice_logo . '" alt="' . $data['core_settings']->company . '"/>'
                                  ];
                    $email = read_file('./application/views/' . $data['core_settings']->template . '/templates/email_pw_reset.html');
                    $message = $this->parser->parse_string($email, $parse_data);
                    $this->email->message($message);
                    $this->email->send();
                    $this->session->set_flashdata('message', 'success:' . $this->lang->line('messages_password_reset'));
                    redirect('login');
                } else {
                    $this->view_data['form_action'] = 'forgotpass/token/' . $token;
                    $this->theme_view = 'login';
                    $this->content_view = 'auth/reset_password';
                }
            } else {
                $this->session->set_flashdata('message', 'error:Password reset token is not valid anymore!');
                redirect('login');
            }
        } else {
            redirect('login');
        }
    }
}
