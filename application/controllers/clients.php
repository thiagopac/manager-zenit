<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Clients extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $access = false;
        if ($this->client) {
            redirect('cprojects');
        } elseif ($this->user) {
            $this->view_data['project_access'] = false;
            $this->view_data['invoice_access'] = false;
            foreach ($this->view_data['menu'] as $key => $value) {
                if ($value->link == 'clients') {
                    $access = true;
                }
                if ($value->link == 'invoices') {
                    $this->view_data['invoice_access'] = true;
                }
                if ($value->link == 'projects') {
                    $this->view_data['project_access'] = true;
                }
            }
            if (!$access) {
                redirect('login');
            }
        } else {
            redirect('login');
        }
    }

    public function index()
    {
        if ($this->user->admin == 0) {
            $thisUserHasNoCompanies = (array) $this->user->companies;
            if (!empty($thisUserHasNoCompanies)) {
                $comp_array = [];
                foreach ($this->user->companies as $value) {
                    array_push($comp_array, $value->id);
                }
                $options = ['conditions' => ['inactive = ? AND id in (?)', 0, $comp_array]];
                $this->view_data['companies'] = Company::find('all', $options);
            } else {
                $this->view_data['companies'] = (object) [];
            }
        } else {
            $options = ['conditions' => ['inactive=?', '0']];
            $this->view_data['companies'] = Company::find('all', $options);
        }

        $this->content_view = 'clients/all';
    }

    public function create($company_id = false)
    {
        if ($_POST) {
            $config['upload_path'] = './files/media/';
            $config['encrypt_name'] = true;
            $config['allowed_types'] = 'gif|jpg|png';
            $config['max_width'] = '180';
            $config['max_height'] = '180';

            $this->load->library('upload', $config);

            if ($this->upload->do_upload()) {
                $data = ['upload_data' => $this->upload->data()];

                $_POST['userpic'] = $data['upload_data']['file_name'];
            } else {
                $error = $this->upload->display_errors('', ' ');
                if ($error != 'You did not select a file to upload. ') {
                    $this->session->set_flashdata('message', 'error:' . $error);
                    redirect('clients');
                }
            }

            unset($_POST['send'], $_POST['userfile'], $_POST['file-name']);

            if (isset($_POST['access'])) {
                $_POST['access'] = implode(',', $_POST['access']);
            } else {
                unset($_POST['access']);
            }
            $_POST = array_map('htmlspecialchars', $_POST);
            $_POST['company_id'] = $company_id;
            $client = Client::create($_POST);
            $client->password = $client->set_password($_POST['password']);
            $client->save();
            if (!$client) {
                $this->session->set_flashdata('message', 'error:' . $this->lang->line('messages_client_add_error'));
            } else {
                $this->session->set_flashdata('message', 'success:' . $this->lang->line('messages_client_add_success'));
                $company = Company::find($company_id);
                if (!isset($company->client->id)) {
                    $client = Client::last();
                    $company->update_attributes(['client_id' => $client->id]);
                }
            }
            redirect('clients/view/' . $company_id);
        } else {
            $this->view_data['clients'] = Client::find('all', ['conditions' => ['inactive=?', '0']]);
            $this->view_data['modules'] = Module::find('all', ['order' => 'sort asc', 'conditions' => ['type = ?', 'client']]);
            $this->view_data['next_reference'] = Client::last();
            $this->theme_view = 'modal';
            $this->view_data['title'] = $this->lang->line('application_add_new_contact');
            $this->view_data['form_action'] = 'clients/create/' . $company_id;
            $this->content_view = 'clients/_clients';
        }
    }

    public function update($id = false, $getview = false)
    {
        if ($_POST) {
            $id = $_POST['id'];
            $client = Client::find($id);
            $config['upload_path'] = './files/media/';
            $config['encrypt_name'] = true;
            $config['allowed_types'] = 'gif|jpg|png';
            $config['max_width'] = '180';
            $config['max_height'] = '180';

            $this->load->library('upload', $config);

            if ($this->upload->do_upload()) {
                $data = ['upload_data' => $this->upload->data()];

                $_POST['userpic'] = $data['upload_data']['file_name'];
            } else {
                $error = $this->upload->display_errors('', ' ');
                if ($error != 'You did not select a file to upload. ') {
                    $this->session->set_flashdata('message', 'error:' . $error);
                    redirect('clients');
                }
            }

            unset($_POST['send'], $_POST['userfile'], $_POST['file-name']);

            if (empty($_POST['password'])) {
                unset($_POST['password']);
            } else {
                $_POST['password'] = $client->set_password($_POST['password']);
            }
            if (!empty($_POST['access'])) {
                $_POST['access'] = implode(',', $_POST['access']);
            }

            if (isset($_POST['view'])) {
                $view = $_POST['view'];
                unset($_POST['view']);
            }
            $_POST = array_map('htmlspecialchars', $_POST);

            $client->update_attributes($_POST);
            if (!$client) {
                $this->session->set_flashdata('message', 'error:' . $this->lang->line('messages_save_client_error'));
            } else {
                $this->session->set_flashdata('message', 'success:' . $this->lang->line('messages_save_client_success'));
            }
            redirect('clients/view/' . $client->company->id);
        } else {
            $this->view_data['client'] = Client::find($id);
            $this->view_data['modules'] = Module::find('all', ['order' => 'sort asc', 'conditions' => ['type = ?', 'client']]);
            if ($getview == 'view') {
                $this->view_data['view'] = 'true';
            }
            $this->theme_view = 'modal';
            $this->view_data['title'] = $this->lang->line('application_edit_client');
            $this->view_data['form_action'] = 'clients/update';
            $this->content_view = 'clients/_clients';
        }
    }

    public function notes($id = false)
    {
        if ($_POST) {
            unset($_POST['send']);
            $_POST = array_map('htmlspecialchars', $_POST);
            $project = Company::find($id);
            $project->update_attributes($_POST);
        }
        $this->theme_view = 'ajax';
    }

    public function company($condition = false, $id = false)
    {
        switch ($condition) {
            case 'create':
            if ($_POST) {
                unset($_POST['send']);
                $terms = $_POST['terms'];
                $_POST = array_map('htmlspecialchars', $_POST);
                $_POST['terms'] = $terms;
                $company = Company::create($_POST);
                $companyid = Company::last();
                $attributes = ['company_id' => $companyid->id, 'user_id' => $this->user->id];
                $adminExists = CompanyHasAdmin::exists($attributes);
                if (!$adminExists) {
                    $addUserAsClientAdmin = CompanyHasAdmin::create($attributes);
                }
                $new_company_reference = $_POST['reference'] + 1;
                $company_reference = Setting::first();
                $company_reference->update_attributes(['company_reference' => $new_company_reference]);
                if (!$company) {
                    $this->session->set_flashdata('message', 'error:' . $this->lang->line('messages_company_add_error'));
                } else {
                    $this->session->set_flashdata('message', 'success:' . $this->lang->line('messages_company_add_success'));
                }
                redirect('clients/view/' . $companyid->id);
            } else {
                $this->view_data['clients'] = Company::find('all', ['conditions' => ['inactive=?', '0']]);
                $this->view_data['next_reference'] = Company::last();
                $this->theme_view = 'modal';
                $this->view_data['title'] = $this->lang->line('application_add_new_company');
                $this->view_data['form_action'] = 'clients/company/create';
                $this->content_view = 'clients/_company';
            }
            break;
            case 'createfromlead':
            if ($_POST) {
                unset($_POST['send']);
                $terms = $_POST['terms'];
                $_POST = array_map('htmlspecialchars', $_POST);

                $company_data = [
                                        'reference' => $_POST['reference'],
                                        'name' => $_POST['name'],
                                        'website' => $_POST['website'],
                                        'phone' => $_POST['phone'],
                                        'mobile' => $_POST['mobile'],
                                        'address' => $_POST['address'],
                                        'zipcode' => $_POST['zipcode'],
                                        'city' => $_POST['city'],
                                        'country' => $_POST['country'],
                                        'province' => $_POST['province'],
                                        'vat' => $_POST['vat'],
                                        'terms' => $terms,

                                        'twitter' => $_POST['twitter'],
                                        'skype' => $_POST['skype'],
                                        'linkedin' => $_POST['linkedin'],
                                        'facebook' => $_POST['facebook'],
                                        'instagram' => $_POST['instagram'],
                                        'googleplus' => $_POST['googleplus'],
                                        'youtube' => $_POST['youtube'],
                                        'pinterest' => $_POST['pinterest'],
                                     ];

                $company = Company::create($company_data);
                $companyid = Company::last();
                $attributes = ['company_id' => $companyid->id, 'user_id' => $this->user->id];
                $adminExists = CompanyHasAdmin::exists($attributes);
                if (!$adminExists) {
                    $addUserAsClientAdmin = CompanyHasAdmin::create($attributes);
                }
                $client_data = [
                                        'company_id' => $companyid->id,
                                        'firstname' => $_POST['firstname'],
                                        'lastname' => $_POST['lastname'],
                                        'email' => $_POST['email'],
                                        'password' => $_POST['password'],
                                        'phone' => $_POST['phone'],
                                        'mobile' => $_POST['mobile'],
                                        'address' => $_POST['address'],
                                        'zipcode' => $_POST['zipcode'],
                                        'city' => $_POST['city'],
                                        'userpic' => 'no-pic.png',

                                        'twitter' => $_POST['twitter'],
                                        'skype' => $_POST['skype'],
                                        'linkedin' => $_POST['linkedin'],
                                        'facebook' => $_POST['facebook'],
                                        'instagram' => $_POST['instagram'],
                                        'googleplus' => $_POST['googleplus'],
                                        'youtube' => $_POST['youtube'],
                                        'pinterest' => $_POST['pinterest'],
                                     ];

                $client_contact = Client::create($client_data);
                $companyid->client_id = $client_contact->id;
                $companyid->save();
                $new_company_reference = $_POST['reference'] + 1;
                $company_reference = Setting::first();
                $company_reference->update_attributes(['company_reference' => $new_company_reference]);
                if (!$company) {
                    $this->session->set_flashdata('message', 'error:' . $this->lang->line('messages_company_add_error'));
                } else {
                    $this->session->set_flashdata('message', 'success:' . $this->lang->line('messages_company_add_success'));
                }
                redirect('clients/view/' . $companyid->id);
            } else {
                $this->view_data['lead'] = Lead::find_by_id($id);
                $this->view_data['modules'] = Module::find('all', ['order' => 'sort asc', 'conditions' => ['type = ?', 'client']]);
                $this->view_data['next_reference'] = Company::last();
                $this->theme_view = 'modal';
                $this->view_data['title'] = $this->lang->line('application_add_new_company');
                $this->view_data['form_action'] = 'clients/company/createfromlead';
                $this->content_view = 'clients/_company_from_lead';
            }
            break;
            case 'update':
            if ($_POST) {
                unset($_POST['send']);
                $id = $_POST['id'];
                if (isset($_POST['view'])) {
                    $view = $_POST['view'];
                    unset($_POST['view']);
                }
                $_POST = array_map('htmlspecialchars', $_POST);
                $company = Company::find_by_id($id);
                $company->update_attributes($_POST);
                if (!$company) {
                    $this->session->set_flashdata('message', 'error:' . $this->lang->line('messages_save_company_error'));
                } else {
                    $this->session->set_flashdata('message', 'success:' . $this->lang->line('messages_save_company_success'));
                }
                redirect('clients/view/' . $id);
            } else {
                $this->view_data['company'] = Company::find_by_id($id);
                $this->theme_view = 'modal';
                $this->view_data['title'] = $this->lang->line('application_edit_company');
                $this->view_data['form_action'] = 'clients/company/update';
                $this->content_view = 'clients/_company';
            }
                break;
                case 'delete':
                $company = Company::find_by_id($id);
                $company->inactive = '1';
                $company->save();
                foreach ($company->clients as $value) {
                    $client = Client::find_by_id($value->id);
                    $client->inactive = '1';
                    $client->save();
                }
                $this->content_view = 'clients/all';
                if (!$company) {
                    $this->session->set_flashdata('message', 'error:' . $this->lang->line('messages_delete_company_error'));
                } else {
                    $this->session->set_flashdata('message', 'success:' . $this->lang->line('messages_delete_company_success'));
                }
                    redirect('clients');
                break;
        }
    }

    public function assign($id = false)
    {
        $this->load->helper('notification');
        if ($_POST) {
            unset($_POST['send']);
            $id = addslashes($_POST['id']);
            $company = Company::find_by_id($id);

            $users_query = $company->company_has_admins;
            $still_assigned_users = [];
            //remove unselected users
            foreach ($users_query as $value) {
                if (!in_array($value->user_id, $_POST['user_id'])) {
                    $delete = CompanyHasAdmin::find_by_id($value->id);
                    $delete->delete();
                } else {
                    array_push($still_assigned_users, $value->user_id);
                }
            }
            //add selected users
            foreach ($_POST['user_id'] as $value) {
                if (!in_array($value, $still_assigned_users)) {
                    $attributes = ['company_id' => $id, 'user_id' => $value];
                    $create = CompanyHasAdmin::create($attributes);
                }
            }

            if (!isset($delete) && !isset($create)) {
                $this->session->set_flashdata('message', 'error:' . $this->lang->line('messages_save_client_error'));
            } else {
                $this->session->set_flashdata('message', 'success:' . $this->lang->line('messages_save_client_success'));
            }
            redirect('clients/view/' . $id);
        } else {
            $this->view_data['users'] = User::find('all', ['conditions' => ['status=?', 'active']]);
            $this->view_data['company'] = Company::find_by_id($id);
            $this->theme_view = 'modal';
            $this->view_data['title'] = $this->lang->line('application_assign_to_agents');
            $this->view_data['form_action'] = 'clients/assign';
            $this->content_view = 'clients/_assign';
        }
    }

    public function removeassigned($id = false, $companyid = false)
    {
        $delete = CompanyHasAdmin::find(['conditions' => ['user_id = ? AND company_id = ?', $id, $companyid]]);
        $delete->delete();
        $this->theme_view = 'ajax';
    }

    public function delete($id = false)
    {
        $client = Client::find($id);
        $client->inactive = '1';
        $client->save();
        $this->content_view = 'clients/all';
        if (!$client) {
            $this->session->set_flashdata('message', 'error:' . $this->lang->line('messages_delete_client_error'));
        } else {
            $this->session->set_flashdata('message', 'success:' . $this->lang->line('messages_delete_client_success'));
        }
        redirect('clients');
    }

    public function view($id = false)
    {
        $this->view_data['submenu'] = [
                        $this->lang->line('application_back') => 'clients',
                        ];
        $this->view_data['company'] = Company::find($id);
        if ($this->user->admin != 1) {
            $comp_array = [];
            foreach ($this->user->companies as $value) {
                array_push($comp_array, $value->id);
            }
            if (!in_array($this->view_data['company']->id, $comp_array)) {
                redirect('clients');
            }
        }
        $this->view_data['invoices'] = Invoice::find('all', ['conditions' => ['estimate != ? AND company_id = ? AND estimate_status != ?', 1, $id, 'Declined']]);
        $this->content_view = 'clients/view';
    }

    public function credentials($id = false, $email = false, $newPass = false)
    {
        if ($email) {
            $this->load->helper('file');
            $client = Client::find($id);
            $timestamp = time();
            $token = hash('sha256', md5($timestamp . $client->id . $client->firstname));
            $attributes = ['email' => $client->email, 'timestamp' => $timestamp, 'token' => $token, 'user' => 0];
            PwReset::create($attributes);

            $setting = Setting::first();
            $this->email->from($setting->email, $setting->company);
            $this->email->to($client->email);
            $this->email->subject($setting->credentials_mail_subject);
            $this->load->library('parser');
            $parse_data = [
                                'client_contact' => $client->firstname . ' ' . $client->lastname,
                                'first_name' => $client->firstname,
                                'last_name' => $client->lastname,
                                'client_company' => $client->company->name,
                                'client_link' => $setting->domain,
                                'company' => $setting->company,
                                'username' => $client->email,
                                'password' => $newPass,
                                'link' => base_url() . 'forgotpass/token/' . $token,
                                'logo' => '<img src="' . base_url() . '' . $setting->logo . '" alt="' . $setting->company . '"/>',
                                'invoice_logo' => '<img src="' . base_url() . '' . $setting->invoice_logo . '" alt="' . $setting->company . '"/>'
                                ];

            $message = read_file('./application/views/' . $setting->template . '/templates/email_credentials.html');
            $message = $this->parser->parse_string($message, $parse_data);
            $this->email->message($message);
            if ($this->email->send()) {
                $this->session->set_flashdata('message', 'success:' . $this->lang->line('messages_send_login_details_success'));
            } else {
                $this->session->set_flashdata('message', 'error:' . $this->lang->line('messages_send_login_details_error'));
            }
            redirect('clients/view/' . $client->company_id);
        } else {
            $this->view_data['client'] = Client::find($id);
            $this->theme_view = 'modal';

            function random_password($length = 8)
            {
                $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
                $password = substr(str_shuffle($chars), 0, $length);
                return $password;
            }

            $this->view_data['new_password'] = random_password();
            $this->view_data['title'] = $this->lang->line('application_login_details');
            $this->view_data['form_action'] = 'clients/credentials';
            $this->content_view = 'clients/_credentials';
        }
    }

    public function hash_passwords()
    {
        $clients = Client::all();
        foreach ($clients as $client) {
            $pass = $client->password_old;
            $client->password = $client->set_password($pass);
            $client->save();
        }
        redirect('clients');
    }
}
