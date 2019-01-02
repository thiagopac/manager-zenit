<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Api extends MY_Controller {
               
	function __construct()
	{
		parent::__construct();

		$api_token = end($this->uri->segment_array());
		$user = User::find_by_token($api_token);
		$client = Client::find_by_token($api_token);
		$error = ($user == NULL && $client == NULL) ? 'Token is not valid!' : false;
		if($error){
			json_response("error", $this->lang->line('application_token_not_valid'));
		}  
		$this->user = $user;
		$this->client = $client;
	}
	public function ical($projects = "false"){ 

		if(($this->user != NULL && !$this->user->has_permission_to("calendar", $this->user)) || ($this->client != NULL && !$this->client->has_permission_to("ccalendar", $this->client))){ 
			json_response("error", $this->lang->line('application_no_permissions'));
		}

		function ical_split($preamble, $value) {
		  $value = trim($value);
		  $value = strip_tags($value);
		  $value = preg_replace('/\n+/', ' ', $value);
		  $value = preg_replace('/\s{2,}/', ' ', $value);
		  $preamble_len = strlen($preamble);
		  $lines = array();
		  while (strlen($value)>(75-$preamble_len)) {
		    $space = (75-$preamble_len);
		    $mbcc = $space;
		    while ($mbcc) {
		      $line = mb_substr($value, 0, $mbcc);
		      $oct = strlen($line);
		      if ($oct > $space) {
		        $mbcc -= $oct-$space;
		      }
		      else {
		        $lines[] = $line;
		        $preamble_len = 1; // Still take the tab into account
		        $value = mb_substr($value, $mbcc);
		        break;
		      }
		    }
		  }
		  if (!empty($value)) {
		    $lines[] = $value;
		  }
		  return join($lines, "\n\t");
		}


		ob_start();
		header('Content-type: text/calendar; charset=utf-8');
		header('Content-Disposition: inline; filename=ical.ics');
		// the iCal date format.
		define('DATE_ICAL', 'Ymd\THis');
		
		$output = "BEGIN:VCALENDAR\r\n" .
		"VERSION:2.0\r\n" .
		"PRODID:FreelanceCockpit\r\n" .
		"CALSCALE:GREGORIAN\r\n" .
		"X-WR-TIMEZONE:".date_default_timezone_get()."\r\n" .
		"METHOD:PUBLISH\r\n";

		if($projects == "true"){ 
			if($this->user->admin == 0){ 
					$comp_array = array();
					$thisUserHasNoCompanies = (array) $this->user->companies;
							if(!empty($thisUserHasNoCompanies)){
						foreach ($this->user->companies as $value) {
							array_push($comp_array, $value->id);
						}
						$projects_by_client_admin = Project::find('all', array('conditions' => array('company_id in (?)', $comp_array)));

							//merge projects by client admin and assigned to projects
							$result = array_merge( $projects_by_client_admin, $this->user->projects );
							//duplicate objects will be removed
							$result = array_map("unserialize", array_unique(array_map("serialize", $result)));
							//array is sorted on the bases of id
							sort( $result );

							$projects = $result;
					}else{
						$projects = $this->user->projects;
					}
				}else{
					$projects = Project::all();
				}
				foreach ($projects as $value) {

				 $output .= "BEGIN:VEVENT\r\n" .
							"SUMMARY:".ical_split('SUMMARY:', $this->lang->line('application_project')." - ".$value->name). "\r\n" .
							"UID:".$value->id."@fcproject\r\n" .
							"STATUS:" . strtoupper("CONFIRMED") . "\r\n" .
							"DTSTAMP:" . date(DATE_ICAL, strtotime($value->start.date('T'))) . "\r\n" .
							"DTSTART:" . date(DATE_ICAL, strtotime($value->start.date('T'))) . "\r\n" .
							"DTEND:" . date(DATE_ICAL, strtotime($value->end.date('T'))) . "\r\n" .
							"DESCRIPTION:" . ical_split('DESCRIPTION:', $value->description) . "\r\n" .
							"END:VEVENT\r\n";
				}
		} // end if Project

		 
		$events = Event::all();
		// loop over events
		foreach ($events as $appointment){
			 $output .=
			"BEGIN:VEVENT\r\n" .
			"SUMMARY:".ical_split('SUMMARY:', $appointment->title). "\r\n" .
			"UID:".$appointment->id."@fcclendar\r\n" .
			"STATUS:" . strtoupper("CONFIRMED") . "\r\n" .
			"DTSTAMP:" . date(DATE_ICAL, strtotime($appointment->start.date('T'))) . "\r\n" .
			"DTSTART:" . date(DATE_ICAL, strtotime($appointment->start.date('T'))) . "\r\n" .
			"DTEND:" . date(DATE_ICAL, strtotime($appointment->end.date('T'))) . "\r\n" .
			"DESCRIPTION:" . ical_split('DESCRIPTION:', $appointment->description) . "\r\n" .
			"END:VEVENT\r\n";
		}
		 
		// close calendar
		$output .= "END:VCALENDAR";
		echo $output;
		exit;
	}
}