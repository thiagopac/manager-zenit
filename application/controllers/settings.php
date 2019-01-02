<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Settings extends MY_Controller
{
    public function __construct()
	{
		parent::__construct();
        $access = false;
		unset($_POST['DataTables_Table_0_length']);
        if ($this->client) {
			redirect('cprojects');
        } elseif ($this->user) {
			foreach ($this->view_data['menu'] as $key => $value) {
                if ($value->link == 'settings') {
                    $access = true;
			}
            }
            if (!$access) {
			redirect('login');
		}
        } else {
            redirect('login');
        }
        if (!$this->user->admin) {
            $this->session->set_flashdata('message', 'error:' . $this->lang->line('messages_no_access'));
			redirect('dashboard');
		}
        $this->view_data['submenu'] = [
				 		$this->lang->line('application_settings') => 'settings',
            $this->lang->line('application_agents') => 'settings/users',

            // opções de configuração do zenit suprimidas / ESCONDIDO
            // $this->lang->line('application_registration') => 'settings/registration',

				 		$this->lang->line('application_calendar') => 'settings/calendar',

            'devider1' => 'devider',

            $this->lang->line('application_email_templates') => 'settings/templates',
            $this->lang->line('application_pdf_templates') => 'settings/invoice_templates',

            'devider2' => 'devider',
            // opções de configuração do zenit suprimidas / ESCONDIDO
				 		// $this->lang->line('application_paypal') => 'settings/paypal',

            // opções de configuração do zenit suprimidas / ESCONDIDO
				 		// $this->lang->line('application_payment_gateways') => 'settings/payment_gateways',

            // opções de configuração do zenit suprimidas / ESCONDIDO
				 		// $this->lang->line('application_bank_transfer') => 'settings/bank_transfer',
            // 'devider3' => 'devider',

				 		$this->lang->line('application_cronjob') => 'settings/cronjob',
            $this->lang->line('application_backup') => 'settings/backup',

            // opções de configuração do zenit suprimidas / ESCONDIDO
            // $this->lang->line('application_system_updates') => 'settings/updates',
            // 'devider4' => 'devider',

				 		$this->lang->line('application_ticket') => 'settings/ticket',
				 		$this->lang->line('application_smtp_settings') => 'settings/smtp_settings',

            'devider5' => 'devider',

            $this->lang->line('application_custom_css') => 'settings/customize',
            $this->lang->line('application_theme_options') => 'settings/themeoptions',

            'devider6' => 'devider',

				 		$this->lang->line('application_logs') => 'settings/logs',
        ];

        $this->view_data['iconlist'] = [
                                    'settings' => 'dripicons-toggles',
                                    'settings/templates' => 'dripicons-duplicate',
                                    'settings/invoice_templates' => 'dripicons-document',
                                    'settings/calendar' => 'dripicons-calendar',
                                    'settings/paypal' => 'dripicons-store',
                                    'settings/payment_gateways' => 'dripicons-card',
                                    'settings/bank_transfer' => 'dripicons-wallet',
                                    'settings/users' => 'dripicons-user-group',
                                    'settings/registration' => 'dripicons-document-edit',
                                    'settings/updates' => 'dripicons-cloud-download',
                                    'settings/backup' => 'dripicons-stack',
                                    'settings/cronjob' => 'dripicons-media-loop',
                                    'settings/ticket' => 'dripicons-ticket',
                                    'settings/customize' => 'dripicons-code',
                                    'settings/themeoptions' => 'dripicons-brush',
                                    'settings/smtp_settings' => 'dripicons-mail',
                                    'settings/logs' => 'dripicons-information'
                                ];

		$this->config->load('defaults');
		$settings = Setting::first();
        $this->view_data['update_count'] = false;
	}

    public function index()
	{
		$this->view_data['breadcrumb'] = $this->lang->line('application_settings');
        $this->view_data['breadcrumb_id'] = 'settings';

		$this->view_data['settings'] = Setting::first();
		$this->view_data['form_action'] = 'settings/settings_update';
		$this->content_view = 'settings/settings_all';

		$this->load->helper('curl');
		/*$object = remote_get_contents('https://secure.freelancecockpit.com/api/updates/code/' . $this->view_data['settings']->pc, 1);
		$object = json_decode($object);

        if (isset($object->error) && isset($object->lastupdate)) {
            if ($object->error == false && $object->lastupdate > $this->view_data['settings']->version) {
                $this->view_data['update_count'] = '1';
			}
		}*/
	}

    public function settings_update()
    {
        if ($_POST) {
					$config['upload_path'] = './files/media/';
					$config['allowed_types'] = 'gif|jpg|png';
            $config['max_size'] = '600';
            $config['max_width'] = '300';
            $config['max_height'] = '300';

					$this->load->library('upload', $config);

            if (!$this->upload->do_upload()) {
							$error = $this->upload->display_errors('', ' ');
                if ($error != 'You did not select a file to upload.') {
								//$this->session->set_flashdata('message', 'error:'.$error);
						}
            } else {
                $data = ['upload_data' => $this->upload->data()];
                $_POST['logo'] = 'files/media/' . $data['upload_data']['file_name'];
						}
            if (!$this->upload->do_upload('userfile2')) {
							$error = $this->upload->display_errors('', ' ');
                if ($error != 'You did not select a file to upload.') {
								//$this->session->set_flashdata('message', 'error:'.$error);
						}
            } else {
                $data = ['upload_data' => $this->upload->data()];
                $_POST['invoice_logo'] = 'files/media/' . $data['upload_data']['file_name'];
						}

            unset($_POST['userfile'], $_POST['userfile2'], $_POST['file-name'], $_POST['file-name2'], $_POST['_wysihtml5_mode'], $_POST['send']);

		$settings = Setting::first();
		$settings->update_attributes($_POST);
            $this->session->set_flashdata('message', 'success:' . $this->lang->line('messages_save_settings_success'));
 		redirect('settings');
        } else {
            $this->session->set_flashdata('message', 'error:' . $this->lang->line('messages_save_settings_error'));
 			redirect('settings');
 		}
	}

    public function settings_reset($template = false)
    {
		$this->load->helper('file');
		$settings = Setting::first();
        if ($template) {
            $data = read_file('./application/views/' . $settings->template . '/templates/default/' . $template . '.html');
            if (write_file('./application/views/' . $settings->template . '/templates/' . $template . '.html', $data)) {
                $this->session->set_flashdata('message', 'success:' . $this->lang->line('messages_reset_mail_body_success'));
	 				redirect('settings/templates');
	 			}
			}
	}

    public function templates($template = 'invoice')
    {
		$this->load->helper('file');
		$settings = Setting::first();
        $filename = './application/views/' . $settings->template . '/templates/email_' . $template . '.html';
        $this->view_data['folder_path'] = '/application/views/' . $settings->template . '/templates/';
		if (!is_writable($filename)) {
		    $this->view_data['not_writable'] = true;
        } else {
			$this->view_data['not_writable'] = false;
		}
		$this->view_data['breadcrumb'] = $this->lang->line('application_templates');
        $this->view_data['breadcrumb_id'] = 'templates';

        $this->view_data['breadcrumb_sub'] = $this->lang->line('application_' . $template);
		$this->view_data['breadcrumb_sub_id'] = $template;

        if ($_POST) {
            $data = html_entity_decode($_POST['mail_body']);

            unset($_POST['mail_body'], $_POST['send']);

						$settings->update_attributes($_POST);
            if (write_file('./application/views/' . $settings->template . '/templates/email_' . $template . '.html', $data)) {
                $this->session->set_flashdata('message', 'success:' . $this->lang->line('messages_save_template_success'));
                redirect('settings/templates/' . $template);
            } else {
                $this->session->set_flashdata('message', 'error:' . $this->lang->line('messages_save_template_error'));
                redirect('settings/templates/' . $template);
					 			}
        } else {
            $this->view_data['email'] = read_file('./application/views/' . $settings->template . '/templates/email_' . $template . '.html');
				 		$this->view_data['template'] = $template;
            $this->view_data['template_files'] = get_filenames('./application/views/' . $settings->template . '/templates/default/');
				 		$this->view_data['template_files'] = str_replace('.html', '', $this->view_data['template_files']);
				 		$this->view_data['template_files'] = str_replace('email_', '', $this->view_data['template_files']);

				 		$this->view_data['settings'] = Setting::first();
            $this->view_data['form_action'] = 'settings/templates/' . $template;
						$this->content_view = 'settings/templates';
				 }
	}

    public function invoice_templates($dest = false, $template = false)
    {
		$this->load->helper('file');
		$settings = Setting::first();
        $filename = './application/views/' . $settings->template . '/templates/invoice/default.php';
        $this->view_data['folder_path'] = '/application/views/' . $settings->template . '/templates/';

		$this->view_data['breadcrumb'] = $this->lang->line('application_pdf_templates');
        $this->view_data['breadcrumb_id'] = 'invoice_templates';
        if ($_POST) {
            unset($_POST['send']);
            if (!isset($_POST['pdf_path'])) {
                $_POST['pdf_path'] = 0;
            }
						$settings->update_attributes($_POST);
            if ($settings) {
                $this->session->set_flashdata('message', 'success:' . $this->lang->line('messages_save_template_success'));
						 		redirect('settings/invoice_templates/');
            } else {
                $this->session->set_flashdata('message', 'error:' . $this->lang->line('messages_save_template_error'));
					 			redirect('settings/invoice_templates/');
					 			}
        } else {
            if ($dest && $template) {
                $DBdest = $dest . '_pdf_template';
                $attr = [];
                $attr[$DBdest] = 'templates/' . $dest . '/' . $template;
						$settings->update_attributes($attr);
						redirect('settings/invoice_templates');
            } else {
                $this->view_data['invoice_template_files'] = get_filenames('./application/views/' . $settings->template . '/templates/invoice/');
				 		$this->view_data['invoice_template_files'] = str_replace('.php', '', $this->view_data['invoice_template_files']);
                $this->view_data['estimate_template_files'] = get_filenames('./application/views/' . $settings->template . '/templates/estimate/');
				 		$this->view_data['estimate_template_files'] = str_replace('.php', '', $this->view_data['estimate_template_files']);

				 		$this->view_data['settings'] = Setting::first();
                $active_template = end(explode('/', $this->view_data['settings']->invoice_pdf_template));
				 		$this->view_data['active_template'] = str_replace('.php', '', $active_template);

                $active_estimate_template = explode('/', $this->view_data['settings']->estimate_pdf_template);
                $active_estimate_template = end();
				 		$this->view_data['active_estimate_template'] = str_replace('.php', '', $active_estimate_template);

                $this->view_data['form_action'] = 'settings/invoice_templates/' . $template;
						$this->content_view = 'settings/invoice_templates';
				 }
		}
	}

    public function paypal()
    {
		$this->view_data['breadcrumb'] = $this->lang->line('application_paypal');
        $this->view_data['breadcrumb_id'] = 'paypal';

        if ($_POST) {
		unset($_POST['send']);
            if (isset($_POST['paypal'])) {
                if ($_POST['paypal'] != '1') {
                    $_POST['paypal'] = '0';
                }
            } else {
                $_POST['paypal'] = '0';
            }
		$settings = Setting::first();
		$settings->update_attributes($_POST);
            if ($settings) {
                $this->session->set_flashdata('message', 'success:' . $this->lang->line('messages_save_settings_success'));
 		redirect('settings/paypal');
            } else {
                $this->session->set_flashdata('message', 'error:' . $this->lang->line('messages_save_settings_error'));
	 			redirect('settings/paypal');
	 			}
        } else {
 		$this->view_data['settings'] = Setting::first();
		$this->view_data['form_action'] = 'settings/paypal';
		$this->content_view = 'settings/paypal';
 		}
	}

    public function calendar()
    {
		$this->view_data['breadcrumb'] = $this->lang->line('application_calendar');
        $this->view_data['breadcrumb_id'] = 'calendar';

        if ($_POST) {
		unset($_POST['send']);

		$settings = Setting::first();
		$settings->update_attributes($_POST);
            if ($settings) {
                $this->session->set_flashdata('message', 'success:' . $this->lang->line('messages_save_settings_success'));
 		redirect('settings/calendar');
            } else {
                $this->session->set_flashdata('message', 'error:' . $this->lang->line('messages_save_settings_error'));
	 			redirect('settings/calendar');
	 			}
        } else {
 		$this->view_data['settings'] = Setting::first();
		$this->view_data['form_action'] = 'settings/calendar';
		$this->content_view = 'settings/calendar';
 		}
	}

    public function payment_gateways()
    {
		$this->view_data['breadcrumb'] = $this->lang->line('application_payment_gateways');
        $this->view_data['breadcrumb_id'] = 'payment_gateways';

        if ($_POST) {
		unset($_POST['send']);
            if (isset($_POST['stripe'])) {
                if ($_POST['stripe'] != '1') {
                    $_POST['stripe'] = '0';
                }
                if ($_POST['stripe_ideal'] != '1') {
                    $_POST['stripe_ideal'] = '0';
                }
            } else {
                $_POST['stripe'] = '0';
            }

            if (isset($_POST['authorize_net'])) {
                if ($_POST['authorize_net'] != '1') {
                    $_POST['authorize_net'] = '0';
                }
            } else {
                $_POST['authorize_net'] = '0';
            }

            if (isset($_POST['twocheckout'])) {
                if ($_POST['twocheckout'] != '1') {
                    $_POST['twocheckout'] = '0';
                }
            } else {
                $_POST['twocheckout'] = '0';
            }

		$settings = Setting::first();
		$settings->update_attributes($_POST);
            if ($settings) {
                $this->session->set_flashdata('message', 'success:' . $this->lang->line('messages_save_settings_success'));
 		redirect('settings/payment_gateways');
            } else {
                $this->session->set_flashdata('message', 'error:' . $this->lang->line('messages_save_settings_error'));
	 			redirect('settings/payment_gateways');
	 			}
        } else {
 		$this->view_data['settings'] = Setting::first();
		$this->view_data['form_action'] = 'settings/payment_gateways';
		$this->content_view = 'settings/stripe';
 		}
	}

    public function bank_transfer()
    {
		$this->view_data['breadcrumb'] = $this->lang->line('application_bank_transfer');
        $this->view_data['breadcrumb_id'] = 'bank_transfer';

        if ($_POST) {
            unset($_POST['send'], $_POST['note-codable'], $_POST['files']);

            if (isset($_POST['bank_transfer'])) {
                if ($_POST['bank_transfer'] != '1') {
                    $_POST['bank_transfer'] = '0';
                }
            } else {
                $_POST['bank_transfer'] = '0';
            }
		$settings = Setting::first();
		$settings->update_attributes($_POST);
            if ($settings) {
                $this->session->set_flashdata('message', 'success:' . $this->lang->line('messages_save_settings_success'));
 		redirect('settings/bank_transfer');
            } else {
                $this->session->set_flashdata('message', 'error:' . $this->lang->line('messages_save_settings_error'));
	 			redirect('settings/bank_transfer');
	 			}
        } else {
 		$this->view_data['settings'] = Setting::first();
		$this->view_data['form_action'] = 'settings/bank_transfer';
		$this->content_view = 'settings/bank_transfer';
 		}
	}

    public function cronjob($type = false)
    {
        $this->view_data['breadcrumb'] = $this->lang->line('application_cronjob');
        $this->view_data['breadcrumb_id'] = 'cronjob';
        if ($_POST) {
		unset($_POST['send']);
            if($type == "notifications"){
                if ($_POST['notifications'] != '1') {
                    $_POST['notifications'] = '0';
                }
            }else{
                if ($_POST['cronjob'] != '1') {
                    $_POST['cronjob'] = '0';
                }
                if ($_POST['autobackup'] != '1') {
                    $_POST['autobackup'] = '0';
                }

            }

		$settings = Setting::first();
		$settings->update_attributes($_POST);
            if ($settings) {
                $this->session->set_flashdata('message', 'success:' . $this->lang->line('messages_save_settings_success'));
 		redirect('settings/cronjob');
            } else {
                $this->session->set_flashdata('message', 'error:' . $this->lang->line('messages_save_settings_error'));
	 			redirect('settings/cronjob');
	 			}
        } else {
 		$this->view_data['settings'] = Setting::first();
		$this->view_data['form_action'] = 'settings/cronjob';
            $this->view_data['form_action2'] = 'settings/cronjob/notifications';

		$this->content_view = 'settings/cronjob';
 		}
	}

    public function ticket()
    {
		$this->view_data['breadcrumb'] = $this->lang->line('application_ticket');
        $this->view_data['breadcrumb_id'] = 'ticket';
		$this->view_data['imap_loaded'] = false;
        if (extension_loaded('imap')) {
			$this->view_data['imap_loaded'] = true;
		}
        if ($_POST) {
		unset($_POST['send']);
            if (!isset($_POST['ticket_config_active'])) {
                $_POST['ticket_config_active'] = '0';
            }
            if (!isset($_POST['ticket_config_delete'])) {
                $_POST['ticket_config_delete'] = '0';
            }
            if (!isset($_POST['ticket_config_ssl'])) {
                $_POST['ticket_config_ssl'] = '0';
            }
            if (!isset($_POST['ticket_config_imap'])) {
                $_POST['ticket_config_imap'] = '0';
            }
		$settings = Setting::first();
		$settings->update_attributes($_POST);
            if ($settings) {
                $this->session->set_flashdata('message', 'success:' . $this->lang->line('messages_save_settings_success'));
 		redirect('settings/ticket');
            } else {
                $this->session->set_flashdata('message', 'error:' . $this->lang->line('messages_save_settings_error'));
	 			redirect('settings/ticket');
	 			}
        } else {
 		$this->view_data['settings'] = Setting::first();
            $this->view_data['types'] = Type::find('all', ['conditions' => ['inactive = ?', '0']]);
            $this->view_data['queues'] = Queue::find('all', ['conditions' => ['inactive = ?', '0']]);
            $this->view_data['owners'] = User::find('all', ['conditions' => ['status = ?', 'active']]);
		$this->view_data['form_action'] = 'settings/ticket';
		$this->content_view = 'settings/ticket';
 		}
	}

    public function ticket_type($id = false, $condition = false)
    {
        if ($condition == 'delete') {
            $_POST['inactive'] = '1';
			$type = Type::find_by_id($id);
			$type->update_attributes($_POST);
        } else {
            if ($_POST) {
			unset($_POST['send']);

                if ($id) {
				$type = Type::find_by_id($id);
				$type->update_attributes($_POST);
                } else {
				$type = Type::create($_POST);
			}
                if ($type) {
                    $this->session->set_flashdata('message', 'success:' . $this->lang->line('messages_save_settings_success'));
	 		redirect('settings/ticket');
                } else {
                    $this->session->set_flashdata('message', 'error:' . $this->lang->line('messages_save_settings_error'));
		 			redirect('settings/ticket');
		 			}
            } else {
                if ($id) {
	 			$this->view_data['type'] = Type::find_by_id($id);
	 		}

	 		$this->view_data['title'] = $this->lang->line('application_type');
                $this->view_data['form_action'] = 'settings/ticket_type/' . $id;
			$this->content_view = 'settings/_ticket_type';
	 		}
 		}
 		$this->theme_view = 'modal_nojs';
	}

    public function ticket_queue($id = false, $condition = false)
    {
        if ($condition == 'delete') {
            $_POST['inactive'] = '1';
			$type = Queue::find_by_id($id);
			$type->update_attributes($_POST);
        } else {
            if ($_POST) {
			unset($_POST['send']);
                if ($id) {
			$queue = Queue::find_by_id($id);
			$queue->update_attributes($_POST);
                } else {
			$queue = Queue::create($_POST);
			}
                if ($queue) {
                    $this->session->set_flashdata('message', 'success:' . $this->lang->line('messages_save_settings_success'));
	 		redirect('settings/ticket');
                } else {
                    $this->session->set_flashdata('message', 'error:' . $this->lang->line('messages_save_settings_error'));
		 			redirect('settings/ticket');
		 			}
            } else {
                if ($id) {
	 			$this->view_data['queue'] = Queue::find_by_id($id);
	 		}
	 		$this->theme_view = 'modal_nojs';
	 		$this->view_data['title'] = $this->lang->line('application_queue');
                $this->view_data['form_action'] = 'settings/ticket_queue/' . $id;
			$this->content_view = 'settings/_ticket_queue';
	 		}
	 	}
	}

    public function testpostmaster()
    {
			$emailconfig = Setting::first();
			$config['login'] = $emailconfig->ticket_config_login;
			$config['pass'] = $emailconfig->ticket_config_pass;
			$config['host'] = $emailconfig->ticket_config_host;
			$config['port'] = $emailconfig->ticket_config_port;
			$config['mailbox'] = $emailconfig->ticket_config_mailbox;

        if ($emailconfig->ticket_config_imap == '1') {
            $flags = '/imap';
        } else {
            $flags = '/pop3';
        }
        if ($emailconfig->ticket_config_ssl == '1') {
            $flags .= '/ssl';
        }

        $config['service_flags'] = $flags . $emailconfig->ticket_config_flags;

			$this->load->library('peeker_connect');
			$this->peeker_connect->initialize($config);

        if ($this->peeker_connect->is_connected()) {
            $this->view_data['msgresult'] = 'success';
            $this->view_data['result'] = 'Connection to email mailbox successful!';
        } else {
            $this->view_data['msgresult'] = 'error';
            $this->view_data['result'] = 'Connection to email mailbox not successful!';
			}
			$this->peeker_connect->message_waiting();

			$this->peeker_connect->close();
			$this->view_data['trace'] = $this->peeker_connect->trace();
		$this->content_view = 'settings/_testpostmaster';
		$this->theme_view = 'modal_nojs';
		$this->view_data['title'] = $this->lang->line('application_postmaster_test');
	}

    public function customize()
    {
		$this->view_data['breadcrumb'] = $this->lang->line('application_customize');
        $this->view_data['breadcrumb_id'] = 'customize';

		$this->load->helper('file');
		$this->view_data['settings'] = Setting::first();
        if ($_POST) {
		$data = $_POST['css-area'];
		//$settings = Setting::first();
		//$settings->update_attributes($_POST);

            if (write_file('./assets/' . $this->view_data['settings']->template . '/css/user.css', $data)) {
                $this->session->set_flashdata('message', 'success:' . $this->lang->line('messages_save_customize_success'));
 		redirect('settings/customize');
            } else {
                $this->session->set_flashdata('message', 'error:' . $this->lang->line('messages_save_customize_error'));
	 			redirect('settings/customize');
	 			}
        } else {
            $this->view_data['writable'] = false;
            if (is_writable('./assets/' . $this->view_data['settings']->template . '/css/user.css')) {
                $this->view_data['writable'] = true;
		}
            $this->view_data['css'] = read_file('./assets/' . $this->view_data['settings']->template . '/css/user.css');
		$this->view_data['form_action'] = 'settings/customize';
		$this->content_view = 'settings/customize';
 		}
	}

    public function registration()
	{
        if ($_POST) {
				unset($_POST['send']);

            if (!isset($_POST['registration'])) {
                $_POST['registration'] = 0;
            }
            if (!empty($_POST['access'])) {
                $_POST['default_client_modules'] = implode(',', $_POST['access']);
            } else {
                $_POST['default_client_modules'] = '';
				}
            unset($_POST['access']);
				$settings = Setting::first();
				$settings->update_attributes($_POST);

            if ($settings) {
                $this->session->set_flashdata('message', 'success:' . $this->lang->line('messages_save_settings_success'));
	 		redirect('settings/registration');
	 		}
		}
		$this->view_data['breadcrumb'] = $this->lang->line('application_registration');
        $this->view_data['breadcrumb_id'] = 'registration';

        $this->view_data['client_modules'] = Module::find('all', ['order' => 'sort asc', 'conditions' => ['type = ?', 'client']]);
        $this->view_data['settings'] = Setting::first();
        $this->view_data['form_action'] = 'settings/registration';
		$this->content_view = 'settings/registration';
	}

    public function users()
	{
		$this->view_data['breadcrumb'] = $this->lang->line('application_users');
        $this->view_data['breadcrumb_id'] = 'users';

        $options = ['conditions' => ['status != ?', 'deleted']];
		$users = User::all($options);
		$this->view_data['users'] = $users;
		$this->content_view = 'settings/user';
	}

    public function user_delete($user = false)
	{
        if ($this->user->id != $user) {
		$user = User::find_by_id($user);
		$user->status = 'deleted';
		$user->save();
            $this->session->set_flashdata('message', 'success:' . $this->lang->line('messages_delete_user_success'));
        } else {
            $this->session->set_flashdata('message', 'error:' . $this->lang->line('messages_delete_user_error'));
		}
		redirect('settings/users');
	}

    public function user_create()
	{
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

            unset($_POST['file-name'], $_POST['send'], $_POST['confirm_password']);

            if (!empty($_POST['access'])) {
                $_POST['access'] = implode(',', $_POST['access']);
			}
			$_POST = array_map('htmlspecialchars', $_POST);
			$user_exists = User::find_by_username($_POST['username']);
            if (empty($user_exists)) {
			$user = User::create($_POST);
                if (!$user) {
                    $this->session->set_flashdata('message', 'error:' . $this->lang->line('messages_create_user_error'));
                } else {
                    $this->session->set_flashdata('message', 'success:' . $this->lang->line('messages_create_user_success'));
                }
            } else {
                $this->session->set_flashdata('message', 'error:' . $this->lang->line('messages_create_user_exists'));
       		}
			redirect('settings/users');
        } else {
			$this->theme_view = 'modal';
			$this->view_data['title'] = $this->lang->line('application_create_user');
            $this->view_data['modules'] = Module::find('all', ['order' => 'sort asc', 'conditions' => ['type != ?', 'client']]);
            $this->view_data['queues'] = Queue::find('all', ['conditions' => ['inactive=?', '0']]);
			$this->view_data['form_action'] = 'settings/user_create/';
			$this->content_view = 'settings/_userform';
		}
	}

    public function user_update($user = false)
    {
 		$user = User::find($user);

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

            unset($_POST['file-name'], $_POST['send'], $_POST['confirm_password']);

            if (!empty($_POST['access'])) {
                $_POST['access'] = implode(',', $_POST['access']);
            }
 		$_POST = array_map('htmlspecialchars', $_POST);
            if (empty($_POST['password'])) {
                unset($_POST['password']);
            }
            if ($_POST['admin'] == '0' && $_POST['username'] == 'Admin') {
                $_POST['admin'] = '1';
            }
 		$user->update_attributes($_POST);
            $this->session->set_flashdata('message', 'success:' . $this->lang->line('messages_save_user_success'));
 		redirect('settings/users');
        } else {
 			$this->view_data['user'] = $user;
			$this->theme_view = 'modal';
            $this->view_data['modules'] = Module::find('all', ['order' => 'sort asc', 'conditions' => ['type != ?', 'client']]);
			$this->view_data['queues'] = Queue::all();

			$this->view_data['title'] = $this->lang->line('application_edit_user');
            $this->view_data['form_action'] = 'settings/user_update/' . $user->id;
			$this->content_view = 'settings/_userform';
 		}
    }

    public function updates()
    {
		$this->view_data['breadcrumb'] = $this->lang->line('application_updates');
        $this->view_data['breadcrumb_id'] = 'updates';
        $this->view_data['settings'] = Setting::first();
		$this->load->helper('file');
		$this->load->helper('curl');

		$filename = './application/controllers/projects.php';
		if (is_writable($filename)) {
            $this->view_data['writable'] = 'TRUE';
		} else {
            $this->view_data['writable'] = 'FALSE';
		}

		$fileversion = read_file('./application/version.txt');

		if ($fileversion != $this->view_data['settings']->version) {
            $this->view_data['version_mismatch'] = 'TRUE';
		} else {
            $this->view_data['version_mismatch'] = 'FALSE';
		}

		$downloaded_updates = get_filenames('./files/updates/');
        $this->view_data['downloaded_updates'] = [];
        if (!empty($downloaded_updates)) {
			foreach ($downloaded_updates as $value) {
                $this->view_data['downloaded_updates'][$value] = ['filename' => $value, 'md5' => md5_file('./files/updates/' . $value)];
			}
		}


		$object = remote_get_contents('https://secure.freelancecockpit.com/api/updates/code/' . $this->view_data['settings']->pc);
		$object = json_decode($object);
        $this->view_data['curl_error'] = false;

        if (isset($object->error)) {
            if ($object->error == false) {
				$this->view_data['lists'] = $object->updatelist;
                foreach ($this->view_data['lists'] as $key => $file) {
                    if (isset($file->md5) && array_key_exists($file->file, $this->view_data['downloaded_updates']) && $this->view_data['downloaded_updates'][$file->file]['md5'] != $file->md5) {
						unset($this->view_data['downloaded_updates'][$file->file]);
                        @unlink('./files/updates/' . $file->file);
					}
				}
            } else {
                $this->view_data['lists'] = [];
                $this->session->set_flashdata('message', 'error: ' . $object->error);
			}
        } else {
            $this->view_data['curl_error'] = true;
            $this->view_data['lists'] = [];
			}

		$this->content_view = 'settings/updates';
    }

    public function updateinfo($version = false)
    {
        $settings = Setting::first();

        $version = str_replace('-', '.', $version);
        $this->load->helper('curl');
        $object = remote_get_contents('https://secure.freelancecockpit.com/api/updateinfo/'.$version.'/code/' . $settings->pc);
        $object = json_decode($object);

        $this->theme_view = 'modal';
        $this->view_data['title'] = $this->lang->line('application_update');
        $this->view_data['update'] = $object;

        $this->content_view = 'settings/_update_info';


    }

    public function checkForUpdates()
    {
        if ($this->user->admin == 1) {
		$settings = Setting::first();
		$this->load->helper('curl');
		$this->theme_view = 'blank';
		$object = remote_get_contents('https://secure.freelancecockpit.com/api/updates/code/' . $settings->pc, 3);
		$object = json_decode($object);
        $object->newUpdate = false;

            if (isset($object->error)) {
                if (empty($object->error) && $object->lastupdate > $settings->version) {
				$object->newUpdate = true;
				}
			}
			echo json_encode($object);
		}
    }

    public function backup()
    {
		$this->view_data['breadcrumb'] = $this->lang->line('application_backup');
        $this->view_data['breadcrumb_id'] = 'backup';

		$this->view_data['settings'] = Setting::first();
		$this->load->helper('file');
		$this->view_data['backups'] = get_filenames('./files/backup/');
        if (!isset($this->view_data['backups'])) {
            $this->session->set_flashdata('message', 'error: Could not check backup folder');
        }

		$this->content_view = 'settings/backup';
	}

    public function logs($val = false)
    {
		$this->view_data['breadcrumb'] = $this->lang->line('application_logs');
        $this->view_data['breadcrumb_id'] = 'logs';

		$this->load->helper('file');
        if ($val == 'clear') {
				delete_files('./application/logs/');
            $this->session->set_flashdata('message', 'success:' . $this->lang->line('messages_log_cleared'));
	 			redirect('settings/logs');
        } else {
            $lognames = get_filenames('./application/logs/');

            $lognames = array_diff($lognames, ['index.html']);
            $this->view_data['logs'] = '';
            $i = 0;
 		krsort($lognames);
            foreach ($lognames as $value) {
                if ($i < 6) {
                    $this->view_data['logs'] .= read_file('./application/logs/' . $value);
                    $i += 1;
                }
 		}

 		$this->view_data['logs'] = explode("\n", $this->view_data['logs']);
            $this->view_data['logs'] = array_diff($this->view_data['logs'], ["<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>", '']);
 		$this->view_data['logs'] = preg_grep("/(?i)(?:(?<=^|\s)(?=\S)|(?<=\S|^)(?=\s))Division by zero(?:(?<=\S)(?=\s|$)|(?<=\s)(?=\S|$))/", $this->view_data['logs'], PREG_GREP_INVERT);
            $this->view_data['logs'] = array_map(function ($line) {
                return (strpos($line, '[cronjob] ') == true) ? '<span style="color:#337ab7 ">' . $line . '</span>' : $line;
 		}, $this->view_data['logs']);
            $this->view_data['logs'] = array_filter($this->view_data['logs'], function ($line) {
                return (strpos($line, 'Severity: 8192') == true) ? false : true;
            });

            $this->view_data['logs'] = preg_grep("/(?i)(?:(?=^|\s)(?=\S)|(?<=\S|^)(?=\s))Trying to get property of non-object(?:(?<=\S)(?=\s|$)|(?<=\s)(?=\S|$))/", $this->view_data['logs'], PREG_GREP_INVERT);

 		rsort($this->view_data['logs']);

 		$this->view_data['settings'] = Setting::first();
		$this->view_data['form_action'] = 'settings/logs';
		$this->content_view = 'settings/logs';
 		}
	}

    public function themeoptions($val = false)
    {
		$this->view_data['breadcrumb'] = $this->lang->line('application_theme_options');
        $this->view_data['breadcrumb_id'] = 'themeoptions';
		$this->view_data['settings'] = Setting::first();
        if ($_POST) {
            if (is_uploaded_file($_FILES['userfile']['tmp_name'])) {
						$config['upload_path'] = './assets/blueline/images/backgrounds/';
                $config['encrypt_name'] = false;
                $config['overwrite'] = true;
						$config['allowed_types'] = 'gif|jpg|jpeg|png';

						$this->load->library('upload', $config);

                if ($this->upload->do_upload()) {
                    $data = ['upload_data' => $this->upload->data()];
								$_POST['login_background'] = $data['upload_data']['file_name'];
							}
					}
            if (is_uploaded_file($_FILES['userfile2']['tmp_name'])) {
					$config['upload_path'] = './files/media/';
                $config['encrypt_name'] = false;
                $config['overwrite'] = true;
					$config['allowed_types'] = 'gif|jpg|jpeg|png|svg';

					$this->load->library('upload', $config);

                if ($this->upload->do_upload('userfile2')) {
                    $data = ['upload_data' => $this->upload->data()];
                    $_POST['login_logo'] = 'files/media/' . $data['upload_data']['file_name'];
                }
						}
            if (!isset($_POST['custom_colors'])) {
                $_POST['custom_colors'] = 0;
					}
            unset($_POST['file-name'], $_POST['userfile2'], $_POST['send']);

			$this->view_data['settings']->update_attributes($_POST);
            $this->session->set_flashdata('message', 'success:' . $this->lang->line('messages_save_settings_success'));
	 		redirect('settings/themeoptions');
		}

		$this->load->helper('file');
        $backgrounds = get_filenames('./assets/blueline/images/backgrounds/');
        $this->view_data['backgrounds'] = array_diff($backgrounds, ['index.html']);

		$this->view_data['form_action'] = 'settings/themeoptions';
		$this->content_view = 'settings/themeoptions';
	}

    public function update_download($update = false)
    {
        if ($update) {
            $this->load->helper('curl');
            $update = str_replace('-', '.', $update);
            $settings = Setting::first();
            $url = 'https://secure.freelancecockpit.com/api/update/install/' . $update . '/code/' . $settings->pc;
            $file_destination = './files/updates/' . $update . '.zip';

            if(!curl_download($url, $file_destination)){
                log_message('error', 'Update download failed!');
                $this->session->set_flashdata('message', 'error: Update download failed!');
                redirect('settings/updates');
            }

			/* Make auto backup after update download */
			$this->load->helper('file');
			$this->load->dbutil();
			$settings = Setting::first();
            $version = str_replace('.', '-', $settings->version);
            $prefs = ['format' => 'zip', 'filename' => 'Zenit-auto-backup_' . date('d-m-Y_H:i')];
            $backup = &$this->dbutil->backup($prefs);
            @write_file('./files/backup/Zenit-auto-backup_' . date('d-m-Y_H:i') . '.zip', $backup);
		}
		redirect('settings/updates');
    }

    public function update_install($version = false, $newsPage = false)
    {
		$this->load->helper('unzip');
        $this->load->helper('file');
        $this->load->library('migration');
        $file = str_replace('-', '.', $version) . '.zip';
        if (!unzip('files/updates/' . $file, '', true, true)) {
            $this->session->set_flashdata('message', 'error:' . $this->lang->line('messages_install_update_error'));
        } else {
            $attr = [];
			$attr['version'] = str_replace('-', '.', $version);
            if (!$this->migration->latest()) {
                show_error($this->migration->error_string());
            }
			$settings = Setting::first();
			$fileversion = read_file('./application/version.txt');

			if ($fileversion != str_replace('-', '.', $version)) {
                $this->session->set_flashdata('message', 'error:' . $this->lang->line('messages_install_update_error'));
			} else {
			    $settings->update_attributes($attr);
                $this->session->set_flashdata('message', 'success:' . $this->lang->line('messages_install_update_success'));
			}
		}
        if ($newsPage) {
			redirect('settings/updatenews');
        } else {
			redirect('settings/updates');
		}
    }

    public function updatenews()
    {
		$this->view_data['settings'] = Setting::first();
		$this->content_view = 'settings/updatenews';
	}

    public function update_man($version = false)
    {
		$this->load->helper('file');
		$settings = Setting::first();
        if (!$version) {
		$_POST['version'] = read_file('application/version.txt');
        } else {
            $_POST['version'] = $version;
        }

        if ($_POST['version'] > $settings->version) {
		$update = str_replace('.', '-', $_POST['version']);
            if (file_exists('application/migrations/' . $update . '.php')) {
				$this->load->dbforge();
                include 'application/migrations/' . $update . '.php';
			}
			$settings->update_attributes($_POST);
            $this->session->set_flashdata('message', 'success:' . $this->lang->line('messages_install_update_success'));
		}

			redirect('settings/updates');
	}

    public function mysql_backup()
    {
		$this->load->helper('file');
		$this->load->dbutil();
		$settings = Setting::first();
        $version = str_replace('.', '-', $settings->version);
        $prefs = ['format' => 'zip', 'filename' => 'Zenit-manual-backup_'. date('d-m-Y_H:i')];

        $backup = &$this->dbutil->backup($prefs);

        if (!write_file('./files/backup/Zenit-manual-backup_' . date('d-m-Y_H:i') . '.zip', $backup)) {
            $this->session->set_flashdata('message', 'error:' . $this->lang->line('messages_create_backup_error'));
        } else {
            $this->session->set_flashdata('message', 'success:' . $this->lang->line('messages_create_backup_success'));
			}

 		redirect('settings/backup');
	}

    public function mysql_download($filename)
    {
		$this->load->helper('file');
		$this->load->helper('download');
        $filename = $filename . '.zip';
        $file = './files/backup/' . $filename;
		$mime = get_mime_by_extension($file);

        if (file_exists($file)) {
            header('Content-Description: File Transfer');
            header('Content-Type: ' . $mime);
            header('Content-Disposition: attachment; filename=' . basename($filename));
            header('Content-Transfer-Encoding: binary');
            header('Expires: 0');
            header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
            header('Pragma: public');
            header('Content-Length: ' . filesize($file));
            readfile($file);
            flush();
            exit;
        }

 		redirect('settings/backup');
	}

    public function mysql_restore()
    {
        if ($_POST) {
		$this->load->helper('file');
		$this->load->helper('unzip');
		$this->load->database();
		$settings = Setting::first();

					$config['upload_path'] = './files/temp/';
					$config['allowed_types'] = 'zip|gzip';
            $config['max_size'] = '9000';

					$this->load->library('upload', $config);

            if (!$this->upload->do_upload()) {
							$error = $this->upload->display_errors('', ' ');
                $this->session->set_flashdata('message', 'error:' . $error);
							redirect('settings/updates');
            } else {
                $data = ['upload_data' => $this->upload->data()];
                $backup = 'files/temp/' . $data['upload_data']['file_name'];
						}

            if (!unzip($backup, 'files/temp/', true, true)) {
                $this->session->set_flashdata('message', 'error:' . $this->lang->line('messages_restore_backup_error'));
            } else {
                $version = explode('_', $backup);
                $version = str_replace('-', '.', $version[1]);

				$this->load->dbforge();
				$backup = str_replace('.zip', '', $backup);
				$backup = str_replace('.gzip', '', $backup);
                $file_content = file_get_contents($backup . '.sql');
                $this->db->query('USE `' . $this->db->database . '`;');

                if ($version < $settings->version) {
                    $pattern = 'INSERT INTO ';
				 	$pattern = "/^.*$pattern.*\$/m";
					// search, and store all matching occurences in $matches
                    if (preg_match_all($pattern, $file_content, $matches)) {
					   $file_content = implode("\n", $matches[0]);
                        $file_content = str_replace('INSERT INTO ', 'INSERT IGNORE INTO ', $file_content);
					}
				}
                foreach (explode(";\n", $file_content) as $sql) {
	         $sql = trim($sql);
                    if ($sql) {
	                $this->db->query($sql);
	               }
	      }
                $this->session->set_flashdata('message', 'success:' . $this->lang->line('messages_restore_backup_success'));
	 		}
            unlink($backup . '.sql');
            @unlink($backup . '.zip');
            @unlink($backup . '.gzip');
	 	redirect('settings/updates');
        } else {
			$this->theme_view = 'modal';
			$this->view_data['title'] = $this->lang->line('application_upload_backup');
			$this->view_data['form_action'] = 'settings/mysql_restore';
			$this->content_view = 'settings/_backup';
		}
	}

    function make_base()
    {
        $this->load->library('VpxMigration');

        // All Tables:

        $this->vpxmigration->generate();
    }
    public function smtp_settings()
    {
		$this->config->load('email');
        if (isset($_POST['testemail'])) {
				//send test email
			 	$this->load->helper('notification');
            if (send_notification($_POST['testemail'], '[Email Settings] Test Email', 'This is a test email.')) {
 					$this->session->set_flashdata('message', 'success: Test email has been sent. Check your inbox!');
            } else {
 					$this->session->set_flashdata('message', 'error: Email not sent. Check your email settings!');
 				}
				redirect('settings/smtp_settings');
		}
        if (isset($_POST['protocol'])) {
			$this->load->helper('file');
            $crypto = $_POST['smtp_crypto'];
            $data = '<?php if ( ! defined("BASEPATH")) exit("No direct script access allowed ");
	$config["useragent"]        = "PHPMailer";
	$config["protocol"]         = "' . $_POST['protocol'] . '";
	$config["mailpath"]         = "/usr/sbin/sendmail";
	$config["smtp_host"]        = "' . $_POST['smtp_host'] . '";
	$config["smtp_user"]        = "' . $_POST['smtp_user'] . '";
	$config["smtp_pass"]        = "' . addslashes($_POST['smtp_pass']) . '";
	$config["smtp_port"]        = "' . $_POST['smtp_port'] . '";
	$config["smtp_timeout"]     = "' . $_POST['smtp_timeout'] . '";
	$config["smtp_crypto"]      = "' . $crypto . '";
	$config["smtp_debug"]       = "' . $_POST['smtp_debug'] . '";
	$config["wordwrap"]         = true;
	$config["wrapchars"]        = 76;
	$config["mailtype"]         = "html";
	$config["charset"]          = "utf-8";
	$config["validate"]         = true;
	$config["priority"]         = 3;
	$config["crlf"]             = "\r\n";
	$config["newline"]          = "\r\n";
	$config["bcc_batch_mode"]   = false;
	$config["bcc_batch_size"]   = 200;
				';

            if (!write_file('./application/config/email.php', $data)) {
				     $this->session->set_flashdata('message', 'error: Unable to write file. Make sure that /application/config/smtp.php as writing permissions!');
            } else {
                $this->session->set_flashdata('message', 'success:' . $this->lang->line('messages_save_settings_success'));
				}

			redirect('settings/smtp_settings', 'refresh');
        } else {
		$this->view_data['breadcrumb'] = $this->lang->line('application_smtp_settings');
            $this->view_data['breadcrumb_id'] = 'smtp_settings';

		$this->view_data['settings'] = Setting::first();

		$this->view_data['form_action'] = 'settings/smtp_settings';
		$this->content_view = 'settings/smtp_settings';
		}
    }
	}
