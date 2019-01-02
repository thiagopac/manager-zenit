<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Quotation extends MY_Controller {
               
	function __construct()
	{
		parent::__construct();

		
		if($this->input->cookie('fc2language') != ""){ $language = $this->input->cookie('fc2language');}else{ if(!empty($core_settings->language)){$language = $core_settings->language; }else{ $language = "english"; } }
		$this->lang->load('quotation', $language);

		if($this->client){	
			
		}elseif($this->user){

		}else{
			//redirect('quotation/');
		}
		$this->view_data['submenu'] = array(
				 		$this->lang->line('application_quotation') => 'Quotation'
				 		);	
		
	}	
	function index()
	{
		if($_POST){
			unset($_POST['send']);
			$_POST = array_map('htmlspecialchars', $_POST);
			$_POST['status'] = "New"; 
			$_POST['date'] = date("Y-m-d H:i", time()); 
			$item = Quote::create($_POST);
       		if(!$item){$this->session->set_flashdata('message', 'error:'.$this->lang->line('quotation_create_error'));}
       		else{
       				$this->load->helper('notification');
       				$this->session->set_flashdata('message', 'success:'.$this->lang->line('quotation_create_success'));
       				$admins = User::find('all', array('conditions' => array('admin = ? AND status = ?', '1', 'active')));
       				foreach ($admins as &$value):
					send_notification($value->email, $this->lang->line('application_notification_quotation_subject'), $this->lang->line('application_notification_quotation'));
					endforeach;
       		}
			redirect('quotation');
			
		}else
		{
		$this->theme_view = 'fullpage';
		$this->view_data['form_action'] = 'quotation';
		$this->content_view = 'quotation/_main';
		}
	}
	function qid($id = FALSE)
	{
		$this->view_data['quotation'] = Customquote::find_by_id($id);

		if($_POST){
			if(!$this->view_data['quotation']){redirect('');}
			unset($_POST['send']);
			$_POST = array_map('htmlspecialchars', $_POST);
			$tfields = explode("||", $_POST["tfields"]);
			unset($_POST['tfields']);
			unset($tfields["section_break"]);
			$counter = 0;
			$form = "";
			foreach ($_POST as $key => $value) {

				if($key != "captcha" && $key != "confirmcaptcha" && $key != "section_break" && !strpos($key, '_')){
				if(empty($value)){$value = "-";}
				$form .= '<div class="question">'.$tfields[$counter].'</div>'; 
				$form .= '<div class="answer">'.$value.'</div>';
				$counter = $counter+1;
				}
				elseif(strpos($key, '_')){
					$checkbox_explode = explode("_", $key);
					
					if(isset($check)){
						if($check != $checkbox_explode[0]){						
						 if(!empty($tfields[$counter])){$form .= '<div class="question">'.$tfields[$counter].'</div>';}
						 $check = $checkbox_explode[0];
						 $counter = $counter+1;
						}
					}else{
						
						if(!empty($tfields[$counter])){$form .= '<div class="question">'.$tfields[$counter].'</div>';}
						$check = $checkbox_explode[0];
						$counter = $counter+1;
						
					}
					

					$form .= '<div class="answer"><i class="icon dripicons-checkmark"></i> '.$value.'</div>';
					
					
				}elseif($key == "section_break"){
					$counter = $counter+1;
					$form .= "<hr>";
				}

			}
			
			$attributes = array('form' => $form, 'status' => 'New', 'custom_quotation_id' => $id, 'date' => date("Y-m-d H:i", time()));
			$item = Quoterequest::create($attributes);
       		if(!$item){$this->session->set_flashdata('message', 'error:'.$this->lang->line('quotation_create_error'));}
       		else{
       				$this->load->helper('notification');
       				$this->session->set_flashdata('message', 'success:'.$this->lang->line('quotation_create_success'));
       				$admins = User::find('all', array('conditions' => array('admin = ? AND status = ?', '1', 'active')));
       				foreach ($admins as &$value):
					send_notification($value->email, $this->lang->line('application_notification_quotation_subject'), $this->lang->line('application_notification_quotation'));
					endforeach;
       		}
			redirect('quotation/qid/'.$id);
			
		}else
		{
		$this->theme_view = 'fullpage';
		
		if(!$this->view_data['quotation']){redirect('quotation');}
		$this->view_data['form_action'] = 'quotation/qid/'.$id;

			  $json_output = json_decode($this->view_data['quotation']->formcontent);
			  $html_fields = "";
			  $i = 0;

			  foreach ( $json_output->fields as $field )
			  {
			    $i = $i++;
			    $required = '';

			  	switch ($field->field_type) {

			  		case 'text':

			        if($field->required == true){ $required = 'required'; }
			        $html_fields .= '<div class="form-group">';
			  		$html_fields .= '<label class="control-label">'.$field->label.'</label>';
			        $html_fields .= '<input type="text" name="'.$field->cid.'" class="form-control '.$required.'"'.$required.'/>';
			        if(isset($field->field_options->description)){ $html_fields .= '<p class="subline">'.$field->field_options->description.'</p>'; }
			        $html_fields .= '</div>';

			  			break;


			      case 'email':

			        if($field->required == true){ $required = 'required'; }
			        $html_fields .= '<div class="form-group">';
			        $html_fields .= '<label class="control-label">'.$field->label.'</label>';
			        $html_fields .= '<input type="email" name="'.$field->cid.'" class="form-control email '.$required.'" '.$required.'/>';
			        if(isset($field->field_options->description)){ $html_fields .= '<p class="subline">'.$field->field_options->description.'</p>'; }
			        $html_fields .= '</div>';

			        break;

			      

			      case 'paragraph':

			        if($field->required == true){ $required = 'required'; }
			        $html_fields .= '<div class="form-group">';
			        $html_fields .= '<label class="control-label">'.$field->label.'</label>';
			        $html_fields .= '<textarea name="'.$field->cid.'" class="form-control '.$required.'" '.$required.'></textarea>';
			        if(isset($field->field_options->description)){ $html_fields .= '<p class="subline">'.$field->field_options->description.'</p>'; }
			        $html_fields .= '</div>';

			        break;

			      case 'section_break':
			        $html_fields .= '<div class="form-group__noborder">';
			        $html_fields .= '<hr>';
			        $html_fields .= '</div>';

			        break;


			  		case 'radio':
			  		
			        if($field->required == true){ $required = 'required'; }
			        
			        $html_fields .= '<div class="form-group">';
			        $html_fields .= '<label class="control-label">'.$field->label.'</label>';

			  			foreach ($field->field_options->options as $value) {
			          $html_fields .= '<input type="radio" class="form-control checkbox" data-labelauty="'.$value->label.'" name="'.$field->cid.'" value="'.$value->label.'" '.$required.'/>';
			  			}      
			        if(isset($field->description)){ $html_fields .= '<p class="subline">'.$field->description.'</p>'; }
			        $html_fields .= '</div>';

			  		break;

			      case 'checkboxes':
			      
			        if($field->required == true){ $required = 'required'; }
			        
			        $html_fields .= '<div class="form-group">';
			        $html_fields .= '<label class="control-label">'.$field->label.'</label>';
			        
			        $recent = false;
			        foreach ($field->field_options->options as $value) {
			          $checked = '';
			          if($recent != $field->cid){
			          	$i = 0;
			          }
			          $recent = $field->cid;
			          $i = $i+1;
			          if($value->checked == true){ $checked = 'checked="checked"'; }
			          $html_fields .= '<div class="margin-bottom-10"><input type="checkbox" class="checkbox" data-labelauty="'.$value->label.'" name="'.$field->cid.'_'.$i.'" value="'.$value->label.'" '.$checked.' /></div>';
			          
			        }      
			        if(isset($field->description)){ $html_fields .= '<p class="subline">'.$field->description.'</p>'; }
			        $html_fields .= '</div>';

			      break;


			      case 'dropdown':
			      
			        if($field->required == true){ $required = 'required'; }
			        
			        $html_fields .= '<div class="form-group">';
			        $html_fields .= '<label class="control-label">'.$field->label.'</label>';
			        $html_fields .= '<select width="210px" class="chosen-select" name="'.$field->cid.'">';
			        foreach ($field->field_options->options as $value) {
			          $html_fields .= '<option>'.$value->label.'</option><br>';
			        } 
			        $html_fields .= '</select>';
			        if(isset($field->description)){ $html_fields .= '<p class="subline">'.$field->description.'</p>'; }
			        $html_fields .= '</div>';

			      break;
			  		
			  	}
			  	

			  }

			  $number1 = rand(1, 10);
			  $number2 = rand(1, 10);

			  $captcha = $number1+$number2;

			  //captcha
			$html_fields .= '<input type="hidden" id="captcha" name="captcha" value="'.$captcha.'"><div class="form-group">';
			$html_fields .= '<label class="control-label-e">'.$number1.'+'.$number2.' = ?</label>';
			$html_fields .= '<input type="text" id="confirmcaptch" name="confirmcaptcha" data-match="#captcha" class="form-control" required/></div>';
			$this->view_data['fields'] = $html_fields;


		$this->content_view = 'quotation/_custom';
		}
	}


	function language($lang = false){
		$folder = 'application/language/';
		$languagefiles = scandir($folder);
		if(in_array($lang, $languagefiles)){
		$cookie = array(
                   'name'   => 'fc2language',
                   'value'  => $lang,
                   'expire' => '31536000',
               );
 
		$this->input->set_cookie($cookie);
		}
		redirect('quotation'); 
	}

	
}