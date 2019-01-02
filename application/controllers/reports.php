<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class reports extends MY_Controller
{
	function __construct()
	{

		parent::__construct();
		$access = FALSE;	
		$this->view_data['update'] = FALSE;
		if($this->client){	
			redirect('cprojects');
		}elseif($this->user){
				if(in_array("reports", $this->view_data['module_permissions'])){
					$access = TRUE;
				}
			if(!$access && !empty($this->view_data['menu'][0])){
				redirect($this->view_data['menu'][0]->link);
			}elseif(empty($this->view_data['menu'][0])){
				$this->view_data['error'] = "true";
				$this->session->set_flashdata('message', 'error: You have no access to any modules!');
				redirect('login');
			}
			
		}else{
			redirect('login');
		}

		
		//Events
		$events = array();
		$date = date('Y-m-d', time());
		$eventcount = 0;
 				
				
				if(in_array("projects", $this->view_data['module_permissions'])){
					$sql = 'SELECT * FROM project_has_tasks WHERE status != "done" AND user_id = "'.$this->user->id.'" ORDER BY project_id';
					$taskquery = ProjectHasTask::find('all', array('conditions' => array('status != ? and user_id = ?', 'done', $this->user->id), 'order' => 'project_id desc'));
					$this->view_data["tasks"] = $taskquery;
				} 

		$this->load->helper('curl');
		
	}

	function period()
	{ 
		if($_POST){
			$report = $_POST['report'];
			$start = $_POST['start']; 
			$end = $_POST['end'];
		}
		
		if($report == "clients"){
			$this->income_by_clients($start, $end); 
			$this->view_data["report_selected"] = $report;
		}else{
		$this->index($start, $end);
		}
	}
	function index($start = FALSE, $end = FALSE)
	{
		$core_settings = Setting::first();
		$year = date('Y', time()); 
		if(!$start){
			$start = date('Y', time())."-01-01";
		}
		if(!$end){
			$end = date('Y', time())."-12-31";	
		} 


		$this->view_data["stats_start_short"] = $start;
		$this->view_data["stats_end_short"] = $end;

		$this->view_data["core_settings"] = $core_settings;

		$this->view_data["stats_start"] = human_to_unix($start.' 00:00');
		$this->view_data["stats_start"] = date($core_settings->date_format, $this->view_data["stats_start"]);
		$this->view_data["stats_end"] = human_to_unix($end.' 00:00');
		$this->view_data["stats_end"] = date($core_settings->date_format, $this->view_data["stats_end"]);
		$currentYearMonth = date('Y-m', time());
		$thismonth = date('m');
		$yearMonth = $year.'-'.$thismonth;


			// View Values
			$this->view_data["month"] = date('M');
			$this->view_data["year"] = $year;
			$this->view_data["stats"] 						= Invoice::getIssueStatisticFor($start, $end);
			$this->view_data["stats_expenses"] 				= Invoice::getExpensesStatisticFor($start, $end);
			$this->view_data["totalExpenses"] 				= 0;
			$this->view_data["totalIncomeForYear"] 			= 0;
			


			//Format main statistic labels and values
			$line1 = '';
			$line2 = '';
		    $labels = '';

			$start_month    = new DateTime($start);
			$start_month->modify('first day of this month');
			$end_month      = new DateTime($end);
			$end_month->modify('first day of next month');
			$interval = DateInterval::createFromDateString('1 month');
			$period   = new DatePeriod($start_month, $interval, $end_month);

		    foreach ($period as $dt) {
				$monthname = $dt->format("M");
				$monthname = $this->lang->line('application_'.$monthname);
		        $num = "0";
		        $num2 = "0";
		        foreach ($this->view_data["stats"] as $value):
		          $act_month = explode("-", $value->issue_date); 
		      	  $act_year_month = $act_month[0].$act_month[1];
		          if($act_year_month == $dt->format("Ym")){  
		            $num = sprintf("%02.2d", $value->summary); 
		          }
		        endforeach; 
		        foreach ($this->view_data["stats_expenses"] as $value):
		          $act_month = explode("-", $value->date_month); 
		          $act_year_month = $act_month[0].$act_month[1];
		          if($act_year_month == $dt->format("Ym")){  
		            $num2 = sprintf("%02.2d", $value->summary); 
		          }
		        endforeach; 
		          $labels .= '"'.$monthname.'"';
		          $line1 .= $num;
		          $this->view_data["totalIncomeForYear"] = $this->view_data["totalIncomeForYear"]+$num;
		          $line2 .= $num2;
		          $this->view_data["totalExpenses"] = $this->view_data["totalExpenses"]+$num2;
		          $line1 .= ","; $line2 .= ","; $labels .= ",";
		        } 
		    $this->view_data["labels"] = rtrim($labels, ",");
		    $this->view_data["line1"] = rtrim($line1);
		    $this->view_data["line2"] = rtrim($line2);
		    $this->view_data["totalProfit"] 				= $this->view_data["totalIncomeForYear"]-$this->view_data["totalExpenses"];

		    $this->view_data['form_action'] = 'reports/period';
			$this->content_view = 'reports/reports';


			/* Tax report */

			$this->view_data['report_year'] = date('Y', human_to_unix($start.' 00:00'));

			$options = array('conditions' => array('estimate != ? and status != ? and issue_date >= ? and issue_date <= ?',1,'Canceled',$start,$end));
			$this->view_data['invoices'] = Invoice::find('all', $options);

			$options = array('conditions' => array('date >= ? and date <= ?',$start,$end));
			$this->view_data['expenses'] = Expense::find('all', $options);

	/* Ust report */

			/* this month */
			$options = array('conditions' => array('estimate != ? and status != ? and issue_date >= ? and issue_date <= ?',1,'Canceled',$currentYearMonth."-01",$currentYearMonth."-".date('t')));
			$invoices_of_this_month = Invoice::find('all', $options);

			$options = array('conditions' => array('date >= ? and date <= ?',$currentYearMonth."-01",$currentYearMonth."-".date('t')));
			$expenses_of_this_month = Expense::find('all', $options);



			$income_of_this_month = 0;
			foreach ($invoices_of_this_month as $value) {
				$tax = floatval("1.".$value->tax);
				$income_of_this_month = $income_of_this_month+($value->sum-($value->sum/$tax));
			}

			$tax_of_this_month = 0;
			foreach ($expenses_of_this_month as $value) {
				$vat = floatval("1.".$value->vat);
				$tax_of_this_month = $tax_of_this_month+($value->value-($value->value/$vat));
			}
			$this->view_data['tax_of_this_month'] = $income_of_this_month-$tax_of_this_month;

			/* last month */

			$lastMonthFirstDay = date("Y-m-d", strtotime("first day of previous month"));
			$lastMonthLastDay = date("Y-m-d", strtotime("last day of previous month"));

			$this->view_data['last_month'] = date("M", strtotime("last day of previous month"));

			$options = array('conditions' => array('estimate != ? and status != ? and issue_date >= ? and issue_date <= ?',1,'Canceled',$lastMonthFirstDay,$lastMonthLastDay));
			$invoices_of_last_month = Invoice::find('all', $options);

			$options = array('conditions' => array('date >= ? and date <= ?',$lastMonthFirstDay,$lastMonthLastDay));
			$expenses_of_last_month = Expense::find('all', $options);


			$income_of_last_month = 0;
			$gross_of_last_month = 0;
			foreach ($invoices_of_last_month as $value) {
				$tax = floatval("1.".$value->tax);
				$income_of_last_month = $income_of_last_month+($value->sum-($value->sum/$tax));
				$gross_of_last_month = $gross_of_last_month+($value->sum-($value->sum-($value->sum/$tax)));
			}

			$paid_tax_of_last_month = 0;
			foreach ($expenses_of_last_month as $value) {
				$vat = floatval("1.".$value->vat);
				$paid_tax_of_last_month = $paid_tax_of_last_month-($value->value-($value->value/$vat));
				$tax_of_last_month = $tax_of_last_month+($value->value-($value->value/$vat));
			}
			$this->view_data['gross_of_last_month'] = $gross_of_last_month;
			$this->view_data['paid_tax_of_last_month'] = $paid_tax_of_last_month;
			$this->view_data['tax_of_last_month'] = $income_of_last_month-$tax_of_last_month;

		
	}

	function income_by_clients($start = FALSE, $end = FALSE)
	{
		$core_settings = Setting::first();
		$year = date('Y', time()); 
		if(!$start){
			$start = date('Y', time())."-01-01";
		}
		if(!$end){
			$end = date('Y', time())."-12-31";	
		} 
		$this->view_data["stats_start_short"] = $start;
		$this->view_data["stats_end_short"] = $end;

		$this->view_data["stats_start"] = human_to_unix($start.' 00:00');
		$this->view_data["stats_start"] = date($core_settings->date_format, $this->view_data["stats_start"]);
		$this->view_data["stats_end"] = human_to_unix($end.' 00:00');
		$this->view_data["stats_end"] = date($core_settings->date_format, $this->view_data["stats_end"]);
		$currentYearMonth = date('Y-m', time());
		$thismonth = date('m');
		$yearMonth = $year.'-'.$thismonth;


			// View Values
			$this->view_data["month"] = date('M');
			$this->view_data["year"] = $year;

			$this->view_data["stats"] 						= Invoice::getStatisticForClients($start, $end);
			//echo "<pre>"; print_r($this->view_data["stats"]); die();
			$this->view_data["stats_expenses"] 				= Invoice::getExpensesStatisticFor($start, $end);
			$this->view_data["totalExpenses"] 				= 0;
			$this->view_data["totalIncomeForYear"] 			= 0;

			//Format main statistic labels and values
			$line1 = '';
			$line2 = '';
		    $labels = '';
		    $untilMonth = ($end) ? date_format(date_create_from_format('Y-m-d', $end), 'm') : 12;
		


		        $num = "0";
		        $num2 = "0";
		        foreach ($this->view_data["stats"] as $value):
		        	$company = Company::find_by_id($value->company_id);
		            $line1 .= sprintf("%02.2d", $value->summary).","; 
		       	 	$labels .= (is_object($company)) ? '"'.$company->name.'",' : '"'.$this->lang->line('application_no_client_assigned').'",';

		        endforeach; 

		        
		    $this->view_data["labels"] = $labels;
		    $this->view_data["line1"] = $line1;
		    $this->view_data["line2"] = $line2;
		    $this->view_data["totalProfit"] 				= $this->view_data["totalIncomeForYear"]->$this->view_data["totalExpenses"];

		    $this->view_data['form_action'] = 'reports/period';
			$this->content_view = 'reports/reports';
		
	}

}


