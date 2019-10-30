<?php if (! defined('BASEPATH')) {
    exit('No direct script access allowed');
}

include_once(dirname(__FILE__).'/../third_party/functions.php');

class Terrains extends MY_Controller{

    public function __construct(){
        parent::__construct();
        $access = false;
        if ($this->client) {
            redirect('cprojects');
        } elseif ($this->user) {
            foreach ($this->view_data['menu'] as $key => $value) {
                if ($value->link == "terrains") {
                    $access = true;
                }
            }
            if (!$access) {
                redirect('login');
            }
        } else {
            redirect('login');
        }
        $this->view_data['submenu'] = array(
                        $this->lang->line('application_all_items') => 'terrains'
                        );
    }

    public function index(){
        $this->content_view = 'terrains/all';
//        $reminders = Terrain::table()->delete(['status_id' => [0]]);
    }

    public function search($search){
        $this->view_data['search'] = $search;
        $this->content_view = 'terrains/_terrain';
    }

    public function all(){

//        $user_email = $this->user->email;
//        list($user_email, $domain) = explode('@', $user_email);
//        $condition = $domain == 'ownergy.com.br' ? 1 : 0;

        $condition = $this->user->department_has_user("Comercial", $this->user);

        if ($condition == 0){
            $terrains = Terrain::find('all', array('conditions' => array("status_id != ? AND user_id =? ORDER BY `order`", 0, $this->user->id), 'include' => array('user')));
        }else{
            $terrains = Terrain::find('all', array('conditions' => array("status_id != ? ORDER BY `order`", 0), 'include' => array('user')));
        }

        foreach ($terrains as $terrain){

            $status = TerrainStatus::find($terrain->status_id);

            $limit_date = date('Y-m-d', strtotime($terrain->last_landing. ' + '.$status->duration.'days'));

            $start = strtotime($terrain->last_landing);
            $end = strtotime($limit_date);
            $current =  strtotime(date('Y-m-d H:i'));

            $completed = (($current - $start) / ($end - $start)) * 100;

            if (is_infinite($completed) == false) { if ($completed >= 100) { $terrain->completed = "danger-terrain"; }else if($completed >= 60){ $terrain->completed = "warning-terrain"; }else{ $terrain->completed = "normal-terrain";} }else{ $terrain->completed = "";}
        }

        $stages = TerrainStatus::find('all', array('order' => "`order` ASC"));
        $data = array('terrains' => object_to_array($terrains, true), 'stages' => object_to_array($stages));
        json_response("success", "", $data);
    }

    public function history($id = false)
    {
        $history = TerreinHistory::find_by_sql('select id, terrain_id, message, DATE_FORMAT(created_at, "%d/%m/%Y às %H:%i ") as created_at from terrain_history where terrain_id = '.$id.' ORDER BY id DESC');
        $data = array('history' => object_to_array($history, false));
        json_response("success", "", $data);
    }

    public function comments($id = false)
    {
        $comments = TerrainComment::find('all', array('conditions' => array("terrain_id = ? ORDER BY `datetime` DESC", $id), 'include' => array('user')));
        $data = array('comments' => object_to_array($comments, true));
        json_response("success", "", $data);
    }

    public function reminders($id = false)
    {
        $reminders = Reminder::find('all', array('conditions' => array("module = 'terrain' AND source_id = ? ORDER BY `done` ASC, `datetime` ASC", $id), 'include' => array('user')));
        $data = array('reminders' => object_to_array($reminders, true));
        json_response("success", "", $data);
    }

    public function duereminders()
    {
        $datetime = new datetime();
        $datetimeNow = $datetime->format('Y-m-d H:i:s T');

        $due_reminders = Reminder::find('all', array('select' => 'source_id', 'conditions' => array("module = 'terrain' AND `done` = ? AND `datetime` < ? GROUP BY source_id", 0, $datetimeNow)));
        $data = array('due_reminders' => object_to_array($due_reminders, true));
        json_response("success", "", $data);
    }

