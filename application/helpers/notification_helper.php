<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
/**
 * Notification Helper
 */
function send_notification($email, $subject, $text, $attachment = false, $link = false)
{
    $instance = &get_instance();
    $instance->email->clear();
    $instance->load->helper('file');
    $instance->load->library('parser');
    $data['core_settings'] = Setting::first();
    $instance->email->from($data['core_settings']->email, $data['core_settings']->company);
    $instance->email->to($email);
    $instance->email->subject($subject);
    if ($attachment) {
        if (is_array($attachment)) {
            foreach ($attachment as $value) {
                $instance->email->attach('files/media/' . $value);
            }
        } else {
            $instance->email->attach('files/media/' . $attachment);
        }
    }
    //Set parse values
    $parse_data = [
                    'company' => $data['core_settings']->company,
                    'link' => base_url(),
                    'logo' => '<img src="' . base_url() . '' . $data['core_settings']->logo . '" alt="' . $data['core_settings']->company . '"/>',
                    'invoice_logo' => '<img src="' . base_url() . '' . $data['core_settings']->invoice_logo . '" alt="' . $data['core_settings']->company . '"/>',
                    'message' => $text,
                    'link' => ($link) ? $link : base_url(),
                    ];
    $find_client = Client::find_by_email($email);
    $find_user = User::find_by_email($email);
    $recepient = ($find_client) ? $find_client : $find_user;
    $parse_data['client_contact'] = (isset($recepient->firstname)) ? $recepient->firstname . ' ' . $recepient->lastname : '';
    $parse_data['client_company'] = ($find_client) ? $recepient->company->name : '';
    $parse_data['first_name'] = (isset($recepient->firstname)) ? $recepient->firstname : '';
    $parse_data['last_name'] = (isset($recepient->firstname)) ? $recepient->lastname : '';

    $email_message = read_file('./application/views/' . $data['core_settings']->template . '/templates/email_notification.html');
    $message = $instance->parser->parse_string($email_message, $parse_data);

    $instance->email->message($message);
    $send = $instance->email->send();
    return $send;
}

function send_ticket_notification($email, $subject, $text, $ticket_id, $attachment = false)
{
    $instance = &get_instance();
    $instance->email->clear();
    $instance->load->helper('file');
    $instance->load->library('parser');
    $data['core_settings'] = Setting::first();

    $ticket = Ticket::find_by_id($ticket_id);
    $ticket_articles = TicketHasArticle::find('all', ['conditions' => ['ticket_id=?', $ticket_id], 'order' => 'id DESC', 'limit' => '3']);

    $ticket_link = base_url() . 'tickets/view/' . $ticket->id;

    $instance->email->reply_to($data['core_settings']->ticket_config_email);
    $instance->email->from($data['core_settings']->email, $data['core_settings']->company);

    $instance->email->to($email);
    $instance->email->subject($subject);
    if ($attachment) {
        if (is_array($attachment)) {
            foreach ($attachment as $value) {
                $instance->email->attach('./files/media/' . $value);
            }
        } else {
            $instance->email->attach('./files/media/' . $attachment);
        }
    }
    $emailsender = $ticket->client->email;
    $emailname = $ticket->client->firstname . ' ' . $ticket->client->lastname;

    $open_div = '<div style="cursor:auto;color:#444;font-family:-apple-system,BlinkMacSystemFont,Segoe UI,Roboto,Oxygen,Ubuntu,Cantarell,Fira Sans,Droid Sans,Helvetica Neue,Helvetica,sans-serif;font-size:13px;line-height:22px;text-align:left;">';
    $close_div = '</div>';
    $open_div_light = '<div style="cursor:auto;color:#888;font-family:-apple-system,BlinkMacSystemFont,Segoe UI,Roboto,Oxygen,Ubuntu,Cantarell,Fira Sans,Droid Sans,Helvetica Neue,Helvetica,sans-serif;font-size:13px;line-height:22px;text-align:left;">';
    $hr = '<p style="font-size:1px;margin:0px auto;border-top:1px solid #F4F7FA;width:100%;"></p>';
    $ticket_body .= ($ticket_articles) ? '' : $open_div_light . get_email_name($ticket->from) . $close_div . $hr . $open_div . $ticket->text . $close_div;
    foreach ($ticket_articles as $article) {
        $ticket_body .= ($article === reset($ticket_articles)) ? $open_div_title : $open_div_light;
        $ticket_body .= get_email_name($article->from) . ' - ' . date($data['core_settings']->date_format . '  ' . $data['core_settings']->date_time_format, $article->datetime) . $close_div;
        $ticket_body .= $hr;
        $ticket_body .= ($article === reset($ticket_articles)) ? $open_div_title : $open_div_light;
        $ticket_body .= $article->message . $close_div;
        $ticket_body .= '<br/><br/>';
    }
    $ticket_body .= ($ticket_articles) ? '' : '';

    //Set parse values
    $parse_data = [
                      'company' => $data['core_settings']->company,
                      'link' => base_url(),
                      'ticket_link' => $ticket_link,
                      'ticket_number' => $ticket->reference,
                      'ticket_created_date' => date($data['core_settings']->date_format . '  ' . $data['core_settings']->date_time_format, $ticket->created),
                      'ticket_status' => $instance->lang->line('applicatio  n_ticket_status_' . $ticket->status),
                      'logo' => '<img src="' . base_url() . '' . $data['core_settings']->logo . '" alt="' . $data['core_settings']->company . '"/>',
                      'invoice_logo' => '<img src="' . base_url() . '' . $data['core_settings']->invoice_logo . '" alt="' . $data['core_settings']->company . '"/>',
                      'message' => $text,
                      'ticket_body' => $ticket_body,
                      'ticket_subject' => $ticket->subject
                      ];
    $parse_data['client_contact'] = (is_object($ticket->client)) ? $ticket->client->firstname . ' ' . $ticket->client->lastname : '';
    $parse_data['client_firstname'] = (is_object($ticket->client)) ? $ticket->client->firstname : '';
    $parse_data['client_lastname'] = (is_object($ticket->client)) ? $ticket->client->lastname : '';
    $parse_data['client_company'] = (is_object($ticket->client)) ? $ticket->company->name : '';

    $email_invoice = read_file('./application/views/' . $data['core_settings']->template . '/templates/email_ticket_notification.html');
    $message = $instance->parser->parse_string($email_invoice, $parse_data);
    $instance->email->message($message);
    $instance->email->send();
}

