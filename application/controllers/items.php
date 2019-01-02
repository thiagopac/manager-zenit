<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Items extends MY_Controller {
               
	function __construct()
	{
		parent::__construct();
		$access = FALSE;
		if($this->client){	
			redirect('cprojects');
		}elseif($this->user){
			foreach ($this->view_data['menu'] as $key => $value) { 
				if($value->link == "items"){ $access = TRUE;}
			}
			if(!$access){redirect('login');}
		}else{
			redirect('login');
		}
		$this->view_data['submenu'] = array(
				 		$this->lang->line('application_all_items') => 'items'
				 		);	
		
	}	
	function index()
	{
		$this->view_data['items'] = Item::find('all',array('conditions' => array('inactive=?','0')));
		$this->content_view = 'invoices/items';
	}
	function create_items(){
		if($_POST){
			unset($_POST['send']);
			$_POST['inactive'] = 0;
			$description = $_POST['description'];
			$_POST = array_map('htmlspecialchars', $_POST);
			$_POST['description'] = $description;
			$item = Item::create($_POST);
       		if(!$item){$this->session->set_flashdata('message', 'error:'.$this->lang->line('messages_create_item_error'));}
       		else{$this->session->set_flashdata('message', 'success:'.$this->lang->line('messages_create_item_success'));}
			redirect('items');
			
		}else
		{
			$this->theme_view = 'modal';
			$this->view_data['title'] = $this->lang->line('application_create_item');
			$this->view_data['form_action'] = 'items/create_items';
			$this->content_view = 'invoices/_items';
		}	
	}
	function update_items($id = FALSE){
		if($_POST){
			unset($_POST['send']);
			$description = $_POST['description'];
			$_POST = array_map('htmlspecialchars', $_POST);
			$_POST['description'] = $description;
			$id = $_POST['id'];
			$item = Item::find($id);
			$item = $item->update_attributes($_POST);
       		if(!$item){$this->session->set_flashdata('message', 'error:'.$this->lang->line('messages_save_item_error'));}
       		else{$this->session->set_flashdata('message', 'success:'.$this->lang->line('messages_save_item_success'));}
			redirect('items');
			
		}else
		{
			$this->view_data['items'] = Item::find($id);
			$this->theme_view = 'modal';
			$this->view_data['title'] = $this->lang->line('application_edit_item');
			$this->view_data['form_action'] = 'items/update_items';
			$this->content_view = 'invoices/_items';
		}	
	}
	function delete_items($id = FALSE){
		$item = Item::find($id);
		$item->inactive = 1;
		$item->save();
		if(!$item){$this->session->set_flashdata('message', 'error:'.$this->lang->line('messages_delete_item_error'));}
       	else{$this->session->set_flashdata('message', 'success:'.$this->lang->line('messages_delete_item_success'));}
		redirect('items');
	}
	
}