    public function reminder($action = false, $id = false)
    {
        switch ($action) {
            case 'create':
                if ($_POST) {
                    $data['module'] = "terrain";
                    $data['source_id'] = $id;
                    $data['title'] = $_POST['title'];
                    $data['body'] = $_POST['message'];
                    $data['email_notification'] = (isset($_POST['email_notification'])) ? 1 : 0;
                    $data['push_notification'] = (isset($_POST['push_notification'])) ? 1 : 0;
                    $data['user_id'] = $this->user->id;
                    $datetime = new datetime($_POST['datetime']);
                    $data['datetime'] = $datetime->format('Y-m-d H:i:s T');
                    $reminder = Reminder::create($data);
                    $data = array('reminder' => object_to_array($reminder, true));
                    json_response("success", "", $data);
                } else {
                    $this->theme_view = 'modal';
                    $this->view_data['title'] = $this->lang->line('application_create_reminder');
                    $this->view_data['form_action'] = 'terrains/reminder/create/'.$id;
                    $this->content_view = 'terrains/_reminder';
                }
                break;
            case 'edit':
                if ($_POST) {
                    $data['title'] = $_POST['title'];
                    $data['body'] = $_POST['message'];
                    $data['email_notification'] = (isset($_POST['email_notification'])) ? 1 : 0;
                    $data['push_notification'] = (isset($_POST['push_notification'])) ? 1 : 0;
                    $data['user_id'] = $this->user->id;
                    $datetime = new datetime($_POST['datetime']);
                    $data['datetime'] = $datetime->format('Y-m-d H:i:s T');
                    $reminder = Reminder::find_by_id($id);
                    $reminder->update_attributes($data);
                    $data = array('reminder' => object_to_array($reminder, true));
                    json_response("success", "", $data);
                } else {
                    $this->theme_view = 'modal';
                    $this->view_data['title'] = $this->lang->line('application_edit_reminder');
                    $this->view_data['form_action'] = 'terrains/reminder/edit/'.$id;
                    $this->view_data['reminder'] = Reminder::find_by_id($id);
                    $this->content_view = 'terrains/_reminder';
                }
                break;
            case 'delete':
                    $reminder = Reminder::find_by_id($id);
                    $reminder->delete();
                    json_response("success", "");
                break;
        }
    }

    public function togglereminder($id = false)
    {
        $reminder = Reminder::find_by_id($id);
        $reminder->done = ($reminder->done == 1) ? 0 : 1;
        $reminder->save();
        json_response("success");
    }

    public function addcomment()
    {
        if ($_POST) {
            $data['terrain_id'] = $_POST['terrain_id'];
            $data['message'] = $_POST['message'];
            $data['user_id'] = $this->user->id;
            $data['datetime'] = time();
            $config['upload_path'] = './files/media/';
            $config['encrypt_name'] = true;
            $config['max_size'] = '0';
            $config['allowed_types'] = '*';
            $this->load->library('upload', $config);
            $this->load->helper('media');

            $data['attachment'] = "";
            $data['attachment_link'] = "";
            if (!$this->upload->do_upload()) {
                $error = $this->upload->display_errors('', ' ');
                if ($error != 'You did not select a file to upload.') {
                    //$this->session->set_flashdata('message', 'error:'.$error);
                }
            } else {
                $filedata = array('upload_data' => $this->upload->data());
                $data['attachment'] = $filedata['upload_data']['orig_name'];
                $data['attachment_link'] = $filedata['upload_data']['file_name'];
                if (is_image('./files/media/'.$data['attachment_link'])) {
                    create_thumb($data['attachment_link'], 230, 230);
                }
            }

            $comment = TerrainComment::create($data);
            $responsedata = array('comment' => array( "datetime" => $comment->datetime,
                                                      "id" => $comment->id,
                                                      "user_id" => $comment->user_id,
                                                      "userpic" => $comment->user->userpic,
                                                      "firstname" => $this->user->firstname,
                                                      "lastname" => $this->user->lastname,
                                                      "attachment" => $data['attachment'],
                                                      "attachment_link" => $data['attachment_link'],)
                                                    );
            json_response("success", "Comment has been posted!", $responsedata);
        } else {
            json_response("error", "Error while sending data to server!", '');
        }
    }

