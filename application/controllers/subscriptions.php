<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Subscriptions extends MY_Controller {
               
	function __construct()
	{
		parent::__construct();
		$access = FALSE;
		if($this->client){	
			redirect('csubscriptions');
		}elseif($this->user){
			foreach ($this->view_data['menu'] as $key => $value) { 
				if($value->link == "subscriptions"){ $access = TRUE;}
			}
			if(!$access){redirect('login');}
		}else{
			redirect('login');
		}
		$this->view_data['submenu'] = array(
				 		$this->lang->line('application_all') => 'subscriptions',
				 		$this->lang->line('application_Active') => 'subscriptions/filter/active',
				 		$this->lang->line('application_Inactive') => 'subscriptions/filter/inactive',
				 		$this->lang->line('application_ended') => 'subscriptions/filter/ended',

				 		);	
		
	}	
	function index()
	{
		if($this->user->admin != 1){
				$comp_array = array();
				$thisUserHasNoCompanies = (array) $this->user->companies;
					if(!empty($thisUserHasNoCompanies)){
					foreach ($this->user->companies as $value) {
						array_push($comp_array, $value->id);
					}
					$this->view_data['subscriptions'] = Subscription::find('all',array('conditions' => array('company_id in (?)', $comp_array)));
				}else{
					$this->view_data['subscriptions'] = (object) array();
				}
			}else{
				$this->view_data['subscriptions'] = Subscription::all();
			}
		
		$this->content_view = 'subscriptions/all';
		/* $days_in_this_month = days_in_month(date('m'), date('Y'));
		$lastday_in_month =  strtotime(date('Y')."-".date('m')."-".$days_in_this_month);
		$firstday_in_month =  strtotime(date('Y')."-".date('m')."-01");

		$this->view_data['subscription_paid_this_month'] = Subscription::count(array('conditions' => 'UNIX_TIMESTAMP(`paid_date`) <= '.$lastday_in_month.' and UNIX_TIMESTAMP(`paid_date`) >= '.$firstday_in_month.''));
		$this->view_data['subscription_due_this_month'] = Subscription::count(array('conditions' => 'UNIX_TIMESTAMP(`due_date`) <= '.$lastday_in_month.' and UNIX_TIMESTAMP(`due_date`) >= '.$firstday_in_month.''));
		
		//statistic
		$now = time();
		$beginning_of_week = strtotime('last Monday', $now); // BEGINNING of the week
		$end_of_week = strtotime('next Sunday', $now) + 86400; // END of the last day of the week
		$this->view_data['subscription_due_this_month_graph'] = Subscription::find_by_sql('select count(id) AS "amount", DATE_FORMAT(`due_date`, "%w") AS "date_day", DATE_FORMAT(`due_date`, "%Y-%m-%d") AS "date_formatted" from invoices where UNIX_TIMESTAMP(`due_date`) >= "'.$beginning_of_week.'" AND UNIX_TIMESTAMP(`due_date`) <= "'.$end_of_week.'" ');
		$this->view_data['subscription_paid_this_month_graph'] = Subscription::find_by_sql('select count(id) AS "amount", DATE_FORMAT(`paid_date`, "%w") AS "date_day", DATE_FORMAT(`paid_date`, "%Y-%m-%d") AS "date_formatted" from invoices where UNIX_TIMESTAMP(`paid_date`) >= "'.$beginning_of_week.'" AND UNIX_TIMESTAMP(`paid_date`) <= "'.$end_of_week.'" ');
 */
	}
	function filter($condition = FALSE)
	{
		$company_select = "";
		$comp_array = "";
		if($this->user->admin != 1){
				$comp_array = array();
				$thisUserHasNoCompanies = (array) $this->user->companies;
					if(!empty($thisUserHasNoCompanies)){
					foreach ($this->user->companies as $value) {
						array_push($comp_array, $value->id);
					}
					$company_select = ' AND company_id in (?)';
					$this->view_data['subscriptions'] = Subscription::find('all', array('conditions' => array('status = ?'.$company_select, ucfirst($condition),$comp_array )));
					if($condition == "ended"){
						$this->view_data['subscriptions'] = Subscription::find('all', array('conditions' => array('status = ? AND end_date < ?'.$company_select, 'Active',date('Y-m-d'),$comp_array)));	
					}
				}else{
					$this->view_data['subscriptions'] = (object) array();
				}
			}else{

				$this->view_data['subscriptions'] = Subscription::find('all', array('conditions' => array('status = ?', ucfirst($condition) )));
				if($condition == "ended"){
					$this->view_data['subscriptions'] = Subscription::find('all', array('conditions' => array('status = ? AND end_date < ?', 'Active',date('Y-m-d'))));	
				}
			}
		
		$this->content_view = 'subscriptions/all';
	}
	function create()
	{	
		if($_POST){
			unset($_POST['send']);
			unset($_POST['_wysihtml5_mode']);
			unset($_POST['files']);
			/*$next_payment = human_to_unix($_POST['issue_date'].' 00:00');
			$next_payment = strtotime($_POST['frequency'], $next_payment);
			
			$_POST['next_payment'] = date("Y-m-d", $next_payment);*/
			$_POST['next_payment'] = $_POST['issue_date'];
			$subscription = Subscription::create($_POST);
			$new_subscription_reference = $_POST['reference']+1;
			$subscription_reference = Setting::first();
			$subscription_reference->update_attributes(array('subscription_reference' => $new_subscription_reference));
       		if(!$subscription){$this->session->set_flashdata('message', 'error:'.$this->lang->line('messages_create_subscription_error'));}
       		else{$this->session->set_flashdata('message', 'success:'.$this->lang->line('messages_create_subscription_success'));}
			redirect('subscriptions');
		}else
		{
			$this->view_data['next_reference'] = Subscription::last();
			if($this->user->admin == 0){
				$this->view_data['companies'] = $this->user->companies;
			}else{
				$this->view_data['companies'] = Company::find('all',array('conditions' => array('inactive=?','0')));
			}
			$this->theme_view = 'modal';
			$this->view_data['title'] = $this->lang->line('application_create_subscription');
			$this->view_data['form_action'] = 'subscriptions/create';
			$this->content_view = 'subscriptions/_subscription';
		}	
	}	
	function update($id = FALSE, $getview = FALSE)
	{	
		if($_POST){
			unset($_POST['send']);
			unset($_POST['files']);
			unset($_POST['_wysihtml5_mode']);
			$id = $_POST['id'];
			$subscription = Subscription::find($id);
			if($_POST['issue_date'] != $subscription->issue_date){
				$_POST['next_payment'] = $_POST['issue_date']; 
			}
			
			$view = FALSE;
			if(isset($_POST['view'])){$view = $_POST['view']; }
			unset($_POST['view']);
			if($_POST['status'] == "Paid"){ $_POST['paid_date'] = date('Y-m-d', time());}
			
			$subscription->update_attributes($_POST);
       		if(!$subscription){$this->session->set_flashdata('message', 'error:'.$this->lang->line('messages_save_subscription_error'));}
       		else{$this->session->set_flashdata('message', 'success:'.$this->lang->line('messages_save_subscription_success'));}
			if($view == 'true'){redirect('subscriptions/view/'.$id);}else{redirect('subscriptions');}
			
		}else
		{
			$this->view_data['subscription'] = Subscription::find($id);
			$this->view_data['companies'] = Company::find('all',array('conditions' => array('inactive=?','0')));
			if($getview == "view"){$this->view_data['view'] = "true";}
			$this->theme_view = 'modal';
			$this->view_data['title'] = $this->lang->line('application_edit_subscription');
			$this->view_data['form_action'] = 'subscriptions/update';
			$this->content_view = 'subscriptions/_subscription';
		}	
	}	
	function view($id = FALSE)
	{
		$this->view_data['submenu'] = array(
						$this->lang->line('application_back') => 'subscriptions',
				 		);	
		$this->view_data['subscription'] = Subscription::find($id);
		$this->view_data['items'] = SubscriptionHasItem::find('all',array('conditions' => array('subscription_id=?',$id)));

	     $datediff = strtotime($this->view_data['subscription']->end_date) - strtotime($this->view_data['subscription']->issue_date);
	     $timespan = floor($datediff/(60*60*24));
	     switch ($this->view_data['subscription']->frequency) {
	     	case '+7 day':
	     		$this->view_data['run_time'] = round($timespan/7);
	     		$this->view_data['p3'] = "1";
	     		$this->view_data['t3'] = "W";
	     		break;
	     	case '+14 day':
	     		$this->view_data['run_time'] = round($timespan/14);
	     		$this->view_data['p3'] = "2";
	     		$this->view_data['t3'] = "W";
	     		break;
	     	case '+1 month':
	     		$this->view_data['run_time'] = round($timespan/30);
	     		$this->view_data['p3'] = "1";
	     		$this->view_data['t3'] = "M";
	     		break;
	     	case '+3 month':
	     		$this->view_data['run_time'] = round($timespan/90);
	     		$this->view_data['p3'] = "3";
	     		$this->view_data['t3'] = "M";
	     		break;
	     	case '+6 month':
	     		$this->view_data['run_time'] = round($timespan/182);
	     		$this->view_data['p3'] = "6";
	     		$this->view_data['t3'] = "M";
	     		break;
	     	case '+1 year':
	     		$this->view_data['run_time'] = round($timespan/365);
	     		$this->view_data['p3'] = "1";
	     		$this->view_data['t3'] = "Y";
	     		break;
	     }
		$this->content_view = 'subscriptions/view';
	}
	function create_invoice($id = FALSE)
	{	
		$subscription = Subscription::find($id);
		$invoice = Invoice::last();
		$invoice_reference = Setting::first();
		if($subscription){
			$_POST['subscription_id'] = $subscription->id;
			$_POST['company_id'] = $subscription->company_id;
			if($subscription->subscribed != 0){$_POST['status'] = "Paid";}else{$_POST['status'] = "Open";}
			$_POST['currency'] = $subscription->currency;
			$_POST['issue_date'] = $subscription->next_payment;
			$_POST['due_date'] = date('Y-m-d', strtotime('+14 day', strtotime ($subscription->next_payment)));
			$_POST['currency'] = $subscription->currency;
			$_POST['terms'] = $subscription->terms;
			$_POST['discount'] = $subscription->discount;
			$_POST['tax'] = $subscription->tax;
			$_POST['second_tax'] = $subscription->second_tax;
			$_POST['reference'] = $invoice_reference->invoice_reference;
			$invoice = Invoice::create($_POST);
			$invoiceid = Invoice::last();
			$items = SubscriptionHasItem::find('all',array('conditions' => array('subscription_id=?',$id)));
			foreach ($items as $value):
				$itemvalues = array(
					'invoice_id' => $invoiceid->id,
					'item_id' => $value->item_id,
					'amount' =>  $value->amount,
					'description' => $value->description,
					'value' => $value->value,
					'name' => $value->name,
					'type' => $value->type,
					);
				InvoiceHasItem::create($itemvalues);
			endforeach;
			$invoice_reference->update_attributes(array('invoice_reference' => $invoice_reference->invoice_reference+1));
       		if(!$invoice){$this->session->set_flashdata('message', 'error:'.$this->lang->line('messages_create_invoice_error'));}
       		else{	$subscription->next_payment = date('Y-m-d', strtotime($subscription->frequency, strtotime ($subscription->next_payment)));
       				$subscription->save();
       				$this->session->set_flashdata('message', 'success:'.$this->lang->line('messages_create_invoice_success'));}
			redirect('subscriptions/view/'.$id);
		}
	}	
	function delete($id = FALSE)
	{	
		$subscription = Subscription::find($id);
		$subscription->delete();
		$this->content_view = 'subscriptions/all';
		if(!$subscription){$this->session->set_flashdata('message', 'error:'.$this->lang->line('messages_delete_subscription_error'));}
       		else{$this->session->set_flashdata('message', 'success:'.$this->lang->line('messages_delete_subscription_success'));}
			redirect('subscriptions');
	}
	function sendsubscription($id = FALSE){
		$this->load->helper(array('dompdf', 'file'));
			$this->load->library('parser');

			$data["subscription"] = Subscription::find($id); 
			$data['items'] = SubscriptionHasItem::find('all',array('conditions' => array('subscription_id=?',$id)));
     		$data["core_settings"] = Setting::first();

  			$issue_date = date($data["core_settings"]->date_format, human_to_unix($data["subscription"]->issue_date.' 00:00:00')); 
  			//Set parse values
  			$parse_data = array(
            					'client_contact' => $data["subscription"]->company->client->firstname.' '.$data["subscription"]->company->client->lastname,
            					'client_company' => $data["subscription"]->company->name,							
								'first_name' => $data["subscription"]->company->client->firstname,
            					'last_name' => $data["subscription"]->company->client->lastname,
								'issue_date' => $issue_date,
								'subscription_id' => $data["core_settings"]->subscription_prefix.$data["subscription"]->reference,
            					'subscription_link' => base_url().'csubscriptions/view/'.$data["subscription"]->id,								
            					'client_link' => $data["core_settings"]->domain,
            					'company' => $data["core_settings"]->company,
            					'logo' => '<img src="'.base_url().''.$data["core_settings"]->logo.'" alt="'.$data["core_settings"]->company.'"/>',
            					'invoice_logo' => '<img src="'.base_url().''.$data["core_settings"]->invoice_logo.'" alt="'.$data["core_settings"]->company.'"/>'
            					);
            //email
     		$subject = $this->parser->parse_string($data["core_settings"]->subscription_mail_subject, $parse_data);
			$this->email->from($data["core_settings"]->email, $data["core_settings"]->company);
			if(!is_object($data["subscription"]->company->client) && $data["subscription"]->company->client->email == ""){
				$this->session->set_flashdata('message', 'error:'.$this->lang->line('messages_send_subscription_error').' No client email!');
				redirect('subscriptions/view/'.$id);

			}
			$this->email->to($data["subscription"]->company->client->email); 
			$this->email->subject($subject); 
			
  			$email_subscription = read_file('./application/views/'.$data["core_settings"]->template.'/templates/email_subscription.html');
  			$message = $this->parser->parse_string($email_subscription, $parse_data);
			$this->email->message($message);			
			if($this->email->send()){$this->session->set_flashdata('message', 'success:'.$this->lang->line('messages_send_subscription_success'));
			//$data["subscription"]->update_attributes(array('status' => 'Sent', 'sent_date' => date("Y-m-d")));
			log_message('error', 'Subscription #'.$data["core_settings"]->subscription_prefix.$data["subscription"]->reference.' has been send to '.$data["subscription"]->company->client->email);
			}
       		else{$this->session->set_flashdata('message', 'error:'.$this->lang->line('messages_send_subscription_error'));
       		log_message('error', 'ERROR: Subscription #'.$data["core_settings"]->subscription_prefix.$data["subscription"]->reference.' has not been send to '.$data["subscription"]->company->client->email.'. Please check your servers email settings.');
       		}
			redirect('subscriptions/view/'.$id);
	}
	function item($id = FALSE)
	{	
		if($_POST){
			unset($_POST['send']);
			$_POST = array_map('htmlspecialchars', $_POST);
			if($_POST['name'] != ""){
				$_POST['name'] = $_POST['name'];
				$_POST['value'] = $_POST['value'];
				$_POST['type'] = $_POST['type'];
			}else{
				if($_POST['item_id'] == "-"){
					$this->session->set_flashdata('message', 'error:'.$this->lang->line('messages_add_item_error'));
					redirect('subscriptions/view/'.$_POST['subscription_id']);

				}else{
					$itemvalue = Item::find($_POST['item_id']);
					$_POST['name'] = $itemvalue->name;
					$_POST['type'] = $itemvalue->type;
					$_POST['value'] = $itemvalue->value;
				}
			}

			$item = SubscriptionHasItem::create($_POST);
       		if(!$item){$this->session->set_flashdata('message', 'error:'.$this->lang->line('messages_add_item_error'));}
       		else{$this->session->set_flashdata('message', 'success:'.$this->lang->line('messages_add_item_success'));}
			redirect('subscriptions/view/'.$_POST['subscription_id']);
			
		}else
		{
			$this->view_data['subscription'] = Subscription::find($id);
			$this->view_data['items'] = Item::find('all',array('conditions' => array('inactive=?','0')));
			$this->theme_view = 'modal';
			$this->view_data['title'] = $this->lang->line('application_add_item');
			$this->view_data['form_action'] = 'subscriptions/item';
			$this->content_view = 'subscriptions/_item';
		}	
	}	
	function item_update($id = FALSE)
	{	
		if($_POST){
			unset($_POST['send']);
			$_POST = array_map('htmlspecialchars', $_POST);
			$item = SubscriptionHasItem::find($_POST['id']);
			$item = $item->update_attributes($_POST);
       		if(!$item){$this->session->set_flashdata('message', 'error:'.$this->lang->line('messages_save_item_error'));}
       		else{$this->session->set_flashdata('message', 'success:'.$this->lang->line('messages_save_item_success'));}
			redirect('subscriptions/view/'.$_POST['subscription_id']);
			
		}else
		{
			$this->view_data['subscription_has_items'] = SubscriptionHasItem::find($id);
			$this->theme_view = 'modal';
			$this->view_data['title'] = $this->lang->line('application_edit_item');
			$this->view_data['form_action'] = 'subscriptions/item_update';
			$this->content_view = 'subscriptions/_item';
		}	
	}	
	function item_delete($id = FALSE, $subscription_id = FALSE)
	{	
		$item = SubscriptionHasItem::find($id);
		$item->delete();
		$this->content_view = 'subscriptions/view';
		if(!$item){$this->session->set_flashdata('message', 'error:'.$this->lang->line('messages_delete_item_error'));}
       		else{$this->session->set_flashdata('message', 'success:'.$this->lang->line('messages_delete_item_success'));}
			redirect('subscriptions/view/'.$subscription_id);
	}	
	
}