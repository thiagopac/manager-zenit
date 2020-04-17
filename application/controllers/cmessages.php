<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class cMessages extends MY_Controller {

	function __construct()
	{
		parent::__construct();
		$access = FALSE;
		if($this->user){
			redirect('messages');
		}elseif($this->client){
			foreach ($this->view_data['menu'] as $key => $value) {
				if($value->link == "cmessages"){ $access = TRUE;}
			}
			if(!$access){redirect('login');}
		}else{
			redirect('login');
		}
		$this->view_data['submenu'] = array(
				 		$this->lang->line('application_new_messages') => 'cmessages',
				 		$this->lang->line('application_read_messages') => 'cmessages/filter/read',
				 		);

	}
	function index()
	{
		$this->content_view = 'messages/client/all';
	}
	function messagelist($con = FALSE, $deleted = FALSE)
	{
		$max_value = 60;
        if ($deleted == 'deleted') {
            $qdeleted = " AND private_message.status = 'deleted' OR private_message.deleted = 1 ";
        } else {
            $qdeleted = ' AND private_message.status != "deleted" AND private_message.deleted = 0 ';
        }

        if (is_numeric($con)) {
            $limit = $con . ',';
        } else {
            $limit = false;
        }
        $this->view_data['message'] = PrivateMessage::getMessages($limit, $max_value, $qdeleted, $this->client->id, true);

        if ($deleted) {
            $this->view_data['deleted'] = '/' . $deleted;
        }
        $this->view_data['message_list_page_next'] = $con + $max_value;
        $this->view_data['message_list_page_prev'] = $con - $max_value;
        $this->view_data['filter'] = false;
        $this->theme_view = 'ajax';

		$this->content_view = 'messages/client/list';
	}
	function filter($condition = FALSE, $con = FALSE)
	{
	$max_value = 60;
        if (is_numeric($con)) {
            $limit = $con . ',';
        } else {
            $limit = false;
        }

        $this->view_data['filter'] = ucfirst($condition);
        $this->view_data['message'] = PrivateMessage::getMessagesWithFilter($limit, $max_value, $condition, $this->client->id, true);

        $this->view_data['message_list_page_next'] = $con + $max_value;
        $this->view_data['message_list_page_prev'] = $con - $max_value;


	    $this->theme_view = 'ajax';

		$this->content_view = 'messages/client/list';
	}
	function write($ajax = FALSE)
	{
		if($_POST){

			$config['upload_path'] = './files/media/';
			$config['encrypt_name'] = TRUE;
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
			if( $receiverart == "u"){
				$receiver = User::find($receiverid);
				$receiveremail = $receiver->email;
                $receiverPushActive = $receiver->push_active;
			}
			$_POST = array_map('htmlspecialchars', $_POST);
			$_POST['message'] = $message;
			$_POST['time'] = date('Y-m-d H:i', time());
			$_POST['sender'] = "c".$this->client->id;
			$_POST['status'] = "New";

			if ( ! $this->upload->do_upload())
						{
							$error = $this->upload->display_errors('', ' ');

							if($error != "You did not select a file to upload."){
								//$this->session->set_flashdata('message', 'error:'.$error);
						}
						}
						else
						{
							$data = array('upload_data' => $this->upload->data());
							$_POST['attachment'] = $data['upload_data']['orig_name'];
							$_POST['attachment_link'] = $data['upload_data']['file_name'];

						}

			if(!isset($_POST['conversation'])){$_POST['conversation'] = random_string('alnum', 32);}
			if(isset($_POST['previousmessage'])){
			    $status = PrivateMessage::find_by_id($_POST['previousmessage']);
			    if($receiveremail == $this->client->email){
					$receiverart = substr($status->recipient, 0, 1);
					$receiverid = substr($status->recipient, 1, 9999);
					$_POST['recipient'] = $status->recipient;

					if( $receiverart == "u"){
						$receiver = User::find($receiverid);
						$receiveremail = $receiver->email;
                        $receiverId = $receiver->id;
                        $receiverPushActive = $receiver->push_active;
					}
				}
        		$status->status = 'Replied';
        		$status->save();
        		unset($_POST['previousmessage']);
			}
			$message = PrivateMessage::create($_POST);
            $push_receivers = array();
            if(!$message){$this->session->set_flashdata('message', 'error:'.$this->lang->line('messages_write_message_error'));}
       		else{
       				$this->session->set_flashdata('message', 'success:'.$this->lang->line('messages_write_message_success'));
       				$this->load->helper('notification');
//       				send_notification($receiveremail, $message->subject, $this->lang->line('application_notification_new_message').'<br><hr style="border-top: 1px solid #CCCCCC; border-left: 1px solid whitesmoke; border-bottom: 1px solid whitesmoke;"/>'.$_POST['message'].'<hr style="border-top: 1px solid #CCCCCC; border-left: 1px solid whitesmoke; border-bottom: 1px solid whitesmoke;"/>');

                    $attributes = array('user_id' => $receiverId, 'message' => $this->lang->line('application_notification_new_message').' de <b>'.$this->client->firstname.'</b>', 'url' => base_url().'messages');
                    Notification::create($attributes);

                    if ($receiverPushActive == 1) {
                        array_push($push_receivers, $receiveremail);
                        Notification::sendPushNotification($push_receivers, $this->client->firstname . ' te enviou uma mensagem', base_url() . 'messages');
                    }


            }
			if($ajax != "reply"){ redirect('cmessages'); }else{
					$this->theme_view = 'ajax';
				}
		}else
		{
			$this->view_data['users'] = $this->client->company->user; // User::find('all',array('conditions' => array('status=?','active')));
			$this->theme_view = 'modal';
			$this->view_data['title'] = $this->lang->line('application_write_message');
			$this->view_data['form_action'] = 'cmessages/write';
			$this->content_view = 'messages/client/_messages';
		}
	}
	function update($id = FALSE, $getview = FALSE)
	{
		if($_POST){
			unset($_POST['send']);
			unset($_POST['_wysihtml5_mode']);
			unset($_POST['files']);
			$id = $_POST['id'];
			$message = PrivateMessage::find($id);
			$message->update_attributes($_POST);
       		if(!$message){$this->session->set_flashdata('message', 'error:'.$this->lang->line('messages_write_message_error'));}
       		else{$this->session->set_flashdata('message', 'success:'.$this->lang->line('messages_write_message_success'));}
			if(isset($view)){redirect('cmessages/view/'.$id);}else{redirect('cmessages');}

		}else
		{
			$this->view_data['id'] = $id;
			$this->theme_view = 'modal';
			$this->view_data['title'] = $this->lang->line('application_edit_message');
			$this->view_data['form_action'] = 'cmessages/update';
			$this->content_view = 'messages/client/_messages_update';
		}
	}
	function delete($id = FALSE)
	{
		$message = PrivateMessage::find_by_id($id);
		$message->status = 'deleted';
		$message->deleted = '1';
		$message->save();
		$this->content_view = 'messages/all';
		if(!$message){$this->session->set_flashdata('message', 'error:'.$this->lang->line('messages_delete_message_error'));}
       		else{$this->session->set_flashdata('message', 'success:'.$this->lang->line('messages_delete_message_success'));}
			redirect('cmessages');
	}
	function attachment($id = FALSE){
				$this->load->helper('download');
				$this->load->helper('file');

		$attachment = PrivateMessage::find_by_id($id);

		$file = './files/media/'.$attachment->attachment_link;
		$mime = get_mime_by_extension($file);

		if(file_exists($file)) {
            header('Content-Description: File Transfer');
            header('Content-Type: '.$mime);
            header('Content-Disposition: attachment; filename='.basename($attachment->attachment));
            header('Content-Transfer-Encoding: binary');
            header('Expires: 0');
            header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
            header('Pragma: public');
            header('Content-Length: ' . filesize($file));
            readfile($file);
            ob_clean();
            flush();
            exit;
        }
	}
	function view($id = FALSE, $filter = FALSE, $additional = FALSE)
	{
		$this->view_data['submenu'] = array(
						$this->lang->line('application_back') => 'messages',
				 		);
		$message = PrivateMessage::find_by_id($id);
		$this->view_data["count"] = "1";
		if(!$filter){
            		if($message->status == "New"){
            			$message->status = 'Read';
            			$message->save();
            		}
        		$this->view_data["filter"] = FALSE;
        		$query = PrivateMessage::find_by_sql('SELECT private_message.id, private_message.conversation FROM private_message
        				WHERE private_message.recipient = "c'.$this->client->id.'" AND private_message.`id`="'.$id.'"');

        		$row = $query[0];
        		$query2 = PrivateMessage::find_by_sql('SELECT private_message.id, private_message.`status`, private_message.conversation, private_message.attachment, private_message.attachment_link, private_message.subject, private_message.message, private_message.sender, private_message.recipient, private_message.`time`, private_message.`sender` , client.`userpic` as userpic_c, user.`userpic` as userpic_u , user.`email` as email_u , client.`email` as email_c , CONCAT(user.firstname," ", user.lastname) as sender_u, CONCAT(client.firstname," ", client.lastname) as sender_c, CONCAT(rec_u.firstname," ", rec_u.lastname) as recipient_u, CONCAT(rec_c.firstname," ", rec_c.lastname) as recipient_c
        				FROM private_message
        				LEFT JOIN client ON CONCAT("c",client.id) = private_message.sender
        				LEFT JOIN user ON CONCAT("u",user.id) = private_message.sender
        				LEFT JOIN client AS rec_c ON CONCAT("c",rec_c.id) = private_message.recipient
        				LEFT JOIN user AS rec_u ON CONCAT("u",rec_u.id) = private_message.recipient

        				GROUP by private_message.id HAVING private_message.conversation = "'.$row->conversation.'" ORDER BY private_message.`id` DESC LIMIT 100');


        		$this->view_data["conversation"] = array_filter($query2);
        		$this->view_data["count"] = count($this->view_data["conversation"]);
		    }else{
		        if($message->status == 'deleted'){
		        $sql = PrivateMessage::find_by_sql('SELECT private_message.id, private_message.`status`, private_message.conversation, private_message.attachment, private_message.attachment_link, private_message.subject, private_message.message, private_message.sender, private_message.recipient, private_message.`time`, private_message.`sender` , client.`userpic` as userpic_c, user.`userpic` as userpic_u , user.`email` as email_u , client.`email` as email_c , CONCAT(user.firstname," ", user.lastname) as sender_u, CONCAT(client.firstname," ", client.lastname) as sender_c, CONCAT(user.firstname," ", user.lastname) as recipient_u, CONCAT(client.firstname," ", client.lastname) as recipient_c
        				FROM private_message
        				LEFT JOIN client ON (CONCAT("c",client.id) = private_message.sender) OR (CONCAT("c",client.id) = private_message.recipient)
        				LEFT JOIN user ON (CONCAT("u",user.id) = private_message.sender) OR (CONCAT("u",user.id) = private_message.recipient)
        				GROUP by private_message.id HAVING private_message.id = "'.$id.'" AND private_message.recipient = "c'.$this->client->id.'" ORDER BY private_message.`id` DESC LIMIT 100');

		        }else{
		        	if($filter == "Sent"){
		        		 $sql = PrivateMessage::find_by_sql('SELECT private_message.id, private_message.`status`, private_message.conversation, private_message.attachment, private_message.attachment_link, private_message.subject, private_message.message, private_message.sender, private_message.recipient, private_message.`time`, private_message.`sender` , client.`userpic` as userpic_c, user.`userpic` as userpic_u , user.`email` as email_u , client.`email` as email_c , CONCAT(user.firstname," ", user.lastname) as sender_u, CONCAT(client.firstname," ", client.lastname) as sender_c, CONCAT(user.firstname," ", user.lastname) as recipient_u, CONCAT(client.firstname," ", client.lastname) as recipient_c
        				FROM private_message
        				LEFT JOIN client ON CONCAT("c",client.id) = private_message.recipient OR CONCAT("c",client.id) = private_message.sender
        				LEFT JOIN user ON  CONCAT("u",user.id) = private_message.recipient OR CONCAT("u",user.id) = private_message.sender
        				GROUP by private_message.id HAVING private_message.id = "'.$id.'" AND private_message.sender = "c'.$this->client->id.'" ORDER BY private_message.`id` DESC LIMIT 100');

							$receiverart = substr($additional, 0, 1);
							$receiverid = substr($additional, 1, 9999);

							if( $receiverart == "u"){
								$receiver = User::find_by_id($receiverid);
								$this->view_data["recipient"] = $receiver->firstname.' '.$receiver->lastname;

							}else{
								$receiver = Client::find_by_id($receiverid);
								$this->view_data["recipient"] = $receiver->firstname.' '.$receiver->lastname;
							}

		        	}else{
					        $sql = PrivateMessage::find_by_sql('SELECT private_message.id, private_message.`status`, private_message.conversation, private_message.attachment, private_message.attachment_link, private_message.subject, private_message.message, private_message.sender, private_message.recipient, private_message.`time`, private_message.`sender` , client.`userpic` as userpic_c, user.`userpic` as userpic_u , user.`email` as email_u , client.`email` as email_c , CONCAT(user.firstname," ", user.lastname) as sender_u, CONCAT(client.firstname," ", client.lastname) as sender_c, CONCAT(user.firstname," ", user.lastname) as recipient_u, CONCAT(client.firstname," ", client.lastname) as recipient_c
			        				FROM private_message
			        				LEFT JOIN client ON (CONCAT("c",client.id) = private_message.sender) OR (CONCAT("c",client.id) = private_message.recipient)
			        				LEFT JOIN user ON (CONCAT("u",user.id) = private_message.sender) OR (CONCAT("u",user.id) = private_message.recipient)
			        				GROUP by private_message.id HAVING private_message.id = "'.$id.'" AND private_message.sender = "c'.$this->client->id.'" ORDER BY private_message.`id` DESC LIMIT 100');
					      }
		        }
        		$query = $sql;

		        $this->view_data["conversation"] = array_filter($query);
		        $this->view_data["filter"] = $filter;
		    }
		$this->theme_view = 'ajax';
		$this->view_data['form_action'] = 'cmessages/write';
		$this->view_data['id'] = $id;
		$this->content_view = 'messages/client/view';
	}

}
