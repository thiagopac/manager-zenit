<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class ServiceOrders extends MY_Controller{

    public function __construct() {
        parent::__construct();
        $access = false;
        if ($this->user) {
            foreach ($this->view_data['menu'] as $key => $value) {
                if ($value->link == 'serviceorders') {
                    $access = true;
                }
            }
            if (!$access) {
                redirect('login');
            }
        } else {
            redirect('login');
        }
    }

    public function index(){
        $this->view_data['is_viewer'] = $is_viewer = BpmFlow::isViewer(2, $this->user->email);
        $this->content_view = 'serviceorders/all';
        $this->view_data['form_action'] = 'serviceorders/search';
    }

    public function search(){
        if ($_POST){
            $this->view_data['is_viewer'] = $is_viewer = BpmFlow::isViewer(2, $this->user->email);
            $service_orders = ServiceOrder::find(1);

            $this->view_data['service_orders'] = $service_orders;

            $search = 'search';
            $this->view_data['filter'] = $search;
            $this->theme_view = 'ajax';
            $this->content_view = 'serviceorders/list';
        }
    }

    public function listing($con = false){

        $limit = 999999;

        if (is_numeric($con)) {
            $max_value = $con.',';
        } else {
            $max_value = false;
        }

        $my_steps = BpmFlow::stepsUserIs(2, $this->user->email);
        $service_orders = ServiceOrder::find('all', ['conditions' => ['step IN (?) AND canceled != 1 AND finished != 1 ORDER BY id DESC', $my_steps]]);
        $progress_service_orders = ServiceOrder::find('all', ['conditions' => ['canceled != 1 AND finished != 1 ORDER BY id DESC'], 'limit' => $limit, 'offset' => $max_value]);

        foreach ($progress_service_orders as $service_order){
            $flow = json_decode($service_order->flow);

            foreach ($flow->steps as $step){

                if ($service_order->step == $step->id){

                    foreach ($step->members as $member){
                        if ($member->name == "creator_name" && $service_order->user_id == $this->user->id){
                            if(!in_array($service_order, $service_orders)){
                                array_push($service_orders, $service_order);
                            }
                        }
                    }
                }
            }
        }

        usort($service_orders, function($a, $b) { return $b->id - $a->id; });

//        $obj_list_page_next = $con + $limit;
//        $obj_list_page_prev = $con - $limit;
//        $this->view_data['obj_list_page_next'] = $obj_list_page_next;
//        $this->view_data['obj_list_page_prev'] = $obj_list_page_prev;
//        $current_page = intval($con);
//        $this->view_data['current_page'] = $current_page;
//        $show_next = count($service_orders);
//        $this->view_data['show_next'] = $show_next;

        $this->view_data['service_orders'] = $service_orders;
        $this->view_data['my_steps'] = $my_steps;

        $this->view_data['filter'] = false;
        $this->theme_view = 'ajax';
        $this->content_view = 'serviceorders/list';
    }

    public function filter($condition = false, $con){

        $limit = 99999;
        if (is_numeric($con)) {
            $max_value = $con.',';
        } else {
            $max_value = false;
        }

        $con = rawurldecode($con);
//        var_dump($con);exit;

        $this->view_data['filter'] = ucfirst($condition);
        $service_orders = array();

        switch ($condition){
            case 'sent' :
                $service_orders = ServiceOrder::find('all', ['conditions' => ['user_id = ? ORDER BY id DESC', $this->user->id], 'limit' => $limit, 'offset' => $max_value]);
                break;
            case "finished" :
                $service_orders =  ServiceOrder::find('all', ['conditions' => ['finished = ? ORDER BY id DESC', 1], 'limit' => $limit, 'offset' => $max_value]);
                break;
            case "canceled" :
                $service_orders =  ServiceOrder::find('all', ['conditions' => ['canceled = ? ORDER BY id DESC', 1], 'limit' => $limit, 'offset' => $max_value]);
                break;
            case "all" :
                $service_orders =  ServiceOrder::find('all', ['conditions' => ['1 = 1 ORDER BY id DESC'], 'limit' => $limit, 'offset' => $max_value]);
                break;
            case "search" :
                $service_orders =  ServiceOrder::find('all', ['conditions' => ["response LIKE '%$con%' OR history LIKE '%$con%' OR id LIKE '%$con%' ORDER BY id DESC"]]);
                break;
        }

//        var_dump($service_orders);

//        $obj_list_page_next = $con + $limit;
//        $obj_list_page_prev = $con - $limit;
//        $this->view_data['obj_list_page_next'] = $obj_list_page_next;
//        $this->view_data['obj_list_page_prev'] = $obj_list_page_prev;
//        $current_page = intval($con);
//        $this->view_data['current_page'] = $current_page;
//        $show_next = count($service_orders) ;
//        $this->view_data['show_next'] = $show_next;

        $this->view_data['service_orders'] = $service_orders;
        $this->view_data['filter'] = $condition;
        $this->theme_view = 'ajax';
        $this->content_view = 'serviceorders/list';
    }

    public function write($ajax = false){
        if ($_POST) {

            if ($_POST['price'] == null || $_POST['price'] == ''){
                $this->session->set_flashdata('message', 'error:'.$this->lang->line('messages_service_order_incomplete'));
                redirect('serviceorders');
            }

            $countfiles = count($_FILES['files']['name']);
            $file_names_arr = array();

            for($i=0;$i<$countfiles;$i++){

                if(!empty($_FILES['files']['name'][$i])){

                    // Define new $_FILES array - $_FILES['file']
                    $_FILES['file']['name'] = $_FILES['files']['name'][$i];
                    $_FILES['file']['type'] = $_FILES['files']['type'][$i];
                    $_FILES['file']['tmp_name'] = $_FILES['files']['tmp_name'][$i];
                    $_FILES['file']['error'] = $_FILES['files']['error'][$i];
                    $_FILES['file']['size'] = $_FILES['files']['size'][$i];

                    // Set preference
                    $config['upload_path'] = './files/serviceorders/';
                    $config['encrypt_name'] = true;
                    $config['allowed_types'] = '*';
                    $config['max_size'] = '10000'; // max_size in kb
                    $config['file_name'] = $_FILES['files']['name'][$i];

                    //Load upload library
                    $this->load->library('upload',$config);

                    // File upload
                    if($this->upload->do_upload('file')){
                        // Get data about the file
                        $uploadData = $this->upload->data();
                        $filename = $uploadData['file_name'];

                        // Initialize array
                        $data['filenames'][] = $filename;

                        $file_names_arr = $data['filenames'];
                    }
                }
            }

            $submit_action = null;
            foreach ($_POST as $key => $value) {
                if (strpos($key, 'submit_') !== 0) continue;
                $submit_action = substr($key, 7);
                unset($_POST["$key"]);
            }

            $response = new stdClass;
            foreach ($_POST as $key => $value) {

                $response->$key = $value;

                if ($key == 'price'){
                    $price = $value;
                }

                if ($key == 'description'){
                    $subject  = $value;
                }

                unset($_POST["$key"]);
            }

            $response->files = $file_names_arr;

            $bpm_flow = BpmFlow::find(2);
            $_POST['flow'] = $bpm_flow->flow;
            $_POST['response'] = json_encode($response);

            $_POST['price'] = $price;
            $_POST['subject'] = $subject;

            $_POST['step'] = $submit_action;
            $_POST['user_id'] = $this->user->id;

            $new_service_order = ServiceOrder::create($_POST);
            $push_receivers = array();

            if (!$new_service_order) {
                $this->session->set_flashdata('message', 'error:'.$this->lang->line('messages_write_message_error'));
            } else {
                $this->session->set_flashdata('message', 'success:'.$this->lang->line('messages_write_message_success'));
                $this->load->helper('notification');

                $last_service_order = ServiceOrder::find('last');
                $current_step = ServiceOrder::getServiceOrderStepWithId($last_service_order->id, 0);

                $next_step = ServiceOrder::nextStepForServiceOrderAfterCurrentStep($last_service_order->id, $current_step->id);

                //criação de registro de histórico
                ServiceOrder::createHistoryForServiceStepAndUser($last_service_order->id, $current_step, $this->user->id, false, true);

                foreach ($next_step->members as $member){
                    $user = User::getUserByEmail($member->email);
                    if ($user->push_active){
                        array_push($push_receivers, $member->email);
                    }

                    $attributes = array('user_id' => $user->id, 'message' => "[Ordem de serviço $last_service_order->id] Uma ação é necessária", 'url' => base_url().'serviceorders');
                    Notification::create($attributes);

                    $document = ServiceOrder::servicebody($last_service_order->id);
                    $history = ServiceOrder::servicehistory($last_service_order->id);

                    $actions = array();
                    foreach ($next_step->actions as $action){
                        $action->title = $action->name;
                        $action->href = base_url().'mailaction/updateserviceorder/'.str_replace('@ownergy.com.br', '', $member->email).'/'.$last_service_order->id.'/'.intval(boolval($action->progress)).'/'.$next_step->id;
                        array_push($actions, $action);
                    }

                    send_bpm_notification($member->email,
                                    "[Ordem de serviço $last_service_order->id]",
                                    sprintf($this->lang->line('application_notification_service_order_updated_mail'), base_url().'serviceorders'),
                         null,
                                base_url().'serviceorders',
                        $actions,
                        $document,
                        $history
                        );
                }

                Notification::sendPushNotification($push_receivers, "[Ordem de serviço $last_service_order->id] Uma ação é necessária", base_url() . 'serviceorders');

                $this->session->set_flashdata('message', 'success:'.$this->lang->line('messages_edit_success'));
                redirect('serviceorders');
            }

        } else {

            $this->theme_view = 'modal';
            $this->view_data['title'] = $this->lang->line('application_new_service_order');
            $this->view_data['form_action'] = 'serviceorders/write';
            $this->content_view = 'serviceorders/_serviceorder';

            $bpm_flow = BpmFlow::find(2);
            $this->view_data['bpm_flow'] = $bpm_flow;
            $this->view_data['flow'] = $flow = json_decode($bpm_flow->flow);

            $actions = $flow->steps[0]->actions;
            $this->view_data['actions'] = $actions;

            $form =  $flow->steps[0]->form;
            $this->view_data['form'] = json_encode($form);

        }
    }

    public function reply($ajax = false, $nextStep = null, $service_order_id = false){

//        var_dump($_POST);


        if ($_POST) {
            $id = $_POST['id'];
            if($id == null){
                $id = $service_order_id;
            }
            $updating_service_order = ServiceOrder::find($id);
            $flow = json_decode($updating_service_order->flow);
            $step = $_POST['current_step'];

            if ($updating_service_order->canceled == true || $updating_service_order->finished == true || $updating_service_order->step > $step){

                if ($updating_service_order->canceled == true){
                    $this->session->set_flashdata('message', 'error:'.'Esta Ordem de Serviço está com status de cancelada');
                    redirect('serviceorders');
                }else if ($updating_service_order->finished == true){
                    $this->session->set_flashdata('message', 'error:'.'Esta Ordem de Serviço está com status de finalizada');
                    redirect('serviceorders');
                }else if($updating_service_order->step > $step  && $nextStep == false){
                    $this->session->set_flashdata('message', 'error:'.'Esta Ordem de Serviço já teve esta etapa completada previamente');
                    redirect('serviceorders');
                }

            }

            $is_new_variation = (count($_FILES['files'])) > 1 ? false : true;

            if($is_new_variation == false){

                $countfiles = count($_FILES['files']['name']);
                $file_names_arr = array();

                for($i=0;$i<$countfiles;$i++){

                    if(!empty($_FILES['files']['name'][$i])){

                        // Define new $_FILES array - $_FILES['file']
                        $_FILES['file']['name'] = $_FILES['files']['name'][$i];
                        $_FILES['file']['type'] = $_FILES['files']['type'][$i];
                        $_FILES['file']['tmp_name'] = $_FILES['files']['tmp_name'][$i];
                        $_FILES['file']['error'] = $_FILES['files']['error'][$i];
                        $_FILES['file']['size'] = $_FILES['files']['size'][$i];

                        // Set preference
                        $config['upload_path'] = './files/purchaseorders/';
                        $config['encrypt_name'] = true;
                        $config['allowed_types'] = '*';
                        $config['max_size'] = '150000'; // max_size in kb
                        $config['file_name'] = $_FILES['files']['name'][$i];

                        //Load upload library
                        $this->load->library('upload',$config);

                        $error = array('error' => $this->upload->display_errors());

                        // File upload
                        if($this->upload->do_upload('files')){
                            // Get data about the file
                            $uploadData = $this->upload->data();
                            $filename = $uploadData['file_name'];

                            // Initialize array
                            $data['filenames'][] = $filename;

                            $file_names_arr = $data['filenames'];
                        }
                    }
                }
            }else{
                $file_names_arr = array();

                foreach($_FILES as $key => $value){
    
                    $i = 0;
    
                    $key_name = array_key_first($_FILES);
                    $input_name = $_FILES[$key_name];
    
                    //if(!empty($_FILES['files']['name'][$i])){
                    if(!empty($input_name)){
    
                        // Define new $_FILES array - $_FILES['file']
                        $_FILES['file']['name'] = $_FILES[$key_name]['name'];
                        $_FILES['file']['type'] = $_FILES[$key_name]['type'];
                        $_FILES['file']['tmp_name'] = $_FILES[$key_name]['tmp_name'];
                        $_FILES['file']['error'] = $_FILES[$key_name]['error'];
                        $_FILES['file']['size'] = $_FILES[$key_name]['size'];
    
                        //var_dump($_FILES);  exit;
    
    
                        // Set preference
                        $config['upload_path'] = './files/serviceorders/';
                        $config['encrypt_name'] = true;
                        $config['allowed_types'] = '*';
                        $config['max_size'] = '150000'; // max_size in kb
                        $config['file_name'] = $_FILES[$key_name]['name'][$i];
                        $config['file_type'] = $_FILES[$key_name]['type'][$i];
    
                        //Load upload library
                        $this->load->library('upload',$config);
                        
                        $error = array('error' => $this->upload->display_errors());
                        // File upload
                        if($this->upload->do_upload($key_name)){
                            // Get data about the file
                            $uploadData = $this->upload->data();
                            $filename = $uploadData['file_name'];
    
                            // Initialize array
                            $data['filenames'][] = $filename;
    
                            $current_file = new stdClass();
                            $current_file->label = $key_name;
                            $current_file->value = $data['filenames'][0];
                            $current_file->type = 'file';
                            array_push($file_names_arr, $current_file);
                        }
                    }
                    $i++;
                }
            }

            $is_progress = null;
            $is_travel = null;
            $total_price = null;

            if ($_POST['total_price'] != null){
                $total_price = $_POST['total_price'];
                $updating_service_order->total_price = $total_price;
                $updating_service_order->save();
            }

            foreach ($_POST as $key => $value) {
                if (strpos($key, 'submit_') !== 0 && $key != "travel") continue;
                $is_progress = substr($key, 7);
                if($key == "travel"){
                    $is_progress = 1;
                    $is_travel = 1;
                }
                unset($_POST["$key"]);
            }

            $history_registry = new stdClass;

            if($is_new_variation == false){
                $history_registry->history_files = $file_names_arr;
            }

            $history_registry->history_data = array();

            $current_step = ServiceOrder::currentStepForServiceOrder($id);
            unset($_POST["next_step_id"]);

            if($nextStep == null){

            foreach ($_POST as $key => $value) {
                foreach ($current_step->form as $form_field){

                    if ($key == $form_field->name){
                        $history_reg = new stdClass();

                        $history_reg->label = $form_field->label;
                        $history_reg->value = $value;
                        $history_reg->name = $key;
                        $history_reg->className = $form_field->className;
                        if ($value != null){
                            array_push($history_registry->history_data, $history_reg);
                        }
                    }
                }
                unset($_POST["$key"]);
            }
        }else{
            foreach ($_POST as $key => $value) {
                $history_reg = new stdClass();
                $history_reg->label = $key;
                $history_reg->value = $value;
                $history_reg->name = $key;
                if ($value != null){
                    array_push($history_registry->history_data, $history_reg);
                }
            }

            $history_reg = new stdClass();
                $history_reg->label = "Retorno";
                $history_reg->value = "Moveu OC da etapa <strong>".$current_step->name."</strong> para a etapa <strong>".$nextStep->name."</strong>";
                $history_reg->name = "Retorno";
                if ($value != null){
                    array_push($history_registry->history_data, $history_reg);
                }
                unset($_POST["Justificativa"]);
            }

            if($is_new_variation == true){
                $history_data_and_files = array_merge($history_registry->history_data, $file_names_arr);
                $history_registry->history_data = $history_data_and_files;
            }


            $canceled_step = null;

            if ($is_progress == false){

                foreach ($flow->steps as $step){
                    if ($step->canceled == true){
                        $canceled_step = $step;
                    }
                }

                $_POST['step']  = $canceled_step->id;
                $_POST['canceled'] = 1;

                $current_step = ServiceOrder::currentStepForServiceOrder($id);

                //criação de registro de histórico
                ServiceOrder::createHistoryForServiceStepAndUser($id, $current_step, $this->user->id, $history_registry, $is_progress);

                if ($_POST['canceled'] == 1){
                    // passo final precisa criar registro de histórico quando o penúltimo passo estiver sendo registrado
                    ServiceOrder::createHistoryForServiceStepAndUser($id, $canceled_step, $this->user->id, false, $is_progress);
                }

            }else{

                $current_step = ServiceOrder::currentStepForServiceOrder($id);
         
                if($nextStep != null){
                    $next_step = $nextStep;
                    $_POST['step']  = $next_step->id;
                }else{
                    $next_step = ServiceOrder::nextStepForServiceOrderAfterCurrentStep($id, $current_step->id);
                    $_POST['step']  = $next_step->id;
                }

                //criação de registro de histórico
                ServiceOrder::createHistoryForServiceStepAndUser($id, $current_step, $this->user->id, $history_registry, $is_progress, $is_travel);

                if ($next_step->finish == true){
                    // passo final precisa criar registro de histórico quando o penúltimo passo estiver sendo registrado
                    ServiceOrder::createHistoryForServiceStepAndUser($id, $next_step, $this->user->id, false, $is_progress, $is_travel);
                    $_POST['finished'] = 1;
                }
            }

            $updating_service_order->update_attributes($_POST);

            $push_receivers = array();
            if (!$updating_service_order) {
                $this->session->set_flashdata('message', 'error:'.$this->lang->line('messages_edit_error'));
            } else {

                if ($is_progress == true){
                    $this->load->helper('notification');

                    $next_step_members = array();

                    foreach ($next_step->members as $member){

                        array_push($arr_emails_in_step, $member->email);
                        if ($member->name == 'creator_name'){

                            $user = User::find($updating_service_order->user_id);
                            $member->name = $user->firstname.' '.$user->lastname;
                            $member->email = $user->email;
                        }

                        array_push($next_step_members, $member);
                    }

                    $next_step_members = $this->my_array_unique($next_step_members);


                    foreach ($next_step_members as $member){
                        $user = User::getUserByEmail($member->email);

                        if ($user->push_active){
                            array_push($push_receivers, $member->email);
                        }

                        $attributes = array('user_id' => $user->id, 'message' => "[Ordem de serviço $updating_service_order->id] Uma atualização foi feita na Ordem de Serviço", 'url' => base_url().'serviceorders');
                        Notification::create($attributes);

                        $document = ServiceOrder::servicebody($updating_service_order->id);
                        $history = ServiceOrder::servicehistory($updating_service_order->id);

                        $actions = array();
                        foreach ($next_step->actions as $action){
                            $action->title = $action->name;
                            $action->href = base_url().'mailaction/updateserviceorder/'.str_replace('@ownergy.com.br', '', $member->email).'/'.$updating_service_order->id.'/'.intval(boolval($action->progress)).'/'.$next_step->id;
                            array_push($actions, $action);
                        }

                        send_bpm_notification($member->email,
                                    "[Ordem de serviço $updating_service_order->id]",
                            sprintf($this->lang->line('application_notification_service_order_updated_mail'), base_url().'serviceorders'),
                                null,
                                base_url().'serviceorders',
                                $actions,
                                $document,
                                $history);
                    }

                    Notification::sendPushNotification($push_receivers, "[Ordem de serviço $updating_service_order->id] Uma atualização foi feita na Ordem de Serviço", base_url() . 'serviceorders');

                }else{
                    //Service Order is backing to the creator
                    array_push($push_receivers, $this->user->email);

                    $attributes = array('user_id' => $updating_service_order->user_id, 'message' => "[Ordem de serviço $updating_service_order->id] Ordem de serviço cancelada, verifique o histórico", 'url' => base_url().'serviceorders');
                    Notification::create($attributes);

                    Notification::sendPushNotification($push_receivers, "[Ordem de serviço $updating_service_order->id] Ordem de Serviço cancelada, verifique o histórico", base_url() . 'serviceorders');
                }

                $this->session->set_flashdata('message', 'success:'.$this->lang->line('messages_edit_success'));
                redirect('serviceorders');
            }

        } else {

            //Service Order has no modal reply

        }
    }

    public function servicedata($service_order_id = false){

        $this->theme_view = 'blank';

        $service_order_data = ServiceOrder::servicehistory($service_order_id);
//        $service_order_data = ServiceOrder::servicebody($service_order_id);

        echo $service_order_data;
    }

    public function delete($id = false){
        $service_order = ServiceOrder::find_by_id($id);
        $service_order->deleted = '1';
        $service_order->save();

        $this->content_view = 'serviceorders/all';
        if (!$service_order) {
            $this->session->set_flashdata('message', 'error:'.$this->lang->line('messages_delete_error'));
        } else {
            $this->session->set_flashdata('message', 'success:'.$this->lang->line('messages_delete_success'));
        }
        redirect('serviceorders');
    }

    public function view($id = false, $filter = false, $additional = false){
        $service_order = ServiceOrder::find_by_id($id);
        $this->view_data['service_order'] = $service_order;

        $this->theme_view = 'ajax';
        $this->view_data['form_action'] = 'serviceorders/write';
        $this->view_data['id'] = $id;
        $this->content_view = 'serviceorders/view';

        $this->view_data['flow'] = $flow = json_decode($service_order->flow);

        $steps = ServiceOrder::progressStepsForServiceOrder($id);

        $user = User::find($service_order->user_id);

        foreach ($steps as $step_reg){
            foreach ($step_reg->members as $member){

                array_push($arr_emails_in_step, $member->email);
                if ($member->name == 'creator_name'){

                    $member->name = $user->firstname.' '.$user->lastname;
                    $member->email = $user->email;
                }
            }

            $step_reg->members = $this->my_array_unique($step_reg->members);
        }

        $creator = User::find($service_order->user_id);

        $actions = BpmFlow::actionsForUserInStep($service_order, $this->user->email, $service_order->step, $creator);

//        var_dump($actions);

        $this->view_data['actions'] = $actions;

        $this->view_data['current_step'] = ServiceOrder::currentStepForServiceOrder($service_order->id);

        $this->view_data['steps'] = $steps;
        $this->view_data['history'] = $history = ServiceOrder::getHistoryForService($id);

        $form = $steps[0]->form;
        $this->view_data['form'] = $form;
        $this->view_data['response'] = json_decode($service_order->response);

        $step_form =  $flow->steps[$service_order->step]->form;
        $this->view_data['step_form'] = json_encode($step_form);
    }

    public function import() {

        if ($_POST) {
            unset($_POST['send']);
            unset($_POST['files']);
            $config['upload_path'] = './files/temp/';
            $config['encrypt_name'] = true;
            $config['allowed_types'] = '*';

            $this->load->library('upload', $config);

            if (! $this->upload->do_upload()) {
                $error = $this->upload->display_errors('', ' ');
                $this->session->set_flashdata('message', 'error:'.$error);
                redirect('serviceorders/');
            } else {
                $data = array('upload_data' => $this->upload->data());

                $_POST['filename'] = $data['upload_data']['orig_name'];
                $savename = $data['upload_data']['file_name'];
                $this->view_data['csv_file'] = $savename;

                $this->load->library('CSVReader');
                $result = $this->csvreader->parse_file($config['upload_path'].$savename);

//                var_dump($result);exit;

                foreach ($result as $idx => $item){

                    foreach ($item as $item_key => $item_value){

                        if ($item_value != 0){

                            $service_order = ServiceOrder::find($item_key);

                            $response = json_decode($service_order->response);

                            foreach ($response as $key => $value){

                                $payment_n = 'payment_date_'.$idx;
                                if ($key == $payment_n){

                                    $response->$payment_n = implode('-', array_reverse(explode('/', $item_value)));
//                                var_dump($key);
//                                var_dump($value);
                                }

                            }

                        }

                        $service_order->response = json_encode($response);
                        $service_order->save();
//                        var_dump($service_order->id);
//                        var_dump($service_order->response);

                    }

//                    exit;

//                    print_r("<hr />");

                    // time spent count
//                    usleep(mt_rand(100, 10000));
//                    $time = microtime(true) - $_SERVER["REQUEST_TIME_FLOAT"];
//                    echo "Did nothing in $time seconds\n";

//                    $service_order->response = json_encode($response);
//                    var_dump($response);exit;
//                    $service_order->save();
                }

                $this->view_data["form_action"] = 'serviceorders/import';
                $this->content_view = 'serviceorders/all';
            }
        } else {
            $this->theme_view = 'modal';
            $this->view_data['title'] = $this->lang->line('application_import');
            $this->view_data['form_action'] = 'serviceorders/import';
            $this->view_data['exemple_file'] = 'https://ownergy.com.br/zenit/files/serviceorders/os_atualizar_pagamento.csv';
            $this->content_view = 'serviceorders/_import';
        }
    }

    public function timetravel($service_order_id = false){

        // Gives the possibility to send a Purchase Order back in the flow it's
        // going if something went wrong in one of the past steps

        if ($_POST) {
            
            $stepsToGoBack = ServiceOrder::getStepsToGoBack($service_order_id);

            $wishedStep = $_POST['next_step_id'];
            $fullFlow = ServiceOrder::progressStepsForServiceOrder($service_order_id);
            $currenthist = ServiceOrder::getHistoryForService($service_order_id);

            foreach($fullFlow as $step){
                if($step->id == $wishedStep){
                    $stepForReply = $step;
                    print_r('</br>');
                }
            }

            print_r('</br>');

            $this->reply($ajax = false, $nextStep = $stepForReply, $service_order_id);
            
            
            }else{

            // If there's no POST, it renders the modal so the user can
            // fill the form to send the Purhcase Order back in the flow

            // Here it calls the method to get which steps the Purchase Order
            // is allowed to go back to

            $stepsToGoBack = ServiceOrder::getStepsToGoBack($service_order_id);

            // And here it prepares for rendering the modal

            $this->view_data['steps_in_flow'] = $stepsToGoBack;
            $this->view_data['title'] = "Alterar fluxo da Ordem de Compra";
            $this->theme_view = 'modal';
            $this->content_view = 'serviceorders/_timetravel';
            
            }
    }

}
