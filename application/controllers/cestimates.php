<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class cEstimates extends MY_Controller {
               
	function __construct()
	{
		parent::__construct();
		$access = FALSE;
		if($this->client){	
			foreach ($this->view_data['menu'] as $key => $value) { 
				if($value->link == "cestimates"){ $access = TRUE;}
			}
			if(!$access){redirect('login');}
		}elseif($this->user){
				redirect('estimates');
		}else{

			redirect('login');
		}
		$this->view_data['submenu'] = array(
				 		$this->lang->line('application_all') => 'cestimates',
				 		);	
		
	}	
	function index()
	{
		$this->view_data['estimates'] = Invoice::find('all', array('conditions' => array('estimate != ? and company_id = ? and estimate_status != ?', 0, $this->client->company_id, 'Open')));

		$this->content_view = 'estimates/client_views/all';
	}
	function filter($condition = FALSE)
	{

		switch ($condition) {
			case 'open':
				$this->view_data['estimates'] = Invoice::find('all', array('conditions' => array('estimate_status = ? and estimate != ? and company_id = ?', 'Open', 0, $this->client->company_id)));
				break;
			case 'sent':
				$this->view_data['estimates'] = Invoice::find('all', array('conditions' => array('estimate_status = ? and estimate != ? and company_id = ?', 'Sent', 0, $this->client->company_id)));
				break;
			case 'accepted':
				$this->view_data['estimates'] = Invoice::find('all', array('conditions' => array('estimate_status = ? and estimate != ? and company_id = ?', 'Accepted', 0, $this->client->company_id)));
				break;
			case 'declined':
				$this->view_data['estimates'] = Invoice::find('all', array('conditions' => array('estimate_status = ? and estimate != ? and company_id = ?', 'Declined', 0, $this->client->company_id)));
				break;
			case 'invoiced':
				$this->view_data['estimates'] = Invoice::find('all', array('conditions' => array('estimate_status = ? and estimate != ? and company_id = ?', 'Invoiced', 0, $this->client->company_id)));
				break;
			default:
				$this->view_data['estimates'] = Invoice::find('all', array('conditions' => array('estimate != ? and company_id = ?', 0, $this->client->company_id)));
				break;
		}
		
		$this->content_view = 'estimates/client_views/all';
	}
	
		
	function accept($id = FALSE)
	{	
		$this->load->helper('notification');
		$data["core_settings"] = Setting::first();
			
			$this->view_data['estimate'] = Invoice::find_by_id($id);
			$this->view_data['estimate']->estimate_status = "Accepted";
			$this->view_data['estimate']->estimate_accepted_date = date("Y-m-d");

			$this->view_data['estimate']->save();

			send_notification($data["core_settings"]->email, $data["core_settings"]->estimate_prefix.$this->view_data['estimate']->estimate_reference.' - '.$this->lang->line('application_Accepted'), $this->lang->line('messages_estimate_accepted'));

			redirect('cestimates/view/'.$id);
			
	}	
	function decline($id = FALSE)
	{	
		$this->load->helper('notification');
		$data["core_settings"] = Setting::first();
		if($_POST){

			$this->view_data['estimate'] = Invoice::find_by_id($_POST['invoice_id']);
			$this->view_data['estimate']->estimate_status = "Declined";
			//$this->view_data['estimate']->estimate_decline_message = $_POST['reason'];
			$this->view_data['estimate']->save();

			send_notification($data["core_settings"]->email, $data["core_settings"]->estimate_prefix.$this->view_data['estimate']->estimate_reference.' - '.$this->lang->line('application_Declined'), $_POST['reason']);

			redirect('cestimates/view/'.$_POST['invoice_id']);
		}else{
			$this->view_data['estimate'] = Invoice::find($id);

			$this->theme_view = 'modal';
			$this->view_data['title'] = $this->lang->line('application_Declined');
			$this->view_data['form_action'] = 'cestimates/decline';
			$this->content_view = 'estimates/client_views/_decline';
		}
		
	}
	
	function view($id = FALSE)
	{

		
		$this->view_data['submenu'] = array(
						$this->lang->line('application_back') => 'cestimates',
				 		);	
		$this->view_data['estimate'] = Invoice::find($id);
		if($this->view_data['estimate']->company_id != $this->client->company->id){ redirect('cestimates');}
		$data["core_settings"] = Setting::first();
		$estimate = $this->view_data['estimate'];
		$this->view_data['items'] = InvoiceHasItem::find('all',array('conditions' => array('invoice_id=?',$id)));
		

		//calculate sum
		$i = 0; $sum = 0;
		foreach ($this->view_data['items'] as $value){
			$sum = $sum+$estimate->invoice_has_items[$i]->amount*$estimate->invoice_has_items[$i]->value; $i++;
		}
		if(substr($estimate->discount, -1) == "%"){ 
			$discount = sprintf("%01.2f", round(($sum/100)*substr($estimate->discount, 0, -1), 2)); 
		}
		else{
			$discount = $estimate->discount;
		}
		$sum = $sum-$discount;

		if($estimate->tax != ""){
			$tax_value = $estimate->tax;
		}else{
			$tax_value = $data["core_settings"]->tax;
		}

		$tax = sprintf("%01.2f", round(($sum/100)*$tax_value, 2));
		$sum = sprintf("%01.2f", round($sum+$tax, 2));

		$estimate->sum = $sum;
			$estimate->save();
		$this->content_view = 'estimates/client_views/view';
	}


	function preview($id = FALSE){
     $this->load->helper(array('dompdf', 'file')); 
     $this->load->library('parser');
     $data["estimate"] = Invoice::find($id); 
     $data['items'] = InvoiceHasItem::find('all',array('conditions' => array('invoice_id=?',$id)));
     $data["core_settings"] = Setting::first();
   
     $due_date = date($data["core_settings"]->date_format, human_to_unix($data["estimate"]->due_date.' 00:00:00'));  
     $parse_data = array(
            					'due_date' => $due_date,
            					'estimate_id' => $data["core_settings"]->estimate_prefix.$data["estimate"]->estimate_reference,
            					'client_link' => $data["core_settings"]->domain,
            					'company' => $data["core_settings"]->company,
            					);
  	$html = $this->load->view($data["core_settings"]->template. '/' .$data["core_settings"]->estimate_pdf_template, $data, true); 
  	$html = $this->parser->parse_string($html, $parse_data);
     
    $filename = $this->lang->line('application_estimate').'_'.$data["core_settings"]->estimate_prefix.$data["estimate"]->estimate_reference;
     pdf_create($html, $filename, TRUE);
	}

	


	
}