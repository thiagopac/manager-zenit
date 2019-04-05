<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class messages extends MY_Controller
{


    public function __construct()
    {
        parent::__construct();
        $access = false;
        if ($this->client) {
            redirect('cprojects');
        } elseif ($this->user) {
            foreach ($this->view_data['menu'] as $key => $value) {
                if ($value->link == 'messages') {
                    $access = true;
                }
            }
            if (!$access) {
                redirect('login');
            }
        } else {
            redirect('login');
        }
        $this->view_data['submenu'] = array(
                        $this->lang->line('application_new_messages') => 'messages',
                        $this->lang->line('application_read_messages') => 'messages/filter/read',
                        );
    }
    public function index()
    {
        $this->content_view = 'messages/all';
    }
    public function messagelist($con = false, $deleted = false)
    {
        $max_value = 60;
        if ($deleted == 'deleted') {
            $qdeleted = " AND privatemessages.status = 'deleted' OR privatemessages.deleted = 1 ";
        } else {
            $qdeleted = ' AND privatemessages.deleted = 0 ';
        }

        if (is_numeric($con)) {
            $limit = $con.',';
        } else {
            $limit = false;
        }
        $this->view_data['message'] = Privatemessage::getMessages($limit, $max_value, $qdeleted, $this->user->id);


        if ($deleted) {
            $this->view_data['deleted'] = '/'.$deleted;
        }
        $this->view_data['message_list_page_next'] = $con + $max_value;
        $this->view_data['message_list_page_prev'] = $con - $max_value;
        $this->view_data['filter'] = false;
        $this->theme_view = 'ajax';
        $this->content_view = 'messages/list';
    }
    public function filter($condition = false, $con = false)
    {
        $max_value = 60;
        if (is_numeric($con)) {
            $limit = $con.',';
        } else {
            $limit = false;
        }

        $this->view_data['filter'] = ucfirst($condition);
        $this->view_data['message'] = Privatemessage::getMessagesWithFilter($limit, $max_value, $condition, $this->user->id);

        $this->view_data['message_list_page_next'] = $con + $max_value;
        $this->view_data['message_list_page_prev'] = $con - $max_value;

        $this->theme_view = 'ajax';
        $this->content_view = 'messages/list';
    }

    public function write($ajax = false)
    {
        if ($_POST) {
            $config['upload_path'] = './files/media/';
            $config['encrypt_name'] = true;
            $config['allowed_types'] = '*';

            $this->load->library('upload', $config);
            $this->load->helper('notification');

            unset($_POST['userfile']);
            unset($_POST['file-name']);

            unset($_POST['send']);
            unset($_POST['note-codable']);
            unset($_POST['files']);
            $message = $_POST['message'];
            $receiverart = substr($_POST['recipient'], 0, 1);
            $receiverid = substr($_POST['recipient'], 1, 9999);
            if ($receiverart == 'u') {
                $receiver = User::find($receiverid);
                $receiveremail = $receiver->email;
                $receiverPushActive = $receiver->push_active;
            } else {
                $receiver = Client::find($receiverid);
                $receiveremail = $receiver->email;
                $receiverPushActive = $receiver->push_active;
            }
            $attachment = false;
            if (!$this->upload->do_upload()) {
                $error = $this->upload->display_errors('', ' ');
                if ($error != 'You did not select a file to upload.') {
                    //$this->session->set_flashdata('message', 'error:'.$error);
                }
            } else {
                $data = array('upload_data' => $this->upload->data());
                $_POST['attachment'] = $data['upload_data']['orig_name'];
                $_POST['attachment_link'] = $data['upload_data']['file_name'];
                $attachment = $data['upload_data']['file_name'];
            }


//ONDE CRIA NOVAS MENSAGENS
            $_POST = array_map('htmlspecialchars', $_POST);
            $_POST['message'] = $message;
            $_POST['time'] = date('Y-m-d H:i', time());
            $_POST['sender'] = 'u'.$this->user->id;
            $_POST['status'] = 'New';
            if (!isset($_POST['conversation'])) {
                $_POST['conversation'] = random_string('sha1');
            }
            if (isset($_POST['previousmessage'])) {
                $status = Privatemessage::find_by_id($_POST['previousmessage']);
                if ($receiveremail == $this->user->email) {
                    $receiverart = substr($status->recipient, 0, 1);
                    $receiverid = substr($status->recipient, 1, 9999);
                    $_POST['recipient'] = $status->recipient;

                    if ($receiverart == 'u') {
                        $receiver = User::find($receiverid);
                        $receiveremail = $receiver->email;
                        $receiverPushActive = $receiver->push_active;
                    } else {
                        $receiver = Client::find($receiverid);
                        $receiveremail = $receiver->email;
                        $receiverPushActive = $receiver->push_active;
                    }
                }

                $status->status = 'Replied';
                $status->save();
                unset($_POST['previousmessage']);
            }
            $message = Privatemessage::create($_POST);
            $push_receivers = array();
            if (!$message) {
                $this->session->set_flashdata('message', 'error:'.$this->lang->line('messages_write_message_error'));
            } else {
                $this->session->set_flashdata('message', 'success:'.$this->lang->line('messages_write_message_success'));
                $this->load->helper('notification');

                 // ENVIO DE NOTIFICAÇÃO DE NOVAS MENSAGENS APENAS PARA QUEM NÃO TEM E-MAIL @OWNERGY / ESCONDIDO
                $usermail = $receiveremail;

                list($usermail, $domain) = explode('@', $usermail);

                if ($domain != 'ownergy.com.br') {
                    send_notification($receiveremail, $message->subject, $this->lang->line('application_notification_new_message').'<br><hr style="border-top: 1px solid #CCCCCC; border-left: 1px solid whitesmoke; border-bottom: 1px solid whitesmoke;"/>'.$_POST['message'].'<hr style="border-top: 1px solid #CCCCCC; border-left: 1px solid whitesmoke; border-bottom: 1px solid whitesmoke;"/>', $attachment);
                }

                if ($receiverPushActive == 1) {
                    array_push($push_receivers, $receiveremail);
                    Notification::sendPushNotification($push_receivers, $this->user->firstname . ' te enviou uma mensagem', base_url() . 'messages');
                }
            }

//            var_dump($_POST);

            if ($ajax != 'reply') {
                redirect('messages');
            } else {
                $this->theme_view = 'ajax';
            }
        } else {
            if ($this->user->admin != 1) {
                $comp_array = array();
                $thisUserHasNoCompanies = (array) $this->user->companies;
                if (!empty($thisUserHasNoCompanies)) {
                    foreach ($this->user->companies as $value) {
                        array_push($comp_array, $value->id);
                    }
                    $this->view_data['clients'] = Client::find('all', array('conditions' => array('inactive=? AND company_id in (?)', '0', $comp_array)));
                } else {
                    $this->view_data['clients'] = (object) array();
                }
            } else {
                $this->view_data['clients'] = Client::find('all', array('conditions' => array('inactive=?', '0')));
            }

            $this->view_data['users'] = User::find('all', array('conditions' => array('status=?', 'active')));
            $this->theme_view = 'modal';
            $this->view_data['title'] = $this->lang->line('application_write_message');
            $this->view_data['form_action'] = 'messages/write';
            $this->content_view = 'messages/_messages';
        }
    }
    public function update($id = false, $getview = false)
    {
        if ($_POST) {
            unset($_POST['send']);
            unset($_POST['_wysihtml5_mode']);
            unset($_POST['files']);
            $id = $_POST['id'];
            $message = Privatemessage::find($id);
            $message->update_attributes($_POST);
            if (!$message) {
                $this->session->set_flashdata('message', 'error:'.$this->lang->line('messages_write_message_error'));
            } else {
                $this->session->set_flashdata('message', 'success:'.$this->lang->line('messages_write_message_success'));
            }
            if (isset($view)) {
                redirect('messages/view/'.$id);
            } else {
                redirect('messages');
            }
        } else {
            $this->view_data['id'] = $id;
            $this->theme_view = 'modal';
            $this->view_data['title'] = $this->lang->line('application_edit_message');
            $this->view_data['form_action'] = 'messages/update';
            $this->content_view = 'messages/_messages_update';
        }
    }
    public function delete($id = false)
    {
        $message = Privatemessage::find_by_id($id);
        $message->status = 'deleted';
        $message->deleted = '1';
        $message->save();

        $this->content_view = 'messages/all';
        if (!$message) {
            $this->session->set_flashdata('message', 'error:'.$this->lang->line('messages_delete_message_error'));
        } else {
            $this->session->set_flashdata('message', 'success:'.$this->lang->line('messages_delete_message_success'));
        }
        redirect('messages');
    }
    public function mark($id = false)
    {
        $message = Privatemessage::find_by_id($id);
        if ($message->status == 'Marked') {
            $message->status = 'Read';
        } else {
            $message->status = 'Marked';
        }
        $message->save();
        $this->content_view = 'messages/all';
    }
    public function attachment($id = false)
    {
        $this->load->helper('download');
        $this->load->helper('file');

        $attachment = Privatemessage::find_by_id($id);

        $file = './files/media/'.$attachment->attachment_link;
        $mime = get_mime_by_extension($file);

        if (file_exists($file)) {
            header('Content-Description: File Transfer');
            header('Content-Type: '.$mime);
            header('Content-Disposition: attachment; filename='.basename($attachment->attachment));
            header('Content-Transfer-Encoding: binary');
            header('Expires: 0');
            header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
            header('Pragma: public');
            header('Content-Length: '.filesize($file));
            readfile($file);
            ob_clean();
            flush();
            exit;
        }
    }
    public function view($id = false, $filter = false, $additional = false)
    {
        $this->view_data['submenu'] = array(
                        $this->lang->line('application_back') => 'messages',
                        );
        $message = Privatemessage::find_by_id($id);
        $this->view_data['count'] = '1';
        if (!$filter || $filter == 'Marked') {
            if ($message->status == 'New') {
                $message->status = 'Read';
                $message->save();
            }
            $this->view_data['filter'] = false;
            $stringQuery = 'SELECT privatemessages.id, privatemessages.conversation FROM privatemessages
        				WHERE privatemessages.recipient = "u'.$this->user->id.'" AND privatemessages.`id`="'.$id.'"';
            $row = Privatemessage::find_by_sql($stringQuery);

            $stringQuery = 'SELECT privatemessages.id, privatemessages.`status`, privatemessages.`deleted`, privatemessages.`receiver_delete`, privatemessages.conversation, privatemessages.attachment, privatemessages.attachment_link, privatemessages.subject, privatemessages.message, privatemessages.sender, privatemessages.recipient, privatemessages.`time`, privatemessages.`sender` , clients.`userpic` as userpic_c, users.`userpic` as userpic_u , users.`email` as email_u , clients.`email` as email_c , CONCAT(users.firstname," ", users.lastname) as sender_u, CONCAT(clients.firstname," ", clients.lastname) as sender_c, CONCAT(rec_u.firstname," ", rec_u.lastname) as recipient_u, CONCAT(rec_c.firstname," ", rec_c.lastname) as recipient_c
        				FROM privatemessages
        				LEFT JOIN clients ON CONCAT("c",clients.id) = privatemessages.sender
        				LEFT JOIN users ON CONCAT("u",users.id) = privatemessages.sender
        				LEFT JOIN clients AS rec_c ON CONCAT("c",rec_c.id) = privatemessages.recipient
        				LEFT JOIN users AS rec_u ON CONCAT("u",rec_u.id) = privatemessages.recipient

        				WHERE privatemessages.conversation = "'.$row[0]->conversation.'" ORDER BY privatemessages.`id` DESC LIMIT 100';
            $query2 = Privatemessage::find_by_sql($stringQuery);

            $this->view_data['conversation'] = array_filter($query2);

            $this->view_data['count'] = count($this->view_data['conversation']);
        } else {
            if ($message->status == 'deleted') {
                $stringQuery = 'SELECT privatemessages.id, privatemessages.`status`, privatemessages.`deleted`, privatemessages.`receiver_delete`, privatemessages.conversation, privatemessages.attachment, privatemessages.attachment_link, privatemessages.subject, privatemessages.message, privatemessages.sender, privatemessages.recipient, privatemessages.`time`, privatemessages.`sender` , clients.`userpic` as userpic_c, users.`userpic` as userpic_u , users.`email` as email_u , clients.`email` as email_c , CONCAT(users.firstname," ", users.lastname) as sender_u, CONCAT(clients.firstname," ", clients.lastname) as sender_c, CONCAT(rec_u.firstname," ", rec_u.lastname) as recipient_u, CONCAT(rec_c.firstname," ", rec_c.lastname) as recipient_c
        				FROM privatemessages
        				LEFT JOIN clients ON CONCAT("c",clients.id) = privatemessages.sender
        				LEFT JOIN users ON CONCAT("u",users.id) = privatemessages.sender
        				LEFT JOIN clients AS rec_c ON CONCAT("c",rec_c.id) = privatemessages.recipient
        				LEFT JOIN users AS rec_u ON CONCAT("u",rec_u.id) = privatemessages.recipient
        				WHERE privatemessages.conversation = "'.$message->conversation.'" ORDER BY privatemessages.`id` DESC LIMIT 100';
//                WHERE privatemessages.id = "'.$id.'" AND privatemessages.recipient = "u'.$this->user->id.'" ORDER BY privatemessages.`id` DESC LIMIT 100';
//                LEFT JOIN users ON (CONCAT("u",users.id) = privatemessages.sender) OR (CONCAT("u",users.id) = privatemessages.recipient)
                $sql = Privatemessage::find_by_sql($stringQuery);
            } else {
                if ($filter == 'Sent') {
                    $stringQuery = 'SELECT privatemessages.id, privatemessages.`status`, privatemessages.`deleted`, privatemessages.`receiver_delete`, privatemessages.conversation, privatemessages.attachment, privatemessages.attachment_link, privatemessages.subject, privatemessages.message, privatemessages.sender, privatemessages.recipient, privatemessages.`time`, privatemessages.`sender` , clients.`userpic` as userpic_c, users.`userpic` as userpic_u , users.`email` as email_u , clients.`email` as email_c , CONCAT(users.firstname," ", users.lastname) as sender_u, CONCAT(clients.firstname," ", clients.lastname) as sender_c, CONCAT(users.firstname," ", users.lastname) as recipient_u, CONCAT(clients.firstname," ", clients.lastname) as recipient_c
        				FROM privatemessages
        				LEFT JOIN clients ON CONCAT("c",clients.id) = privatemessages.recipient OR CONCAT("c",clients.id) = privatemessages.sender
        				LEFT JOIN users ON CONCAT("u",users.id) = privatemessages.sender
        				WHERE privatemessages.id = "'.$id.'" AND privatemessages.sender = "u'.$this->user->id.'" ORDER BY privatemessages.`id` DESC LIMIT 100';
//                    LEFT JOIN users ON  CONCAT("u",users.id) = privatemessages.recipient OR CONCAT("u",users.id) = privatemessages.senders
                    $sql = Privatemessage::find_by_sql($stringQuery);

                    $receiverart = substr($additional, 0, 1);
                    $receiverid = substr($additional, 1, 9999);

                    if ($receiverart == 'u') {
                        $receiver = User::find_by_id($receiverid);
                        $this->view_data['recipient'] = $receiver->firstname.' '.$receiver->lastname;
                    } else {
                        $receiver = Client::find_by_id($receiverid);
                        $this->view_data['recipient'] = $receiver->firstname.' '.$receiver->lastname;
                    }
                } else {
                    $stringQuery = 'SELECT privatemessages.id, privatemessages.`status`, privatemessages.`deleted`, privatemessages.`receiver_delete`, privatemessages.conversation, privatemessages.attachment, privatemessages.attachment_link, privatemessages.subject, privatemessages.message, privatemessages.sender, privatemessages.recipient, privatemessages.`time`, privatemessages.`sender` , clients.`userpic` as userpic_c, users.`userpic` as userpic_u , users.`email` as email_u , clients.`email` as email_c , CONCAT(users.firstname," ", users.lastname) as sender_u, CONCAT(clients.firstname," ", clients.lastname) as sender_c, CONCAT(users.firstname," ", users.lastname) as recipient_u, CONCAT(clients.firstname," ", clients.lastname) as recipient_c
        				FROM privatemessages
        				LEFT JOIN clients ON (CONCAT("c",clients.id) = privatemessages.sender) OR (CONCAT("c",clients.id) = privatemessages.recipient)
        				LEFT JOIN users ON (CONCAT("u",users.id) = privatemessages.sender) OR (CONCAT("u",users.id) = privatemessages.recipient)
        				WHERE privatemessages.id = "'.$id.'" AND (privatemessages.sender = "u'.$this->user->id.'" OR privatemessages.recipient = "u'.$this->user->id.'") ORDER BY privatemessages.`id` DESC LIMIT 100';
                    $sql = Privatemessage::find_by_sql($stringQuery);
                }
            }

//            echo $stringQuery;

            $query = $sql;

            $this->view_data['conversation'] = array_filter($query);
            $this->view_data['filter'] = $filter;
            $this->view_data['count'] = count($this->view_data['conversation']);
        }
        $this->theme_view = 'ajax';
        $this->view_data['form_action'] = 'messages/write';
        $this->view_data['id'] = $id;
        $this->content_view = 'messages/view';
    }
}
