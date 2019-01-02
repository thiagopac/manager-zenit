<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class cTickets extends MY_Controller {

	function __construct()
	{
		parent::__construct();
		$access = FALSE;
		if($this->client){
			foreach ($this->view_data['menu'] as $key => $value) {
				if($value->link == "ctickets"){ $access = TRUE;}
			}
			if(!$access && !empty($this->view_data['menu'][0])){
				redirect($this->view_data['menu'][0]->link);
			}elseif(empty($this->view_data['menu'][0])){
				$this->view_data['error'] = "true";
				$this->session->set_flashdata('message', 'error: You have no access to any modules!');
				redirect('login');
			}
		}elseif($this->user){
				redirect('tickets');
		}else{
			redirect('login');
		}

		$this->view_data['submenu'] = array(

				 		$this->lang->line('application_open_tickets') => 'ctickets',
				 		$this->lang->line('application_closed_tickets') => 'ctickets/filter/closed'
				 		);

	}
	function index()
	{
		$options = array('conditions' => 'status != "closed" AND company_id = '.$this->client->company_id);
		$this->view_data['ticket'] = Ticket::all($options);
		$this->content_view = 'tickets/client_views/all';
	}
	function filter($condition)
	{
		switch ($condition) {
			case 'open':
				$options = array('conditions' => 'status != "closed" AND company_id = '.$this->client->comapny_id);
				break;
			case 'closed':
				$options = array('conditions' => 'status = "closed" AND company_id = '.$this->client->company_id);
				break;
		}

		$this->view_data['ticket'] = Ticket::all($options);
		$this->content_view = 'tickets/client_views/all';
	}
	function create()
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
			unset($_POST['_wysihtml5_mode']);
			unset($_POST['files']);
			$settings = Setting::first();
			$client = Client::find_by_id($this->client->id);
			$user = User::find_by_id($settings->ticket_default_owner);
			$_POST['from'] = $client->firstname.' '.$client->lastname.' - '.$client->email;
			$_POST['company_id'] = $client->company->id;
			$_POST['client_id'] = $client->id;
			$_POST['user_id'] = $settings->ticket_default_owner;
			$_POST['queue_id'] = $settings->ticket_default_queue;
			$_POST['type_id'] = $settings->ticket_default_type;
			$_POST['status'] = $settings->ticket_default_status;
			$_POST['created'] = time();
			$_POST['subject'] = htmlspecialchars($_POST['subject']);
			$ticket_reference = Setting::first();
			$_POST['reference'] = $ticket_reference->ticket_reference;
			$ticket = Ticket::create($_POST);
			$new_ticket_reference = $_POST['reference']+1;
			$ticket_reference->update_attributes(array('ticket_reference' => $new_ticket_reference));
			$email_attachment = FALSE;
			if ( ! $this->upload->do_upload())
						{
							$error = $this->upload->display_errors('', ' ');
							$this->session->set_flashdata('message', 'error:'.$error);

						}
						else
						{
							$data = array('upload_data' => $this->upload->data());

							$attributes = array('ticket_id' => $ticket->id, 'filename' => $data['upload_data']['orig_name'], 'savename' => $data['upload_data']['file_name']);
							$attachment = TicketHasAttachment::create($attributes);
							$email_attachment = $data['upload_data']['file_name'];
						}


       		if(!$ticket){$this->session->set_flashdata('message', 'error:'.$this->lang->line('messages_create_ticket_error'));
       					redirect('ctickets');
       					}
       		else{$this->session->set_flashdata('message', 'success:'.$this->lang->line('messages_create_ticket_success'));

  				if(isset($user->email) && isset($ticket->reference)){
					send_ticket_notification($user->email, '[Ticket#'.$ticket->reference.'] - '.$_POST['subject'], $_POST['text'], $ticket->id, $email_attachment);
				}
				if(isset($client->email) && isset($ticket->reference)){
					send_ticket_notification($client->email, '[Ticket#'.$ticket->reference.'] - '.$_POST['subject'], $_POST['text'], $ticket->id, $email_attachment);
				}


       			redirect('ctickets/view/'.$ticket->id);
       			}

		}else
		{
			$this->theme_view = 'modal';
			$this->view_data['title'] = $this->lang->line('application_create_ticket');
			$this->view_data['form_action'] = 'ctickets/create';
			$this->content_view = 'tickets/client_views/_ticket';
		}
	}
	function view($id = FALSE)
	{
		$this->load->helper('file');

		$this->view_data['submenu'] = array();
		$this->content_view = 'tickets/client_views/view';
		$this->view_data['ticket'] = Ticket::find_by_id($id);
		$this->view_data['articles'] = TicketHasArticle::find('all', ['conditions' => ['ticket_id=? AND internal = ?', $id, 0], 'order' => 'id DESC']);

		if(!$this->view_data['ticket']){redirect('ctickets');}
		if($this->view_data['ticket']->company_id != $this->client->company->id || $this->view_data['ticket']->client_id != $this->client->id){ redirect('ctickets');}
		$this->view_data['form_action'] = 'ctickets/article/'.$id.'/add';

	}
	function article($id = FALSE, $condition = FALSE, $article_id = FALSE)
	{
		$this->view_data['submenu'] = array(
								$this->lang->line('application_back') => 'ctickets',
								$this->lang->line('application_overview') => 'ctickets/view/'.$id,
						 		);
		switch ($condition) {
			case 'add':
				$this->content_view = 'tickets/client_views/_note';
				if($_POST){
					$config['upload_path'] = './files/media/';
					$config['encrypt_name'] = TRUE;
					$config['allowed_types'] = '*';

					$this->load->library('upload', $config);
					$this->load->helper('notification');


					unset($_POST['userfile']);
					unset($_POST['file-name']);

					unset($_POST['send']);
					unset($_POST['_wysihtml5_mode']);
					unset($_POST['files']);
					$ticket = Ticket::find_by_id($id);
					$ticket->updated = "1";
					$ticket->save();
					if($ticket->company_id != $this->client->company->id || $ticket->client_id != $this->client->id){ redirect('ctickets');}
					if($ticket->user_id != 0){
					send_ticket_notification($ticket->user->email, '[Ticket#'.$ticket->reference.'] - '.$_POST['subject'], $_POST['message'], $ticket->id);
					}
					$_POST['internal'] = "0";

					unset($_POST['notify']);
					$_POST['subject'] = htmlspecialchars($_POST['subject']);
					$_POST['datetime'] = time();
					$_POST['ticket_id'] = $id;
					$_POST['from'] = $this->client->firstname." ".$this->client->lastname.' - '.$this->client->email;
					$_POST['reply_to'] = $this->client->email;
					$article = TicketHasArticle::create($_POST);

					if ( ! $this->upload->do_upload())
						{
							$error = $this->upload->display_errors('', ' ');
							$this->session->set_flashdata('message', 'error:'.$error);

						}
						else
						{
							$data = array('upload_data' => $this->upload->data());

							$attributes = array('article_id' => $article->id, 'filename' => $data['upload_data']['orig_name'], 'savename' => $data['upload_data']['file_name']);
							$attachment = ArticleHasAttachment::create($attributes);
						}

		       		if(!$article){$this->session->set_flashdata('message', 'error:'.$this->lang->line('messages_save_article_error'));}
		       		else{$this->session->set_flashdata('message', 'success:'.$this->lang->line('messages_save_article_success'));}
					redirect('ctickets/view/'.$id);
				}else
				{
					$this->theme_view = 'modal';
					$this->view_data['ticket'] = Ticket::find($id);
					$this->view_data['title'] = $this->lang->line('application_add_note');
					$this->view_data['form_action'] = 'ctickets/article/'.$id.'/add';
					$this->content_view = 'tickets/client_views/_note';
				}
				break;
			default:
				redirect('ctickets');
				break;
		}

	}

	function attachment($id = FALSE){
		$this->load->helper('download');
		$this->load->helper('file');

		$attachment = TicketHasAttachment::find_by_savename($id);

		$file = './files/media/'.$attachment->savename;
		$mime = get_mime_by_extension($file);
		if(file_exists($file)) {
            header('Content-Description: File Transfer');
            header('Content-Type: '.$mime);
            header('Content-Disposition: attachment; filename='.basename($attachment->filename));
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
	function articleattachment($id = FALSE){
		$this->load->helper('download');
		$this->load->helper('file');

		$attachment = ArticleHasAttachment::find_by_savename($id);
		$file = './files/media/'.$attachment->savename;
		$mime = get_mime_by_extension($file);
		if(file_exists($file)) {
            header('Content-Description: File Transfer');
            header('Content-Type: '.$mime);
            header('Content-Disposition: attachment; filename='.basename($attachment->filename));
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

}
