<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Cronjob extends MY_Controller
{
    public function index()
    {
        ini_set('max_execution_time', 300); //5 minutes
        $this->theme_view = 'blank';
        $this->load->helper(['dompdf', 'file']);
        $timestamp = time();
        $core_settings = Setting::first();
        $date = date('Y-m-d');
        $this->load->library('parser');

        /* Check if cronjob option is enabled */
        if ($core_settings->cronjob != '1' && time() > ($core_settings->last_cronjob + 0)) {
            log_message('error', '[cronjob] Cronjob link has been called but cronjob option is not enabled in settings.');
            show_error('Cronjob link has been called but cronjob option is not enabled!', 403);
            return false;
        }

        // Log cronjob execution time
        $core_settings->last_cronjob = time();
        $core_settings->save();

        // Run auto Backup if enabled and if last backup is older then 7 days
        if ($core_settings->autobackup == '1' && time() > ($core_settings->last_autobackup + 7 * 24 * 60 * 60)) {
            $this->load->dbutil();

            $version = str_replace('.', '-', $core_settings->version);
            $prefs = ['format' => 'zip', 'filename' => 'Database-auto-full-backup_' . $version . '_' . date('Y-m-d_H-i')];

            $backup = &$this->dbutil->backup($prefs);

            if (!write_file('./files/backup/Database-auto-full-backup_' . $version . '_' . date('Y-m-d_H-i') . '.zip', $backup)) {
                log_message('error', '[cronjob] Error while creating auto database backup!');
            } else {
                $core_settings->last_autobackup = time();
                $core_settings->save();
                log_message('error', '[cronjob] Auto backup has been created.');
            }
        }

        /* create new expeses */
        $this->expenses();

        // Get subscriptions which require new invoice
        $subscriptions = Subscription::find_by_sql('SELECT * FROM subscriptions WHERE status != "Inactive" AND (end_date > "' . $date . '" OR end_date = "") AND "' . $date . '" >= next_payment ORDER BY next_payment');

        // Stop if subscription count is 0
        $subscription_count = count($subscriptions);
        if ($subscription_count == 0) {
            return false;
        }

        // Start invoice creation
        log_message('error', '[cronjob] ' . $subscription_count . ' subscriptions to process...');

        $subscription = Subscription::find_by_id($subscriptions[0]->id);

        log_message('error', '[cronjob][' . $subscription_count . '] Processing of subscription ' . $core_settings->subscription_prefix . $subscription->reference . ' started!');

        // Create new invoice using subscription data
        $invoice_reference = $core_settings->invoice_reference;
        $_POST['subscription_id'] = $subscription->id;
        $_POST['company_id'] = $subscription->company_id;
        $_POST['currency'] = $subscription->currency;
        $_POST['issue_date'] = $subscription->next_payment;
        $_POST['due_date'] = date('Y-m-d', strtotime('+14 day', strtotime($subscription->next_payment)));
        $_POST['terms'] = $subscription->terms;
        $_POST['discount'] = $subscription->discount;
        $_POST['tax'] = $subscription->tax;
        $_POST['second_tax'] = $subscription->second_tax;
        $_POST['reference'] = $invoice_reference;
        $_POST['status'] = ($subscription->subscribed != 0) ? 'Paid' : 'Open';
        $invoice = Invoice::create($_POST);

        // Check if invoice creation was successfull and cancel if not
        if (!$invoice) {
            log_message('error', '[cronjob][' . $subscription_count . '] ERROR while creating invoice for subscription ' . $core_settings->subscription_prefix . $subscription->reference . ' !');
            return false;
        } else {
            // Increase next invoice reference by 1 after invoice creation and set next payment to next frequency
            $core_settings->update_attributes(['invoice_reference' => $invoice_reference + 1]);
            $subscription->next_payment = date('Y-m-d', strtotime($subscription->frequency, strtotime($subscription->next_payment)));
            $subscription->save();
        }

        // Create invoice items
        foreach ($subscription->subscription_has_items as $value):
            $itemvalues = [
                'invoice_id' => $invoice->id,
                'item_id' => $value->item_id,
                'amount' => $value->amount,
                'description' => $value->description,
                'value' => $value->value,
                'name' => $value->name,
                'type' => $value->type,
            ];
        InvoiceHasItem::create($itemvalues);
        endforeach;

        // Check if all invoice items have been created
        if (count($subscription->subscription_has_items) != count($invoice->invoice_has_items)) {
            log_message('error', '[cronjob][' . $subscription_count . '] ERROR while creating invoice for subscription ' . $core_settings->subscription_prefix . $subscription->reference . ' ! Invoice item count does not match with subscription item count!');
            $invoice->delete();
            return false;
        }
        // Calculate invoice sum
        $invoice = Invoice::calculateSum($invoice);

        //Clear email instance
        $this->email->clear(true);

        // Pass values to Invoice PDF view
        $data['invoice'] = $invoice;
        $data['items'] = $invoice->invoice_has_items;
        $data['core_settings'] = $core_settings;

        // Generate PDF
        $html = $this->load->view($core_settings->template . '/' . $core_settings->invoice_pdf_template, $data, true);
        $filename = $this->lang->line('application_invoice') . '_' . $core_settings->invoice_prefix . $data['invoice']->reference;
        pdf_create($html, $filename, false);
        // Check if PDF was created and file was saved successfully
        if (!file_exists('files/temp/' . $filename . '.pdf')) {
            log_message('error', '[cronjob][' . $subscription_count . '] ERROR while creating invoice for subscription ' . $core_settings->subscription_prefix . $subscription->reference . ' ! Generated PDF file was not found -> files/temp/' . $filename . '.pdf !');
            $invoice->delete();
            return false;
        }

        log_message('error', '[cronjob][' . $subscription_count . '] PDF for invoice ' . $core_settings->invoice_prefix . $invoice->reference . ' has been created and is ready to be sent out!');

        if (is_object($invoice->company) && is_object($invoice->company->client) && $invoice->company->client->email != '') {
            //Set parse values for Email
            $due_date = date($core_settings->date_format, human_to_unix($data['invoice']->due_date . ' 00:00:00'));
            $parse_data = [
                                'client_contact' => $data['invoice']->company->client->firstname . ' ' . $data['invoice']->company->client->lastname,
                                'client_company' => $data['invoice']->company->name,
                                'balance' => display_money($data['invoice']->outstanding, $data['invoice']->currency),
                                'due_date' => $due_date,
                                'client_company' => $data['invoice']->company->name,
                                'invoice_id' => $core_settings->invoice_prefix . $data['invoice']->reference,
                                'client_link' => $core_settings->domain,
                                'invoice_link' => base_url() . 'cinvoices/view/' . $data['invoice']->id,
                                'company' => $core_settings->company,
                                'logo' => '<img src="' . base_url() . '' . $core_settings->logo . '" alt="' . $core_settings->company . '"/>',
                                'invoice_logo' => '<img src="' . base_url() . '' . $core_settings->invoice_logo . '" alt="' . $core_settings->company . '"/>'
            ];
            $mail_subject = $this->parser->parse_string($core_settings->invoice_mail_subject, $parse_data);

            //email
            $this->email->from($core_settings->email, $core_settings->company);
            $this->email->to($data['invoice']->company->client->email);
            $this->email->subject($mail_subject);
            $this->email->attach('files/temp/' . $filename . '.pdf');

            $email_invoice = read_file('./application/views/' . $core_settings->template . '/templates/email_invoice.html');
            $message = $this->parser->parse_string($email_invoice, $parse_data);
            $this->email->message($message);
            if (!$this->email->send()) {
                log_message('error', '[cronjob][' . $subscription_count . '] ERROR Invoice email ' . $core_settings->invoice_prefix . $invoice->reference . ' could not be sent!');
            } else {
                log_message('error', '[cronjob][' . $subscription_count . '] Invoice email ' . $core_settings->invoice_prefix . $invoice->reference . ' was sent to ' . $data['invoice']->company->client->email . ' successfully!');
                $data['invoice']->update_attributes(['status' => 'Sent', 'sent_date' => date('Y-m-d')]);
            }
        } else {
            log_message('error', '[cronjob][' . $subscription_count . '] Invoice email ' . $core_settings->invoice_prefix . $invoice->reference . ' was not sent since no client is assigned to the subscription.');
        }

        @unlink('files/temp/' . $filename . '.pdf');

        redirect('cronjob');
    }

    public function expenses()
    {
        $date = date('Y-m-d');
        $open_exepnses = true;
        while ($open_exepnses == true) {
            $open_exepnses = false;
            // Get expenses which require new invoice
            $expenses = Expense::find_by_sql('SELECT * FROM expenses WHERE type = "recurring_payment" AND (recurring_until >= next_payment OR recurring_until = "") AND "' . $date . '" >= next_payment ORDER BY next_payment');

            // Stop if expenses count is 0
            $expense_count = count($expenses);
            if ($expense_count > 0) {
                log_message('error', '[cronjob] ' . $expense_count . ' expenses to process...');

                foreach ($expenses as $value) {
                    $expensevalues = [
                    'invoice_id' => $value->invoice_id,
                    'description' => $value->description,
                    'category' => $value->category,
                    'date' => $value->next_payment,
                    'currency' => $value->currency,
                    'value' => $value->value,
                    'vat' => $value->vat,
                    'reference' => $value->reference,
                    'project_id' => $value->project_id,
                    'invoice_id' => 0,
                    'recurring' => $value->recurring,
                    'recurring_until' => $value->recurring_until,
                    'user_id' => $value->user_id,
                    'expense_id' => $value->id,
                    'type' => 'recurring_payment_child',
                ];
                    $new_expense = Expense::create($expensevalues);
                    if ($new_expense) {
                        log_message('error', '[cronjob] New expense with ID ' . $new_expense->id . ' for ' . $value->next_payment . ' has been created!');
                        $exp = Expense::find_by_id($value->id);
                        $exp->next_payment = date('Y-m-d', strtotime($value->recurring, strtotime($value->next_payment)));
                        $exp->save();
                        if ($date >= $exp->next_payment) {
                            $open_exepnses = true;
                        }
                    }
                }
            }
        }
        return true;
    }
}
