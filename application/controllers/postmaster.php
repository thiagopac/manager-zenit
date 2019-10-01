<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Postmaster extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $blacklist = (file_exists('./files/blacklist.txt')) ? file_get_contents('./files/blacklist.txt') : '';

        $this->load->helper('notification');
        $puriconfig = HTMLPurifier_Config::createDefault();
        $purifier = new HTMLPurifier($puriconfig);

        $this->load->helper('string');
        $emailconfig = Setting::first();
        $settings = $emailconfig;
        if ($emailconfig->ticket_config_active == '1') {
            $emailconfig->ticket_config_timestamp = time();
            $emailconfig->save();

            // this shows basic IMAP, no TLS required
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

            $this->load->library('peeker', $config);
            //attachment folder
            $bool = $this->peeker->set_attachment_dir('files/media/');
            //Search Filter
            $this->peeker->set_search($emailconfig->ticket_config_search);

            if ($this->peeker->search_and_count_messages() != '0') {
                log_message('error', 'Postmaster fetched ' . $this->peeker->search_and_count_messages() . ' new email tickets.');

                $id_array = $this->peeker->get_ids_from_search();
                //walk trough emails
                foreach ($id_array as $email_id) {
                    $ticket = false;
                    $email = $this->peeker->get_message($email_id);
                    $email->rewrite_html_transform_img_tags('files/media/');
                    $queue = $settings->ticket_default_queue;

                    /* Check if Queue header is set */
                    if (isset($email->header_array['fc2-queue'])) {
                        $queueHeader = $email->header_array['fc2-queue'];
                        $queueQuery = Queue::find_by_id($queueHeader);
                        if ($queueQuery) {
                            $queue = $queueHeader;
                        }
                    }
                    /* Convert only plain email to HTML */
                    if ($email->has_PLAIN_not_HTML()) {
                        $email->put_PLAIN_into_HTML();
                    }
                    echo '';

                    /* Check if encoding is UTF-8 and convert if it's not */
                    if (mb_detect_encoding($email->get_html(), 'UTF-8', true)) {
                        $emailbody = mb_convert_encoding($email->get_html(), 'UTF-8');
                    } else {
                        $emailbody = utf8_encode((nl2br($email->get_html())));
                    }
                    /* Remove unwanted html */
                    $emailbody = $purifier->purify($emailbody);

                    /* Set sender and host */
                    $emailaddr = $email->get_from_array();
                    $emailHost = $emailaddr[0]->host;
                    $emailaddr = $emailaddr[0]->mailbox . '@' . $emailHost;

                    /* Cancel if email host is on Blacklist */
                    $blocked = stripos($blacklist, $emailHost);
                    if ($blocked !== false) {
                        log_message('error', 'Fetched email was declined. Sender address (' . $emailHost . ') is listed on blacklist. (' . htmlspecialchars($email->get_subject()) . ')');
                        continue;
                    }

                    /* Check if Reply to is set */
                    if ($email->get_reply_to() != $emailaddr) {
                        if (valid_email($email->get_reply_to())) {
                            $emailaddr = $email->get_reply_to();
                        }
                    }
                    /* get next ticket number */
                    $ticket_reference = $settings->ticket_reference;
                    $settings->ticket_reference = $settings->ticket_reference + 1;
                    $settings->save();

                    /* Check if email subject contains ticket number */
                    if (preg_match('/\[Ticket\#([^\]]+)]/is', $email->get_subject(), $matches)) {
                        $ticket = Ticket::find_by_reference($matches[1]);
                    }

                    /* Ticket number found so email will be merged into existing ticket */
                    if ($ticket) {
                        log_message('error', 'Fetched email merged to ticket #' . $matches[1]);
                        $article_attributes = [
                                        'ticket_id' => $ticket->id,
                                        'internal' => '0',
                                        'from' => $email->get_from() . ' - ' . $emailaddr,
                                        'reply_to' => $emailaddr,
                                        'to' => $email->get_to(),
                                        'cc' => $email->get_cc(),
                                        'subject' => htmlspecialchars($email->get_subject()),
                                        'message' => strip_quotes_from_message($emailbody),
                                        'datetime' => time(),
                                        'raw' => $email->get_header_string() . '\n \n' . $email->get_body_string()
                                ];
                        if ($ticket->status == 'closed') {
                            $ticket->status = 'reopened';
                            $ticket->updated = '1';
                            $ticket->save();
                        }
                        $ticket->updated = '1';
                        $ticket->save();
                        $article = TicketArticle::create($article_attributes);

                        //Attachments
                        $parts = $email->get_parts_array();
                        $email_attachment = [];
                        if ($email->has_attachment()) {
                            foreach ($parts as $part) {
                                $savename = $email->get_fingerprint() . random_string('alnum', 8) . $part->get_filename();
                                $savename = str_replace(' ', '_', $savename);
                                $savename = str_replace('%20', '_', $savename);
                                $savename = preg_replace("([^\w\s\d\-_~,;:\[\]\(\).])", '', $savename);
                                // Remove any runs of periods
                                $savename = preg_replace("([\.]{2,})", '', $savename);
                                $orgname = $part->get_filename();
                                $orgname = str_replace(' ', '_', $orgname);
                                $orgname = str_replace('%20', '_', $orgname);
                                $part->filename = $savename;
                                $attributes = ['article_id' => $article->id, 'filename' => $orgname, 'savename' => $savename];
                                $attachment = ArticleAttachment::create($attributes);
                                $email_attachment[] = 'files/media/' . $savename;
                            }
                            $email->save_all_attachments('files/media/');
                        }

                        if (is_object($ticket->user)) {
                            send_ticket_notification($ticket->user->email, '[Ticket#' . $ticket->reference . '] - ' . $ticket->subject, strip_quotes_from_message($emailbody), $ticket->id, $email_attachment);
                        }

                        /* No ticket number found so new ticket will be created */
                    } else {
                        //Ticket Attributes
                        $ticket_attributes = [
                                        'reference' => $ticket_reference,
                                        'from' => $email->get_from() . ' - ' . $emailaddr,
                                        'subject' => $email->get_subject(),
                                        'text' => $emailbody,
                                        'updated' => '1',
                                        'created' => time(),
                                        'user_id' => $settings->ticket_default_owner,
                                        'type_id' => $settings->ticket_default_type,
                                        'status' => $settings->ticket_default_status,
                                        'queue_id' => $queue,
                                        'raw' => $email->get_header_string() . ' ' . $email->get_body_string()
                                    ];

                        //check if sender is client
                        $client = Client::find_by_email_and_inactive($emailaddr, 0);
                        if (isset($client)) {
                            $ticket_attributes['client_id'] = $client->id;
                            $ticket_attributes['company_id'] = $client->company->id;
                        }

                        //create Ticket
                        $ticket = Ticket::create($ticket_attributes);

                        //Attachments
                        $parts = $email->get_parts_array();
                        $email_attachment = [];
                        if ($email->has_attachment()) {
                            foreach ($parts as $part) {
                                $savename = $email->get_fingerprint() . random_string('alnum', 8) . $part->get_filename();
                                $savename = str_replace(' ', '_', $savename);
                                $savename = str_replace('%20', '_', $savename);
                                $savename = preg_replace("([^\w\s\d\-_~,;:\[\]\(\).])", '', $savename);
                                // Remove any runs of periods
                                $savename = preg_replace("([\.]{2,})", '', $savename);
                                $orgname = $part->get_filename();
                                $orgname = str_replace(' ', '_', $orgname);
                                $orgname = str_replace('%20', '_', $orgname);
                                $part->filename = $savename;
                                $attributes = ['ticket_id' => $ticket->id, 'filename' => $orgname, 'savename' => $savename];
                                $attachment = TicketAttachment::create($attributes);
                                $email_attachment[] = 'files/media/' . $savename;
                            }
                            $email->save_all_attachments('files/media/');
                        }

                        send_ticket_notification($ticket->user->email, '[Ticket#' . $ticket->reference . '] - ' . $ticket->subject, $emailbody, $ticket->id, $email_attachment);

                        log_message('error', 'New ticket created #' . $ticket->reference);
                    }

                    if ($emailconfig->ticket_config_delete == '1') {
                        $email->set_delete();
                        $email->expunge();
                        $this->peeker->delete_and_expunge($email_id);
                    }
                }
            }

            $this->peeker->close();

            // tell the story of the connection (only for debuging)
            //echo "<pre>"; print_r($this->peeker->trace()); echo "</pre>";
        }
        die();
    }
}
