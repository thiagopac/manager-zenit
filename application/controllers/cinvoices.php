<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class cInvoices extends MY_Controller {
               
	function __construct()
	{
		parent::__construct();
		$access = FALSE;
		if($this->client){	
			foreach ($this->view_data['menu'] as $key => $value) { 
				if($value->link == "cinvoices"){ $access = TRUE;}
			}
			if(!$access){redirect('login');}
		}elseif($this->user){
				redirect('invoices');
		}else{

			redirect('login');
		}
		$this->view_data['submenu'] = array(
				 		$this->lang->line('application_all_invoices') => 'cinvoices',
				 		);	
		
	}	
	function index()
	{
		$this->view_data['invoices'] = Invoice::find('all',array('conditions' => array('company_id=? AND estimate != ? AND issue_date<=?',$this->client->company->id,1,date('Y-m-d', time()))));
		$this->content_view = 'invoices/client_views/all';
	}

	function view($id = FALSE)
	{
		$this->view_data['submenu'] = array(
						$this->lang->line('application_back') => 'invoices',
				 		);	
		$this->view_data['invoice'] = Invoice::find($id);
		$data["core_settings"] = Setting::first();
		$invoice = $this->view_data['invoice'];
		$this->view_data['items'] = $invoice->invoice_has_items;

		//calculate sum
		$i = 0; $sum = 0;
		foreach ($this->view_data['items'] as $value){
			$sum = $sum+$invoice->invoice_has_items[$i]->amount*$invoice->invoice_has_items[$i]->value; $i++;
		}
		if(substr($invoice->discount, -1) == "%"){ 
			$discount = sprintf("%01.2f", round(($sum/100)*substr($invoice->discount, 0, -1), 2)); 
		}
		else{
			$discount = $invoice->discount;
		}
		$sum = $sum-$discount;

		if($invoice->tax != ""){
			$tax_value = $invoice->tax;
		}else{
			$tax_value = $data["core_settings"]->tax;
		}

		if($invoice->second_tax != ""){
	      $second_tax_value = $invoice->second_tax;
	    }else{
	      $second_tax_value = $data["core_settings"]->second_tax;
	    }

		$tax = sprintf("%01.2f", round(($sum/100)*$tax_value, 2));
		$second_tax = sprintf("%01.2f", round(($sum/100)*$second_tax_value, 2));

    	$sum = sprintf("%01.2f", round($sum+$tax+$second_tax, 2));

    	$payment = 0;
    	$i = 0;
    	$payments = $invoice->invoice_has_payments;
    	if(isset($payments)){
    		foreach ($payments as $value) {
    			$payment = sprintf("%01.2f", round($payment+$payments[$i]->amount, 2));
    			$i++;
    		}
    	$invoice->paid = $payment;
    	$invoice->outstanding = sprintf("%01.2f", round($sum-$payment, 2));
		}

		$invoice->sum = $sum;
			$invoice->save();


		if($this->view_data['invoice']->company_id != $this->client->company->id){ redirect('cinvoices');}
		$this->content_view = 'invoices/client_views/view';
	}
	function download($id = FALSE){
     $this->load->helper(array('dompdf', 'file')); 
     $this->load->library('parser');
     $data["invoice"] = Invoice::find($id); 
     $data['items'] = InvoiceHasItem::find('all',array('conditions' => array('invoice_id=?',$id)));
     if($data['invoice']->company_id != $this->client->company->id){ redirect('cinvoices');}
     $data["core_settings"] = Setting::first(); 
     $due_date = date($data["core_settings"]->date_format, human_to_unix($data["invoice"]->due_date.' 00:00:00'));  
     $parse_data = array(
            					'due_date' => $due_date,
            					'invoice_id' => $data["core_settings"]->invoice_prefix.$data["invoice"]->reference,
            					'client_link' => $data["core_settings"]->domain,
            					'company' => $data["core_settings"]->company,
            					); 
  	$html = $this->load->view($data["core_settings"]->template. '/' .$data["core_settings"]->invoice_pdf_template, $data, true); 
     $html = $this->parser->parse_string($html, $parse_data); 
     $filename = $this->lang->line('application_invoice').'_'.$data["core_settings"]->invoice_prefix.$data["invoice"]->reference;
     pdf_create($html, $filename, TRUE);
       
	}
	function banktransfer($id = FALSE, $sum = FALSE){

		$this->theme_view = 'modal';
		$this->view_data['title'] = $this->lang->line('application_bank_transfer');
	
		$data["core_settings"] = Setting::first();
		$this->view_data['invoice'] = Invoice::find($id);
		$this->content_view = 'invoices/client_views/_banktransfer';
	}
		function twocheckout($id = FALSE, $sum = FALSE){
		$data["core_settings"] = Setting::first();
		$this->load->helper('notification');
		
		if($_POST){ 
					$invoice = Invoice::find_by_id($_POST['id']);
					$invoice_reference = $data["core_settings"]->invoice_prefix.$invoice->reference;
					$this->load->file(APPPATH.'helpers/2checkout/Twocheckout.php', true);
					$token = $_POST["token"];
					Twocheckout::privateKey($data["core_settings"]->twocheckout_private_key);
					Twocheckout::sellerId($data["core_settings"]->twocheckout_seller_id);
					//Twocheckout::sandbox(true);  #Uncomment to use Sandbox

					//Get currency
					$currency = $invoice->currency;
				    $currency_codes = getCurrencyCodesForTwocheckout();
					if(!array_key_exists($currency, $currency_codes)){
						$currency = $data["core_settings"]->twocheckout_currency;
					}

					try {
					    $charge = Twocheckout_Charge::auth(array(
					        "merchantOrderId" => $invoice_reference,
					        "token"      => $_POST['token'],
					        "currency"   => $currency,
					        "total"      =>$_POST['sum'],
					        "billingAddr" => array(
					            "name" => $invoice->company->name,
					            "addrLine1" => $invoice->company->address,
					            "city" => $invoice->company->city,
					            "state" => $invoice->company->province,
					            "zipCode" => $invoice->company->zipcode,
					            "country" => $invoice->company->country,
					            "email" => $invoice->company->client->email,
					            "phoneNumber" => $invoice->company->phone
					        )
					    ));

					    if ($charge['response']['responseCode'] == 'APPROVED') {

					        $attr= array();
							$paid_date = date('Y-m-d', time());
							$payment_reference = $invoice->reference.'00'.InvoiceHasPayment::count(array('conditions' => 'invoice_id = '.$invoice->id))+1;
							$attributes = array('invoice_id' => $invoice->id, 'reference' => $payment_reference, 'amount' => $_POST['sum'], 'date' => $paid_date, 'type' => 'credit_card', 'notes' => '');
							$invoiceHasPayment = InvoiceHasPayment::create($attributes);
								
							if($_POST['sum'] >= $invoice->outstanding){
								$invoice->update_attributes(array('paid_date' => $paid_date, 'status' => 'Paid'));
							}else{
								$invoice->update_attributes(array('status' => 'PartiallyPaid'));
							}
							
							$this->session->set_flashdata('message', 'success:'.$this->lang->line('messages_payment_complete'));
					        log_message('error', '2Checkout: Payment of '.$_POST['sum'].' for invoice '.$invoice_reference.' received!');
					        //send receipt to client
							receipt_notification($this->client->id, FALSE, $invoiceHasPayment->id);
							//send email to admin
							send_notification($data["core_settings"]->email, $this->lang->line('application_notification_payment_processed_subject'), $this->lang->line('application_notification_payment_processed').' #'.$data["core_settings"]->invoice_prefix.$invoiceHasPayment->invoice->reference);

					    }
					} catch (Twocheckout_Error $e) {
						$this->session->set_flashdata('message', 'error: Your payment could NOT be processed (i.e., you have not been charged) because the payment system rejected the transaction.');
					    log_message('error', '2Checkout: Payment of invoice '.$invoice_reference.' failed - '.$e->getMessage());
					}
					redirect('cinvoices/view/'.$_POST['id']);
			}else{
				$this->view_data['invoices'] = Invoice::find_by_id($id);
			
				$this->view_data['publishable_key'] = $data["core_settings"]->twocheckout_publishable_key;
				$this->view_data['seller_id'] = $data["core_settings"]->twocheckout_seller_id;

				$this->view_data['sum'] = $sum;
				$this->theme_view = 'modal';
				$this->view_data['title'] = $this->lang->line('application_pay_with_credit_card');
				$this->view_data['form_action'] = 'cinvoices/twocheckout';
				$this->content_view = 'invoices/_2checkout';
			}
	}
	function stripepay($id = FALSE, $sum = FALSE, $type = "card"){
		$data["core_settings"] = Setting::first();
		$this->load->helper('notification');
		$stripe_keys = array(
		  "secret_key"      => $data["core_settings"]->stripe_p_key, 
		  "publishable_key" => $data["core_settings"]->stripe_key 
		);


		if($_POST){
			unset($_POST['send']);
			$invoice = Invoice::find($_POST['id']);
			
			// Stores errors:
	$errors = array();
	
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
		log_message('error', 'Stripe: ERROR - Payment canceled for invoice #'.$data["core_settings"]->invoice_prefix.$invoice->reference.'.');
			
	}
	
	// Set the order amount somehow:
	$sum_exp = explode('.', $_POST['sum']);
	$amount = $sum_exp[0]*100+$sum_exp[1]; // in cents

	//Get currency
	$currency = $invoice->currency;
    $currency_codes = getCurrencyCodes();
	if(!array_key_exists($currency, $currency_codes)){
		$currency = $data["core_settings"]->stripe_currency;
	}

	// Validate other form data!

	// If no errors, process the order:
	if (empty($errors)) {
		
		// create the charge on Stripe's servers - this will charge the user's card
		try {

			// set your secret key
			// see your keys here https://manage.stripe.com/account
			\Stripe\Stripe::setApiKey($stripe_keys["secret_key"]);

			// Charge the order:
			$charge = \Stripe\Charge::create(array(
				"amount" => $amount, // amount in cents, again
				"currency" => $currency,
				"card" => $token,
				"receipt_email" => $invoice->company->client->email,
				"description" => $data["core_settings"]->invoice_prefix.$invoice->reference
				)
			);

			// Check that it was paid:
			if ($charge->paid == true) {
				$attr= array();
				$paid_date = date('Y-m-d', time());
				$payment_reference = $invoice->reference.'00'.InvoiceHasPayment::count(array('conditions' => 'invoice_id = '.$invoice->id))+1;
				$attributes = array('invoice_id' => $invoice->id, 'reference' => $payment_reference, 'amount' => $_POST['sum'], 'date' => $paid_date, 'type' => 'credit_card', 'notes' => '');
				$invoiceHasPayment = InvoiceHasPayment::create($attributes);
					
				
				if($_POST['sum'] >= $invoice->outstanding){
					$invoice->update_attributes(array('paid_date' => $paid_date, 'status' => 'Paid'));
				}else{
					$invoice->update_attributes(array('status' => 'PartiallyPaid'));
				}
				$this->session->set_flashdata('message', 'success:'.$this->lang->line('messages_payment_complete'));
				log_message('error', 'Stripe: Payment for Invoice #'.$data["core_settings"]->invoice_prefix.$invoice->reference.' successfully made');
				//send receipt to client
				receipt_notification($this->client->id, FALSE, $invoiceHasPayment->id);
				//send email to admin
				send_notification($data["core_settings"]->email, $this->lang->line('application_notification_payment_processed_subject'), $this->lang->line('application_notification_payment_processed').' #'.$data["core_settings"]->invoice_prefix.$invoiceHasPayment->invoice->reference);
			} else { // Charge was not paid!	
				$this->session->set_flashdata('message', 'error: Your payment could NOT be processed (i.e., you have not been charged) because the payment system rejected the transaction.');
				log_message('error', 'Stripe: ERROR - Payment for Invoice #'.$data["core_settings"]->invoice_prefix.$invoice->reference.' was not successful!');

				}
			
		} catch (\Stripe\Error\Card $e) {
					    // Card was declined.
						$e_json = $e->getJsonBody();
						$err = $e_json['error'];
						$errors['stripe'] = $err['message'];
						$this->session->set_flashdata('message', 'error: Card was declined!');
						log_message('error', 'Stripe: ERROR - Credit Card was declined by Stripe! Payment process canceled for invoice #'.$data["core_settings"]->invoice_prefix.$invoice->reference.'.');
					
					} catch (\Stripe\Error\RateLimit $e) {
						// Too many requests made to the API too quickly
						$e_json = $e->getJsonBody();
						$err = $e_json['error'];
						$this->session->set_flashdata('message', 'error: Too many requests made to the API too quickly!');
					    log_message('error', 'Too many stripe requests: '.$err['message']);
					} catch (\Stripe\Error\Authentication $e) {
						$e_json = $e->getJsonBody();
						$err = $e_json['error'];
						$this->session->set_flashdata('message', 'error: Payment could not be processed!');
						log_message('error', 'Stripe authentication error: '.$err['message']);
					} catch (\Stripe\Error\InvalidRequest $e) {
						$e_json = $e->getJsonBody();
						$err = $e_json['error'];
						$this->session->set_flashdata('message', 'error: Payment could not be processed!');
						log_message('error', 'Stripe invalid request error: '.$err['message']);
					} catch (\Stripe\Error\ApiConnection $e) {
						$e_json = $e->getJsonBody();
						$err = $e_json['error'];
						$this->session->set_flashdata('message', 'error: Payment could not be processed!');
					    log_message('error', 'Stripe API connection error: '.$err['message']);
					} catch (\Stripe\Error\Base $e) {
						$e_json = $e->getJsonBody();
						$err = $e_json['error'];
						$this->session->set_flashdata('message', 'error: Payment could not be processed!');
					   	log_message('error', 'Stripe error: '.$err['message']);
					} catch (Exception $e) {
						$e_json = $e->getJsonBody();
						$err = $e_json['error'];
						$this->session->set_flashdata('message', 'error: Payment could not be processed!');
					    log_message('error', 'Error during stripe process: '.$err['message']);
					}

	}else{
		
		$this->session->set_flashdata('message', 'error: '.$errors["token"]);
		log_message('error', 'Stripe: '.$errors["token"]);
		
	} 



			redirect('cinvoices/view/'.$_POST['id']);
		}else
		{
			$this->view_data['invoices'] = Invoice::find_by_id($id);
			
			$this->view_data['public_key'] = $data["core_settings"]->stripe_key;
			$this->view_data['sum'] = $sum;
			$this->theme_view = 'modal';
			switch($type){
				case "ideal":
					$this->view_data['form_action'] = 'cinvoices/idealpay'; 
					$this->view_data['title'] = $this->lang->line('application_pay_with_ideal');
					$this->content_view = 'invoices/_stripe_ideal';
				break;
				default: 
					$this->view_data['form_action'] = 'cinvoices/stripepay';
					$this->view_data['title'] = $this->lang->line('application_pay_with_credit_card');
					$this->content_view = 'invoices/_stripe';
				break;
			}
		}

	}
	function success($id = FALSE){
		$this->session->set_flashdata('message', 'success:'.$this->lang->line('messages_payment_success'));
		redirect('cinvoices/view/'.$id);
	}

	function idealpay($id = FALSE, $sum = FALSE){
		  $core_settings = Setting::first();
		  // Set API key for stripe:
		  \Stripe\Stripe::setApiKey($core_settings->stripe_p_key);
		  // Get Stripe source from url source id 
		  $source = \Stripe\Source::retrieve($_GET['source']);
		  // Find invoice and get currecny
		  $invoice = Invoice::find_by_id($id);
		  $currency = $invoice->currency;

		  $sum_exp = explode('.', $sum);
		  $amount = $sum_exp[0]*100+$sum_exp[1]; // in cents

		  switch ($source->status) {
		  	case 'chargeable':
		  		$create = \Stripe\Charge::create(array(
				    'amount' => $amount,
				    'currency' => $currency,
				    "source" => $_GET['source'],
				));
		  		var_dump($create->status);
		  		if($create->status == "succeeded"){

		  			$attr= array();
					$paid_date = date('Y-m-d', time());
					$payment_reference = $invoice->reference.'00'.InvoiceHasPayment::count(array('conditions' => 'invoice_id = '.$invoice->id))+1;
					$attributes = array('invoice_id' => $invoice->id, 'reference' => $payment_reference, 'amount' => $sum, 'date' => $paid_date, 'type' => 'iDEAL', 'notes' => '');
					$invoiceHasPayment = InvoiceHasPayment::create($attributes);
						
					if($sum >= $invoice->outstanding){
						$invoice->update_attributes(array('paid_date' => $paid_date, 'status' => 'Paid'));
					}else{
						$invoice->update_attributes(array('status' => 'PartiallyPaid'));
					}

		  			$this->session->set_flashdata('message', 'success:'.$this->lang->line('messages_payment_complete'));
					log_message('error', 'Stripe: Payment for Invoice #'.$core_settings->invoice_prefix.$invoice->reference.' successfully made with iDEAL.');
		  		}else{
		  			$this->session->set_flashdata('message', 'error: Payment could not be processed!');
					log_message('error', 'iDEAL Payment was canceled!');
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

		  redirect("cinvoices/view/".$id);
	}

	function authorizenet($id = FALSE){

		if($_POST){
				// Authorize.net lib
				$data["core_settings"] = Setting::first();
				$this->load->library('authorize_net');
				$invoice = Invoice::find_by_id($_POST['invoice_id']);
				log_message('error', 'Authorize.net: Payment process started for invoice: #'.$data["core_settings"]->invoice_prefix.$invoice->reference);
				
				$amount = $_POST["sum"];

				$auth_net = array(
					'x_card_num'			=> str_replace(' ', '', $_POST['x_card_num']),
					'x_exp_date'			=> $_POST['x_card_month'].'/'.$_POST['x_card_year'],
					'x_card_code'			=> $_POST['x_card_code'],
					'x_description'			=> $this->lang->line('application_invoice').' #'.$data["core_settings"]->invoice_prefix.$invoice->reference,
					'x_amount'				=> $amount,
					'x_first_name'			=> $invoice->company->client->firstname,
					'x_last_name'			=> $invoice->company->client->lastname,
					'x_address'				=> $invoice->company->address,
					'x_city'				=> $invoice->company->city,
					//'x_state'				=> 'KY',
					'x_zip'					=> $invoice->company->zipcode,
					//'x_country'			=> 'US',
					'x_phone'				=> $invoice->company->phone,
					'x_email'				=> $invoice->company->client->email,
					'x_customer_ip'			=> $this->input->ip_address(),
					);
				$this->authorize_net->setData($auth_net);
				// Try to AUTH_CAPTURE
				if( $this->authorize_net->authorizeAndCapture() )
				{
					
					$this->session->set_flashdata('message', 'success: '.$this->lang->line('messages_payment_complete'));
					
					log_message('error', 'Authorize.net: Transaction ID: ' . $this->authorize_net->getTransactionId());
					log_message('error', 'Authorize.net: Approval Code: ' . $this->authorize_net->getApprovalCode());
					log_message('error', 'Authorize.net: Payment completed.');
					$invoice->status = "Paid";
					$invoice->paid_date = date('Y-m-d', time());

					$invoice->save();
					$attributes = array('invoice_id' => $invoice->id, 'reference' => $this->authorize_net->getTransactionId(), 'amount' => $amount, 'date' => date('Y-m-d', time()), 'type' => 'credit_card', 'notes' => $this->authorize_net->getApprovalCode());
					$invoiceHasPayment = InvoiceHasPayment::create($attributes);
					//send receipt to client
					receipt_notification($this->client->id, FALSE, $invoiceHasPayment->id);
					//send email to admin
					send_notification($data["core_settings"]->email, $this->lang->line('application_notification_payment_processed_subject'), $this->lang->line('application_notification_payment_processed').' #'.$data["core_settings"]->invoice_prefix.$invoiceHasPayment->invoice->reference);
					redirect('cinvoices/view/'.$invoice->id);
				}
				else
				{
					
				log_message('error', 'Authorize.net: Payment failed.');
				log_message('error', 'Authorize.net: '.$this->authorize_net->getError());

				

					$this->view_data['return_link'] = "invoices/view/".$invoice->id;

					$this->view_data['message'] = $this->authorize_net->getError();
					//$this->authorize_net->debug();


					$this->content_view = 'error/error';
				}
		}else{

			$this->view_data['invoices'] = Invoice::find_by_id($id);
			$this->view_data["settings"] = Setting::first();
			$this->view_data["sum"] = sprintf("%01.2f", $this->view_data['invoices']->outstanding);

			$this->theme_view = 'modal';
			$this->view_data['title'] = $this->lang->line('application_pay_with_credit_card');
			$this->view_data['form_action'] = 'cinvoices/authorizenet';
			$this->content_view = 'invoices/_authorizenet';
		}



	}

	
	
}