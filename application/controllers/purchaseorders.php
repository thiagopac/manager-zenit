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
        $this->content_view = 'purchaseorders/all';
    }

    public function listing(){

        $bpm_flow = BpmFlow::find(1);
        $this->view_data['flow'] = $flow = json_decode($bpm_flow->flow);

        $my_steps = BpmFlow::stepsUserIs(1, $this->user->email);

        $is_viewer = BpmFlow::isViewer(1, $this->user->email);

        $purchase_orders = PurchaseOrder::find('all', ['conditions' => ['step IN (?)', $my_steps]]);
        if ($is_viewer == true){
            $purchase_orders = PurchaseOrder::find('all');
        }

        $this->view_data['purchase_orders'] = $purchase_orders;

        $this->view_data['filter'] = false;
        $this->theme_view = 'ajax';
        $this->content_view = 'purchaseorders/list';
    }

    public function filter($condition = false){

        $this->view_data['filter'] = ucfirst($condition);

        switch ($condition){
            case 'sent' :
                $this->view_data['purchase_orders'] = PurchaseOrder::find('all', ['conditions' => ['user_id', $this->user->id]]);
                break;
            case "finished" :
                $this->view_data['purchase_orders'] = PurchaseOrder::find('all', ['conditions' => ['finished', 1]]);
                break;
            case "canceled" :
                $this->view_data['purchase_orders'] = PurchaseOrder::find('all', ['conditions' => ['canceled', 1]]);
                break;
        }

        $this->theme_view = 'ajax';
        $this->content_view = 'purchaseorders/list';
    }

    public function write($ajax = false){
        if ($_POST) {

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
            $_POST['form'] = $bpm_flow->form;
            $_POST['response'] = json_encode($response);

            $_POST['price'] = $price;
            $_POST['subject'] = $subject;

            $_POST['step'] = $submit_action;
            $_POST['user_id'] = $this->user->id;

            $new_purchase_order = PurchaseOrder::create($_POST);
            $push_receivers = array();

            $this->load->helper('notification');

            if (!$new_purchase_order) {
                $this->session->set_flashdata('message', 'error:'.$this->lang->line('messages_write_message_error'));
            } else {
                $this->session->set_flashdata('message', 'success:'.$this->lang->line('messages_write_message_success'));
                $this->load->helper('notification');

                $last_purchase_order = PurchaseOrder::find('last');
                $next_step = PurchaseOrder::nextStepForPurchaseOrderAfterCurrentStep(1, $last_purchase_order->id, 1);
                $current_step = PurchaseOrder::getStepWithId(1, 0);

                //criação de registro de histórico
                PurchaseOrder::createHistoryForBpmPurchaseStepAndUser(1, $last_purchase_order->id, $current_step, $this->user->id);


                foreach ($next_step->members as $member){
                    $user = User::getUserByEmail($member->email);
                    if ($user->push_active){
                        array_push($push_receivers, $member->email);
                    }

                    $attributes = array('user_id' => $user->id, 'message' => "[Ordem de compra $last_purchase_order->id] Uma ação é necessária", 'url' => base_url().'purchaseorders');
                    Notification::create($attributes);

                    send_notification($member->email, "[Ordem de compra $last_purchase_order->id]", $this->lang->line('application_notification_purchase_order_updated').'<br><hr style="border-top: 1px solid #CCCCCC; border-left: 1px solid whitesmoke; border-bottom: 1px solid whitesmoke;"/>'.$this->lang->line('application_notification_purchase_order_updated').'<hr style="border-top: 1px solid #CCCCCC; border-left: 1px solid whitesmoke; border-bottom: 1px solid whitesmoke;"/>');
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

            $this->view_data['form'] = $form = json_encode($bpm_flow->form);
        }
    }

    public function reply($ajax = false){
        if ($_POST) {
            $id = $_POST['id'];
            $updating_purchase_order = PurchaseOrder::find($id);

            $bpm_flow = BpmFlow::find(1);
            $flow = json_decode($bpm_flow->flow);

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

            $is_progress = null;

            foreach ($_POST as $key => $value) {
                if (strpos($key, 'submit_') !== 0) continue;
                $is_progress = substr($key, 7);
                unset($_POST["$key"]);
            }

            $history_registry = new stdClass;
            $history_registry->history_files = $file_names_arr;

            foreach ($_POST as $key => $value) {
                $history_registry->$key = $value;
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

                $current_step = PurchaseOrder::currentStepForPurchaseOrder(1, $id);

                //criação de registro de histórico
                PurchaseOrder::createHistoryForBpmPurchaseStepAndUser(1, $id, $current_step, $this->user->id, $history_registry, $is_progress);

                if ($_POST['canceled'] == 1){
                    // passo final precisa criar registro de histórico quando o penúltimo passo estiver sendo registrado
                    PurchaseOrder::createHistoryForBpmPurchaseStepAndUser(1, $id, $canceled_step, $this->user->id, $is_progress);
                }

            }else{

                $current_step = PurchaseOrder::currentStepForPurchaseOrder(1, $id);

                $next_step = PurchaseOrder::nextStepForPurchaseOrderAfterCurrentStep(1, $id, $current_step->id);
                $_POST['step']  = $next_step->id;

                //criação de registro de histórico
                PurchaseOrder::createHistoryForBpmPurchaseStepAndUser(1, $id, $current_step, $this->user->id, $history_registry, $is_progress);

                if ($next_step->finish == true){
                    // passo final precisa criar registro de histórico quando o penúltimo passo estiver sendo registrado
                    PurchaseOrder::createHistoryForBpmPurchaseStepAndUser(1, $id, $next_step, $this->user->id, $is_progress);
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

                    foreach ($next_step->members as $member){
                        if ($member->email == "creator_email"){
                            $user = User::find($updating_purchase_order->user_id);
                        }else{
                            $user = User::getUserByEmail($member->email);
                        }

                        if ($user->push_active){
                            array_push($push_receivers, $member->email);
                        }

                        $attributes = array('user_id' => $user->id, 'message' => "[Ordem de compra $updating_purchase_order->id] Uma atualização foi feita na Ordem de Venda", 'url' => base_url().'purchaseorders');
                        Notification::create($attributes);


                        send_notification($member->email, "[Ordem de compra $updating_purchase_order->id]", $this->lang->line('application_notification_purchase_order_updated').'<br><hr style="border-top: 1px solid #CCCCCC; border-left: 1px solid whitesmoke; border-bottom: 1px solid whitesmoke;"/>'.$_POST['message'].'<hr style="border-top: 1px solid #CCCCCC; border-left: 1px solid whitesmoke; border-bottom: 1px solid whitesmoke;"/>');
                    }

                    Notification::sendPushNotification($push_receivers, "[Ordem de compra $updating_purchase_order->id] Uma atualização foi feita na Ordem de Venda", base_url() . 'purchaseorders');

                }else{
                    //Purchase Order is backing to the creator
                    array_push($push_receivers, $this->user->email);

                    $attributes = array('user_id' => $updating_purchase_order->user_id, 'message' => "[Ordem de compra $updating_purchase_order->id] Ordem de compra cancelada, verifique o histórico.", 'url' => base_url().'purchaseorders');
                    Notification::create($attributes);

                    Notification::sendPushNotification($push_receivers, "[Ordem de compra $updating_purchase_order->id] Uma ação é necessária", base_url() . 'purchaseorders');
                }

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
            $current_flow = $flow->steps[0]->name." &rarr; ".$flow->steps[$flow->steps[0]->options[0]->destiny]->name;
            $this->view_data['current_flow'] = $current_flow;

            $actions = $flow->steps[0]->options;
            $this->view_data['actions'] = $actions;

        }
    }

    public function update($id = false, $getview = false){
        if ($_POST) {
            $message = PrivateMessage::find($id);
            $message->update_attributes($_POST);
            if (!$message) {
                $this->session->set_flashdata('message', 'error:'.$this->lang->line('messages_write_message_error'));
            } else {
                $this->session->set_flashdata('message', 'success:'.$this->lang->line('messages_write_message_success'));
            }
            if (isset($view)) {
                redirect('purchaseorders/view/'.$id);
            } else {
                redirect('messages');
            }
        } else {
            $this->view_data['id'] = $id;
            $this->theme_view = 'modal';
            $this->view_data['title'] = $this->lang->line('application_edit_message');
            $this->view_data['form_action'] = 'messages/update';
            $this->content_view = 'purchaseorders/_pruchaseorder_update';
        }
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

        $bpm_flow = BpmFlow::find(1);
        $this->view_data['bpm_flow'] = $bpm_flow;
        $this->view_data['flow'] = $flow = json_decode($bpm_flow->flow);


        $actions = BpmFlow::actionsForUserInStep(1, $this->user->email, $purchase_order->step);

        $this->view_data['actions'] = $actions;

        $steps = PurchaseOrder::progressStepsForPurchaseOrder(1, $id);

        $user = User::find($purchase_order->user_id);

        foreach ($steps as $step_reg){
            foreach ($step_reg->members as $member){
                if ($member->name == 'creator_name'){

                    $member->name = $user->firstname.' '.$user->lastname;
                    $member->email = $user->email;
                }
            }
        }

        $this->view_data['steps'] = $steps;
        $this->view_data['history'] = $history = PurchaseOrder::getHistoryForPurchase($id);

        $this->view_data['form'] = json_decode($purchase_order->form);
        $this->view_data['response'] = json_decode($purchase_order->response);
    }
}
