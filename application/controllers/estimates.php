<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Estimates extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $access = false;
        if ($this->client) {
            redirect('cprojects');
        } elseif ($this->user) {
            foreach ($this->view_data['menu'] as $key => $value) {
                if ($value->link == 'estimates') {
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
                        $this->lang->line('application_all') => 'estimates',
                        $this->lang->line('application_open') => 'estimates/filter/open',
                        $this->lang->line('application_Sent') => 'estimates/filter/sent',
                        $this->lang->line('application_Accepted') => 'estimates/filter/accepted',
                        $this->lang->line('application_Invoiced') => 'estimates/filter/invoiced',
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
                $options = ['conditions' => ['estimate != ? AND company_id in (?)', 0, $comp_array]];
                $this->view_data['estimates'] = Invoice::find('all', $options);
            } else {
                $this->view_data['estimates'] = (object) [];
            }
        } else {
            $options = ['conditions' => ['estimate != ?', 0]];
            $this->view_data['estimates'] = Invoice::find('all', $options);
        }

        $days_in_this_month = days_in_month(date('m'), date('Y'));
        $lastday_in_month = strtotime(date('Y') . '-' . date('m') . '-' . $days_in_this_month);
        $firstday_in_month = strtotime(date('Y') . '-' . date('m') . '-01');

        $this->view_data['estimates_paid_this_month'] = Invoice::count(['conditions' => 'UNIX_TIMESTAMP(`paid_date`) <= ' . $lastday_in_month . ' and UNIX_TIMESTAMP(`paid_date`) >= ' . $firstday_in_month . ' AND estimate != 0']);
        $this->view_data['estimates_due_this_month'] = Invoice::count(['conditions' => 'UNIX_TIMESTAMP(`due_date`) <= ' . $lastday_in_month . ' and UNIX_TIMESTAMP(`due_date`) >= ' . $firstday_in_month . ' AND estimate != 0']);

        //statistic
        $now = time();
        $beginning_of_week = strtotime('last Monday', $now); // BEGINNING of the week
        $end_of_week = strtotime('next Sunday', $now) + 86400; // END of the last day of the week
        $this->view_data['estimates_due_this_month_graph'] = Invoice::find_by_sql('select count(id) AS "amount", DATE_FORMAT(`due_date`, "%w") AS "date_day", DATE_FORMAT(`due_date`, "%Y-%m-%d") AS "date_formatted" from invoices where UNIX_TIMESTAMP(`due_date`) >= "' . $beginning_of_week . '" AND UNIX_TIMESTAMP(`due_date`) <= "' . $end_of_week . '" AND estimate != 0 Group by date_formatted, due_date');
        $this->view_data['estimates_paid_this_month_graph'] = Invoice::find_by_sql('select count(id) AS "amount", DATE_FORMAT(`paid_date`, "%w") AS "date_day", DATE_FORMAT(`paid_date`, "%Y-%m-%d") AS "date_formatted" from invoices where UNIX_TIMESTAMP(`paid_date`) >= "' . $beginning_of_week . '" AND UNIX_TIMESTAMP(`paid_date`) <= "' . $end_of_week . '" AND estimate != 0 Group by date_formatted, paid_date');

        $this->content_view = 'estimates/all';
    }

    public function filter($condition = false)
    {
        $days_in_this_month = days_in_month(date('m'), date('Y'));
        $lastday_in_month = date('Y') . '-' . date('m') . '-' . $days_in_this_month;
        $firstday_in_month = date('Y') . '-' . date('m') . '-01';
        $this->view_data['estimates_paid_this_month'] = Invoice::count(['conditions' => 'paid_date <= ' . $lastday_in_month . ' and paid_date >= ' . $firstday_in_month . ' AND estimate != 0']);
        $this->view_data['estimates_due_this_month'] = Invoice::count(['conditions' => 'due_date <= ' . $lastday_in_month . ' and due_date >= ' . $firstday_in_month . ' AND estimate != 0']);

        switch ($condition) {
            case 'open':
                $option = 'estimate_status = "Open" and estimate != 0';
                break;
            case 'sent':
                $option = 'estimate_status = "Sent" and estimate != 0';
                break;
            case 'accepted':
                $option = 'estimate_status = "Accepted" and estimate != 0';
                break;
            case 'declined':
                $option = 'estimate_status = "Declined" and estimate != 0';
                break;
            case 'invoiced':
                $option = 'estimate_status = "Invoiced" and estimate != 0';
                break;
            default:
                $option = 'estimate != 0';
                break;
        }

        if ($this->user->admin == 0) {
            $comp_array = [];
            $thisUserHasNoCompanies = (array) $this->user->companies;
            if (!empty($thisUserHasNoCompanies)) {
                foreach ($this->user->companies as $value) {
                    array_push($comp_array, $value->id);
                }
                $options = ['conditions' => [$option . ' AND company_id in (?)', $comp_array]];
                $this->view_data['estimates'] = Invoice::find('all', $options);
            } else {
                $this->view_data['estimates'] = (object) [];
            }
        } else {
            $options = ['conditions' => [$option]];
            $this->view_data['estimates'] = Invoice::find('all', $options);
        }

        $this->content_view = 'estimates/all';
    }

    public function create()
    {
        if ($_POST) {
            unset($_POST['send'], $_POST['_wysihtml5_mode'], $_POST['files']);

            $_POST['estimate'] = 1;
            $_POST['estimate_status'] = 'Open';
            $estimate = Invoice::create($_POST);
            $new_estimate_reference = $_POST['estimate_reference'] + 1;
            $estimate_reference = Setting::first();
            $estimate_reference->update_attributes(['estimate_reference' => $new_estimate_reference]);
            if (!$estimate) {
                $this->session->set_flashdata('message', 'error:' . $this->lang->line('messages_create_estimate_error'));
            } else {
                $this->session->set_flashdata('message', 'success:' . $this->lang->line('messages_create_estimate_success'));
            }
            redirect('estimates');
        } else {
            if ($this->user->admin != 1) {
                $comp_array = [];
                $thisUserHasNoCompanies = (array) $this->user->companies;
                if (!empty($thisUserHasNoCompanies)) {
                    foreach ($this->user->companies as $value) {
                        array_push($comp_array, $value->id);
                    }
                    $this->view_data['estimates'] = Invoice::find('all', ['conditions' => ['company_id in (?)', $comp_array]]);
                    $this->view_data['projects'] = $this->user->projects;
                    $this->view_data['companies'] = $this->user->companies;
                } else {
                    $this->view_data['estimates'] = (object) [];
                    $this->view_data['projects'] = $this->user->projects;
                    $this->view_data['companies'] = $this->user->companies;
                }
            } else {
                $this->view_data['estimates'] = Invoice::all();
                $this->view_data['projects'] = Project::all();
                $this->view_data['companies'] = Company::find('all', ['conditions' => ['inactive=?', '0']]);
            }
            $this->view_data['next_reference'] = Invoice::last();
            $this->theme_view = 'modal';
            $this->view_data['title'] = $this->lang->line('application_create_estimate');
            $this->view_data['form_action'] = 'estimates/create';
            $this->content_view = 'estimates/_estimate';
        }
    }

    public function update($id = false, $getview = false)
    {
        if ($_POST) {
            unset($_POST['send'], $_POST['_wysihtml5_mode'], $_POST['files']);

            $id = $_POST['id'];
            $view = false;
            if (isset($_POST['view'])) {
                $view = $_POST['view'];
            }
            unset($_POST['view']);
            if ($_POST['status'] == 'Paid') {
                $_POST['paid_date'] = date('Y-m-d', time());
            }
            $estimate = Invoice::find($id);
            $estimate->update_attributes($_POST);

            if (!$estimate) {
                $this->session->set_flashdata('message', 'error:' . $this->lang->line('messages_save_estimate_error'));
            } else {
                $this->session->set_flashdata('message', 'success:' . $this->lang->line('messages_save_estimate_success'));
            }
            redirect('estimates/view/' . $id);
        } else {
            if ($this->user->admin != 1) {
                $comp_array = [];
                foreach ($this->user->companies as $value) {
                    array_push($comp_array, $value->id);
                }
                $this->view_data['projects'] = $this->user->projects;
                $this->view_data['companies'] = $this->user->companies;
            } else {
                $this->view_data['projects'] = Project::all();
                $this->view_data['companies'] = Company::find('all', ['conditions' => ['inactive=?', '0']]);
            }
            $this->view_data['estimate'] = Invoice::find($id);
            if ($getview == 'view') {
                $this->view_data['view'] = 'true';
            }
            $this->theme_view = 'modal';
            $this->view_data['title'] = $this->lang->line('application_edit_estimate');
            $this->view_data['form_action'] = 'estimates/update';
            $this->content_view = 'estimates/_estimate';
        }
    }

    public function view($id = false)
    {
        $this->view_data['submenu'] = [
                        $this->lang->line('application_back') => 'estimates',
                        ];
        $this->view_data['estimate'] = Invoice::find($id);

        if ($this->user->admin != 1) {
            $comp_array = [];
            foreach ($this->user->companies as $value) {
                array_push($comp_array, $value->id);
            }
            if (!in_array($this->view_data['estimate']->company_id, $comp_array)) {
                redirect('estimates');
            }
        }

        $data['core_settings'] = Setting::first();
        $estimate = $this->view_data['estimate'];
        $this->view_data['items'] = InvoiceHasItem::find('all', ['conditions' => ['invoice_id=?', $id]]);

        //calculate sum
        $i = 0;
        $sum = 0;
        foreach ($this->view_data['items'] as $value) {
            $sum = $sum + $estimate->invoice_has_items[$i]->amount * $estimate->invoice_has_items[$i]->value;
            $i++;
        }
        if (substr($estimate->discount, -1) == '%') {
            $discount = sprintf('%01.2f', round(($sum / 100) * substr($estimate->discount, 0, -1), 2));
        } else {
            $discount = $estimate->discount;
        }
        $sum = $sum - $discount;

        if ($estimate->tax != '') {
            $tax_value = $estimate->tax;
        } else {
            $tax_value = $data['core_settings']->tax;
        }

        $tax = sprintf('%01.2f', round(($sum / 100) * $tax_value, 2));
        $sum = sprintf('%01.2f', round($sum + $tax, 2));

        $estimate->sum = $sum;
        $estimate->save();
        $this->content_view = 'estimates/view';
    }

    public function estimateToInvoice($id = false, $getview = false)
    {
        $settings = Setting::first();
        $estimate = Invoice::find($id);
        $estimate->estimate = 2;
        $estimate->estimate_status = 'Invoiced';
        $estimate->reference = $settings->invoice_reference;
        $estimate->terms = $settings->invoice_terms;
        $estimate->save();
        $settings->invoice_reference = $settings->invoice_reference + 1;
        $settings->save();

        if (!$estimate) {
            $this->session->set_flashdata('message', 'error:' . $this->lang->line('messages_save_invoice_error'));
        } else {
            $this->session->set_flashdata('message', 'success:' . $this->lang->line('messages_save_invoice_success'));
        }
        redirect('invoices/view/' . $id);
    }

    public function delete($id = false)
    {
        $estimate = Invoice::find($id);
        $estimate->delete();
        $this->content_view = 'estimates/all';
        if (!$estimate) {
            $this->session->set_flashdata('message', 'error:' . $this->lang->line('messages_delete_estimate_error'));
        } else {
            $this->session->set_flashdata('message', 'success:' . $this->lang->line('messages_delete_estimate_success'));
        }
        redirect('estimates');
    }

    public function preview($id = false, $attachment = false)
    {
        $this->load->helper(['dompdf', 'file']);
        $this->load->library('parser');
        $data['estimate'] = Invoice::find($id);
        $data['items'] = InvoiceHasItem::find('all', ['conditions' => ['invoice_id=?', $id]]);
        $data['core_settings'] = Setting::first();

        $due_date = date($data['core_settings']->date_format, human_to_unix($data['estimate']->due_date . ' 00:00:00'));
        $parse_data = [
                                'due_date' => $due_date,
                                'estimate_id' => $data['core_settings']->estimate_prefix . $data['estimate']->estimate_reference,
                                'client_link' => $data['core_settings']->domain,
                                'company' => $data['core_settings']->company,
                                ];
        $html = $this->load->view($data['core_settings']->template . '/' . $data['core_settings']->estimate_pdf_template, $data, true);
        $html = $this->parser->parse_string($html, $parse_data);

        $filename = $this->lang->line('application_estimate') . '_' . $data['core_settings']->estimate_prefix . $data['estimate']->estimate_reference;
        pdf_create($html, $filename, true, $attachment);
    }

    public function sendestimate($id = false)
    {
        $this->load->helper(['dompdf', 'file']);
        $this->load->library('parser');
        $data['estimate'] = Invoice::find($id);
        //check if client contact has permissions for estimates and grant if not
        if (isset($data['estimate']->company->client->id)) {
            $access = explode(',', $data['estimate']->company->client->access);
            if (!in_array('107', $access)) {
                $client_estimate_permission = Client::find_by_id($data['estimate']->company->client->id);
                if ($client_estimate_permission) {
                    $client_estimate_permission->access = $client_estimate_permission->access . ',107';
                    $client_estimate_permission->save();
                }
            }
        }
        $data['estimate']->estimate_sent = date('Y-m-d');
        $data['estimate']->estimate_status = 'Sent';

        $data['items'] = InvoiceHasItem::find('all', ['conditions' => ['invoice_id=?', $id]]);
        $data['core_settings'] = Setting::first();
        $due_date = date($data['core_settings']->date_format, human_to_unix($data['estimate']->due_date . ' 00:00:00'));
        //Set parse values
        $parse_data = [
                        'client_contact' => $data['estimate']->company->client->firstname . ' ' . $data['estimate']->company->client->lastname,
                        'first_name' => $data['estimate']->company->client->firstname,
                        'last_name' => $data['estimate']->company->client->lastname,
                        'client_company' => $data['estimate']->company->name,
                        'project' => (is_object($data['estimate']->project)) ? $data['estimate']->project->name : '',
                        'due_date' => $due_date,
                        'estimate_id' => $data['core_settings']->estimate_prefix . $data['estimate']->estimate_reference,
                        'client_link' => $data['core_settings']->domain,
                        'estimate_link' => base_url() . 'cestimates/view/' . $data['estimate']->id,
                        'company' => $data['core_settings']->company,
                        'logo' => '<img src="' . base_url() . '' . $data['core_settings']->logo . '" alt="' . $data['core_settings']->company . '"/>',
                        'invoice_logo' => '<img src="' . base_url() . '' . $data['core_settings']->invoice_logo . '" alt="' . $data['core_settings']->company . '"/>'
                        ];
        // Generate PDF
        $html = $this->load->view($data['core_settings']->template . '/' . $data['core_settings']->estimate_pdf_template, $data, true);
        $html = $this->parser->parse_string($html, $parse_data);
        $filename = $this->lang->line('application_estimate') . '_' . $data['core_settings']->estimate_prefix . $data['estimate']->estimate_reference;
        pdf_create($html, $filename, false);
        //email
        $subject = $this->parser->parse_string($data['core_settings']->estimate_mail_subject, $parse_data);
        $this->email->from($data['core_settings']->email, $data['core_settings']->company);
        if (!is_object($data['estimate']->company->client) && $data['estimate']->company->client->email == '') {
            $this->session->set_flashdata('message', 'error:This client company has no primary contact! Just add a primary contact.');
            redirect('estimates/view/' . $id);
        }
        $this->email->to($data['estimate']->company->client->email);
        $this->email->subject($subject);
        $this->email->attach('files/temp/' . $filename . '.pdf');

        $email_estimate = read_file('./application/views/' . $data['core_settings']->template . '/templates/email_estimate.html');
        $message = $this->parser->parse_string($email_estimate, $parse_data);
        $this->email->message($message);
        if ($this->email->send()) {
            $this->session->set_flashdata('message', 'success:' . $this->lang->line('messages_send_estimate_success'));
            $data['estimate']->update_attributes(['status' => 'Sent', 'sent_date' => date('Y-m-d')]);
            log_message('error', 'Estimate #' . $data['core_settings']->estimate_prefix . $data['estimate']->estimate_reference . ' has been send to ' . $data['estimate']->company->client->email);
        } else {
            $this->session->set_flashdata('message', 'error:' . $this->lang->line('messages_send_estimate_error'));
            log_message('error', 'ERROR: Estimate #' . $data['core_settings']->estimate_prefix . $data['estimate']->estimate_reference . ' has not been send to ' . $data['estimate']->company->client->email . '. Please check your servers email settings.');
        }
        unlink('files/temp/' . $filename . '.pdf');
        redirect('estimates/view/' . $id);
    }

    public function item($id = false)
    {
        if ($_POST) {
            unset($_POST['send']);
            $_POST = array_map('htmlspecialchars', $_POST);
            if ($_POST['name'] != '') {
                $_POST['name'] = $_POST['name'];
                $_POST['value'] = $_POST['value'];
                $_POST['type'] = $_POST['type'];
            } else {
                if ($_POST['item_id'] == '-') {
                    $this->session->set_flashdata('message', 'error:' . $this->lang->line('messages_add_item_error'));
                    redirect('estimates/view/' . $_POST['invoice_id']);
                } else {
                    $itemvalue = Item::find_by_id($_POST['item_id']);
                    $_POST['name'] = $itemvalue->name;
                    $_POST['type'] = $itemvalue->type;
                    $_POST['value'] = $itemvalue->value;
                }
            }

            $item = InvoiceHasItem::create($_POST);
            if (!$item) {
                $this->session->set_flashdata('message', 'error:' . $this->lang->line('messages_add_item_error'));
            } else {
                $this->session->set_flashdata('message', 'success:' . $this->lang->line('messages_add_item_success'));
            }
            redirect('estimates/view/' . $_POST['invoice_id']);
        } else {
            $this->view_data['estimate'] = Invoice::find($id);
            $this->view_data['items'] = Item::find('all', ['conditions' => ['inactive=?', '0']]);
            $this->theme_view = 'modal';
            $this->view_data['title'] = $this->lang->line('application_add_item');
            $this->view_data['form_action'] = 'estimates/item';
            $this->content_view = 'estimates/_item';
        }
    }

    public function item_update($id = false)
    {
        if ($_POST) {
            unset($_POST['send']);
            $_POST = array_map('htmlspecialchars', $_POST);
            $item = InvoiceHasItem::find($_POST['id']);
            $item = $item->update_attributes($_POST);
            if (!$item) {
                $this->session->set_flashdata('message', 'error:' . $this->lang->line('messages_save_item_error'));
            } else {
                $this->session->set_flashdata('message', 'success:' . $this->lang->line('messages_save_item_success'));
            }
            redirect('estimates/view/' . $_POST['invoice_id']);
        } else {
            $this->view_data['estimate_has_items'] = InvoiceHasItem::find($id);
            $this->theme_view = 'modal';
            $this->view_data['title'] = $this->lang->line('application_edit_item');
            $this->view_data['form_action'] = 'estimates/item_update';
            $this->content_view = 'estimates/_item';
        }
    }

    public function item_delete($id = false, $estimate_id = false)
    {
        $item = InvoiceHasItem::find($id);
        $item->delete();
        $this->content_view = 'estimates/view';
        if (!$item) {
            $this->session->set_flashdata('message', 'error:' . $this->lang->line('messages_delete_item_error'));
        } else {
            $this->session->set_flashdata('message', 'success:' . $this->lang->line('messages_delete_item_success'));
        }
        redirect('estimates/view/' . $estimate_id);
    }
}