    public function updateblock()
    {
        if ($_POST) {
            $item = Terrain::find_by_id($_POST['id']);
            $field = array($_POST['field'] => $_POST['value'], 'order' => $_POST['order']);

            $currentTerrain = $item;

            $destinationTerrainStatus = null;

            if (is_numeric($_POST['value'])){
                $destinationTerrainStatus = TerrainStatus::find($_POST['value']);
            }else{

                $destinationTerrainStatus->name = "perdidos";

//                $historyAttributes = array('terrain_id' => $_POST['id'], 'message' => $this->user->firstname.' moveu '.$currentTerrain->name.' para '.$destinationTerrainStatus->name);
//                TerrainHistory::create($historyAttributes);
            }

            $statusReceivers = TerrainStatusReceiver::find('all', ['conditions' => ['terrain_status_id = ?', $_POST['value']]]);

            $push_receivers = array();

            foreach ($statusReceivers as $statusReceiver) {
                $user = User::find($statusReceiver->user_id);

                if ($user->push_active == 1) {
                    array_push($push_receivers, $user->email);
                }

                $notificationAttributes = array('user_id' => $user->id, 'message' => '<b>'.$this->user->firstname.'</b> moveu <b>'.$currentTerrain->name.'</b> para <b>'.$destinationTerrainStatus->name.'</b>', 'url' => base_url().'terrains/');
                Notification::create($notificationAttributes);
            }

            $warningUsers = TerrainWarningUser::find('all', array('conditions' => array('terrain_id = ?',$_POST['id'])));

            //push será enviado para todos colaboradores que marcaram aquele terrain com interesse em notificação de movimentação
            foreach ($warningUsers as $warningUser){
                $user = User::find($warningUser->user_id);

                if ($user->push_active == 1) {
                    array_push($push_receivers, $user->email);
                }

                $notificationAttributes = array('user_id' => $user->id, 'message' => '<b>'.$this->user->firstname.'</b> moveu <b>'.$currentTerrain->name.'</b> para <b>'.$destinationTerrainStatus->name.'</b>', 'url' => base_url().'terrains/');
                Notification::create($notificationAttributes);
            }

            Notification::sendPushNotification($push_receivers, $this->user->firstname.' moveu '.$currentTerrain->name.' para '.$destinationTerrainStatus->name, base_url().'terrains/');

            $historyAttributes = array('terrain_id' => $_POST['id'], 'message' => $this->user->firstname.' moveu '.$currentTerrain->name.' para '.$destinationTerrainStatus->name);
            TerrainHistory::create($historyAttributes);

            $item->last_landing = date("Y-m-d H:i");

            $item = $item->update_attributes($field);
            json_response("success", "Block has been updated!", '');
        } else {
            json_response("error", "Request has no post data!", '');
        }
    }

    public function icon($id = false, $icon = false)
    {
        $item = Terrain::find_by_id($id);
        if ($item) {
            $item->icon = $icon;
            $item->modified = date("Y-m-d H:i");
            $item->last_landing = date("Y-m-d H:i");
            $item->save();
            json_response("success", "Block has been updated!", '');
        } else {
            json_response("error", "Request has no post data!", '');
        }
    }

