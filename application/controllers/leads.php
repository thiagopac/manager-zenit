<?php if (! defined('BASEPATH')) {
    exit('No direct script access allowed');
}

include_once(dirname(__FILE__).'/../third_party/functions.php');

class Leads extends MY_Controller{

    public function __construct(){
        parent::__construct();
        $access = false;
        if ($this->client) {
            redirect('cprojects');
        } elseif ($this->user) {
            foreach ($this->view_data['menu'] as $key => $value) {
                if ($value->link == "leads") {
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
                        $this->lang->line('application_all_items') => 'leads'
                        );
    }

    public function index(){
        $this->content_view = 'leads/all';
//        $reminders = Lead::table()->delete(['status_id' => [0]]);
    }

    public function search($search){
        $this->view_data['search'] = $search;
        $this->content_view = 'leads/_lead';
    }

    public function all(){

//        $user_email = $this->user->email;

//        list($user_email, $domain) = explode('@', $user_email);

//        $condition = $domain == 'ownergy.com.br' ? 1 : 0;

        $condition = $this->user->department_has_user("Comercial", $this->user);

        if ($condition == 0){
            $leads = Lead::find('all', array('conditions' => array("status_id != ? AND user_id =? ORDER BY `order`", 0, $this->user->id), 'include' => array('user')));
        }else{
            $leads = Lead::find('all', array('conditions' => array("status_id != ? ORDER BY `order`", 0), 'include' => array('user')));
        }

        foreach ($leads as $lead){

            $status = LeadStatus::find($lead->status_id);

            $limit_date = date('Y-m-d', strtotime($lead->last_landing. ' + '.$status->duration.'days'));

            $start = strtotime($lead->last_landing);
            $end = strtotime($limit_date);
            $current =  strtotime(date('Y-m-d H:i'));

            $completed = (($current - $start) / ($end - $start)) * 100;

            if (is_infinite($completed) == false) { if ($completed >= 100) { $lead->completed = "danger-lead"; }else if($completed >= 60){ $lead->completed = "warning-lead"; }else{ $lead->completed = "normal-lead";} }else{ $lead->completed = "";}
        }

        $stages = LeadStatus::find('all', array('order' => "`order` ASC"));
        $data = array('leads' => object_to_array($leads, true), 'stages' => object_to_array($stages));
        json_response("success", "", $data);
    }

    public function history($id = false)
    {
        $history = LeadHistory::find_by_sql('select id, lead_id, message, DATE_FORMAT(created_at, "%d/%m/%Y às %H:%i ") as created_at from lead_history where lead_id = '.$id.' ORDER BY id DESC');
        $data = array('history' => object_to_array($history, false));
        json_response("success", "", $data);
    }

    public function comments($id = false)
    {
        $comments = LeadHasComment::find('all', array('conditions' => array("lead_id = ? ORDER BY `datetime` DESC", $id), 'include' => array('user')));
        $data = array('comments' => object_to_array($comments, true));
        json_response("success", "", $data);
    }

    public function reminders($id = false)
    {
        $reminders = Reminder::find('all', array('conditions' => array("module = 'lead' AND source_id = ? ORDER BY `done` ASC, `datetime` ASC", $id), 'include' => array('user')));
        $data = array('reminders' => object_to_array($reminders, true));
        json_response("success", "", $data);
    }

    public function duereminders()
    {
        $datetime = new datetime();
        $datetimeNow = $datetime->format('Y-m-d H:i:s T');

        $due_reminders = Reminder::find('all', array('select' => 'source_id', 'conditions' => array("module = 'lead' AND `done` = ? AND `datetime` < ? GROUP BY source_id", 0, $datetimeNow)));
        $data = array('due_reminders' => object_to_array($due_reminders, true));
        json_response("success", "", $data);
    }

    public function reminder($action = false, $id = false)
    {
        switch ($action) {
            case 'create':
                if ($_POST) {
                    $data['module'] = "lead";
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
                    $this->view_data['form_action'] = 'leads/reminder/create/'.$id;
                    $this->content_view = 'leads/_reminder';
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
                    $this->view_data['form_action'] = 'leads/reminder/edit/'.$id;
                    $this->view_data['reminder'] = Reminder::find_by_id($id);
                    $this->content_view = 'leads/_reminder';
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
            $data['lead_id'] = $_POST['lead_id'];
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

            $comment = LeadHasComment::create($data);
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
            $item = Lead::find_by_id($_POST['id']);
            $field = array($_POST['field'] => $_POST['value'], 'order' => $_POST['order']);

            $currentLead = $item;

            $destinationLeadStatus = null;

            if (is_numeric($_POST['value'])){
                $destinationLeadStatus = LeadStatus::find($_POST['value']);
            }else{

                $destinationLeadStatus->name = "perdidos";

//                $historyAttributes = array('lead_id' => $_POST['id'], 'message' => $this->user->firstname.' moveu '.$currentLead->name.' para '.$destinationLeadStatus->name);
//                LeadHistory::create($historyAttributes);
            }

            $statusReceivers = LeadStatusHasReceiver::find('all', ['conditions' => ['lead_status_id = ?', $_POST['value']]]);

            $push_receivers = array();

            foreach ($statusReceivers as $statusReceiver) {
                $user = User::find($statusReceiver->user_id);

                if ($user->push_active == 1) {
                    array_push($push_receivers, $user->email);
                }

                $notificationAttributes = array('user_id' => $user->id, 'message' => '<b>'.$this->user->firstname.'</b> moveu <b>'.$currentLead->name.'</b> para <b>'.$destinationLeadStatus->name.'</b>', 'url' => base_url().'leads/');
                Notification::create($notificationAttributes);
            }

            $warningUsers = LeadHasWarningUser::find('all', array('conditions' => array('lead_id = ?',$_POST['id'])));

            //push será enviado para todos colaboradores que marcaram aquele lead com interesse em notificação de movimentação
            foreach ($warningUsers as $warningUser){
                $user = User::find($warningUser->user_id);

                if ($user->push_active == 1) {
                    array_push($push_receivers, $user->email);
                }

                $notificationAttributes = array('user_id' => $user->id, 'message' => '<b>'.$this->user->firstname.'</b> moveu <b>'.$currentLead->name.'</b> para <b>'.$destinationLeadStatus->name.'</b>', 'url' => base_url().'leads/');
                Notification::create($notificationAttributes);
            }

            Notification::sendPushNotification($push_receivers, $this->user->firstname.' moveu '.$currentLead->name.' para '.$destinationLeadStatus->name, base_url().'leads/');

            $historyAttributes = array('lead_id' => $_POST['id'], 'message' => $this->user->firstname.' moveu '.$currentLead->name.' para '.$destinationLeadStatus->name);
            LeadHistory::create($historyAttributes);

            $item->last_landing = date("Y-m-d H:i");

            $item = $item->update_attributes($field);
            json_response("success", "Block has been updated!", '');
        } else {
            json_response("error", "Request has no post data!", '');
        }
    }

    public function icon($id = false, $icon = false)
    {
        $item = Lead::find_by_id($id);
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

            if (!empty($_POST['tags_arr'])) {
                $_POST['tags'] = implode(',', $_POST['tags_arr']);
            } else {
                unset($_POST['tags']);
            }

            unset($_POST['tags_arr']);

            $item = Lead::create($_POST);

            $historyAttributes = array('lead_id' => $item->id, 'message' => $this->user->firstname.' criou o lead '.$item->name);
            LeadHistory::create($historyAttributes);

            if (!$item) {
                $this->session->set_flashdata('message', 'error:'.$this->lang->line('messages_create_lead_error'));
            } else {
                $this->session->set_flashdata('message', 'success:'.$this->lang->line('messages_create_lead_success'));
            }
            redirect('leads');
        } else {
            $this->theme_view = 'modal';
            $this->view_data['title'] = $this->lang->line('application_create_lead');
            $this->view_data['status'] = LeadStatus::all();
            $this->view_data['users'] = User::find('all', ['conditions' => ['status=?', 'active']]);

            $this->view_data['form_action'] = 'leads/create';

            $tags = array();
            $all_tags = Tag::all();
            foreach ($all_tags as $tag){
                array_push($tags, $tag->name);
            }
            $this->view_data['tags'] = $tags;

            $this->content_view = 'leads/_lead';
        }
    }

    public function edit($id = false)
    {
        if ($_POST) {
            unset($_POST['send']);
            unset($_POST['files']);

            $_POST['private'] = (isset($_POST['private'])) ? 1 : 0;

            $post_lead_has_warning_user = (isset($_POST['lead_warning_user'])) ? 1 : 0;
            unset($_POST['lead_warning_user']);

            $description = $_POST['description'];
            $_POST['description'] = $description;
            $_POST['modified'] = date("Y-m-d H:i");

            $lead = Lead::find_by_id($_POST['id']);
            $destinationLeadStatus = LeadStatus::find($_POST['status_id']);

            if (!empty($_POST['tags_arr'])) {
                $_POST['tags'] = implode(',', $_POST['tags_arr']);
            } else {
                $_POST['tags'] = implode(',', $_POST['tags_arr']);
            }

            unset($_POST['tags_arr']);

            $changedDataHistory = "";

            if ($lead->company != $_POST['company']){
                $changedDataHistory .= "Cliente; ";
            }

            if (trim($lead->description) != trim($_POST['description'])){
                $changedDataHistory .= "Descrição; ";
            }

            if ($lead->private != $_POST['private']){
                $changedDataHistory .= "Privacidade; ";
            }

            if ($lead->address != $_POST['address'] || $lead->city != $_POST['city'] || $lead->state != $_POST['state'] || $lead->country != $_POST['country'] || $lead->zipcode != $_POST['zipcode']){
                $changedDataHistory .= "Dados de endereço; ";
            }

            if ($lead->email != $_POST['email'] || $lead->phone != $_POST['phone'] || $lead->mobile != $_POST['mobile']){
                $changedDataHistory .= "Dados de contato; ";
            }

            if ($lead->owner != $_POST['owner']){
                $changedDataHistory .= "Dado do lead; ";
            }

            if ($lead->user_id != $_POST['user_id']){
                $changedDataHistory .= "Responsável pelo lead; ";
            }

            if ($lead->tags != $_POST['tags']){
                $changedDataHistory .= "Tags; ";
            }

            if ($lead->proposal_value != $_POST['proposal_value']){
                $changedDataHistory .= "Valor da proposta; ";
            }

            if ($lead->rated_power_mod != $_POST['rated_power_mod']){
                $changedDataHistory .= "Potência nominal; ";
            }

            if ($changedDataHistory != ""){
                $changedDataHistoryFull = array('lead_id' => $lead->id, 'message' => $this->user->firstname.' alterou os seguintes dados de '.$lead->name.': '.$changedDataHistory);
                LeadHistory::create($changedDataHistoryFull);
            }


            if ($lead->status_id != $_POST['status_id']){

                $_POST['last_landing'] = date("Y-m-d H:i");

                $historyAttributes = array('lead_id' => $lead->id, 'message' => $this->user->firstname.' moveu '.$lead->name.' para '.$destinationLeadStatus->name);
                LeadHistory::create($historyAttributes);
            }

            $statusReceivers = LeadStatusHasReceiver::find('all', ['conditions' => ['lead_status_id=?', $_POST['status_id']]]);

            if ($lead->status_id != $_POST['status_id']) {

                $push_receivers = array();

                //push será enviado para todos colaboradores que estão selecionados na configuração de status
                foreach ($statusReceivers as $statusReceiver) {
                    $user = User::find($statusReceiver->user_id);

                    if ($user->push_active == 1) {
                        array_push($push_receivers, $user->email);
                    }

                    $notificationAttributes = array('user_id' => $user->id, 'message' => '<b>' . $this->user->firstname . '</b> moveu <b>' . $lead->name . '</b> para <b>' . $destinationLeadStatus->name . '</b>', 'url' => base_url() . 'leads/');
                    Notification::create($notificationAttributes);
                }

                $warningUsers = LeadHasWarningUser::find('all', array('conditions' => array('lead_id = ?', $_POST['id'])));

                //push será enviado para todos colaboradores que marcaram aquele lead com interesse em notificação de movimentação
                foreach ($warningUsers as $warningUser) {
                    $user = User::find($warningUser->user_id);

                    if ($user->push_active == 1) {
                        array_push($push_receivers, $user->email);
                    }

                    $notificationAttributes = array('user_id' => $user->id, 'message' => '<b>' . $this->user->firstname . '</b> moveu <b>' . $lead->name . '</b> para <b>' . $destinationLeadStatus->name . '</b>', 'url' => base_url() . 'leads/');
                    Notification::create($notificationAttributes);
                }

                Notification::sendPushNotification($push_receivers, $this->user->firstname . ' moveu ' . $lead->name . ' para ' . $destinationLeadStatus->name, base_url() . 'leads/');
            }

            $lead_has_warning_user = LeadHasWarningUser::find('first', array('conditions' => array('lead_id = ? AND user_id = ?',$_POST['id'], $this->user->id)));

            if ($post_lead_has_warning_user == 0){
                if ($lead_has_warning_user != null){
                    $atributes = array('user_id' => $this->user->id, 'lead_id' => $_POST['id']);
                    $deleted = LeadHasWarningUser::find($atributes);
                    $deleted->delete();
                }
            }else{
                if ($lead_has_warning_user != null){
                    $atributes = array('user_id' => $this->user->id, 'lead_id' => $_POST['id']);
                    LeadHasWarningUser::save($atributes);
                }else{
                    $atributes = array('user_id' => $this->user->id, 'lead_id' => $_POST['id']);
                    LeadHasWarningUser::create($atributes);
                }
            }

            $lead->update_attributes($_POST);
            if (!$lead) {
                $this->session->set_flashdata('message', 'error:'.$this->lang->line('messages_edit_lead_error'));
            } else {
                $this->session->set_flashdata('message', 'success:'.$this->lang->line('messages_edit_lead_success'));
            }
            redirect('leads');
        } else {
            $editing_lead = Lead::find_by_id($id);
            $this->theme_view = 'modal';
            $this->view_data['title'] = $this->lang->line('application_edit_lead');
            $lead_status = LeadStatus::find_by_id($editing_lead->status_id);
            $this->view_data['previous_status'] = LeadStatus::find('first', array('conditions' => array('lead_status.order < ? ORDER BY lead_status.order DESC',$lead_status->order)));
            $this->view_data['next_status'] = LeadStatus::find('first', array('conditions' => array('lead_status.order > ? ORDER BY lead_status.order ASC',$lead_status->order)));
            $this->view_data['status'] = LeadStatus::all();
            $this->view_data['users'] = User::find('all', ['conditions' => ['status=?', 'active']]);
            $this->view_data['lead'] = $editing_lead;
            $this->view_data['lead_warning_user'] = LeadHasWarningUser::find('first', array('conditions' => array('lead_id = ? AND user_id = ?',$id, $this->user->id)));
            $this->view_data['form_action'] = 'leads/edit';

            $this->content_view = 'leads/_lead';

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
        $reminders = Reminder::table()->delete(['source_id' => [$id], 'module' => ['lead']]);
        json_response('success', 'Lead has been removed!', '');

//        $currentLead = Lead::find_by_id($id);

//        $notificationAttributes = array('user_id' => $this->user->id, 'message' => '<b>'.$this->user->firstname.'</b> moveu <b>'.$currentLead->name.'</b> para <b> perdidos </b>', 'url' => base_url().'leads/');
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
                    $order = LeadStatus::find('all', array('order' => "`order` desc", 'limit' => 1));
                    $color = $_POST['color'];

                    $atributes = array('name' => $name, 'description' => $description, 'order' => $order[0]->order+1, 'duration' => $duration, 'color' => $color);

                    $status = LeadStatus::create($atributes);

                    if (!isset($_POST["user_id"])) {
                        $_POST["user_id"] = array();
                    }

                    foreach ($_POST["user_id"] as $value) {
                        $atributes = array('lead_status_id' => $status->id, 'user_id' => $value);

                        LeadStatusHasReceiver::create($atributes);
                    }

                    if (!$status) {
                        $this->session->set_flashdata('message', 'error:'.$this->lang->line('messages_create_status_error'));
                    } else {
                        $this->session->set_flashdata('message', 'success:'.$this->lang->line('messages_create_status_success'));
                    }
                    redirect('leads');
                } else {
                    $this->theme_view = 'modal';
                    $this->view_data['title'] = $this->lang->line('application_create_status');
                    $this->view_data['users'] = User::find('all', array('conditions' => array('status=?','active')));
                    //$this->view_data['status'] = LeadStatus::all();
                    $this->view_data['form_action'] = 'leads/status/create';
                    $this->content_view = 'leads/_status';
                }
            break;

            case 'edit':
                if ($_POST) {
                    unset($_POST['send']);
                    unset($_POST['files']);
                    $description = $_POST['description'];
                    $status = LeadStatus::find_by_id($_POST['id']);
                    $status_id = addslashes($_POST['id']);
                    $status->name = $_POST['name'];
                    $status->duration = $_POST['duration'];
                    $status->description = $description;
                    $status->color = $_POST['color'];

                    if (!isset($_POST["user_id"])) {
                        $_POST["user_id"] = array();
                    }

                    $query = array();

                    foreach ($status->lead_status_has_receivers as $receiver) {
                        array_push($query, $receiver->user_id);
                    }

                    $added = array_diff($_POST["user_id"], $query);
                    $removed = array_diff($query, $_POST["user_id"]);

                    foreach ($added as $value) {
                        $atributes = array('lead_status_id' => $status_id, 'user_id' => $value);

                        LeadStatusHasReceiver::create($atributes);
                    }

                    foreach ($removed as $value) {
                        $atributes = array('lead_status_id' => $status_id, 'user_id' => $value);
                        $worker = LeadStatusHasReceiver::find($atributes);
                        $worker->delete();
                    }

                    $status->save();
                    if (!$status) {
                        $this->session->set_flashdata('message', 'error:'.$this->lang->line('messages_edit_status_error'));
                    } else {
                        $this->session->set_flashdata('message', 'success:'.$this->lang->line('messages_edit_status_success'));
                    }
                    redirect('leads');
                } else {
                    $this->theme_view = 'modal';
                    $lead_status = LeadStatus::find_by_id($id);
                    $this->view_data['users'] = User::find('all', array('conditions' => array('status=?','active')));
                    $this->view_data['title'] = $this->lang->line('application_create_status');
                    $this->view_data['status'] = $lead_status;
                    $this->view_data['form_action'] = 'leads/status/edit';
                    $this->content_view = 'leads/_status';
                }
            break;

            case 'move':
                    $status = LeadStatus::find_by_id($id);
                    $find = ($attr == "left") ? "`order` < ? order by `order` DESC LIMIT 1" : "`order` > ? order by `order` ASC LIMIT 1";
                    $statusNewPos = LeadStatus::find('all', array('conditions' => array($find, array($status->order))));
                    $order = $status->order;
                    $status->order = $statusNewPos[0]->order;
                    $status->save();
                    $other = LeadStatus::find_by_id($statusNewPos[0]->id);
                    $other->order = $order;
                    $other->save();
                    json_response("success", "Status has been moved!", '');
            break;

            case 'delete':
                    $status = LeadStatus::find_by_id($id);
                    $leads = Lead::find('all', ['conditions' => ['status_id', [$status->id]]]);
                    foreach ($leads as $lead) {
                        $leads_ids[] = $lead->id;
                    }
//                    $leads_delete = Lead::table()->delete(array('status_id' => array($status->id)));
                    $reminders = Reminder::table()->delete(['source_id' => $leads_ids, 'module' => 'lead']);
                    $receivers_delete = LeadStatusHasReceiver::table()->delete(array('lead_status_id' => array($status->id)));

                    $status->delete();
                    json_response("success", "Status has been deleted!", '');
            break;
            
            default:
               
            break;
        }
    }
    public function attachment($lead)
    {
        $this->load->helper('download');
        $this->load->helper('file');

        $comment = LeadHasComment::find_by_id($lead);
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

    public function import()
    {
        if ($_POST) {
            unset($_POST['send']);
            unset($_POST['files']);
            $_POST['private'] = (isset($_POST['private'])) ? 1 : 0;
            $config['upload_path'] = './files/media/';
            $config['encrypt_name'] = true;
            $config['allowed_types'] = '*';

            $this->load->library('upload', $config);

            if (! $this->upload->do_upload()) {
                $error = $this->upload->display_errors('', ' ');
                $this->session->set_flashdata('message', 'error:'.$error);
                redirect('leads/');
            } else {
                $data = array('upload_data' => $this->upload->data());

                $_POST['filename'] = $data['upload_data']['orig_name'];
                $savename = $data['upload_data']['file_name'];

                $this->load->library('CSVReader');
                $result = $this->csvreader->parse_file($config['upload_path'].$savename);
                $this->view_data['leads'] = $result;
                $this->view_data['columns'] = array_keys($result[1]);
                $this->view_data['db_fields'] = Lead::Connection()->columns("leads");
                $this->view_data['select_options'] = '<option value=""></option>';
                $this->view_data['except_fields'] = array('id', 'status_id', 'source', 'tags', 'created', 'modified', 'private', 'user_id', 'icon', 'order');
                $this->view_data['required_fields'] = array('name');
                
                $this->view_data['csv_file'] = $savename;
                $this->view_data['status_id'] = $_POST['status_id'];
                $this->view_data['source'] = $_POST['source'];
                $this->view_data['private'] = $_POST['private'];
                $this->view_data['user_id'] = $this->user->id;



                foreach ($this->view_data['columns'] as $key => $column) {
                    $this->view_data['select_options'] .= '<option value="'.$key.'">'.htmlspecialchars($column).'</option>';
                }
                
                $this->view_data["form_action"] = 'leads/importdata';
                $this->content_view = 'leads/import';
            }
        } else {
            $this->theme_view = 'modal';
            $this->view_data['title'] = $this->lang->line('application_create_lead');
            $this->view_data['status'] = LeadStatus::all();
            $this->view_data['form_action'] = 'leads/import';
            $this->content_view = 'leads/_import';
        }
    }

    public function importdata()
    {
        if ($_POST) {
            unset($_POST['send']);
            unset($_POST['files']);
            $csv_file = $_POST['csv_file'];
            $status_id = $_POST['status_id'];
            $private = $_POST['private'];
            $source = $_POST['source'];
            $user_id = $_POST['user_id'];
            unset($_POST['csv_file']);
            unset($_POST['status_id']);
            unset($_POST['private']);
            unset($_POST['source']);
            unset($_POST['user_id']);

            $this->load->library('CSVReader');
            $result = $this->csvreader->parse_file("./files/media/".$csv_file);

            $inserts = "";
            $order = 100;
            function addSlash($n)
            {
                return "`".$n."`";
            }
            foreach ($result as $key => $value) {
                $order = $order+10;
                $column_values = array();
                
                $columns = array_map("addSlash", array_keys($_POST));
                array_push($columns, "`status_id`");
                array_push($columns, "`private`");
                array_push($columns, "`source`");
                array_push($columns, "`user_id`");
                array_push($columns, "`order`");
                $columns = implode(',', $columns);

                $row = array_values($value);
                foreach ($_POST as $key => $value) {
                    array_push($column_values, '"'.$row[$value].'"');
                }
                array_push($column_values, '"'.$status_id.'"');
                array_push($column_values, '"'.$private.'"');
                array_push($column_values, '"'.$source.'"');
                array_push($column_values, '"'.$user_id.'"');
                array_push($column_values, '"'.$order.'"');

                $column_values = implode(",", $column_values);
                $inserts .= "INSERT INTO `leads` ($columns) VALUES ($column_values);";
            }
            if (Lead::Connection()->query($inserts)) {
                $this->session->set_flashdata('message', 'success:'.$this->lang->line('messages_leads_have_been_imported'));
            } else {
                $this->session->set_flashdata('message', 'error:'.$this->lang->line('messages_leads_have_not_been_imported'));
            }
            unlink("./files/media/".$csv_file);
            redirect("/leads");
        }
    }

    public function lost(){

        $options = ['conditions' => ['status_id = ? ORDER BY ID DESC', '0']];
        $lost_leads = Lead::all($options);
        $this->view_data['leads'] = $lost_leads;
        $this->content_view = 'leads/lost';
    }


    public function tags(){

        $all_tags = Tag::all();
        $this->view_data['tags'] = $all_tags;
        $this->content_view = 'leads/tags';
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
                    redirect('leads/tags');
                } else {
                    $this->theme_view = 'modal';
                    $this->view_data['title'] = $this->lang->line('application_create_tag');
                    $this->view_data['form_action'] = 'leads/edittag/create';
                    $this->content_view = 'leads/_tag';
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
                    redirect('leads/tags');
                } else {
                    $this->theme_view = 'modal';
                    $editing_tag = Tag::find_by_id($id);
                    $this->view_data['tag'] = $editing_tag;
                    $this->view_data['title'] = $this->lang->line('application_edit_tag');
                    $this->view_data['form_action'] = 'leads/edittag/edit';
                    $this->content_view = 'leads/_tag';
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

    public function notifycomercial($lead_id){

        $comercialTeam = DepartmentHasWorker::find('all', array('conditions' => array('department_id = ?', 2)));

        $lead = Lead::find_by_id($lead_id);

        $push_receivers = array();

        //push será enviado para todos colaboradores que tem funções no Departamento Comercial id = 2
        foreach ($comercialTeam as $worker){
            $user = User::find($worker->user_id);

            if ($user->push_active == 1) {
                array_push($push_receivers, $user->email);
            }

            $notificationAttributes = array('user_id' => $user->id, 'message' => '<b>[Atenção ao Lead]</b> - '.$this->user->firstname.' chamou sua atenção para o Lead '.$lead->name, 'url' => base_url().'leads/');
            Notification::create($notificationAttributes);
        }

        Notification::sendPushNotification($push_receivers, '[Atenção ao Lead] - '.$this->user->firstname.' chamou sua atenção para o Lead '.$lead->name, base_url().'leads/');
    }

}
