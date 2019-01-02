<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Expenses extends MY_Controller {
               
	function __construct()
	{
		parent::__construct();
		$access = FALSE;
		if($this->client){	
			redirect('cprojects');
		}elseif($this->user){
			foreach ($this->view_data['menu'] as $key => $value) { 
				if($value->link == "expenses"){ $access = TRUE;}
			}
			if(!$access){redirect('login');}
		}else{
			redirect('login');
		}
		$this->view_data['submenu'] = array(
				 		$this->lang->line('application_all') => 'expenses',
				 		$this->lang->line('application_open') => 'expenses/filter/open',
				 		$this->lang->line('application_Sent') => 'expenses/filter/sent',
				 		$this->lang->line('application_Paid') => 'expenses/filter/paid',
				 		);	
		
	}	
	function index()
	{
		$this->view_data['userlist'] = User::find('all', array('conditions' => array('status = ?', 'active')));
		$this->view_data['user_id'] = 0;
		$this->view_data['year'] = date("Y");
		$this->view_data['month'] = 0;
		$year = date("Y");
		
		//statistic
		$graph_month = date('m');
		$days_in_this_month = days_in_month($graph_month, $year);
		$lastday_in_month =  strtotime($year."-12-31");
		$firstday_in_month =  strtotime($year."-01-01");
		$this->view_data['days_in_this_month'] = 12;
		$this->view_data['expenses_this_month'] = Expense::count(array('conditions' => 'UNIX_TIMESTAMP(`date`) <= '.$lastday_in_month.' and UNIX_TIMESTAMP(`date`) >= '.$firstday_in_month));
		$this->view_data['expenses_owed_this_month'] = Expense::find_by_sql('select sum(value) AS "owed" from expenses where UNIX_TIMESTAMP(`date`) >= "'.$firstday_in_month.'" AND UNIX_TIMESTAMP(`date`) <= "'.$lastday_in_month.'"');	
		$this->view_data['expenses_due_this_month_graph'] = Expense::find_by_sql('select sum(value) AS "owed", MONTH(`date`) as `date` from expenses where UNIX_TIMESTAMP(`date`) >= "'.$firstday_in_month.'" AND UNIX_TIMESTAMP(`date`) <= "'.$lastday_in_month.'" Group By MONTH(`date`)');

		$this->view_data['expenses'] = Expense::find('all', array('conditions' => array("date >= '$year-01-01' and date <= '$year-12-31'")));
		

		$this->content_view = 'expenses/all';
	}
	function filter($userid = FALSE, $year = FALSE, $month = FALSE)
	{
		$this->view_data['userlist'] = User::find('all', array('conditions' => array('status = ?', 'active')));
		$this->view_data['username'] = User::find_by_id($userid);
		$this->view_data['user_id'] = $userid;
		$this->view_data['year'] = $year;
		$this->view_data['month'] = $month;

		$search = "";
		$stats_search = "";
		if($userid){
			$search .= "user_id = $userid and "; 
			$stats_search = " AND user_id = $userid ";
		}
		if($month && $year){
			$search .= "date >= '$year-$month-01' and date <= '$year-$month-31'";
		}else{
			$search .= "date >= '$year-01-01' and date <= '$year-12-31'";
		}
		//statistic
		$graph_month = $month != 0 ? $month : date('m');
		if($month == 0){
			$lastday_in_month =  strtotime($year."-12-31");
		$firstday_in_month =  strtotime($year."-01-01");
		$this->view_data['days_in_this_month'] = 12;
		$this->view_data['expenses_this_month'] = Expense::count(array('conditions' => 'UNIX_TIMESTAMP(`date`) <= '.$lastday_in_month.' and UNIX_TIMESTAMP(`date`) >= '.$firstday_in_month.$stats_search));
		$this->view_data['expenses_owed_this_month'] = Expense::find_by_sql('select sum(value) AS "owed" from expenses where UNIX_TIMESTAMP(`date`) >= "'.$firstday_in_month.'" AND UNIX_TIMESTAMP(`date`) <= "'.$lastday_in_month.'"'.$stats_search);	
		$this->view_data['expenses_due_this_month_graph'] = Expense::find_by_sql('select sum(value) AS "owed", MONTH(`date`) as `date` from expenses where UNIX_TIMESTAMP(`date`) >= "'.$firstday_in_month.'" AND UNIX_TIMESTAMP(`date`) <= "'.$lastday_in_month.'"'.$stats_search.' Group By MONTH(`date`)');

	}else{
		$days_in_this_month = days_in_month($graph_month, $year);
		$lastday_in_month =  strtotime($year."-".$graph_month."-".$days_in_this_month);
		$firstday_in_month =  strtotime($year."-".$graph_month."-01");
		$this->view_data['days_in_this_month'] = $days_in_this_month;
		$this->view_data['expenses_this_month'] = Expense::count(array('conditions' => 'UNIX_TIMESTAMP(`date`) <= '.$lastday_in_month.' and UNIX_TIMESTAMP(`date`) >= '.$firstday_in_month.$stats_search));
		$this->view_data['expenses_owed_this_month'] = Expense::find_by_sql('select sum(value) AS "owed" from expenses where UNIX_TIMESTAMP(`date`) >= "'.$firstday_in_month.'" AND UNIX_TIMESTAMP(`date`) <= "'.$lastday_in_month.'"'.$stats_search);
		$this->view_data['expenses_due_this_month_graph'] = Expense::find_by_sql('select sum(value) AS "owed", `date` from expenses where UNIX_TIMESTAMP(`date`) >= "'.$firstday_in_month.'" AND UNIX_TIMESTAMP(`date`) <= "'.$lastday_in_month.'"'.$stats_search.' Group By `date`');
		}

		$this->view_data['expenses'] = Expense::find('all', array('conditions' => array("$search")));
		$this->content_view = 'expenses/all';
	}
	function create()
	{	
		if($_POST){
			unset($_POST['send']);
			unset($_POST['_wysihtml5_mode']);
			unset($_POST['files']);

			$config['upload_path'] = './files/media/';
					$config['encrypt_name'] = TRUE;
					$config['allowed_types'] = '*';

					$this->load->library('upload', $config);

					if ($this->upload->do_upload())

						{
							$data = array('upload_data' => $this->upload->data());

							if($_POST['attachment_description'] == ""){
								$_POST['attachment_description'] = $data['upload_data']['orig_name'];
							}
							$_POST['attachment'] = $data['upload_data']['file_name'];
						}

			if($_POST["type"] == "recurring_payment"){
				$_POST["next_payment"] = date('Y-m-d', strtotime($_POST["recurring"], strtotime ($_POST["date"])));
			}			
			$expense = Expense::create($_POST);

       		if(!$expense){$this->session->set_flashdata('message', 'error:'.$this->lang->line('messages_create_expense_error'));}
       		else{$this->session->set_flashdata('message', 'success:'.$this->lang->line('messages_create_expense_success'));}
			redirect('expenses');
		}else
		{
			$this->view_data['expenses'] = Expense::all();
			$this->view_data['next_reference'] = Expense::last();
			if($this->user->admin != 1){
				$this->view_data['projects'] = $this->user->projects;
				$this->view_data['companies'] = $this->user->companies;
			}else{
				$this->view_data['projects'] = Project::all();
				$this->view_data['companies'] = Company::find('all',array('conditions' => array('inactive=?','0')));
			} 
			
			$this->view_data['core_settings'] = Setting::first();
			
			$this->theme_view = 'modal';
			$this->view_data['users'] = User::find('all', array('conditions' => array('status=?', 'active')));
			$this->view_data['categories'] = Expense::find_by_sql("select category from expenses group by category");
			$this->view_data['title'] = $this->lang->line('application_create_expense');
			$this->view_data['form_action'] = 'expenses/create';
			$this->content_view = 'expenses/_expense';
		}	
	}	
	function update($id = FALSE, $getview = FALSE)
	{	
		if($_POST){
			unset($_POST['send']);
			unset($_POST['_wysihtml5_mode']);
			unset($_POST['files']);

			$config['upload_path'] = './files/media/';
					$config['encrypt_name'] = TRUE;
					$config['allowed_types'] = '*';

					$this->load->library('upload', $config);

					if ($this->upload->do_upload())

						{
							$data = array('upload_data' => $this->upload->data());

							if($_POST['attachment_description'] == ""){
								$_POST['attachment_description'] = $data['upload_data']['orig_name'];
							}
							$_POST['attachment'] = $data['upload_data']['file_name'];
						}

			$id = $_POST['id'];

			$expense = Expense::find_by_id($id);

			if($expense->type != "recurring_payment" && $_POST["type"] == "recurring_payment"){
				$_POST["next_payment"] = date('Y-m-d', strtotime($_POST["recurring"], strtotime ($_POST["date"])));
			}	

			$expense->update_attributes($_POST);
			
       		if(!$expense){$this->session->set_flashdata('message', 'error:'.$this->lang->line('messages_save_expense_error'));}
       		else{$this->session->set_flashdata('message', 'success:'.$this->lang->line('messages_save_expense_success'));}
			redirect('expenses');
			
		}else
		{
			$this->view_data['next_reference'] = Expense::last();
			$this->view_data['expense'] = Expense::find_by_id($id);
			$this->view_data['projects'] = Project::all();
			$this->view_data['core_settings'] = Setting::first();
			$this->view_data['users'] = User::find('all', array('conditions' => array('status=?', 'active')));
			$this->view_data['companies'] = Company::find('all',array('conditions' => array('inactive=?','0')));
			$this->theme_view = 'modal';
			$this->view_data['categories'] = Expense::find_by_sql("select category from expenses group by category");
			$this->view_data['title'] = $this->lang->line('application_create_expense');
			$this->view_data['form_action'] = 'expenses/update';
			$this->content_view = 'expenses/_expense';
		}	
	}	
	function attachment($id = FALSE){
		$this->load->helper('download');
		$this->load->helper('file');
		$media = Expense::find_by_id($id);

        $file = './files/media/'.$media->attachment;
		$mime = get_mime_by_extension($file);
        $extension = end(explode('.', $media->attachment));
        $basename = ($media->attachment_description != '') ? trim($media->attachment_description).'.'.$extension : $media->attachment;
        if (file_exists($file)) {
            if ($mime != '') {
                header('Content-Type: ' . $mime,true,200);
            } else {
                header('Content-type: application/octet-stream');
            }
            header('Content-Description: File Transfer');
            header('Content-Disposition: attachment; filename=' . basename($basename));
            header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
            header('Expires: 0');
            header('Content-Length: ' . filesize($file));

            readfile_chunked($file);
            @ob_end_flush();
            exit;
        } else {
            show_error('File could not be found!', 400, 'File download error');
        }

	}
	
	

	function delete($id = FALSE)
	{	
		$expense = Expense::find($id);
		$expense->delete();
		$this->content_view = 'expenses/all';
		if(!$expense){$this->session->set_flashdata('message', 'error:'.$this->lang->line('messages_delete_expense_error'));}
       		else{$this->session->set_flashdata('message', 'success:'.$this->lang->line('messages_delete_expense_success'));}
			redirect('expenses');
	}
	
	
	
	
	
}