    public function create()
    {
        if ($_POST) {
            unset($_POST['send']);
            unset($_POST['files']);
            $_POST['private'] = (isset($_POST['private'])) ? 1 : 0;
            $description = $_POST['description'];
            $_POST['description'] = $description;
            $_POST['created'] = date("Y-m-d H:i");
            $_POST['last_landing'] = date("Y-m-d H:i");
            $_POST['modified'] = date("Y-m-d H:i");
            $_POST['order'] = -50+rand(1, 5);

            $post_terrain_has_warning_user = (isset($_POST['terrain_warning_user'])) ? 1 : 0;
            unset($_POST['terrain_warning_user']);

            $terrain_warning_user = TerrainWarningUser::find('first', array('conditions' => array('terrain_id = ? AND user_id = ?',$_POST['id'], $this->user->id)));

            if ($post_terrain_has_warning_user == 0){
                if ($terrain_warning_user != null){
                    $atributes = array('user_id' => $this->user->id, 'terrain_id' => $_POST['id']);
                    $deleted = TerrainWarningUser::find($atributes);
                    $deleted->delete();
                }
            }else{
                if ($terrain_warning_user != null){
                    $atributes = array('user_id' => $this->user->id, 'terrain_id' => $_POST['id']);
                    TerrainWarningUser::save($atributes);
                }else{
                    $atributes = array('user_id' => $this->user->id, 'terrain_id' => $_POST['id']);
                    TerrainWarningUser::create($atributes);
                }
            }

            if (!empty($_POST['tags_arr'])) {
                $_POST['tags'] = implode(',', $_POST['tags_arr']);
            } else {
                unset($_POST['tags']);
            }

            unset($_POST['tags_arr']);

            $item = Terrain::create($_POST);

            $historyAttributes = array('terrain_id' => $item->id, 'message' => $this->user->firstname.' criou o terreno '.$item->name);
            TerrainHistory::create($historyAttributes);

            if (!$item) {
                $this->session->set_flashdata('message', 'error:'.$this->lang->line('messages_create_terrain_error'));
            } else {
                $this->session->set_flashdata('message', 'success:'.$this->lang->line('messages_create_terrain_success'));
            }
            redirect('terrains');
        } else {
            $this->theme_view = 'modal';
            $this->view_data['title'] = $this->lang->line('application_create_terrain');
            $this->view_data['status'] = TerrainStatus::all();
            $this->view_data['users'] = User::find('all', ['conditions' => ['status=?', 'active']]);

            $this->view_data['form_action'] = 'terrains/create';

            $tags = array();
            $all_tags = Tag::all();
            foreach ($all_tags as $tag){
                array_push($tags, $tag->name);
            }
            $this->view_data['tags'] = $tags;

            $this->content_view = 'terrains/_terrain';
        }
    }

