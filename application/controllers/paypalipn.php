<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Paypalipn extends MY_Controller
{
	function __construct()
	{

		parent::__construct();

		function curlInstalled() {
	    if  (in_array  ('curl', get_loaded_extensions())) {
	        return true;
	    }
	    else {
	        return false;
	    }
	}
		
	}
	
	function index()
	{		

			$this->load->helper('notification');
			$this->theme_view = 'blank';
			$settings = Setting::first();
			log_message('error', "Paypal IPN called");
			$item_number = $_POST['item_number'];

			$raw_post_data = file_get_contents('php://input');
			$raw_post_array = explode('&', $raw_post_data);
			$myPost = array();
			foreach ($raw_post_array as $keyval) {
			  $keyval = explode ('=', $keyval);
			  if (count($keyval) == 2)
			     $myPost[$keyval[0]] = urldecode($keyval[1]);
			}
			// read the IPN message sent from PayPal and prepend 'cmd=_notify-validate'
			$req = 'cmd=_notify-validate';
			if(function_exists('get_magic_quotes_gpc')) {
			   $get_magic_quotes_exists = true;
			} 
			foreach ($myPost as $key => $value) {        
			   if($get_magic_quotes_exists == true && get_magic_quotes_gpc() == 1) { 
			        $value = urlencode(stripslashes($value)); 
			   } else {
			        $value = urlencode($value);
			   }
			   $req .= "&$key=$value";
			}

			if(curlInstalled()){
				$ch = curl_init('https://www.paypal.com/cgi-bin/webscr');
				curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
				curl_setopt($ch, CURLOPT_POST, 1);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
				curl_setopt($ch, CURLOPT_POSTFIELDS, $req);
				curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
				curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
				curl_setopt($ch, CURLOPT_FORBID_REUSE, 1);
				curl_setopt($ch, CURLOPT_HTTPHEADER, array('Connection: Close'));
				// In wamp-like environments that do not come bundled with root authority certificates,
				// please download 'cacert.pem' from "http://curl.haxx.se/docs/caextract.html" and set 
				// the directory path of the certificate as shown below:
				// curl_setopt($ch, CURLOPT_CAINFO, dirname(__FILE__) . '/cacert.pem');
				if( !($res = curl_exec($ch)) ) {
					log_message('error', 'Paypal IPN: '.curl_error($ch).' when processing IPN data');
				    //error_log("Got " . curl_error($ch) . " when processing IPN data");
				    curl_close($ch);
				    exit;
				}
				curl_close($ch);
			}else{

			$header = "POST /cgi-bin/webscr HTTP/1.1\r\n";
			$header .= "Content-Type: application/x-www-form-urlencoded\r\n";
			$header .= "Host: www.paypal.com\r\n";  // www.sandbox.paypal.com for a test site
			$header .= "Content-Length: " . strlen($req) . "\r\n";
			$header .= "Connection: close\r\n\r\n";

			//$fp = fsockopen ('ssl://www.sandbox.paypal.com', 443, $errno, $errstr, 30);
			$fp = fsockopen ('ssl://www.paypal.com', 443, $errno, $errstr, 30);


				if (!$fp) {
				// HTTP ERROR Failed to connect
				 $mail_From = "From: IPN@paypal-tester.com";
				 $mail_To = $settings->email;
				 $mail_Subject = "HTTP ERROR";
				 $mail_Body = $errstr;
				 log_message('error', 'Paypal IPN - HTTP ERROR: '.$errstr);

				}
				else
				{
				  fputs($fp, $header . $req);
				  while (!feof($fp)) {
				    $res = fgets ($fp, 1024);
				    //log_message('error', 'Paypal IPN - fp handler -'.$res);

				  }
				  fclose ($fp);
				} 
			}
			    if (strcmp ($res, "VERIFIED") == 0) {
			      log_message('error', 'Paypal IPN - VERIFIED');

			      $item_name = $_POST['item_name'];
			      $item_number = $_POST['item_number'];

			      log_message('error', 'Paypal IPN - Invoice number: #'.$item_number);

			      $custom = explode('-', $_POST['custom']);  
				  $payment_currency = $_POST['mc_currency'];
			      $receiver_email = $_POST['receiver_email'];
			      $payer_email = $_POST['payer_email'];

			      log_message('error', 'Paypal IPN - Type: '.$custom[0]);
			      
		if($custom[0] == "invoice" || $custom[0] == "cinvoice"){
			$txn_id = $_POST['txn_id']; 
			$payment_amount = $_POST['mc_gross'];
			$payment_status = $_POST['payment_status'];
			$invoice = Invoice::find_by_reference($item_number);

			$currency = $invoice->currency;
			    $currency_codes = array("AFA"=>"Afghani","AFN"=>"Afghani","ALK"=>"Albanian old lek","ALL"=>"Lek","DZD"=>"Algerian Dinar","USD"=>"US Dollar","ADF"=>"Andorran Franc","ADP"=>"Andorran Peseta","EUR"=>"Euro","AOR"=>"Angolan Kwanza Readjustado","AON"=>"Angolan New Kwanza","AOA"=>"Kwanza","XCD"=>"East Caribbean Dollar","ARA"=>"Argentine austral","ARS"=>"Argentine Peso","ARL"=>"Argentine peso ley","ARM"=>"Argentine peso moneda nacional","ARP"=>"Peso argentino","AMD"=>"Armenian Dram","AWG"=>"Aruban Guilder","AUD"=>"Australian Dollar","ATS"=>"Austrian Schilling","AZM"=>"Azerbaijani manat","AZN"=>"Azerbaijanian Manat","BSD"=>"Bahamian Dollar","BHD"=>"Bahraini Dinar","BDT"=>"Taka","BBD"=>"Barbados Dollar","BYR"=>"Belarussian Ruble","BEC"=>"Belgian Franc (convertible)","BEF"=>"Belgian Franc (currency union with LUF)","BEL"=>"Belgian Franc (financial)","BZD"=>"Belize Dollar","XOF"=>"CFA Franc BCEAO","BMD"=>"Bermudian Dollar","INR"=>"Indian Rupee","BTN"=>"Ngultrum","BOP"=>"Bolivian peso","BOB"=>"Boliviano","BOV"=>"Mvdol","BAM"=>"Convertible Marks","BWP"=>"Pula","NOK"=>"Norwegian Krone","BRC"=>"Brazilian cruzado","BRB"=>"Brazilian cruzeiro","BRL"=>"Brazilian Real","BND"=>"Brunei Dollar","BGN"=>"Bulgarian Lev","BGJ"=>"Bulgarian lev A/52","BGK"=>"Bulgarian lev A/62","BGL"=>"Bulgarian lev A/99","BIF"=>"Burundi Franc","KHR"=>"Riel","XAF"=>"CFA Franc BEAC","CAD"=>"Canadian Dollar","CVE"=>"Cape Verde Escudo","KYD"=>"Cayman Islands Dollar","CLP"=>"Chilean Peso","CLF"=>"Unidades de fomento","CNX"=>"Chinese People's Bank dollar","CNY"=>"Yuan Renminbi","COP"=>"Colombian Peso","COU"=>"Unidad de Valor real","KMF"=>"Comoro Franc","CDF"=>"Franc Congolais","NZD"=>"New Zealand Dollar","CRC"=>"Costa Rican Colon","HRK"=>"Croatian Kuna","CUP"=>"Cuban Peso","CYP"=>"Cyprus Pound","CZK"=>"Czech Koruna","CSK"=>"Czechoslovak koruna","CSJ"=>"Czechoslovak koruna A/53","DKK"=>"Danish Krone","DJF"=>"Djibouti Franc","DOP"=>"Dominican Peso","ECS"=>"Ecuador sucre","EGP"=>"Egyptian Pound","SVC"=>"Salvadoran colón","EQE"=>"Equatorial Guinean ekwele","ERN"=>"Nakfa","EEK"=>"Kroon","ETB"=>"Ethiopian Birr","FKP"=>"Falkland Island Pound","FJD"=>"Fiji Dollar","FIM"=>"Finnish Markka","FRF"=>"French Franc","XFO"=>"Gold-Franc","XPF"=>"CFP Franc","GMD"=>"Dalasi","GEL"=>"Lari","DDM"=>"East German Mark of the GDR (East Germany)","DEM"=>"Deutsche Mark","GHS"=>"Ghana Cedi","GHC"=>"Ghanaian cedi","GIP"=>"Gibraltar Pound","GRD"=>"Greek Drachma","GTQ"=>"Quetzal","GNF"=>"Guinea Franc","GNE"=>"Guinean syli","GWP"=>"Guinea-Bissau Peso","GYD"=>"Guyana Dollar","HTG"=>"Gourde","HNL"=>"Lempira","HKD"=>"Hong Kong Dollar","HUF"=>"Forint","ISK"=>"Iceland Krona","ISJ"=>"Icelandic old krona","IDR"=>"Rupiah","IRR"=>"Iranian Rial","IQD"=>"Iraqi Dinar","IEP"=>"Irish Pound (Punt in Irish language)","ILP"=>"Israeli lira","ILR"=>"Israeli old sheqel","ILS"=>"New Israeli Sheqel","ITL"=>"Italian Lira","JMD"=>"Jamaican Dollar","JPY"=>"Yen","JOD"=>"Jordanian Dinar","KZT"=>"Tenge","KES"=>"Kenyan Shilling","KPW"=>"North Korean Won","KRW"=>"Won","KWD"=>"Kuwaiti Dinar","KGS"=>"Som","LAK"=>"Kip","LAJ"=>"Lao kip","LVL"=>"Latvian Lats","LBP"=>"Lebanese Pound","LSL"=>"Loti","ZAR"=>"Rand","LRD"=>"Liberian Dollar","LYD"=>"Libyan Dinar","CHF"=>"Swiss Franc","LTL"=>"Lithuanian Litas","LUF"=>"Luxembourg Franc (currency union with BEF)","MOP"=>"Pataca","MKD"=>"Denar","MKN"=>"Former Yugoslav Republic of Macedonia denar A/93","MGA"=>"Malagasy Ariary","MGF"=>"Malagasy franc","MWK"=>"Kwacha","MYR"=>"Malaysian Ringgit","MVQ"=>"Maldive rupee","MVR"=>"Rufiyaa","MAF"=>"Mali franc","MTL"=>"Maltese Lira","MRO"=>"Ouguiya","MUR"=>"Mauritius Rupee","MXN"=>"Mexican Peso","MXP"=>"Mexican peso","MXV"=>"Mexican Unidad de Inversion (UDI)","MDL"=>"Moldovan Leu","MCF"=>"Monegasque franc (currency union with FRF)","MNT"=>"Tugrik","MAD"=>"Moroccan Dirham","MZN"=>"Metical","MZM"=>"Mozambican metical","MMK"=>"Kyat","NAD"=>"Namibia Dollar","NPR"=>"Nepalese Rupee","NLG"=>"Netherlands Guilder","ANG"=>"Netherlands Antillian Guilder","NIO"=>"Cordoba Oro","NGN"=>"Naira","OMR"=>"Rial Omani","PKR"=>"Pakistan Rupee","PAB"=>"Balboa","PGK"=>"Kina","PYG"=>"Guarani","YDD"=>"South Yemeni dinar","PEN"=>"Nuevo Sol","PEI"=>"Peruvian inti","PEH"=>"Peruvian sol","PHP"=>"Philippine Peso","PLZ"=>"Polish zloty A/94","PLN"=>"Zloty","PTE"=>"Portuguese Escudo","TPE"=>"Portuguese Timorese escudo","QAR"=>"Qatari Rial","RON"=>"New Leu","ROL"=>"Romanian leu A/05","ROK"=>"Romanian leu A/52","RUB"=>"Russian Ruble","RWF"=>"Rwanda Franc","SHP"=>"Saint Helena Pound","WST"=>"Tala","STD"=>"Dobra","SAR"=>"Saudi Riyal","RSD"=>"Serbian Dinar","CSD"=>"Serbian Dinar","SCR"=>"Seychelles Rupee","SLL"=>"Leone","SGD"=>"Singapore Dollar","SKK"=>"Slovak Koruna","SIT"=>"Slovenian Tolar","SBD"=>"Solomon Islands Dollar","SOS"=>"Somali Shilling","ZAL"=>"South African financial rand (Funds code) (discont","ESP"=>"Spanish Peseta","ESA"=>"Spanish peseta (account A)","ESB"=>"Spanish peseta (account B)","LKR"=>"Sri Lanka Rupee","SDD"=>"Sudanese Dinar","SDP"=>"Sudanese Pound","SDG"=>"Sudanese Pound","SRD"=>"Surinam Dollar","SRG"=>"Suriname guilder","SZL"=>"Lilangeni","SEK"=>"Swedish Krona","CHE"=>"WIR Euro","CHW"=>"WIR Franc","SYP"=>"Syrian Pound","TWD"=>"New Taiwan Dollar","TJS"=>"Somoni","TJR"=>"Tajikistan ruble","TZS"=>"Tanzanian Shilling","THB"=>"Baht","TOP"=>"Pa'anga","TTD"=>"Trinidata and Tobago Dollar","TND"=>"Tunisian Dinar","TRY"=>"New Turkish Lira","TRL"=>"Turkish lira A/05","TMM"=>"Manat","RUR"=>"Russian rubleA/97","SUR"=>"Soviet Union ruble","UGX"=>"Uganda Shilling","UGS"=>"Ugandan shilling A/87","UAH"=>"Hryvnia","UAK"=>"Ukrainian karbovanets","AED"=>"UAE Dirham","GBP"=>"Pound Sterling","USN"=>"US Dollar (Next Day)","USS"=>"US Dollar (Same Day)","UYU"=>"Peso Uruguayo","UYN"=>"Uruguay old peso","UYI"=>"Uruguay Peso en Unidades Indexadas","UZS"=>"Uzbekistan Sum","VUV"=>"Vatu","VEF"=>"Bolivar Fuerte","VEB"=>"Venezuelan Bolivar","VND"=>"Dong","VNC"=>"Vietnamese old dong","YER"=>"Yemeni Rial","YUD"=>"Yugoslav Dinar","YUM"=>"Yugoslav dinar (new)","ZRN"=>"Zairean New Zaire","ZRZ"=>"Zairean Zaire","ZMK"=>"Kwacha","ZWD"=>"Zimbabwe Dollar","ZWC"=>"Zimbabwe Rhodesian dollar");
				if(!array_key_exists($currency, $currency_codes)){
					$currency = $settings->paypal_currency;
				}

			      if (($payment_status == 'Completed' || $payment_status == 'Processed' || $payment_status == 'Sent' || $payment_status == 'Pending') &&   //payment_status = Completed
			         ($receiver_email == $settings->paypal_account) &&   // receiver_email is same as your account email
			         ($payment_currency == $currency)) {  

			    	
				    	
						$invoice->paid_date = date("Y-m-d", time());
						$invoice->status = "Paid";
						$invoice->save();

						$payment_reference = $invoice->reference.'00'.InvoiceHasPayment::count(array('conditions' => 'invoice_id = '.$invoice->id))+1;
						$attributes = array('invoice_id' => $invoice->id, 'reference' => $payment_reference, 'amount' => $payment_amount, 'date' => date("Y-m-d", time()), 'type' => 'paypal', 'notes' => '');
						$invoiceHasPayment = InvoiceHasPayment::create($attributes);

						log_message('error', 'Paypal IPN - Success: Invoice #'.$settings->invoice_prefix.$item_number.' payment processed via Paypal.');
						//send email to admin
						send_notification($settings->email, $this->lang->line('application_notification_payment_processed_subject'), $this->lang->line('application_notification_payment_processed').' #'.$settings->invoice_prefix.$item_number);
						//send receipt to client
						receipt_notification($invoiceHasPayment->invoice->company->client->id, FALSE, $invoiceHasPayment->id);

						
			      }
			      else
			      {


			          $mail_To =  $settings->email;
			          $mail_Subject = "PayPal IPN status not completed or security check fail";

			          $mail_Body = "Something wrong. \n\nThe transaction ID number is: $txn_id \n\n Payment status = $payment_status \n\n Payment amount = $payment_amount";
			          mail($mail_To, $mail_Subject, $mail_Body);
			          log_message('error', 'Paypal IPN - Error: Invoice #'.$settings->invoice_prefix.$item_number.'. PayPal IPN status not completed or security check fail');
			          if($payment_currency != $currency){
			          	log_message('error', 'Paypal IPN - Error: Invoice and Paypal currency do not match: '.$payment_currency.' != '. $currency);
			          }
			           if($receiver_email != $settings->paypal_account){
			          	log_message('error', 'Paypal IPN - Error: Receiver email addresses do not match: '.$receiver_email.' != '. $settings->paypal_account);
			          }
			      	  log_message('error', 'Paypal IPN - Error: Paypal transaction status: '.$payment_status.'.');
			      }

			}elseif($custom[0] == "subscription" || $custom[0] == "csubscription"){
				$txn_type = $_POST["txn_type"];
				log_message('error', 'Paypal IPN - '.$_POST["subscr_id"]);
				if (($txn_type == "subscr_signup") &&  
			         ($receiver_email == $settings->paypal_account) && 
			         ($_POST['mc_amount3'] == $custom[1]) && 
			         ($payment_currency == $settings->paypal_currency)) {  

						$Subscription = Subscription::find_by_reference($item_number);
						$Subscription->subscribed = date("Y-m-d", time());
						$Subscription->save();
						log_message('error', 'Paypal IPN - Success: Subscription #'.$settings->subscription_prefix.$item_number.' payment processed via Paypal.');
						send_notification($settings->email, $this->lang->line('application_notification_subscribed_subject'), $this->lang->line('application_notification_subscribed').' #'.$settings->subscription_prefix.$item_number);
				}
			}


			    }
			    else if (strcmp ($res, "INVALID") == 0) {
				if(!$_POST){echo "IPN cannot be called outside of a paypal request!";}else{
			      log_message('error', 'Paypal IPN - Error: Invoice #'.$settings->subscription_prefix.$item_number.'. We have had an INVALID response. \n\nThe transaction ID number is: $txn_id \n\n username = $username');
				 
				}
			    }
			  
			
			}

		
	}
	
	
