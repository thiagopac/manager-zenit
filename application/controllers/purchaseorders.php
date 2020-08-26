<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class PurchaseOrders extends MY_Controller{

    public function __construct() {
        parent::__construct();
        $access = false;
        if ($this->user) {
            foreach ($this->view_data['menu'] as $key => $value) {
                if ($value->link == 'purchaseorders') {
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
        $this->view_data['is_viewer'] = $is_viewer = BpmFlow::isViewer(1, $this->user->email);
        $this->content_view = 'purchaseorders/all';
        $this->view_data['form_action'] = 'purchaseorders/search';
    }

    public function search(){
        if ($_POST){
            $this->view_data['is_viewer'] = $is_viewer = BpmFlow::isViewer(1, $this->user->email);
            $purchase_orders = PurchaseOrder::find(1);

            $this->view_data['purchase_orders'] = $purchase_orders;

            $search = 'search';
            $this->view_data['filter'] = $search;
            $this->theme_view = 'ajax';
            $this->content_view = 'purchaseorders/list';
        }
    }

    public function listing($con = false){

        $limit = 999999;

        if (is_numeric($con)) {
            $max_value = $con.',';
        } else {
            $max_value = false;
        }

        $my_steps = BpmFlow::stepsUserIs(1, $this->user->email);
        $purchase_orders = PurchaseOrder::find('all', ['conditions' => ['step IN (?) AND canceled != 1 AND finished != 1 ORDER BY id DESC', $my_steps]]);
        $progress_purchase_orders = PurchaseOrder::find('all', ['conditions' => ['canceled != 1 AND finished != 1 ORDER BY id DESC'], 'limit' => $limit, 'offset' => $max_value]);

        foreach ($progress_purchase_orders as $purchase_order){
            $flow = json_decode($purchase_order->flow);

            foreach ($flow->steps as $step){

                if ($purchase_order->step == $step->id){

                    foreach ($step->members as $member){
                        if ($member->name == "creator_name" && $purchase_order->user_id == $this->user->id){
                            if(!in_array($purchase_order, $purchase_orders)){
                                array_push($purchase_orders, $purchase_order);
                            }
                        }
                    }
                }
            }
        }

        usort($purchase_orders, function($a, $b) { return $b->id - $a->id; });

//        $obj_list_page_next = $con + $limit;
//        $obj_list_page_prev = $con - $limit;
//        $this->view_data['obj_list_page_next'] = $obj_list_page_next;
//        $this->view_data['obj_list_page_prev'] = $obj_list_page_prev;
//        $current_page = intval($con);
//        $this->view_data['current_page'] = $current_page;
//        $show_next = count($purchase_orders);
//        $this->view_data['show_next'] = $show_next;

        $this->view_data['purchase_orders'] = $purchase_orders;
        $this->view_data['my_steps'] = $my_steps;

        $this->view_data['filter'] = false;
        $this->theme_view = 'ajax';
        $this->content_view = 'purchaseorders/list';
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
        $purchase_orders = array();

        switch ($condition){
            case 'sent' :
                $purchase_orders = PurchaseOrder::find('all', ['conditions' => ['user_id = ? ORDER BY id DESC', $this->user->id], 'limit' => $limit, 'offset' => $max_value]);
                break;
            case "finished" :
                $purchase_orders =  PurchaseOrder::find('all', ['conditions' => ['finished = ? ORDER BY id DESC', 1], 'limit' => $limit, 'offset' => $max_value]);
                break;
            case "canceled" :
                $purchase_orders =  PurchaseOrder::find('all', ['conditions' => ['canceled = ? ORDER BY id DESC', 1], 'limit' => $limit, 'offset' => $max_value]);
                break;
            case "all" :
                $purchase_orders =  PurchaseOrder::find('all', ['conditions' => ['1 = 1 ORDER BY id DESC'], 'limit' => $limit, 'offset' => $max_value]);
                break;
            case "search" :
                $purchase_orders =  PurchaseOrder::find('all', ['conditions' => ["response LIKE '%$con%' OR history LIKE '%$con%' OR id LIKE '%$con%' ORDER BY id DESC"]]);
                break;
        }

//        var_dump($purchase_orders);

//        $obj_list_page_next = $con + $limit;
//        $obj_list_page_prev = $con - $limit;
//        $this->view_data['obj_list_page_next'] = $obj_list_page_next;
//        $this->view_data['obj_list_page_prev'] = $obj_list_page_prev;
//        $current_page = intval($con);
//        $this->view_data['current_page'] = $current_page;
//        $show_next = count($purchase_orders) ;
//        $this->view_data['show_next'] = $show_next;

        $this->view_data['purchase_orders'] = $purchase_orders;
        $this->view_data['filter'] = $condition;
        $this->theme_view = 'ajax';
        $this->content_view = 'purchaseorders/list';
    }

    public function write($ajax = false){
        if ($_POST) {

            if ($_POST['price'] == null || $_POST['price'] == ''){
                $this->session->set_flashdata('message', 'error:'.$this->lang->line('messages_purchase_order_incomplete'));
                redirect('purchaseorders');
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
                    $config['upload_path'] = './files/purchaseorders/';
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

            $bpm_flow = BpmFlow::find(1);
            $_POST['flow'] = $bpm_flow->flow;
            $_POST['response'] = json_encode($response);

            $_POST['price'] = $price;
            $_POST['subject'] = $subject;

            $_POST['step'] = $submit_action;
            $_POST['user_id'] = $this->user->id;

            $new_purchase_order = PurchaseOrder::create($_POST);
            $push_receivers = array();

            if (!$new_purchase_order) {
                $this->session->set_flashdata('message', 'error:'.$this->lang->line('messages_write_message_error'));
            } else {
                $this->session->set_flashdata('message', 'success:'.$this->lang->line('messages_write_message_success'));
                $this->load->helper('notification');

                $last_purchase_order = PurchaseOrder::find('last');
                $current_step = PurchaseOrder::getPurchaseOrderStepWithId($last_purchase_order->id, 0);

                $next_step = PurchaseOrder::nextStepForPurchaseOrderAfterCurrentStep($last_purchase_order->id, $current_step->id);

                //criação de registro de histórico
                PurchaseOrder::createHistoryForPurchaseStepAndUser($last_purchase_order->id, $current_step, $this->user->id, false, true);

                foreach ($next_step->members as $member){
                    $user = User::getUserByEmail($member->email);
                    if ($user->push_active){
                        array_push($push_receivers, $member->email);
                    }

                    $attributes = array('user_id' => $user->id, 'message' => "[Ordem de compra $last_purchase_order->id] Uma ação é necessária", 'url' => base_url().'purchaseorders');
                    Notification::create($attributes);

                    $document = PurchaseOrder::purchasebody($last_purchase_order->id);
                    $history = PurchaseOrder::purchasehistory($last_purchase_order->id);

                    $actions = array();
                    foreach ($next_step->actions as $action){
                        $action->title = $action->name;
                        $action->href = base_url().'mailaction/updatepurchaseorder/'.str_replace('@ownergy.com.br', '', $member->email).'/'.$last_purchase_order->id.'/'.intval(boolval($action->progress)).'/'.$next_step->id;
                        array_push($actions, $action);
                    }

                    send_bpm_notification($member->email,
                                    "[Ordem de compra $last_purchase_order->id]",
                                    sprintf($this->lang->line('application_notification_purchase_order_updated_mail'), base_url().'purchaseorders'),
                         null,
                                base_url().'purchaseorders',
                        $actions,
                        $document,
                        $history
                        );
                }

                Notification::sendPushNotification($push_receivers, "[Ordem de compra $last_purchase_order->id] Uma ação é necessária", base_url() . 'purchaseorders');

                $this->session->set_flashdata('message', 'success:'.$this->lang->line('messages_edit_success'));
                redirect('purchaseorders');
            }

        } else {

            $this->theme_view = 'modal';
            $this->view_data['title'] = $this->lang->line('application_new_purchase_order');
            $this->view_data['form_action'] = 'purchaseorders/write';
            $this->content_view = 'purchaseorders/_purchaseorder';

            $bpm_flow = BpmFlow::find(1);
            $this->view_data['bpm_flow'] = $bpm_flow;
            $this->view_data['flow'] = $flow = json_decode($bpm_flow->flow);

            $actions = $flow->steps[0]->actions;
            $this->view_data['actions'] = $actions;

            $form =  $flow->steps[0]->form;
            $this->view_data['form'] = json_encode($form);

        }
    }

    public function reply($ajax = false){

//        var_dump($_POST);


        if ($_POST) {
            $id = $_POST['id'];
            $updating_purchase_order = PurchaseOrder::find($id);
            $flow = json_decode($updating_purchase_order->flow);
            $step = $_POST['current_step'];

            if ($updating_purchase_order->canceled == true || $updating_purchase_order->finished == true || $updating_purchase_order->step > $step){

                if ($updating_purchase_order->canceled == true){
                    $this->session->set_flashdata('message', 'error:'.'Esta Ordem de Compra está com status de cancelada');
                    redirect('purchaseorders');
                }else if ($updating_purchase_order->finished == true){
                    $this->session->set_flashdata('message', 'error:'.'Esta Ordem de Compra está com status de finalizada');
                    redirect('purchaseorders');
                }else if($updating_purchase_order->step > $step){
                    $this->session->set_flashdata('message', 'error:'.'Esta Ordem de Compra já teve esta etapa completada previamente');
                    redirect('purchaseorders');
                }

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
                    $config['upload_path'] = './files/purchaseorders/';
                    $config['encrypt_name'] = true;
                    $config['allowed_types'] = '*';
                    $config['max_size'] = '15000'; // max_size in kb
                    $config['file_name'] = $_FILES['files']['name']['type'][$i];

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

            $is_progress = null;

            $total_price = null;

            if ($_POST['total_price'] != null){
                $total_price = $_POST['total_price'];
                $updating_purchase_order->total_price = $total_price;
                $updating_purchase_order->save();
            }

            foreach ($_POST as $key => $value) {
                if (strpos($key, 'submit_') !== 0) continue;
                $is_progress = substr($key, 7);
                unset($_POST["$key"]);
            }

            $history_registry = new stdClass;
            $history_registry->history_files = $file_names_arr;
            $history_registry->history_data = array();

            $current_step = PurchaseOrder::currentStepForPurchaseOrder($id);

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

            $canceled_step = null;

            if ($is_progress == false){

                foreach ($flow->steps as $step){
                    if ($step->canceled == true){
                        $canceled_step = $step;
                    }
                }

                $_POST['step']  = $canceled_step->id;
                $_POST['canceled'] = 1;

                $current_step = PurchaseOrder::currentStepForPurchaseOrder($id);

                //criação de registro de histórico
                PurchaseOrder::createHistoryForPurchaseStepAndUser($id, $current_step, $this->user->id, $history_registry, $is_progress);

                if ($_POST['canceled'] == 1){
                    // passo final precisa criar registro de histórico quando o penúltimo passo estiver sendo registrado
                    PurchaseOrder::createHistoryForPurchaseStepAndUser($id, $canceled_step, $this->user->id, false, $is_progress);
                }

            }else{

                $current_step = PurchaseOrder::currentStepForPurchaseOrder($id);

                $next_step = PurchaseOrder::nextStepForPurchaseOrderAfterCurrentStep($id, $current_step->id);
                $_POST['step']  = $next_step->id;

                //criação de registro de histórico
                PurchaseOrder::createHistoryForPurchaseStepAndUser($id, $current_step, $this->user->id, $history_registry, $is_progress);

                if ($next_step->finish == true){
                    // passo final precisa criar registro de histórico quando o penúltimo passo estiver sendo registrado
                    PurchaseOrder::createHistoryForPurchaseStepAndUser($id, $next_step, $this->user->id, false, $is_progress);
                    $_POST['finished'] = 1;
                }
            }

            $updating_purchase_order->update_attributes($_POST);

            $push_receivers = array();
            if (!$updating_purchase_order) {
                $this->session->set_flashdata('message', 'error:'.$this->lang->line('messages_edit_error'));
            } else {

                if ($is_progress == true){
                    $this->load->helper('notification');

                    $next_step_members = array();

                    foreach ($next_step->members as $member){

                        array_push($arr_emails_in_step, $member->email);
                        if ($member->name == 'creator_name'){

                            $user = User::find($updating_purchase_order->user_id);
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

                        $attributes = array('user_id' => $user->id, 'message' => "[Ordem de compra $updating_purchase_order->id] Uma atualização foi feita na Ordem de Compra", 'url' => base_url().'purchaseorders');
                        Notification::create($attributes);

                        $document = PurchaseOrder::purchasebody($updating_purchase_order->id);
                        $history = PurchaseOrder::purchasehistory($updating_purchase_order->id);

                        $actions = array();
                        foreach ($next_step->actions as $action){
                            $action->title = $action->name;
                            $action->href = base_url().'mailaction/updatepurchaseorder/'.str_replace('@ownergy.com.br', '', $member->email).'/'.$updating_purchase_order->id.'/'.intval(boolval($action->progress)).'/'.$next_step->id;
                            array_push($actions, $action);
                        }

                        send_bpm_notification($member->email,
                                    "[Ordem de compra $updating_purchase_order->id]",
                            sprintf($this->lang->line('application_notification_purchase_order_updated_mail'), base_url().'purchaseorders'),
                                null,
                                base_url().'purchaseorders',
                                $actions,
                                $document,
                                $history);
                    }

                    Notification::sendPushNotification($push_receivers, "[Ordem de compra $updating_purchase_order->id] Uma atualização foi feita na Ordem de Compra", base_url() . 'purchaseorders');

                }else{
                    //Purchase Order is backing to the creator
                    array_push($push_receivers, $this->user->email);

                    $attributes = array('user_id' => $updating_purchase_order->user_id, 'message' => "[Ordem de compra $updating_purchase_order->id] Ordem de compra cancelada, verifique o histórico", 'url' => base_url().'purchaseorders');
                    Notification::create($attributes);

                    Notification::sendPushNotification($push_receivers, "[Ordem de compra $updating_purchase_order->id] Ordem de Compra cancelada, verifique o histórico", base_url() . 'purchaseorders');
                }

                $this->session->set_flashdata('message', 'success:'.$this->lang->line('messages_edit_success'));
                redirect('purchaseorders');
            }

        } else {

            //Purchase Order has no modal reply

        }
    }

    public function purchasedata($purchase_order_id = false){

        $this->theme_view = 'blank';

        $purchase_order_data = PurchaseOrder::purchasehistory($purchase_order_id);
//        $purchase_order_data = PurchaseOrder::purchasebody($purchase_order_id);

        echo $purchase_order_data;
    }

    public function delete($id = false){
        $purchase_order = PurchaseOrder::find_by_id($id);
        $purchase_order->deleted = '1';
        $purchase_order->save();

        $this->content_view = 'purchaseorders/all';
        if (!$purchase_order) {
            $this->session->set_flashdata('message', 'error:'.$this->lang->line('messages_delete_error'));
        } else {
            $this->session->set_flashdata('message', 'success:'.$this->lang->line('messages_delete_success'));
        }
        redirect('purchaseorders');
    }

    public function view($id = false, $filter = false, $additional = false){
        $purchase_order = PurchaseOrder::find_by_id($id);
        $this->view_data['purchase_order'] = $purchase_order;

        $this->theme_view = 'ajax';
        $this->view_data['form_action'] = 'purchaseorders/write';
        $this->view_data['id'] = $id;
        $this->content_view = 'purchaseorders/view';

        $this->view_data['flow'] = $flow = json_decode($purchase_order->flow);

        $steps = PurchaseOrder::progressStepsForPurchaseOrder($id);

        $user = User::find($purchase_order->user_id);

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

        $creator = User::find($purchase_order->user_id);

        $actions = BpmFlow::actionsForUserInStep($purchase_order, $this->user->email, $purchase_order->step, $creator);

//        var_dump($actions);

        $this->view_data['actions'] = $actions;

        $this->view_data['current_step'] = PurchaseOrder::currentStepForPurchaseOrder($purchase_order->id);

        $this->view_data['steps'] = $steps;
        $this->view_data['history'] = $history = PurchaseOrder::getHistoryForPurchase($id);

        $form = $steps[0]->form;
        $this->view_data['form'] = $form;
        $this->view_data['response'] = json_decode($purchase_order->response);

        $step_form =  $flow->steps[$purchase_order->step]->form;
        $this->view_data['step_form'] = json_encode($step_form);
    }

    /*public function preview($id = false, $attachment = false) {
        $this->load->helper(['dompdf', 'file']);
        $this->load->library('parser');
        $purchase_order = PurchaseOrder::find($id);
        $data['purchase_order'] = $purchase_order;
        $data['body'] = InvoiceHasItem::find('all', ['conditions' => ['invoice_id=?', $id]]);
        $data['core_settings'] = Setting::first();

        $parse_data = [
            'company' => $data['core_settings']->company,
            'logo' => '<img src="' . base_url() . '' . $data['core_settings']->logo . '" alt="' . $data['core_settings']->company . '"/>',
        ];
        $html = $this->load->view('blueline/templates/pruchaseorder/template', $data, true);
        $html = $this->parser->parse_string($html, $parse_data);

        $filename = 'purchaseorder'.'_'.$purchase_order->id;
        pdf_create($html, $filename, true, $attachment);
    }*/
}