    public function edit($id = false)
    {
        if ($_POST) {
            unset($_POST['send']);
            unset($_POST['files']);

            $_POST['private'] = (isset($_POST['private'])) ? 1 : 0;

            $post_terrain_has_warning_user = (isset($_POST['terrain_warning_user'])) ? 1 : 0;
            unset($_POST['terrain_warning_user']);

            $description = $_POST['description'];
            $_POST['description'] = $description;
            $_POST['modified'] = date("Y-m-d H:i");

            $terrain = Terrain::find_by_id($_POST['id']);
            $destinationTerrainStatus = TerrainStatus::find($_POST['status_id']);

            if (!empty($_POST['tags_arr'])) {
                $_POST['tags'] = implode(',', $_POST['tags_arr']);
            } else {
                $_POST['tags'] = implode(',', $_POST['tags_arr']);
            }

            unset($_POST['tags_arr']);

            $changedDataHistory = "";

            if ($terrain->company != $_POST['company']){
                $changedDataHistory .= "Cliente; ";
            }

            if (trim($terrain->description) != trim($_POST['description'])){
                $changedDataHistory .= "Descrição; ";
            }

            if ($terrain->private != $_POST['private']){
                $changedDataHistory .= "Privacidade; ";
            }

            if ($terrain->address != $_POST['address'] || $terrain->city != $_POST['city'] || $terrain->state != $_POST['state'] || $terrain->country != $_POST['country'] || $terrain->zipcode != $_POST['zipcode']){
                $changedDataHistory .= "Dados de endereço; ";
            }

            if ($terrain->email != $_POST['email'] || $terrain->phone != $_POST['phone'] || $terrain->mobile != $_POST['mobile']){
                $changedDataHistory .= "Dados de contato; ";
            }

            if ($terrain->owner != $_POST['owner']){
                $changedDataHistory .= "Dado do terreno; ";
            }

            if ($terrain->user_id != $_POST['user_id']){
                $changedDataHistory .= "Responsável pelo terreno; ";
            }

            if ($terrain->tags != $_POST['tags']){
                $changedDataHistory .= "Tags; ";
            }

            if ($terrain->proposal_value != $_POST['proposal_value']){
                $changedDataHistory .= "Valor da proposta; ";
            }

            if ($terrain->rated_power_mod != $_POST['rated_power_mod']){
                $changedDataHistory .= "Potência nominal; ";
            }

            if ($changedDataHistory != ""){
                $changedDataHistoryFull = array('terrain_id' => $terrain->id, 'message' => $this->user->firstname.' alterou os seguintes dados de '.$terrain->name.': '.$changedDataHistory);
                TerrainHistory::create($changedDataHistoryFull);
            }


            if ($terrain->status_id != $_POST['status_id']){

                $_POST['last_landing'] = date("Y-m-d H:i");

                $historyAttributes = array('terrain_id' => $terrain->id, 'message' => $this->user->firstname.' moveu '.$terrain->name.' para '.$destinationTerrainStatus->name);
                TerrainHistory::create($historyAttributes);
            }

            $statusReceivers = TerrainStatusReceiver::find('all', ['conditions' => ['terrain_status_id=?', $_POST['status_id']]]);

            if ($terrain->status_id != $_POST['status_id']) {

                $push_receivers = array();

                //push será enviado para todos colaboradores que estão selecionados na configuração de status
                foreach ($statusReceivers as $statusReceiver) {
                    $user = User::find($statusReceiver->user_id);

                    if ($user->push_active == 1) {
                        array_push($push_receivers, $user->email);
                    }

                    $notificationAttributes = array('user_id' => $user->id, 'message' => '<b>' . $this->user->firstname . '</b> moveu <b>' . $terrain->name . '</b> para <b>' . $destinationTerrainStatus->name . '</b>', 'url' => base_url() . 'terrains/');
                    Notification::create($notificationAttributes);
                }

                $warningUsers = TerrainWarningUser::find('all', array('conditions' => array('terrain_id = ?', $_POST['id'])));

                //push será enviado para todos colaboradores que marcaram aquele terrain com interesse em notificação de movimentação
                foreach ($warningUsers as $warningUser) {
                    $user = User::find($warningUser->user_id);

                    if ($user->push_active == 1) {
                        array_push($push_receivers, $user->email);
                    }

                    $notificationAttributes = array('user_id' => $user->id, 'message' => '<b>' . $this->user->firstname . '</b> moveu <b>' . $terrain->name . '</b> para <b>' . $destinationTerrainStatus->name . '</b>', 'url' => base_url() . 'terrains/');
                    Notification::create($notificationAttributes);
                }

                Notification::sendPushNotification($push_receivers, $this->user->firstname . ' moveu ' . $terrain->name . ' para ' . $destinationTerrainsStatus->name, base_url() . 'terrains/');
            }

            $terrain_warning_user = TerrainWarningUser::find('first', array('conditions' => array('terrain_id = ? AND user_id = ?',$_POST['id'], $this->user->id)));

            if ($post_terrain_has_warning_user == 0){
                if ($terrain_warning_user != null){
                    $atributes = array('user_id' => $this->user->id, 'terrain_id' => $_POST['id']);
                    $deleted = TerrainWarningUser::find($atributes);
                    $deleted->delete();
                }
            }else{
                if ($terrain_warning_user != null){
                    $atributes = array('user_id' => $this->user->id, 'terrain_id' => $_POST['id']);
                    $terrain_warning_user->save($atributes);
                }else{
                    $atributes = array('user_id' => $this->user->id, 'terrain_id' => $_POST['id']);
                    TerrainWarningUser::create($atributes);
                }
            }

            $terrain->update_attributes($_POST);
            if (!$terrain) {
                $this->session->set_flashdata('message', 'error:'.$this->lang->line('messages_edit_terrain_error'));
            } else {
                $this->session->set_flashdata('message', 'success:'.$this->lang->line('messages_edit_terrain_success'));
            }
            redirect('terrains');
        } else {
            $editing_terrain = Terrain::find_by_id($id);
            $this->theme_view = 'modal';
            $this->view_data['title'] = $this->lang->line('application_edit_terrain');
            $terrain_status = TerrainStatus::find_by_id($editing_terrain->status_id);
            $this->view_data['previous_status'] = TerrainStatus::find('first', array('conditions' => array('terrain_status.order < ? ORDER BY terrain_status.order DESC',$terrain_status->order)));
            $this->view_data['next_status'] = TerrainStatus::find('first', array('conditions' => array('terrain_status.order > ? ORDER BY terrain_status.order ASC',$terrain_status->order)));
            $this->view_data['status'] = TerrainStatus::all();
            $this->view_data['users'] = User::find('all', ['conditions' => ['status=?', 'active']]);
            $this->view_data['terrain'] = $editing_terrain;
            $this->view_data['terrain_warning_user'] = TerrainWarningUser::find('first', array('conditions' => array('terrain_id = ? AND user_id = ?',$id, $this->user->id)));
            $this->view_data['form_action'] = 'terrains/edit';

            $this->content_view = 'terrains/_terrain';

            $tags = array();
            $all_tags = Tag::all();
            foreach ($all_tags as $tag){
                array_push($tags, $tag->name);
            }
            $this->view_data['tags'] = $tags;
        }
    }
    public function delete($id = false)
    {
        $reminders = Reminder::table()->delete(['source_id' => [$id], 'module' => ['terrain']]);
        json_response('success', 'Terrain has been removed!', '');

//        $currentTerrain = Terrain::find_by_id($id);

//        $notificationAttributes = array('user_id' => $this->user->id, 'message' => '<b>'.$this->user->firstname.'</b> moveu <b>'.$currentTerrain->name.'</b> para <b> perdidos </b>', 'url' => base_url().'terrains/');
//        Notification::create($notificationAttributes);
    }
    public function status($action = false, $id = false, $attr = false)
    {
        switch ($action) {
            case 'create':
                if ($_POST) {
                    unset($_POST['send']);
                    unset($_POST['files']);
                    $description = $_POST['description'];
                    $name = $_POST['name'];
                    $duration = $_POST['duration'];
                    $order = TerrainStatus::find('all', array('order' => "`order` desc", 'limit' => 1));
                    $color = $_POST['color'];

                    $atributes = array('name' => $name, 'description' => $description, 'order' => $order[0]->order+1, 'duration' => $duration, 'color' => $color);

                    $status = TerrainStatus::create($atributes);

                    if (!isset($_POST["user_id"])) {
                        $_POST["user_id"] = array();
                    }

                    foreach ($_POST["user_id"] as $value) {
                        $atributes = array('terrain_status_id' => $status->id, 'user_id' => $value);

                        TerrainStatusReceiver::create($atributes);
                    }

                    if (!$status) {
                        $this->session->set_flashdata('message', 'error:'.$this->lang->line('messages_create_status_error'));
                    } else {
                        $this->session->set_flashdata('message', 'success:'.$this->lang->line('messages_create_status_success'));
                    }
                    redirect('terrains');
                } else {
                    $this->theme_view = 'modal';
                    $this->view_data['title'] = $this->lang->line('application_create_status');
                    $this->view_data['users'] = User::find('all', array('conditions' => array('status=?','active')));
                    //$this->view_data['status'] = TerrainStatus::all();
                    $this->view_data['form_action'] = 'terrains/status/create';
                    $this->content_view = 'terrains/_status';
                }
            break;

            case 'edit':
                if ($_POST) {
                    unset($_POST['send']);
                    unset($_POST['files']);
                    $description = $_POST['description'];
                    $status = TerrainStatus::find_by_id($_POST['id']);
                    $status_id = addslashes($_POST['id']);
                    $status->name = $_POST['name'];
                    $status->duration = $_POST['duration'];
                    $status->description = $description;
                    $status->color = $_POST['color'];

                    if (!isset($_POST["user_id"])) {
                        $_POST["user_id"] = array();
                    }

                    $query = array();

                    foreach ($status->terrain_status_receiver as $receiver) {
                        array_push($query, $receiver->user_id);
                    }

                    $added = array_diff($_POST["user_id"], $query);
                    $removed = array_diff($query, $_POST["user_id"]);

                    foreach ($added as $value) {
                        $atributes = array('terrain_status_id' => $status_id, 'user_id' => $value);

                        TerrainStatusReceiver::create($atributes);
                    }

                    foreach ($removed as $value) {
                        $atributes = array('terrain_status_id' => $status_id, 'user_id' => $value);
                        $worker = TerrainStatusReceiver::find($atributes);
                        $worker->delete();
                    }

                    $status->save();
                    if (!$status) {
                        $this->session->set_flashdata('message', 'error:'.$this->lang->line('messages_edit_status_error'));
                    } else {
                        $this->session->set_flashdata('message', 'success:'.$this->lang->line('messages_edit_status_success'));
                    }
                    redirect('terrains');
                } else {
                    $this->theme_view = 'modal';
                    $terrain_status = TerrainStatus::find_by_id($id);
                    $this->view_data['users'] = User::find('all', array('conditions' => array('status=?','active')));
                    $this->view_data['title'] = $this->lang->line('application_create_status');
                    $this->view_data['status'] = $terrain_status;
                    $this->view_data['form_action'] = 'terrains/status/edit';
                    $this->content_view = 'terrains/_status';
                }
            break;

            case 'move':
                    $status = TerrainStatus::find_by_id($id);
                    $find = ($attr == "left") ? "`order` < ? order by `order` DESC LIMIT 1" : "`order` > ? order by `order` ASC LIMIT 1";
                    $statusNewPos = TerrainStatus::find('all', array('conditions' => array($find, array($status->order))));
                    $order = $status->order;
                    $status->order = $statusNewPos[0]->order;
                    $status->save();
                    $other = TerrainStatus::find_by_id($statusNewPos[0]->id);
                    $other->order = $order;
                    $other->save();
                    json_response("success", "Status has been moved!", '');
            break;

            case 'delete':
                    $status = TerrainStatus::find_by_id($id);
                    $terrains = Terrain::find('all', ['conditions' => ['status_id', [$status->id]]]);
                    foreach ($terrains as $terrain) {
                        $terrains_ids[] = $terrain->id;
                    }
//                    $terrains_delete = Terrain::table()->delete(array('status_id' => array($status->id)));
                    $reminders = Reminder::table()->delete(['source_id' => $terrains_ids, 'module' => 'terrain']);
                    $receivers_delete = TerrainStatusReceiver::table()->delete(array('terrain_status_id' => array($status->id)));

                    $status->delete();
                    json_response("success", "Status has been deleted!", '');
            break;
            
            default:
               
            break;
        }
    }
    public function attachment($terrain)
    {
        $this->load->helper('download');
        $this->load->helper('file');

        $comment = TerrainComment::find_by_id($terrain);
        if ($comment && $comment->attachment != "") {
            $file = './files/media/'.$comment->attachment_link;
        } else {
            json_response("error", "Comment not found!", '');
        }
        
        $mime = get_mime_by_extension($file);
        if (file_exists($file)) {
            if ($mime != "") {
                header('Content-Type: '.$mime);
            } else {
                header("Content-type: application/octet-stream");
            }
            header('Content-Description: File Transfer');
            header('Content-Disposition: attachment; filename='.basename($comment->attachment));
            header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
            header('Expires: 0');
            header('Content-Length: ' . filesize($file));
            
            readfile_chunked($file);
            @ob_end_flush();
            exit;
        } else {
            show_error("File could not be found!", 400, "File download error");
        }
    }