function receipt_notification($clientId, $subject = false, $paymentId = false)
{
    $instance = &get_instance();
    $instance->email->clear();
    $instance->load->helper('file');
    $instance->load->library('parser');
    $settings = Setting::first();
    $client = Client::find_by_id($clientId);

    $instance->email->from($settings->email, $settings->company);
    $instance->email->to($client->email);

    //Set parse values
    $parse_data = [
                      'company' => $settings->company,
                      'link' => base_url(),
                      'logo' => '<img src="' . base_url() . '' . $settings->logo . '" alt="' . $settings->company . '"/>',
                      'invoice_logo' => '<img src="' . base_url() . '' . $settings->invoice_logo . '" alt="' . $settings->company . '"/>',
                      'client_firstname' => $client->firstname,
                      'client_lastname' => $client->lastname,
                      'client_company' => $client->company->name,
                      ];
    $subject = $instance->parser->parse_string($settings->receipt_mail_subject, $parse_data);

    $instance->email->subject($subject);

    $email_invoice = read_file('./application/views/' . $settings->template . '/templates/email_receipt.html');
    $message = $instance->parser->parse_string($email_invoice, $parse_data);
    $instance->email->message($message);
    $instance->email->send();
}

function reminder_notification($class, $user = false, $module = false, $reminder = false)
{
    $instance = &get_instance();
    $instance->email->clear();
    $instance->load->helper('file');
    $instance->load->library('parser');
    $settings = Setting::first();
    switch ($class) {
                    case 'Lead':
                        $subject = '[' . $instance->lang->line('application_reminder') . '] ' . $reminder->title;
                        $body = $reminder->body;
                        $parse_body = [
                                        'name' => $module->name,
                                        'address' => $module->address,
                                        'city' => $module->city,
                                        'zipcode' => $module->zipcode,
                                        'owner' => $module->owner,
                                        'phone' => '<a href="tel:' . $module->phone . '">' . $module->phone . '</a>',
                                        'mobile' => '<a href="tel:' . $module->phone . '">' . $module->mobile . '</a>',
                                        'company' => $module->company,
                                        'description' => $module->description,
                                      ];

                        $body = $instance->parser->parse_string($body, $parse_body);

                        $parse_data = [
                                    'first_name' => $user->firstname,
                                    'last_name' => $user->lastname,
                                    'title' => $reminder->title,
                                    'message' => $body,
                                    'datetime' => $reminder->datetime,
                                    'logo' => '<img src="' . base_url() . '' . $settings->logo . '" alt="' . $settings->company . '"/>',
                                    'invoice_logo' => '<img src="' . base_url() . '' . $settings->invoice_logo . '" alt="' . $settings->company . '"/>',
                                    'company' => $settings->company,

                                    'icon' => '<img alt="Lembrete" height="auto" src="' . base_url() . 'assets/blueline/images/bell-circle-red.png" width="70">',
                                    'button_text' => $instance->lang->line('application_go_to_lead'),
                                    'button_link' => base_url() . 'leads/'
                                    ];
                        break;

                    default:
                        // code...
                        break;
                }

    //email
    $instance->email->from($settings->email, $settings->company);
    $instance->email->to($user->email);
    $instance->email->subject($subject);

    $email_template = read_file('./application/views/' . $settings->template . '/templates/email_reminder.html');
    $message = $instance->parser->parse_string($email_template, $parse_data);
    $instance->email->message($message);
    if (!$instance->email->send()) {
        log_message('error', '[notification cronjob] ERROR reminder email could not be sent!');
        log_message('error', $instance->email->print_debugger());
        return false;
    } else {
        log_message('error', "[notification cronjob] Reminder email was sent to $user->firstname successfully!");
        return true;
    }
}
