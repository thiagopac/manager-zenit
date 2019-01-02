<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Register extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $core_settings = Setting::first();
        if ($core_settings->registration != 1) {
            redirect('login');
        }

        if ($_POST) {
            $this->load->library('parser');
            $this->load->helper('file');
            $this->load->helper('notification');
            $client = Client::find_by_email(trim(htmlspecialchars($_POST['email'])));
            if ($client->inactive == 1) {
                $client = false;
            }
            $check_company = Company::find_by_name(trim(htmlspecialchars($_POST['name'])));

            if (!$client && !$check_company && trim(htmlspecialchars($_POST['name'])) != '' && trim(htmlspecialchars($_POST['email'])) != '' && $_POST['password'] != '' && $_POST['firstname'] != '' && $_POST['lastname'] != '' && $_POST['confirmcaptcha'] != '') {
                $client_attr = [];
                $company_attr['name'] = trim(htmlspecialchars($_POST['name']));
                $company_attr['website'] = trim(htmlspecialchars($_POST['website']));
                $company_attr['phone'] = trim(htmlspecialchars($_POST['phone']));
                $company_attr['mobile'] = trim(htmlspecialchars($_POST['mobile']));
                $company_attr['address'] = trim(htmlspecialchars($_POST['address']));
                $company_attr['zipcode'] = trim(htmlspecialchars($_POST['zipcode']));
                $company_attr['city'] = trim(htmlspecialchars($_POST['city']));
                $company_attr['country'] = trim(htmlspecialchars($_POST['country']));
                $company_attr['province'] = trim(htmlspecialchars($_POST['province']));
                $company_attr['vat'] = trim(htmlspecialchars($_POST['vat']));
                $company_attr['reference'] = $core_settings->company_reference;

                $core_settings->company_reference = $core_settings->company_reference + 1;
                $core_settings->save();

                $company = Company::create($company_attr);

                if (!$company) {
                    $this->session->set_flashdata('message', 'success:' . $this->lang->line('messages_registration_error'));
                    redirect('register');
                }

                $lastclient = Client::last();
                $client_attr = [];
                $client_attr['email'] = trim(htmlspecialchars($_POST['email']));
                $client_attr['firstname'] = trim(htmlspecialchars($_POST['firstname']));
                $client_attr['lastname'] = trim(htmlspecialchars($_POST['lastname']));
                $client_attr['phone'] = trim(htmlspecialchars($_POST['phone']));
                $client_attr['mobile'] = trim(htmlspecialchars($_POST['mobile']));
                $client_attr['address'] = trim(htmlspecialchars($_POST['address']));
                $client_attr['zipcode'] = trim(htmlspecialchars($_POST['zipcode']));
                $client_attr['city'] = trim(htmlspecialchars($_POST['city']));
                $client_attr['access'] = $core_settings->default_client_modules;

                $client_attr['company_id'] = $company->id;

                $client = Client::create($client_attr);
                if ($client) {
                    $client->password = $client->set_password($_POST['password']);
                    $client->save();
                    $company->client_id = $client->id;
                    $company->save();

                    $this->email->from($core_settings->email, $core_settings->company);
                    $this->email->to($client_attr['email']);

                    $this->email->subject($this->lang->line('application_your_account_has_been_created'));
                    $parse_data = [
                                    'link' => base_url() . 'login/',
                                    'company' => $core_settings->company,
                                    'client_company' => $company->name,
                                    'first_name' => $client->firstname,
                                    'last_name' => $client->lastname,
                                    'company_reference' => $company->reference,
                                    'logo' => '<img src="' . base_url() . '' . $core_settings->logo . '" alt="' . $core_settings->company . '"/>',
                                    'invoice_logo' => '<img src="' . base_url() . '' . $core_settings->invoice_logo . '" alt="' . $core_settings->company . '"/>'
                                    ];
                    $email = read_file('./application/views/' . $core_settings->template . '/templates/email_create_account.html');
                    $message = $this->parser->parse_string($email, $parse_data);
                    $this->email->message($message);
                    $this->email->send();
                    send_notification($core_settings->email, $this->lang->line('application_new_client_has_registered'), $this->lang->line('application_new_client_has_registered') . ': <br><strong>' . $company_attr['name'] . '</strong><br>' . $client_attr['firstname'] . ' ' . $client_attr['lastname'] . '<br>' . $client_attr['email']);

                    $tickets = Ticket::find('all', ['conditions' => ['`from` LIKE CONCAT("%", ? ,"%")', $client_attr['email']]]);
                    if ($tickets) {
                        foreach ($tickets as $ticket) {
                            $ticket->client_id = $client->id;
                            $ticket->company_id = $client_attr['company_id'];
                            $ticket->save();
                        }
                    }

                    $this->session->set_flashdata('message', 'success:' . $this->lang->line('messages_registration_success'));
                    redirect('login');
                } else {
                    $this->session->set_flashdata('message', 'success:' . $this->lang->line('messages_registration_error'));
                    redirect('login');
                }
            } else {
                if ($client) {
                    $this->view_data['error'] = $this->lang->line('messages_email_already_taken');
                }
                if ($check_company) {
                    $this->view_data['error'] = 'Company name is already taken!';
                }
                $this->theme_view = 'login';
                $this->content_view = 'auth/register';
                $this->view_data['form_action'] = 'register';
                $_POST['name'] = trim(htmlspecialchars($_POST['name']));
                $_POST['website'] = trim(htmlspecialchars($_POST['website']));
                $_POST['phone'] = trim(htmlspecialchars($_POST['phone']));
                $_POST['mobile'] = trim(htmlspecialchars($_POST['mobile']));
                $_POST['address'] = trim(htmlspecialchars($_POST['address']));
                $_POST['zipcode'] = trim(htmlspecialchars($_POST['zipcode']));
                $_POST['city'] = trim(htmlspecialchars($_POST['city']));
                $_POST['country'] = trim(htmlspecialchars($_POST['country']));
                $_POST['province'] = trim(htmlspecialchars($_POST['province']));
                $_POST['vat'] = trim(htmlspecialchars($_POST['vat']));
                $_POST['email'] = trim(htmlspecialchars($_POST['email']));
                $_POST['firstname'] = trim(htmlspecialchars($_POST['firstname']));
                $_POST['lastname'] = trim(htmlspecialchars($_POST['lastname']));
                $_POST['phone'] = trim(htmlspecialchars($_POST['phone']));
                $_POST['mobile'] = trim(htmlspecialchars($_POST['mobile']));
                $_POST['address'] = trim(htmlspecialchars($_POST['address']));
                $_POST['zipcode'] = trim(htmlspecialchars($_POST['zipcode']));
                $_POST['city'] = trim(htmlspecialchars($_POST['city']));
                $this->view_data['registerdata'] = array_map('htmlspecialchars', $_POST);
            }
        } else {
            $this->view_data['error'] = 'false';
            $this->theme_view = 'login';
            $this->content_view = 'auth/register';
            $this->view_data['form_action'] = 'register';
        }
    }
}