    public function lost(){

        $options = ['conditions' => ['status_id = ? ORDER BY ID DESC', '0']];
        $lost_terrains = Terrain::all($options);
        $this->view_data['terrains'] = $lost_terrains;
        $this->content_view = 'terrains/lost';
    }


    public function tags(){

        $all_tags = Tag::all();
        $this->view_data['tags'] = $all_tags;
        $this->content_view = 'terrains/tags';
    }


    public function edittag($action = false, $id = false)
    {
        switch ($action) {
            case 'create':
                if ($_POST) {
                    $name = $_POST['name'];

                    $atributes = array('name' => $name);

                    $created_tag = Tag::create($atributes);

                    if (!$created_tag) {
                        $this->session->set_flashdata('message', 'error:'.$this->lang->line('messages_create_tag_error'));
                    } else {
                        $this->session->set_flashdata('message', 'success:'.$this->lang->line('messages_create_tag_success'));
                    }
                    redirect('terrains/tags');
                } else {
                    $this->theme_view = 'modal';
                    $this->view_data['title'] = $this->lang->line('application_create_tag');
                    $this->view_data['form_action'] = 'terrains/edittag/create';
                    $this->content_view = 'terrains/_tag';
                }
                break;

            case 'edit':
                if ($_POST) {

                    $editing_tag = Tag::find_by_id($_POST['id']);

                    $editing_tag->id = $_POST['id'];
                    $editing_tag->name = $_POST['name'];

                    $editing_tag->save();

                    if (!$editing_tag) {
                        $this->session->set_flashdata('message', 'error:'.$this->lang->line('messages_edit_tag_error'));
                    } else {
                        $this->session->set_flashdata('message', 'success:'.$this->lang->line('messages_edit_tag_success'));
                    }
                    redirect('terrains/tags');
                } else {
                    $this->theme_view = 'modal';
                    $editing_tag = Tag::find_by_id($id);
                    $this->view_data['tag'] = $editing_tag;
                    $this->view_data['title'] = $this->lang->line('application_edit_tag');
                    $this->view_data['form_action'] = 'terrains/edittag/edit';
                    $this->content_view = 'terrains/_tag';
                }
                break;

            case 'delete':
                $deleting_tag = Tag::find_by_id($id);

                $deleting_tag->delete();
                json_response("success", "Tag removida com sucesso", '');
                break;

            default:

                break;
        }
    }

    public function notifycomercial($terrain_id){

        $comercialTeam = DepartmentWorker::find('all', array('conditions' => array('department_id = ?', 2)));

        $terrain = Terrain::find_by_id($terrain_id);

        $push_receivers = array();

        //push será enviado para todos colaboradores que tem funções no Departamento Comercial id = 2
        foreach ($comercialTeam as $worker){
            $user = User::find($worker->user_id);

            if ($user->push_active == 1) {
                array_push($push_receivers, $user->email);
            }

            $notificationAttributes = array('user_id' => $user->id, 'message' => '<b>[Atenção ao Terreno]</b> - '.$this->user->firstname.' chamou sua atenção para o Terreno '.$terrain->name, 'url' => base_url().'terrains/');
            Notification::create($notificationAttributes);
        }

        Notification::sendPushNotification($push_receivers, '[Atenção ao Terreno] - '.$this->user->firstname.' chamou sua atenção para o Terreno '.$terrain->name, base_url().'terrains/');
    }

}
