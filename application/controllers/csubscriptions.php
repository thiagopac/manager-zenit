<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class cSubscriptions extends MY_Controller {
               
	function __construct()
	{
		parent::__construct();
		$access = FALSE;
		if($this->user){	
			redirect('subscriptions');
		}elseif($this->client){
			foreach ($this->view_data['menu'] as $key => $value) { 
				if($value->link == "csubscriptions"){ $access = TRUE;}
			}
			if(!$access){redirect('login');}
		}else{
			redirect('login');
		}
		$this->view_data['submenu'] = array(
				 		$this->lang->line('application_all') => 'csubscriptions',
				 		$this->lang->line('application_Active') => 'csubscriptions/filter/active',
				 		$this->lang->line('application_Inactive') => 'csubscriptions/filter/inactive',
				 		);	
		
	}	
	function index()
	{
		$this->view_data['subscriptions'] = Subscription::find('all',array('conditions' => array('status = ? AND company_id=?', 'Active', $this->client->company->id)));
		$this->content_view = 'subscriptions/client_views/all';
	}
	function filter($condition = FALSE)
	{
		switch ($condition) {
			case 'active':
				$this->view_data['subscriptions'] = Subscription::find('all', array('conditions' => array('status = ? AND company_id = ?', 'Active', $this->client->company->id)));
				break;
			case 'inactive':
				$this->view_data['subscriptions'] = Subscription::find('all', array('conditions' => array('status = ? AND company_id = ?', 'Inactive', $this->client->company->id)));
				break;
			default:
				$this->view_data['subscriptions'] = Subscription::find('all', array('conditions' => array('company_id = ?', $this->client->company->id)));
				break;
		}
		
		$this->content_view = 'subscriptions/client_views/all';
	}
	function view($id = FALSE)
	{
		$this->view_data['submenu'] = array(
						$this->lang->line('application_back') => 'subscriptions',
				 		);	
		$this->view_data['subscription'] = Subscription::find($id);
		$this->view_data['items'] = SubscriptionHasItem::find('all',array('conditions' => array('subscription_id=?',$id)));
		if($this->view_data['subscription']->company_id != $this->client->company->id){ redirect('csubscriptions');}
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
		$this->content_view = 'subscriptions/client_views/view';
	}
	function success($id = FALSE){
		$this->session->set_flashdata('message', 'success:'.$this->lang->line('messages_subscribe_success'));
		redirect('csubscriptions/view/'.$id);
	}
	
}