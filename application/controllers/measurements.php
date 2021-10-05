<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Measurements extends MY_Controller{

    public function __construct() {
        parent::__construct();
        $access = false;
        if ($this->user) {
            foreach ($this->view_data['menu'] as $key => $value) {
                if ($value->link == 'measurements') {
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
        $this->content_view = 'measurements/all';
        $this->view_data['form_action'] = 'measurements/search';
    }

    public function search(){
        if ($_POST){
            $this->view_data['is_viewer'] = $is_viewer = BpmFlow::isViewer(1, $this->user->email);
            $measurements = Measurement::find(1);

            $this->view_data['measurements'] = $measurements;

            $search = 'search';
            $this->view_data['filter'] = $search;
            $this->theme_view = 'ajax';
            $this->content_view = 'measurements/list';
        }
    }

    public function listing($con = false){

        $limit = 999999;

        if (is_numeric($con)) {
            $max_value = $con.',';
        } else {
            $max_value = false;
        }

        // $my_steps = BpmFlow::stepsUserIs(1, $this->user->email);
        // $measurements = Measurement::find('all', ['conditions' => ['step IN (?) AND canceled != 1 AND finished != 1 ORDER BY id DESC', $my_steps]]);
        $measurements_all = Measurement::find('all', ['conditions' => ['canceled != 1 AND finished != 1 ORDER BY id DESC']]);

        $measurements_inbox = array();
        foreach($measurements_all as $po){
            $po->flow = json_decode($po->flow);
            foreach ($po->flow->steps as $idx => $step){
                foreach ($step->members as $member){
                    // print_r($member->email);
                    // print_r($this->user->email);
                    if ($member->email == $this->user->email){
                        if($po->step == $step->id){
                            array_push($measurements_inbox, $po->id);
                            // print_r("Entrou aqui, ". $step->name. ": ".  $po->id . '<br/>');
                        }
                    }
                    if($member->name == 'project_leader'){
                        if($po->project_leader == $this->user->email){
                            if($po->step == $step->id){
                                array_push($measurements_inbox, $po->id);
                            }
                        }
                    }
                    if($member->name == 'technical_manager'){
                        if($po->technical_manager == $this->user->email){
                            if($po->step == $step->id){
                                array_push($measurements_inbox, $po->id);
                            }
                        }
                    }
                }
            }
        }

        

        // var_dump($measurements_inbox);
        // print_r('</br> proxima </br>');
        $measurements_inbox = array_unique($measurements_inbox);
        $ids_inbox = implode(",", $measurements_inbox);
        //var_dump($ids_inbox);
        // print_r("<br/>");
        $measurements = Measurement::find('all', ['conditions' => ["id IN ($ids_inbox) AND canceled != 1 AND finished != 1 ORDER BY id DESC"]]);
        // var_dump($measurements);
        // print_r("<br/>");    
        // $query = "SELECT id FROM measurement WHERE id IN ($ids_inbox) AND canceled != 1 AND finished != 1 ORDER BY id DESC";
        // print_r($query);
        // $measurements = $measurements_inbox;

        $progress_measurements = Measurement::find('all', ['conditions' => ['canceled != 1 AND finished != 1 ORDER BY id DESC'], 'limit' => $limit, 'offset' => $max_value]);

        foreach ($progress_measurements as $measurement){
            $flow = json_decode($measurement->flow);

            foreach ($flow->steps as $step){

                if ($measurement->step == $step->id){

                    foreach ($step->members as $member){
                        if ($member->name == "creator_name" && $measurement->user_id == $this->user->id){
                            if(!in_array($measurement, $measurements)){
                                // print_r("Entrou aqui, creator: ". $measurement->id . '<br/>');
                                array_push($measurements, $measurement);
                            }
                        }
                        if ($member->name == "technical_manager" && $measurement->technical_manager == $this->user->email){
                            if(!in_array($measurement, $measurements)){
                                // print_r("Entrou aqui, technical manager: ". $measurement->id . '<br/>');
                                array_push($measurements, $measurement);
                            }
                        }
                        if ($member->name == "project_leader" && $measurement->project_leader == $this->user->email){
                            if(!in_array($measurement, $measurements)){
                                // print_r("Entrou aqui, project leader: ". $measurement->id . '</br>');
                                array_push($measurements, $measurement);
                            }
                        }
                    }
                }
            }
        }

        usort($measurements, function($a, $b) { return $b->id - $a->id; });

//        $obj_list_page_next = $con + $limit;
//        $obj_list_page_prev = $con - $limit;
//        $this->view_data['obj_list_page_next'] = $obj_list_page_next;
//        $this->view_data['obj_list_page_prev'] = $obj_list_page_prev;
//        $current_page = intval($con);
//        $this->view_data['current_page'] = $current_page;
//        $show_next = count($measurements);
//        $this->view_data['show_next'] = $show_next;

        $this->view_data['measurements'] = $measurements;
        //$this->view_data['my_steps'] = $my_steps;

        $this->view_data['filter'] = false;
        $this->theme_view = 'ajax';
        $this->content_view = 'measurements/list';
    }

    public function filter($condition = false, $con){

        $limit = 99999;
        if (is_numeric($con)) {
            $max_value = $con.',';
        } else {
            $max_value = false;
        }

        $con = rawurldecode($con);

        $this->view_data['filter'] = ucfirst($condition);
        $measurements = array();

        switch ($condition){
            case 'sent' :
                $measurements = Measurement::find('all', ['conditions' => ['user_id = ? ORDER BY id DESC', $this->user->id], 'limit' => $limit, 'offset' => $max_value]);
                break;
            case "finished" :
                $measurements =  Measurement::find('all', ['conditions' => ['finished = ? ORDER BY id DESC', 1], 'limit' => $limit, 'offset' => $max_value]);
                break;
            case "canceled" :
                $measurements =  Measurement::find('all', ['conditions' => ['canceled = ? ORDER BY id DESC', 1], 'limit' => $limit, 'offset' => $max_value]);
                break;
            case "all" :
                $measurements =  Measurement::find('all', ['conditions' => ['1 = 1 ORDER BY id DESC'], 'limit' => $limit, 'offset' => $max_value]);
                break;
            case "search" :
                $measurements =  Measurement::find('all', ['conditions' => ["response LIKE '%$con%' OR history LIKE '%$con%' OR id LIKE '%$con%' ORDER BY id DESC"]]);
                break;
        }

//        var_dump($measurements);

//        $obj_list_page_next = $con + $limit;
//        $obj_list_page_prev = $con - $limit;
//        $this->view_data['obj_list_page_next'] = $obj_list_page_next;
//        $this->view_data['obj_list_page_prev'] = $obj_list_page_prev;
//        $current_page = intval($con);
//        $this->view_data['current_page'] = $current_page;
//        $show_next = count($measurements) ;
//        $this->view_data['show_next'] = $show_next;

        $this->view_data['measurements'] = $measurements;
        $this->view_data['filter'] = $condition;
        $this->theme_view = 'ajax';
        $this->content_view = 'measurements/list';
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
                    $config['upload_path'] = './files/measurements/';
                    $config['encrypt_name'] = true;
                    $config['allowed_types'] = '*';
                    $config['max_size'] = '10000'; // max_size in kb
                    $config['file_name'] = $_FILES['files']['name'][$i];

                    //Load upload library
                    $this->load->library('upload',$config);

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

                if ($key == 'faturamento'){
                    $faturamento  = $value;
                }
                if ($key == 'project_leader'){
                    $project_leader = $value;
                }
                if ($key == 'technical_manager'){
                    $technical_manager = $value;
                }
                if($key == 'work'){
                    $work = $value;
                }
                if($key == 'requester_company'){
                    $company = $value;
                }

                unset($_POST["$key"]);
            }

            $response->files = $file_names_arr;

            $bpm_flow = BpmFlow::find(4);
            $_POST['flow'] = $bpm_flow->flow;
            $_POST['response'] = json_encode($response);

            $_POST['price'] = $price;
            $_POST['work'] = $work;

            $_POST['step'] = $submit_action;
            $_POST['user_id'] = $this->user->id;

            $_POST['technical_manager'] = $technical_manager;
            $_POST['project_leader'] = $project_leader;
            $_POST['faturamento'] = $faturamento;
            $_POST['company'] = $company;

            $new_measurement = Measurement::create($_POST);
            $push_receivers = array();

            if (!$new_measurement) {
                $this->session->set_flashdata('message', 'error:'.$this->lang->line('messages_write_message_error'));
            } else {
                $this->session->set_flashdata('message', 'success:'.$this->lang->line('messages_write_message_success'));
                $this->load->helper('notification');

                $last_measurement_order = Measurement::find('last');
                $current_step = Measurement::getMeasurementStepWithId($last_measurement_order->id, 0);

                $next_step = Measurement::nextStepForMeasurementAfterCurrentStep($last_measurement_order->id, $current_step->id);

                //criação de registro de histórico
                Measurement::createHistoryForMeasurementStepAndUser($last_measurement_order->id, $current_step, $this->user->id, false, true);

                foreach ($next_step->members as $member){
                    $user = User::getUserByEmail($member->email);
                    if ($user->push_active){
                        array_push($push_receivers, $member->email);
                    }

                    $attributes = array('user_id' => $user->id, 'message' => "[Ordem de compra $last_measurement_order->id] Uma ação é necessária", 'url' => base_url().'measurements');
                    Notification::create($attributes);

                    $document = Measurement::measurementbody($last_measurement_order->id);
                    $history = Measurement::measurementhistory($last_measurement_order->id);

                    $actions = array();
                    foreach ($next_step->actions as $action){
                        $action->title = $action->name;
                        $action->href = base_url().'mailaction/updatemeasurementorder/'.str_replace('@ownergy.com.br', '', $member->email).'/'.$last_measurement_order->id.'/'.intval(boolval($action->progress)).'/'.$next_step->id;
                        array_push($actions, $action);
                    }

                    send_bpm_notification($member->email,
                                    "[Ordem de compra $last_measurement_order->id]",
                                    sprintf($this->lang->line('application_notification_measurement_order_updated_mail'), base_url().'measurements'),
                         null,
                                base_url().'measurements',
                        $actions,
                        $document,
                        $history
                        );
                }

                Notification::sendPushNotification($push_receivers, "[Ordem de compra $last_measurement_order->id] Uma ação é necessária", base_url() . 'measurements');

                $this->session->set_flashdata('message', 'success:'.$this->lang->line('messages_edit_success'));
                redirect('measurements');
            }

        } else {

            $this->theme_view = 'modal';
            $this->view_data['title'] = $this->lang->line('application_new_measurement');
            $this->view_data['form_action'] = 'measurements/write';
            $this->content_view = 'measurements/_measurement';

            $bpm_flow = BpmFlow::find(4);
            $this->view_data['bpm_flow'] = $bpm_flow;
            $this->view_data['flow'] = $flow = json_decode($bpm_flow->flow);

            $actions = $flow->steps[0]->actions;
            $this->view_data['actions'] = $actions;

            $form =  $flow->steps[0]->form;
            $this->view_data['form'] = json_encode($form);

        }
    }

    public function reply($ajax = false, $nextStep = null, $measurement_id = false){

        // Method that handles the reply of a Measurement, deciding its fate
        // in the flow

        // First it checks for a POST, and if it exists, it finds de Measurement through its ID.
        // Then the flow is decoded and the current step is stored from the POST variable

        if ($_POST) {
            $id = $_POST['id'];
            if($id == null){
                $id = $measurement_id;
            }
            $updating_measurement_order = Measurement::find($id);
            $flow = json_decode($updating_measurement_order->flow);
            $step = $_POST['current_step'];

            // Here it handles some errors. First trying to reply to a cancelled Measurement, then trying to reply
            // to a finished Measurement, and then trying to update a Measurement step that has been already filled

            if ($updating_measurement_order->canceled == true || $updating_measurement_order->finished == true || $updating_measurement_order->step > $step){

                if ($updating_measurement_order->canceled == true){
                    $this->session->set_flashdata('message', 'error:'.'Esta Ordem de Compra está com status de cancelada');
                    redirect('measurements');
                }else if ($updating_measurement_order->finished == true){
                    $this->session->set_flashdata('message', 'error:'.'Esta Ordem de Compra está com status de finalizada');
                    redirect('measurements');
                }else if($updating_measurement_order->step > $step && $nextStep == null){
                    $this->session->set_flashdata('message', 'error:'.'Esta Ordem de Compra já teve esta etapa completada previamente');
                    redirect('measurements');
                }

            }

            // Things were dealt in a X way to upload files in the past, but then we needed to deal in the Y way. So the reply
            // doesn't crack old Measurements that haven't been completed, it checks if it's the old or new structure

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
                        $config['upload_path'] = './files/measurements/';
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

                $i = 0;

                foreach($_FILES as $key => $value){

    
                    $key_name = $key;
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
                        $config['upload_path'] = './files/measurements/';
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
                            $current_file->value = $data['filenames'][$i];
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
            $payment_type = null;

            if ($_POST['price'] != null){
                $total_price = $_POST['price'];
                $updating_measurement_order->price = $total_price;
                $updating_measurement_order->save();
            }

            if ($_POST['work'] != null){
                $work = $_POST['work'];
                $updating_measurement_order->work = $work;
                $updating_measurement_order->save();
            }

            if ($_POST['faturamento'] != null){
                $faturamento = $_POST['faturamento'];
                $updating_measurement_order->faturamento = $faturamento;
                $updating_measurement_order->save();
            }

            foreach ($_POST as $key => $value) {
                // var_dump($key);
                if (strpos($key, 'submit_') !== 0 && $key != "travel") continue;
                $is_progress = substr($key, 7);
                if($key == "travel"){
                    $is_progress = 1;
                    $is_travel = 1;
                }
                unset($_POST["$key"]);
            }

            // var_dump($is_progress);
            // exit;

            $history_registry = new stdClass;

            if($is_new_variation == false){
                $history_registry->history_files = $file_names_arr;
            }

            $history_registry->history_data = array();

            $current_step = Measurement::currentStepForMeasurement($id);
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

            // var_dump($history_registry);
            // exit;

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

                $current_step = Measurement::currentStepForMeasurement($id);

                //criação de registro de histórico
                Measurement::createHistoryForMeasurementStepAndUser($id, $current_step, $this->user->id, $history_registry, $is_progress, $is_travel);

                if ($_POST['canceled'] == 1){
                    // passo final precisa criar registro de histórico quando o penúltimo passo estiver sendo registrado
                    Measurement::createHistoryForMeasurementStepAndUser($id, $canceled_step, $this->user->id, false, $is_progress, $is_travel);
                }

            }else{

                $current_step = Measurement::currentStepForMeasurement($id);

                if($nextStep != null){
                    $next_step = $nextStep;
                    $_POST['step']  = $next_step->id;
                }else{
                    $next_step = Measurement::nextStepForMeasurementAfterCurrentStep($id, $current_step->id);
                    $_POST['step']  = $next_step->id;
                }


                //criação de registro de histórico
                Measurement::createHistoryForMeasurementStepAndUser($id, $current_step, $this->user->id, $history_registry, $is_progress, $is_travel);

                if ($next_step->finish == true){
                    // passo final precisa criar registro de histórico quando o penúltimo passo estiver sendo registrado
                    Measurement::createHistoryForMeasurementStepAndUser($id, $next_step, $this->user->id, false, $is_progress, $is_travel);
                    $_POST['finished'] = 1;
                }
            }

            $updating_measurement_order->update_attributes($_POST);

            $push_receivers = array();
            if (!$updating_measurement_order) {
                $this->session->set_flashdata('message', 'error:'.$this->lang->line('messages_edit_error'));
            } else {

                if ($is_progress == true){
                    $this->load->helper('notification');

                    $next_step_members = array();

                    foreach ($next_step->members as $member){

                        array_push($arr_emails_in_step, $member->email);
                        if ($member->name == 'creator_name'){

                            $user = User::find($updating_measurement_order->user_id);
                            $member->name = $user->firstname.' '.$user->lastname;
                            $member->email = $user->email;
                        }
                        if ($member->name == 'project_leader'){

                            $member->name = User::getUserByEmail(Measurement::find($id)->project_leader)->firstname . ' ' . User::getUserByEmail(Measurement::find($id)->project_leader)->lastname;
                            $member->email = Measurement::find($id)->project_leader;
                        }
                        if ($member->name == 'technical_manager'){

                            $member->name = User::getUserByEmail(Measurement::find($id)->technical_manager)->firstname . ' ' . User::getUserByEmail(Measurement::find($id)->technical_manager)->lastname;
                            $member->email = Measurement::find($id)->technical_manager;
                        }

                        array_push($next_step_members, $member);
                    }

                    $next_step_members = $this->my_array_unique($next_step_members);


                    foreach ($next_step_members as $member){
                        $user = User::getUserByEmail($member->email);

                        if ($user->push_active){
                            array_push($push_receivers, $member->email);
                        }

                        $attributes = array('user_id' => $user->id, 'message' => "[Ordem de compra $updating_measurement_order->id] Uma atualização foi feita na Ordem de Compra", 'url' => base_url().'measurements');
                        Notification::create($attributes);

                        $document = Measurement::measurementbody($updating_measurement_order->id);
                        $history = Measurement::measurementhistory($updating_measurement_order->id);

                        $actions = array();
                        foreach ($next_step->actions as $action){
                            $action->title = $action->name;
                            $action->href = base_url().'mailaction/updatemeasurementorder/'.str_replace('@ownergy.com.br', '', $member->email).'/'.$updating_measurement_order->id.'/'.intval(boolval($action->progress)).'/'.$next_step->id;
                            array_push($actions, $action);
                        }

                        send_bpm_notification($member->email,
                                    "[Ordem de compra $updating_measurement_order->id]",
                            sprintf($this->lang->line('application_notification_measurement_order_updated_mail'), base_url().'measurements'),
                                null,
                                base_url().'measurements',
                                $actions,
                                $document,
                                $history);
                    }

                    Notification::sendPushNotification($push_receivers, "[Ordem de compra $updating_measurement_order->id] Uma atualização foi feita na Ordem de Compra", base_url() . 'measurements');

                }else{
                    //Measurement is backing to the creator
                    array_push($push_receivers, $this->user->email);

                    $attributes = array('user_id' => $updating_measurement_order->user_id, 'message' => "[Ordem de compra $updating_measurement_order->id] Ordem de compra cancelada, verifique o histórico", 'url' => base_url().'measurements');
                    Notification::create($attributes);

                    Notification::sendPushNotification($push_receivers, "[Ordem de compra $updating_measurement_order->id] Ordem de Compra cancelada, verifique o histórico", base_url() . 'measurements');
                }

                $this->session->set_flashdata('message', 'success:'.$this->lang->line('messages_edit_success'));
                redirect('measurements');
            }

        } else {

            //Measurement has no modal reply

        }
    }

    public function measurementdata($measurement_id = false){

        $this->theme_view = 'blank';

        $measurement_order_data = Measurement::measurementhistory($measurement_id);
//        $measurement_order_data = Measurement::measurementbody($measurement_id);

        echo $measurement_order_data;
    }

    public function delete($id = false){
        $measurement = Measurement::find_by_id($id);
        $measurement->deleted = '1';
        $measurement->save();

        $this->content_view = 'measurements/all';
        if (!$measurement) {
            $this->session->set_flashdata('message', 'error:'.$this->lang->line('messages_delete_error'));
        } else {
            $this->session->set_flashdata('message', 'success:'.$this->lang->line('messages_delete_success'));
        }
        redirect('measurements');
    }

    public function view($id = false, $filter = false, $additional = false){
        $measurement = Measurement::find_by_id($id);
        $this->view_data['measurement'] = $measurement;

        $this->theme_view = 'ajax';
        $this->view_data['form_action'] = 'measurements/write';
        $this->view_data['id'] = $id;
        $this->content_view = 'measurements/view';

        $this->view_data['flow'] = $flow = json_decode($measurement->flow);

        $steps = Measurement::progressStepsForMeasurement($id);

        $user = User::find($measurement->user_id);

        foreach ($steps as $step_reg){
            foreach ($step_reg->members as $member){

                array_push($arr_emails_in_step, $member->email);
                if ($member->name == 'creator_name'){

                    $member->name = $user->firstname.' '.$user->lastname;
                    $member->email = $user->email;
                }
                if ($member->name == 'project_leader'){

                    $member->name = User::getUserByEmail(Measurement::find($id)->project_leader)->firstname . ' ' . User::getUserByEmail(Measurement::find($id)->project_leader)->lastname;
                    $member->email = Measurement::find($id)->project_leader;
                }
                if ($member->name == 'technical_manager'){

                    $member->name = User::getUserByEmail(Measurement::find($id)->technical_manager)->firstname . ' ' . User::getUserByEmail(Measurement::find($id)->technical_manager)->lastname;
                    $member->email = Measurement::find($id)->technical_manager;
                }
            }

            $step_reg->members = $this->my_array_unique($step_reg->members);
        }

        $creator = User::find($measurement->user_id);

        $actions = BpmFlow::actionsForUserInStep($measurement, $this->user->email, $measurement->step, $creator);


        $this->view_data['actions'] = $actions;

        $this->view_data['current_step'] = Measurement::currentStepForMeasurement($measurement->id);

        $this->view_data['steps'] = $steps;
        $this->view_data['history'] = $history = Measurement::getHistoryForMeasurement($id);

        $form = $steps[0]->form;
        $this->view_data['form'] = $form;
        $this->view_data['response'] = json_decode($measurement->response);

        $step_form =  $flow->steps[$measurement->step]->form;
        $this->view_data['step_form'] = json_encode($step_form);
    }

    public function timetravel($measurement_id = false){

        // Gives the possibility to send a Measurement back in the flow it's
        // going if something went wrong in one of the past steps

        if ($_POST) {
            
            $stepsToGoBack = Measurement::getStepsToGoBack($measurement_id);

            $wishedStep = $_POST['next_step_id'];
            $fullFlow = Measurement::progressStepsForMeasurement($measurement_id);
            $currenthist = Measurement::getHistoryForMeasurement($measurement_id);

            foreach($fullFlow as $step){
                if($step->id == $wishedStep){
                    $stepForReply = $step;
                    print_r('</br>');
                }
            }

            print_r('</br>');

            $this->reply($ajax = false, $nextStep = $stepForReply, $measurement_id);
            
            
            }else{

            // If there's no POST, it renders the modal so the user can
            // fill the form to send the Measurement back in the flow

            // Here it calls the method to get which steps the Measurement
            // is allowed to go back to

            $stepsToGoBack = Measurement::getStepsToGoBack($measurement_id);

            // And here it prepares for rendering the modal

            $this->view_data['steps_in_flow'] = $stepsToGoBack;
            $this->view_data['title'] = "Alterar fluxo da Ordem de Compra";
            $this->theme_view = 'modal';
            $this->content_view = 'measurements/_timetravel';
            
            }
    }

    /*public function preview($id = false, $attachment = false) {
        $this->load->helper(['dompdf', 'file']);
        $this->load->library('parser');
        $measurement = Measurement::find($id);
        $data['measurement'] = $measurement;
        $data['body'] = InvoiceHasItem::find('all', ['conditions' => ['invoice_id=?', $id]]);
        $data['core_settings'] = Setting::first();

        $parse_data = [
            'company' => $data['core_settings']->company,
            'logo' => '<img src="' . base_url() . '' . $data['core_settings']->logo . '" alt="' . $data['core_settings']->company . '"/>',
        ];
        $html = $this->load->view('blueline/templates/pruchaseorder/template', $data, true);
        $html = $this->parser->parse_string($html, $parse_data);

        $filename = 'measurementorder'.'_'.$measurement->id;
        pdf_create($html, $filename, true, $attachment);
    }*/
}
