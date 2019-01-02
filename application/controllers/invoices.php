<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Invoices extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $access = false;
        if ($this->client) {
            redirect('cprojects');
        } elseif ($this->user) {
            foreach ($this->view_data['menu'] as $key => $value) {
                if ($value->link == 'invoices') {
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
                        $this->lang->line('application_all') => 'invoices',
                        $this->lang->line('application_open') => 'invoices/filter/open',
                        $this->lang->line('application_Sent') => 'invoices/filter/sent',
                        $this->lang->line('application_Paid') => 'invoices/filter/paid',
                        $this->lang->line('application_Canceled') => 'invoices/filter/canceled',
                        $this->lang->line('application_Overdue') => 'invoices/filter/overdue',
                        $this->lang->line('application_PartiallyPaid') => 'invoices/filter/PartiallyPaid',
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
                $options = ['conditions' => ['estimate != ? AND company_id in (?)', 1, $comp_array]];
                $this->view_data['invoices'] = Invoice::find('all', $options);
            } else {
                $this->view_data['invoices'] = (object) [];
            }
        } else {
            $options = ['conditions' => ['estimate != ?', 1]];
            $this->view_data['invoices'] = Invoice::find('all', $options);
        }

        $days_in_this_month = days_in_month(date('m'), date('Y'));
        $lastday_in_month = strtotime(date('Y') . '-' . date('m') . '-' . $days_in_this_month);
        $firstday_in_month = strtotime(date('Y') . '-' . date('m') . '-01');

        $this->view_data['invoices_paid_this_month'] = Invoice::count(['conditions' => 'UNIX_TIMESTAMP(`paid_date`) <= ' . $lastday_in_month . ' and UNIX_TIMESTAMP(`paid_date`) >= ' . $firstday_in_month . ' AND estimate != 1 AND status = "paid"']);
        $this->view_data['invoices_due_this_month'] = Invoice::count(['conditions' => 'UNIX_TIMESTAMP(`due_date`) <= ' . $lastday_in_month . ' and UNIX_TIMESTAMP(`due_date`) >= ' . $firstday_in_month . ' AND estimate != 1 AND status != "paid" AND status != "canceled"']);

        //statistic
        $now = time();
        $beginning_of_week = strtotime('last Monday', $now); // BEGINNING of the week
        $end_of_week = strtotime('next Sunday', $now) + 86400; // END of the last day of the week
        $this->view_data['invoices_due_this_month_graph'] = Invoice::find_by_sql('select count(id) AS "amount", DATE_FORMAT(`due_date`, "%w") AS "date_day", DATE_FORMAT(`due_date`, "%Y-%m-%d") AS "date_formatted" from invoices where UNIX_TIMESTAMP(`due_date`) >= "' . $beginning_of_week . '" AND UNIX_TIMESTAMP(`due_date`) <= "' . $end_of_week . '" AND estimate != 1 GROUP BY due_date');
        $this->view_data['invoices_paid_this_month_graph'] = Invoice::find_by_sql("SELECT 
    COUNT(id) AS 'amount',
    DATE_FORMAT(`paid_date`, '%w') AS 'date_day',
    DATE_FORMAT(`paid_date`, '%Y-%m-%d') AS 'date_formatted'
FROM
    invoices
WHERE
    UNIX_TIMESTAMP(`paid_date`) >= '$beginning_of_week'
        AND UNIX_TIMESTAMP(`paid_date`) <= '$end_of_week'
        AND estimate != 1
GROUP BY paid_date");

        $this->content_view = 'invoices/all';
    }

    public function calc()
    {
        $invoices = Invoice::find('all', ['conditions' => ['estimate != ?', 1]]);
        foreach ($invoices as $invoice) {
            $settings = Setting::first();

            $items = InvoiceHasItem::find('all', ['conditions' => ['invoice_id=?', $invoice->id]]);

            //calculate sum
            $i = 0;
            $sum = 0;
            foreach ($items as $value) {
                $sum = $sum + $invoice->invoice_has_items[$i]->amount * $invoice->invoice_has_items[$i]->value;
                $i++;
            }
            if (substr($invoice->discount, -1) == '%') {
                $discount = sprintf('%01.2f', round(($sum / 100) * substr($invoice->discount, 0, -1), 2));
            } else {
                $discount = $invoice->discount;
            }
            $sum = $sum - $discount;

            if ($invoice->tax != '') {
                $tax_value = $invoice->tax;
            } else {
                $tax_value = $settings->tax;
            }

            if ($invoice->second_tax != '') {
                $second_tax_value = $invoice->second_tax;
            } else {
                $second_tax_value = $core_settings->second_tax;
            }

            $tax = sprintf('%01.2f', round(($sum / 100) * $tax_value, 2));
            $second_tax = sprintf('%01.2f', round(($sum / 100) * $second_tax_value, 2));

            $sum = sprintf('%01.2f', round($sum + $tax + $second_tax, 2));

            $invoice->sum = $sum;
            $invoice->save();
        }
        redirect('invoices');
    }

    public function filter($condition = false)
    {
        $days_in_this_month = days_in_month(date('m'), date('Y'));
        $lastday_in_month = date('Y') . '-' . date('m') . '-' . $days_in_this_month;
        $firstday_in_month = date('Y') . '-' . date('m') . '-01';
        $this->view_data['invoices_paid_this_month'] = Invoice::count(['conditions' => 'paid_date <= ' . $lastday_in_month . ' and paid_date >= ' . $firstday_in_month . ' AND estimate != 1']);
        $this->view_data['invoices_due_this_month'] = Invoice::count(['conditions' => 'due_date <= ' . $lastday_in_month . ' and due_date >= ' . $firstday_in_month . ' AND estimate != 1']);

        //statistic
        $now = time();
        $beginning_of_week = strtotime('last Monday', $now); // BEGINNING of the week
        $end_of_week = strtotime('next Sunday', $now) + 86400; // END of the last day of the week
        $this->view_data['invoices_due_this_month_graph'] = Invoice::find_by_sql('select count(id) AS "amount", DATE_FORMAT(`due_date`, "%w") AS "date_day", DATE_FORMAT(`due_date`, "%Y-%m-%d") AS "date_formatted" from invoices where UNIX_TIMESTAMP(`due_date`) >= "' . $beginning_of_week . '" AND UNIX_TIMESTAMP(`due_date`) <= "' . $end_of_week . '" AND estimate != 1');
        $this->view_data['invoices_paid_this_month_graph'] = Invoice::find_by_sql('select count(id) AS "amount", DATE_FORMAT(`paid_date`, "%w") AS "date_day", DATE_FORMAT(`paid_date`, "%Y-%m-%d") AS "date_formatted" from invoices where UNIX_TIMESTAMP(`paid_date`) >= "' . $beginning_of_week . '" AND UNIX_TIMESTAMP(`paid_date`) <= "' . $end_of_week . '" AND estimate != 1');

        switch ($condition) {
                case 'open':
                    $option = 'status = "Open" and estimate != 1';
                    break;
                case 'sent':
                    $option = 'status = "Sent" and estimate != 1';
                    break;
                case 'paid':
                    $option = 'status = "Paid" and estimate != 1';
                    break;
                case 'PartiallyPaid':
                    $option = 'status = "PartiallyPaid" and estimate != 1';
                    break;
                case 'canceled':
                    $option = 'status = "Canceled" and estimate != 1';
                    break;
                case 'overdue':
                    $option = '(status = "Open" OR status = "Sent" OR status = "PartiallyPaid") and estimate != 1 and due_date < "' . date('Y') . '-' . date('m') . '-' . date('d') . '" ';
                    break;
                default:
                    $option = 'estimate != 1';
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
                $this->view_data['invoices'] = Invoice::find('all', $options);
            } else {
                $this->view_data['invoices'] = (object) [];
            }
        } else {
            $options = ['conditions' => [$option]];
            $this->view_data['invoices'] = Invoice::find('all', $options);
        }

        $this->content_view = 'invoices/all';
    }

    public function create()
    {
        if ($_POST) {
            unset($_POST['send'], $_POST['_wysihtml5_mode'], $_POST['files']);

            $invoice = Invoice::create($_POST);
            $new_invoice_reference = $_POST['reference'] + 1;

            $invoice_reference = Setting::first();
            $invoice_reference->update_attributes(['invoice_reference' => $new_invoice_reference]);
            if (!$invoice) {
                $this->session->set_flashdata('message', 'error:' . $this->lang->line('messages_create_invoice_error'));
            } else {
                $this->session->set_flashdata('message', 'success:' . $this->lang->line('messages_create_invoice_success'));
            }
            redirect('invoices');
        } else {
            $this->view_data['invoices'] = Invoice::all();
            $this->view_data['next_reference'] = Invoice::last();
            if ($this->user->admin != 1) {
                $comp_array = [];
                foreach ($this->user->companies as $value) {
                    array_push($comp_array, $value->id);
                }
                $this->view_data['companies'] = $this->user->companies;
            } else {
                $this->view_data['companies'] = Company::find('all', ['conditions' => ['inactive=?', '0']]);
            }

            $this->theme_view = 'modal';
            $this->view_data['title'] = $this->lang->line('application_create_invoice');
            $this->view_data['form_action'] = 'invoices/create';
            $this->content_view = 'invoices/_invoice';
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
            $invoice = Invoice::find($id);
            if ($_POST['status'] == 'Paid' && !isset($_POST['paid_date'])) {
                $_POST['paid_date'] = date('Y-m-d', time());
            }
            if ($_POST['status'] == 'Sent' && $invoice->status != 'Sent' && !isset($_POST['sent_date'])) {
                $_POST['sent_date'] = date('Y-m-d', time());
            }

            $invoice->update_attributes($_POST);

            if (!$invoice) {
                $this->session->set_flashdata('message', 'error:' . $this->lang->line('messages_save_invoice_error'));
            } else {
                $this->session->set_flashdata('message', 'success:' . $this->lang->line('messages_save_invoice_success'));
            }
            if ($view == 'true') {
                redirect('invoices/view/' . $id);
            } else {
                redirect('invoices');
            }
        } else {
            $this->view_data['invoice'] = Invoice::find($id);
            if ($this->user->admin != 1) {
                $comp_array = [];
                foreach ($this->user->companies as $value) {
                    array_push($comp_array, $value->id);
                }
                $this->view_data['companies'] = $this->user->companies;
            } else {
                $this->view_data['companies'] = Company::find('all', ['conditions' => ['inactive=?', '0']]);
            }
            //$this->view_data['projects'] = Project::all();
            //$this->view_data['companies'] = Company::find('all',array('conditions' => array('inactive=?','0')));
            if ($getview == 'view') {
                $this->view_data['view'] = 'true';
            }
            $this->theme_view = 'modal';
            $this->view_data['title'] = $this->lang->line('application_edit_invoice');
            $this->view_data['form_action'] = 'invoices/update';
            $this->content_view = 'invoices/_invoice';
        }
    }

    public function view($id = false)
    {
        $this->view_data['submenu'] = [
                        $this->lang->line('application_back') => 'invoices',
                        ];

        $this->view_data['invoice'] = Invoice::find($id);

        if ($this->user->admin != 1) {
            $comp_array = [];
            foreach ($this->user->companies as $value) {
                array_push($comp_array, $value->id);
            }
            if (!in_array($this->view_data['invoice']->company_id, $comp_array)) {
                redirect('invoices');
            }
        }

        $data['core_settings'] = Setting::first();
        $invoice = $this->view_data['invoice'];
        $this->view_data['items'] = $invoice->invoice_has_items;

        //calculate sum
        $i = 0;
        $sum = 0;
        foreach ($this->view_data['items'] as $value) {
            $sum = $sum + $invoice->invoice_has_items[$i]->amount * $invoice->invoice_has_items[$i]->value;
            $i++;
        }
        if (substr($invoice->discount, -1) == '%') {
            $discount = sprintf('%01.2f', round(($sum / 100) * substr($invoice->discount, 0, -1), 2));
        } else {
            $discount = $invoice->discount;
        }
        $sum = $sum - $discount;

        if ($invoice->tax != '') {
            $tax_value = $invoice->tax;
        } else {
            $tax_value = $data['core_settings']->tax;
        }

        if ($invoice->second_tax != '') {
            $second_tax_value = $invoice->second_tax;
        } else {
            $second_tax_value = $data['core_settings']->second_tax;
        }

        $tax = sprintf('%01.2f', round(($sum / 100) * $tax_value, 2));
        $second_tax = sprintf('%01.2f', round(($sum / 100) * $second_tax_value, 2));

        $sum = sprintf('%01.2f', round($sum + $tax + $second_tax, 2));

        $payment = 0;
        $i = 0;
        $payments = $invoice->invoice_has_payments;
        if (isset($payments)) {
            foreach ($payments as $value) {
                $payment = sprintf('%01.2f', round($payment + $payments[$i]->amount, 2));
                $i++;
            }
            $invoice->paid = $payment;
            $invoice->outstanding = sprintf('%01.2f', round($sum - $payment, 2));
        }

        $invoice->sum = $sum;
        $invoice->save();
        $this->content_view = 'invoices/view';
    }

    public function banktransfer($id = false, $sum = false)
    {
        $this->theme_view = 'modal';
        $this->view_data['title'] = $this->lang->line('application_bank_transfer');

        $data['core_settings'] = Setting::first();
        $this->view_data['invoice'] = Invoice::find($id);
        $this->content_view = 'invoices/_banktransfer';
    }

    public function payment($id = false)
    {
        if ($_POST) {
            $this->load->helper('notification');

            $receipt = (isset($_POST['receipt'])) ? true : false;
            unset($_POST['send'], $_POST['receipt'], $_POST['_wysihtml5_mode'], $_POST['files']);

            $_POST['user_id'] = $this->user->id;
            $_POST['amount'] = str_replace(',', '.', $_POST['amount']);
            $invoice = Invoice::find_by_id($_POST['invoice_id']);
            $invoiceHasPayment = InvoiceHasPayment::create($_POST);

            if ($invoice->outstanding == $_POST['amount']) {
                $new_status = 'Paid';
                $payment_date = $_POST['date'];
            } else {
                $new_status = 'PartiallyPaid';
            }

            $invoice->update_attributes(['status' => $new_status]);
            if (isset($payment_date)) {
                $invoice->update_attributes(['paid_date' => $payment_date]);
            }
            if (!$invoiceHasPayment) {
                $this->session->set_flashdata('message', 'error:' . $this->lang->line('messages_create_payment_error'));
            } else {
                receipt_notification($invoice->company->client->id, false, $invoiceHasPayment->id);
                $this->session->set_flashdata('message', 'success:' . $this->lang->line('messages_create_payment_success'));
            }
            redirect('invoices/view/' . $_POST['invoice_id']);
        } else {
            $this->view_data['invoice'] = Invoice::find_by_id($id);
            $this->view_data['payment_reference'] = InvoiceHasPayment::count(['conditions' => 'invoice_id = ' . $id]) + 1;
            $this->view_data['sumRest'] = sprintf('%01.2f', round($this->view_data['invoice']->sum - $this->view_data['invoice']->paid, 2));

            $this->theme_view = 'modal';
            $this->view_data['title'] = $this->lang->line('application_add_payment');
            $this->view_data['form_action'] = 'invoices/payment';
            $this->content_view = 'invoices/_payment';
        }
    }

    public function payment_update($id = false)
    {
        if ($_POST) {
            unset($_POST['send'], $_POST['_wysihtml5_mode'], $_POST['files']);

            $_POST['amount'] = str_replace(',', '.', $_POST['amount']);

            $payment = InvoiceHasPayment::find_by_id($_POST['id']);
            $invoice_id = $payment->invoice_id;
            $payment = $payment->update_attributes($_POST);

            $invoice = Invoice::find_by_id($invoice_id);
            $payment = 0;
            $i = 0;
            $payments = $invoice->invoice_has_payments;
            if (isset($payments)) {
                foreach ($payments as $value) {
                    $payment = sprintf('%01.2f', round($payment + $payments[$i]->amount, 2));
                    $i++;
                }
            }
            $paymentsum = sprintf('%01.2f', round($payment + $_POST['amount'], 2));
            if ($invoice->sum <= $paymentsum) {
                $new_status = 'Paid';
                $payment_date = $_POST['date'];
            } else {
                $new_status = 'PartiallyPaid';
            }
            $invoice->update_attributes(['status' => $new_status]);
            if (isset($payment_date)) {
                $invoice->update_attributes(['paid_date' => $payment_date]);
            }
            if (!$payment) {
                $this->session->set_flashdata('message', 'error:' . $this->lang->line('messages_edit_payment_error'));
            } else {
                $this->session->set_flashdata('message', 'success:' . $this->lang->line('messages_edit_payment_success'));
            }
            redirect('invoices/view/' . $_POST['invoice_id']);
        } else {
            $this->view_data['payment'] = InvoiceHasPayment::find_by_id($id);
            $this->view_data['invoice'] = Invoice::find_by_id($this->view_data['payment']->invoice_id);
            $this->theme_view = 'modal';
            $this->view_data['title'] = $this->lang->line('application_add_payment');
            $this->view_data['form_action'] = 'invoices/payment_update';
            $this->content_view = 'invoices/_payment';
        }
    }

    public function payment_delete($id = false, $invoice_id = false)
    {
        $item = InvoiceHasPayment::find_by_id($id);
        $item->delete();
        $this->content_view = 'invoices/view';
        if (!$item) {
            $this->session->set_flashdata('message', 'error:' . $this->lang->line('messages_delete_payment_error'));
        } else {
            $this->session->set_flashdata('message', 'success:' . $this->lang->line('messages_delete_payment_success'));
        }
        redirect('invoices/view/' . $invoice_id);
    }

    public function twocheckout($id = false, $sum = false)
    {
        $data['core_settings'] = Setting::first();

        if ($_POST) {
            $invoice = Invoice::find_by_id($_POST['id']);
            $invoice_reference = $data['core_settings']->invoice_prefix . $invoice->reference;
            $this->load->file(APPPATH . 'helpers/2checkout/Twocheckout.php', true);
            $token = $_POST['token'];
            Twocheckout::privateKey($data['core_settings']->twocheckout_private_key);
            Twocheckout::sellerId($data['core_settings']->twocheckout_seller_id);
            //Twocheckout::sandbox(true);  #Uncomment to use Sandbox

            //Get currency
            $currency = $invoice->currency;
            $currency_codes = getCurrencyCodesForTwocheckout();
            if (!array_key_exists($currency, $currency_codes)) {
                $currency = $data['core_settings']->twocheckout_currency;
            }

            try {
                $charge = Twocheckout_Charge::auth([
                            'merchantOrderId' => $invoice->reference,
                            'token' => $_POST['token'],
                            'currency' => $currency,
                            'total' => $_POST['sum'],
                            'billingAddr' => [
                                'name' => $invoice->company->name,
                                'addrLine1' => $invoice->company->address,
                                'city' => $invoice->company->city,
                                'state' => $invoice->company->province,
                                'zipCode' => $invoice->company->zipcode,
                                'country' => $invoice->company->country,
                                'email' => $invoice->company->client->email,
                                'phoneNumber' => $invoice->company->phone
                            ]
                        ]);

                if ($charge['response']['responseCode'] == 'APPROVED') {
                    echo 'Thanks for your Order!';
                    echo '<h3>Return Parameters:</h3>';
                    echo '<pre>';
                    print_r($charge);
                    echo '</pre>';

                    $attr = [];
                    $paid_date = date('Y-m-d', time());
                    $payment_reference = $invoice->reference . '00' . InvoiceHasPayment::count(['conditions' => 'invoice_id = ' . $invoice->id]) + 1;
                    $attributes = ['invoice_id' => $invoice->id, 'reference' => $payment_reference, 'amount' => $_POST['sum'], 'date' => $paid_date, 'type' => 'credit_card', 'notes' => ''];
                    $invoiceHasPayment = InvoiceHasPayment::create($attributes);

                    if ($_POST['sum'] >= $invoice->outstanding) {
                        $invoice->update_attributes(['paid_date' => $paid_date, 'status' => 'Paid']);
                    } else {
                        $invoice->update_attributes(['status' => 'PartiallyPaid']);
                    }

                    $this->session->set_flashdata('message', 'success:' . $this->lang->line('messages_payment_complete'));
                    log_message('error', '2Checkout: Payment of ' . $_POST['sum'] . ' for invoice ' . $invoice_reference . ' received!');
                }
            } catch (Twocheckout_Error $e) {
                $this->session->set_flashdata('message', 'error: Your payment could NOT be processed (i.e., you have not been charged) because the payment system rejected the transaction.');
                log_message('error', '2Checkout: Payment of invoice ' . $invoice_reference . ' failed - ' . $e->getMessage());
            }
            redirect('invoices/view/' . $_POST['id']);
        } else {
            $this->view_data['invoices'] = Invoice::find_by_id($id);

            $this->view_data['publishable_key'] = $data['core_settings']->twocheckout_publishable_key;
            $this->view_data['seller_id'] = $data['core_settings']->twocheckout_seller_id;

            $this->view_data['sum'] = $sum;
            $this->theme_view = 'modal';
            $this->view_data['title'] = $this->lang->line('application_pay_with_credit_card');
            $this->view_data['form_action'] = 'invoices/twocheckout';
            $this->content_view = 'invoices/_2checkout';
        }
    }

    public function stripepay($id = false, $sum = false, $type = 'card')
    {
        $data['core_settings'] = Setting::first();

        $stripe_keys = [
          'secret_key' => $data['core_settings']->stripe_p_key,
          'publishable_key' => $data['core_settings']->stripe_key
        ];

        if ($_POST) {
            unset($_POST['send']);
            $invoice = Invoice::find($_POST['id']);
            // Stores errors:
            $errors = [];

            // Need a payment token:
            if (isset($_POST['stripeToken'])) {
                $token = $_POST['stripeToken'];

                // Check for a duplicate submission, just in case:
                // Uses sessions, you could use a cookie instead.
                if (isset($_SESSION['token']) && ($_SESSION['token'] == $token)) {
                    $errors['token'] = 'You have apparently resubmitted the form. Please do not do that.';
                    $this->session->set_flashdata('message', 'error: You have apparently resubmitted the form. Please do not do that.');
                } else { // New submission.
                    $_SESSION['token'] = $token;
                }
            } else {
                $this->session->set_flashdata('message', 'error: The order cannot be processed. Please make sure you have JavaScript enabled and try again.');
                $errors['token'] = 'The order cannot be processed. Please make sure you have JavaScript enabled and try again.';
                log_message('error', 'Stripe: ERROR - Payment canceled for invoice #' . $data['core_settings']->invoice_prefix . $invoice->reference . '.');
            }

            // Set the order amount somehow:
            $sum_exp = explode('.', $_POST['sum']);
            $amount = $sum_exp[0] * 100 + $sum_exp[1]; // in cents

            //Get currency

            $currency = $invoice->currency;
            $currency_codes = getCurrencyCodes();
            if (!array_key_exists($currency, $currency_codes)) {
                $currency = $data['core_settings']->stripe_currency;
            }

            // If no errors, process the order:
            if (empty($errors)) {
                // create the charge on Stripe's servers - this will charge the user's card
                try {
                    // Set API key for stripe:
                    \Stripe\Stripe::setApiKey($stripe_keys['secret_key']);

                    // Charge the order:
                    $charge = \Stripe\Charge::create(
                            [
                            'amount' => $amount, // amount in cents, again
                            'currency' => $currency,
                            'card' => $token,
                            'receipt_email' => $invoice->company->client->email,
                            'description' => $data['core_settings']->invoice_prefix . $invoice->reference,
                            ]
                        );

                    // Check that it was paid:
                    if ($charge->paid == true) {
                        $attr = [];
                        $paid_date = date('Y-m-d', time());
                        $payment_reference = $invoice->reference . '00' . InvoiceHasPayment::count(['conditions' => 'invoice_id = ' . $invoice->id]) + 1;
                        $attributes = ['invoice_id' => $invoice->id, 'reference' => $payment_reference, 'amount' => $_POST['sum'], 'date' => $paid_date, 'type' => 'credit_card', 'notes' => ''];
                        $invoiceHasPayment = InvoiceHasPayment::create($attributes);

                        if ($_POST['sum'] >= $invoice->outstanding) {
                            $invoice->update_attributes(['paid_date' => $paid_date, 'status' => 'Paid']);
                        } else {
                            $invoice->update_attributes(['status' => 'PartiallyPaid']);
                        }

                        $this->session->set_flashdata('message', 'success:' . $this->lang->line('messages_payment_complete'));
                        log_message('error', 'Stripe: Payment for Invoice #' . $data['core_settings']->invoice_prefix . $invoice->reference . ' successfully made');
                    } else { // Charge was not paid!
                        $this->session->set_flashdata('message', 'error: Your payment could NOT be processed (i.e., you have not been charged) because the payment system rejected the transaction.');
                        log_message('error', 'Stripe: ERROR - Payment for Invoice #' . $data['core_settings']->invoice_prefix . $invoice->reference . ' was not successful!');
                    }
                } catch (\Stripe\Error\Card $e) {
                    // Card was declined.
                    $e_json = $e->getJsonBody();
                    $err = $e_json['error'];
                    $errors['stripe'] = $err['message'];
                    $this->session->set_flashdata('message', 'error: Card was declined!');
                    log_message('error', 'Stripe: ERROR - Credit Card was declined by Stripe! Payment process canceled for invoice #' . $data['core_settings']->invoice_prefix . $invoice->reference . '.');
                } catch (\Stripe\Error\RateLimit $e) {
                    // Too many requests made to the API too quickly
                    $e_json = $e->getJsonBody();
                    $err = $e_json['error'];
                    $this->session->set_flashdata('message', 'error: Too many requests made to the API too quickly!');
                    log_message('error', 'Too many stripe requests: ' . $err['message']);
                } catch (\Stripe\Error\Authentication $e) {
                    $e_json = $e->getJsonBody();
                    $err = $e_json['error'];
                    $this->session->set_flashdata('message', 'error: Payment could not be processed!');
                    log_message('error', 'Stripe authentication error: ' . $err['message']);
                } catch (\Stripe\Error\InvalidRequest $e) {
                    $e_json = $e->getJsonBody();
                    $err = $e_json['error'];
                    $this->session->set_flashdata('message', 'error: Payment could not be processed!');
                    log_message('error', 'Stripe invalid request error: ' . $err['message']);
                } catch (\Stripe\Error\ApiConnection $e) {
                    $e_json = $e->getJsonBody();
                    $err = $e_json['error'];
                    $this->session->set_flashdata('message', 'error: Payment could not be processed!');
                    log_message('error', 'Stripe API connection error: ' . $err['message']);
                } catch (\Stripe\Error\Base $e) {
                    $e_json = $e->getJsonBody();
                    $err = $e_json['error'];
                    $this->session->set_flashdata('message', 'error: Payment could not be processed!');
                    log_message('error', 'Stripe error: ' . $err['message']);
                } catch (Exception $e) {
                    $e_json = $e->getJsonBody();
                    $err = $e_json['error'];
                    $this->session->set_flashdata('message', 'error: Payment could not be processed!');
                    log_message('error', 'Error during stripe process: ' . $err['message']);
                }
            } else {
                $this->session->set_flashdata('message', 'error: ' . $errors['token']);
                log_message('error', 'Stripe: ' . $errors['token']);
            }

            redirect('invoices/view/' . $_POST['id']);
        } else {
            $this->view_data['invoices'] = Invoice::find_by_id($id);

            $this->view_data['public_key'] = $data['core_settings']->stripe_key;
            $this->view_data['sum'] = $sum;
            $this->theme_view = 'modal';

            switch ($type) {
                case 'ideal':
                    $this->view_data['form_action'] = 'invoices/idealpay';
                    $this->view_data['title'] = $this->lang->line('application_pay_with_ideal');
                    $this->content_view = 'invoices/_stripe_ideal';
                break;
                default:
                    $this->view_data['form_action'] = 'invoices/stripepay';
                    $this->view_data['title'] = $this->lang->line('application_pay_with_credit_card');
                    $this->content_view = 'invoices/_stripe';
                break;
            }
        }
    }

    public function idealpay($id = false, $sum = false)
    {
        $core_settings = Setting::first();
        // Set API key for stripe:
        \Stripe\Stripe::setApiKey($core_settings->stripe_p_key);
        // Get Stripe source from url source id
        $source = \Stripe\Source::retrieve($_GET['source']);
        // Find invoice and get currecny
        $invoice = Invoice::find_by_id($id);
        $currency = $invoice->currency;

        $sum_exp = explode('.', $sum);
        $amount = $sum_exp[0] * 100 + $sum_exp[1]; // in cents

        switch ($source->status) {
            case 'chargeable':
                $create = \Stripe\Charge::create([
                    'amount' => $amount,
                    'currency' => $currency,
                    'source' => $_GET['source'],
                ]);

                if ($create->status == 'succeeded') {
                    $attr = [];
                    $paid_date = date('Y-m-d', time());
                    $payment_reference = $invoice->reference . '00' . InvoiceHasPayment::count(['conditions' => 'invoice_id = ' . $invoice->id]) + 1;
                    $attributes = ['invoice_id' => $invoice->id, 'reference' => $payment_reference, 'amount' => $sum, 'date' => $paid_date, 'type' => 'iDEAL', 'notes' => ''];
                    $invoiceHasPayment = InvoiceHasPayment::create($attributes);

                    if ($sum >= $invoice->outstanding) {
                        $invoice->update_attributes(['paid_date' => $paid_date, 'status' => 'Paid']);
                    } else {
                        $invoice->update_attributes(['status' => 'PartiallyPaid']);
                    }

                    $this->session->set_flashdata('message', 'success:' . $this->lang->line('messages_payment_complete'));
                    log_message('error', 'Stripe: Payment for Invoice #' . $core_settings->invoice_prefix . $invoice->reference . ' successfully made with iDEAL.');
                    redirect('invoices/view/' . $id);
                } else {
                    $this->session->set_flashdata('message', 'error: Payment could not be processed!');
                    log_message('error', 'iDEAL Payment was canceled!');
                    redirect('invoices/view/' . $id);
                }

            break;
            case 'canceled':
                $this->session->set_flashdata('message', 'error: Payment could not be processed!');
                log_message('error', 'iDEAL Payment was canceled!');
            break;
            case 'consumed':
                $this->session->set_flashdata('message', 'error: Payment already completed!');
                log_message('error', 'iDEAL Payment was called again but already compleated!');
            break;
            case 'failed':
                $this->session->set_flashdata('message', 'error: Payment failed!');
                log_message('error', 'iDEAL Payment failed during process!');
            break;
          }

        redirect('invoices/view/' . $id);
    }

    public function authorizenet($id = false)
    {
        if ($_POST) {
            // Authorize.net lib
            $data['core_settings'] = Setting::first();
            $this->load->library('authorize_net');
            $invoice = Invoice::find_by_id($_POST['invoice_id']);
            log_message('error', 'Authorize.net: Payment process started for invoice: #' . $data['core_settings']->invoice_prefix . $invoice->reference);

            $amount = $_POST['sum'];

            $auth_net = [
                    'x_card_num' => str_replace(' ', '', $_POST['x_card_num']),
                    'x_exp_date' => $_POST['x_card_month'] . '/' . $_POST['x_card_year'],
                    'x_card_code' => $_POST['x_card_code'],
                    'x_description' => $this->lang->line('application_invoice') . ' #' . $data['core_settings']->invoice_prefix . $invoice->reference,
                    'x_amount' => $amount,
                    'x_first_name' => $invoice->company->client->firstname,
                    'x_last_name' => $invoice->company->client->lastname,
                    'x_address' => $invoice->company->address,
                    'x_city' => $invoice->company->city,
                    //'x_state'				=> 'KY',
                    'x_zip' => $invoice->company->zipcode,
                    //'x_country'			=> 'US',
                    'x_phone' => $invoice->company->phone,
                    'x_email' => $invoice->company->client->email,
                    'x_customer_ip' => $this->input->ip_address(),
                    ];
            $this->authorize_net->setData($auth_net);
            // Try to AUTH_CAPTURE
            if ($this->authorize_net->authorizeAndCapture()) {
                $this->session->set_flashdata('message', 'success: ' . $this->lang->line('messages_payment_complete'));

                log_message('error', 'Authorize.net: Transaction ID: ' . $this->authorize_net->getTransactionId());
                log_message('error', 'Authorize.net: Approval Code: ' . $this->authorize_net->getApprovalCode());
                log_message('error', 'Authorize.net: Payment completed.');
                $invoice->status = 'Paid';
                $invoice->paid_date = date('Y-m-d', time());

                $invoice->save();
                $attributes = ['invoice_id' => $invoice->id, 'reference' => $this->authorize_net->getTransactionId(), 'amount' => $amount, 'date' => date('Y-m-d', time()), 'type' => 'credit_card', 'notes' => $this->authorize_net->getApprovalCode()];
                $invoiceHasPayment = InvoiceHasPayment::create($attributes);
                redirect('invoices/view/' . $invoice->id);
            } else {
                log_message('error', 'Authorize.net: Payment failed.');
                log_message('error', 'Authorize.net: ' . $this->authorize_net->getError());

                $this->view_data['return_link'] = 'invoices/view/' . $invoice->id;

                $this->view_data['message'] = $this->authorize_net->getError();
                //$this->authorize_net->debug();

                $this->content_view = 'error/error';
            }
        } else {
            $this->view_data['invoices'] = Invoice::find_by_id($id);
            $this->view_data['settings'] = Setting::first();
            $this->view_data['sum'] = sprintf('%01.2f', $this->view_data['invoices']->outstanding);

            $this->theme_view = 'modal';
            $this->view_data['title'] = $this->lang->line('application_pay_with_credit_card');
            $this->view_data['form_action'] = 'invoices/authorizenet';
            $this->content_view = 'invoices/_authorizenet';
        }
    }

    public function delete($id = false)
    {
        $invoice = Invoice::find($id);
        $invoice->delete();
        $this->content_view = 'invoices/all';
        if (!$invoice) {
            $this->session->set_flashdata('message', 'error:' . $this->lang->line('messages_delete_invoice_error'));
        } else {
            $this->session->set_flashdata('message', 'success:' . $this->lang->line('messages_delete_invoice_success'));
        }
        redirect('invoices');
    }

    public function preview($id = false, $attachment = false)
    {
        $this->load->helper(['dompdf', 'file']);
        $this->load->library('parser');
        $data['invoice'] = Invoice::find($id);
        $data['items'] = InvoiceHasItem::find('all', ['conditions' => ['invoice_id=?', $id]]);
        $data['core_settings'] = Setting::first();

        $invoice_project = (is_object($data['invoice']->project)) ? $data['core_settings']->invoice_prefix . $data['invoice']->project->reference . ' - ' . $data['invoice']->project->name : '';


        $due_date = date($data['core_settings']->date_format, human_to_unix($data['invoice']->due_date . ' 00:00:00'));
        $parse_data = [
                                'client_contact' => $data['invoice']->company->client->firstname . ' ' . $data['invoice']->company->client->lastname,
                                'client_company' => $data['invoice']->company->name,
                                'due_date' => $due_date,
                                'invoice_project' => $invoice_project,
                                'invoice_id' => $data['core_settings']->invoice_prefix . $data['invoice']->reference,
                                'balance' => display_money($data['invoice']->outstanding, $data['invoice']->currency),
                                'client_link' => $data['core_settings']->domain,
                                'invoice_link' => base_url() . 'cinvoices/view/' . $data['invoice']->id,
                                'company' => $data['core_settings']->company,
                                'logo' => '<img src="' . base_url() . '' . $data['core_settings']->logo . '" alt="' . $data['core_settings']->company . '"/>',
                                'invoice_logo' => '<img src="' . base_url() . '' . $data['core_settings']->invoice_logo . '" alt="' . $data['core_settings']->company . '"/>'
                              
                                ];
        $html = $this->load->view($data['core_settings']->template . '/' . $data['core_settings']->invoice_pdf_template, $data, true);
        $html = $this->parser->parse_string($html, $parse_data);

        $filename = $this->lang->line('application_invoice') . '_' . $data['core_settings']->invoice_prefix . $data['invoice']->reference;
        pdf_create($html, $filename, true, $attachment);
    }

    public function previewHTML($id = false)
    {
        $this->load->helper(['file']);
        $this->load->library('parser');
        $data['htmlPreview'] = true;
        $data['invoice'] = Invoice::find($id);
        $data['items'] = InvoiceHasItem::find('all', ['conditions' => ['invoice_id=?', $id]]);
        $data['core_settings'] = Setting::first();

        $invoice_project = (is_object($data['invoice']->project)) ? $data['core_settings']->invoice_prefix.$data['invoice']->project->reference.' - '.$data['invoice']->project->name : '';
    
        $due_date = date($data['core_settings']->date_format, human_to_unix($data['invoice']->due_date . ' 00:00:00'));
        $parse_data = [
                                'client_contact' => $data['invoice']->company->client->firstname . ' ' . $data['invoice']->company->client->lastname,
                                'client_company' => $data['invoice']->company->name,
                                'due_date' => $due_date,
                                'invoice_project' => $invoice_project,
                                'invoice_id' => $data['core_settings']->invoice_prefix . $data['invoice']->reference,
                                'balance' => display_money($data['invoice']->outstanding, $data['invoice']->currency),
                                'client_link' => $data['core_settings']->domain,
                                'invoice_link' => base_url() . 'cinvoices/view/' . $data['invoice']->id,
                                'company' => $data['core_settings']->company,
                                'logo' => '<img src="' . base_url() . '' . $data['core_settings']->logo . '" alt="' . $data['core_settings']->company . '"/>',
                                'invoice_logo' => '<img src="' . base_url() . '' . $data['core_settings']->invoice_logo . '" alt="' . $data['core_settings']->company . '"/>'
                              
                                ];
        $html = $this->load->view($data['core_settings']->template . '/' . $data['core_settings']->invoice_pdf_template, $data, true);
        $html = $this->parser->parse_string($html, $parse_data);
        $this->theme_view = 'blank';
        $this->content_view = 'invoices/_preview';
    }

    public function sendinvoice($id = false)
    {
        $this->load->helper(['dompdf', 'file']);
        $this->load->library('parser');

        $data['invoice'] = Invoice::find($id);
        $data['items'] = InvoiceHasItem::find('all', ['conditions' => ['invoice_id=?', $id]]);
        $data['core_settings'] = Setting::first();
        $due_date = date($data['core_settings']->date_format, human_to_unix($data['invoice']->due_date . ' 00:00:00'));
        $invoice_project = (is_object($data['invoice']->project)) ? $data['core_settings']->invoice_prefix.$data['invoice']->project->reference.' - '.$data['invoice']->project->name : '';
        //Set parse values
        $parse_data = [
                                'client_contact' => $data['invoice']->company->client->firstname . ' ' . $data['invoice']->company->client->lastname,
                                'client_company' => $data['invoice']->company->name,
                                'due_date' => $due_date,
                                'invoice_id' => $data['core_settings']->invoice_prefix . $data['invoice']->reference,
                                'invoice_project' => $invoice_project,
                                'balance' => display_money($data['invoice']->outstanding, $data['invoice']->currency),
                                'client_link' => $data['core_settings']->domain,
                                'invoice_link' => base_url() . 'cinvoices/view/' . $data['invoice']->id,
                                'company' => $data['core_settings']->company,
                                'logo' => '<img src="' . base_url() . '' . $data['core_settings']->logo . '" alt="' . $data['core_settings']->company . '"/>',
                                'invoice_logo' => '<img src="' . base_url() . '' . $data['core_settings']->invoice_logo . '" alt="' . $data['core_settings']->company . '"/>'
                                ];
        // Generate PDF
        $html = $this->load->view($data['core_settings']->template . '/' . $data['core_settings']->invoice_pdf_template, $data, true);
        $html = $this->parser->parse_string($html, $parse_data);
        $filename = $this->lang->line('application_invoice') . '_' . $data['core_settings']->invoice_prefix . $data['invoice']->reference;
        pdf_create($html, $filename, false);
        //email
        $subject = $this->parser->parse_string($data['core_settings']->invoice_mail_subject, $parse_data);
        $this->email->from($data['core_settings']->email, $data['core_settings']->company);
        if (!is_object($data['invoice']->company->client) && $data['invoice']->company->client->email == '') {
            $this->session->set_flashdata('message', 'error:This client company has no primary contact! Just add a primary contact.');
            redirect('invoices/view/' . $id);
        }
        $this->email->to($data['invoice']->company->client->email);
        $this->email->subject($subject);
        $this->email->attach('files/temp/' . $filename . '.pdf');

        $email_invoice = read_file('./application/views/' . $data['core_settings']->template . '/templates/email_invoice.html');
        $message = $this->parser->parse_string($email_invoice, $parse_data);
        $this->email->message($message);
        if ($this->email->send()) {
            $this->session->set_flashdata('message', 'success:' . $this->lang->line('messages_send_invoice_success'));
            if ($data['invoice']->status == 'Open') {
                $data['invoice']->update_attributes(['status' => 'Sent', 'sent_date' => date('Y-m-d')]);
            }
            log_message('error', 'Invoice #' . $data['core_settings']->invoice_prefix . $data['invoice']->reference . ' has been send to ' . $data['invoice']->company->client->email);
        } else {
            $this->session->set_flashdata('message', 'error:' . $this->lang->line('messages_send_invoice_error'));
            log_message('error', 'ERROR: Invoice #' . $data['core_settings']->invoice_prefix . $data['invoice']->reference . ' has not been send to ' . $data['invoice']->company->client->email . '. Please check your servers email settings.');
        }
        unlink('files/temp/' . $filename . '.pdf');
        redirect('invoices/view/' . $id);
    }

    public function item($id = false)
    {
        if ($_POST) {
            unset($_POST['send']);
            $_POST = array_map('htmlspecialchars', $_POST);
            if ($_POST['name'] != '') {
                $_POST['name'] = $_POST['name'];
                $_POST['value'] = str_replace(',', '.', $_POST['value']);
                $_POST['type'] = $_POST['type'];
            } else {
                if ($_POST['item_id'] == '-') {
                    $this->session->set_flashdata('message', 'error:' . $this->lang->line('messages_add_item_error'));
                    redirect('invoices/view/' . $_POST['invoice_id']);
                } else {
                    $rebill = explode('_', $_POST['item_id']);
                    if ($rebill[0] == 'rebill') {
                        $itemvalue = Expense::find_by_id($rebill[1]);
                        $_POST['name'] = $itemvalue->description;
                        $_POST['type'] = $_POST['item_id'];
                        $_POST['value'] = $itemvalue->value;
                        $itemvalue->rebill = 2;
                        $itemvalue->invoice_id = $_POST['invoice_id'];
                        $itemvalue->save();
                    } else {
                        $itemvalue = Item::find_by_id($_POST['item_id']);
                        $_POST['name'] = $itemvalue->name;
                        $_POST['type'] = $itemvalue->type;
                        $_POST['value'] = $itemvalue->value;
                    }
                }
            }

            $item = InvoiceHasItem::create($_POST);
            if (!$item) {
                $this->session->set_flashdata('message', 'error:' . $this->lang->line('messages_add_item_error'));
            } else {
                $this->session->set_flashdata('message', 'success:' . $this->lang->line('messages_add_item_success'));
            }
            redirect('invoices/view/' . $_POST['invoice_id']);
        } else {
            $this->view_data['invoice'] = Invoice::find($id);
            $this->view_data['items'] = Item::find('all', ['conditions' => ['inactive=?', '0']]);
            $this->view_data['rebill'] = Expense::find('all', ['conditions' => ['project_id=? and (rebill=? or invoice_id=?)', $this->view_data['invoice']->project_id, 1, $id]]);

            $this->theme_view = 'modal';
            $this->view_data['title'] = $this->lang->line('application_add_item');
            $this->view_data['form_action'] = 'invoices/item';
            $this->content_view = 'invoices/_item';
        }
    }

    public function item_update($id = false)
    {
        if ($_POST) {
            unset($_POST['send']);
            $_POST = array_map('htmlspecialchars', $_POST);
            $_POST['value'] = str_replace(',', '.', $_POST['value']);
            $item = InvoiceHasItem::find($_POST['id']);
            $item = $item->update_attributes($_POST);
            if (!$item) {
                $this->session->set_flashdata('message', 'error:' . $this->lang->line('messages_save_item_error'));
            } else {
                $this->session->set_flashdata('message', 'success:' . $this->lang->line('messages_save_item_success'));
            }
            redirect('invoices/view/' . $_POST['invoice_id']);
        } else {
            $this->view_data['invoice_has_items'] = InvoiceHasItem::find($id);
            $this->theme_view = 'modal';
            $this->view_data['title'] = $this->lang->line('application_edit_item');
            $this->view_data['form_action'] = 'invoices/item_update';
            $this->content_view = 'invoices/_item';
        }
    }

    public function item_delete($id = false, $invoice_id = false)
    {
        $item = InvoiceHasItem::find($id);
        $item->delete();
        $this->content_view = 'invoices/view';
        if (!$item) {
            $this->session->set_flashdata('message', 'error:' . $this->lang->line('messages_delete_item_error'));
        } else {
            $this->session->set_flashdata('message', 'success:' . $this->lang->line('messages_delete_item_success'));
        }
        redirect('invoices/view/' . $invoice_id);
    }

    public function changestatus($id = false, $status = false)
    {
        $invoice = Invoice::find_by_id($id);
        if ($this->user->admin != 1) {
            $comp_array = [];
            foreach ($this->user->companies as $value) {
                array_push($comp_array, $value->id);
            }
            if (!in_array($invoice->company_id, $comp_array)) {
                return false;
            }
        }
        switch ($status) {
            case 'Sent':
                $invoice->sent_date = date('Y-m-d', time());
            break;
            case 'Paid':
                $invoice->paid_date = date('Y-m-d', time());
            break;
        }
        $invoice->status = $status;
        $invoice->save();
        die();
    }

    public function getterms($id = false)
    {
        $settings = Setting::first();

        $company = Company::find_by_id($id);
        $terms = ($company->terms == '') ? $settings->invoice_terms : $company->terms;
        json_response('success', '', html_entity_decode($terms));
    }
}
