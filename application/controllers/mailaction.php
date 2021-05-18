<?php

class MailAction extends MY_Controller {

    public function updatepurchaseorder($username, $purchase_order_id, $action_id, $step) {

        $this->theme_view = 'blank';

        $updating_purchase_order = PurchaseOrder::find($purchase_order_id);
        $flow = json_decode($updating_purchase_order->flow);

        if ($updating_purchase_order->canceled == true || $updating_purchase_order->finished == true || $updating_purchase_order->step > $step){

            if ($updating_purchase_order->canceled == true){
                echo "Esta Ordem de Compra está com status de cancelada";
                exit;
            }else if ($updating_purchase_order->finished == true){
                echo "Esta Ordem de Compra está com status de finalizada";
                exit;
            }else if($updating_purchase_order->step > $step){
                echo "Esta Ordem de Compra já teve esta etapa completada previamente";
                exit;
            }

        }

        $user = User::getUserByUsername($username);
        $is_progress = $action_id;

        $history_registry = new stdClass;

        if ($is_progress == false) {

            foreach ($flow->steps as $step) {
                if ($step->canceled == true) {
                    $canceled_step = $step;
                }
            }

            $_POST['step'] = $canceled_step->id;
            $_POST['canceled'] = 1;

            $current_step = PurchaseOrder::currentStepForPurchaseOrder($purchase_order_id);

//criação de registro de histórico
            PurchaseOrder::createHistoryForPurchaseStepAndUser($purchase_order_id, $current_step, $user->id, $history_registry, $is_progress);

            if ($_POST['canceled'] == 1) {
// passo final precisa criar registro de histórico quando o penúltimo passo estiver sendo registrado
                PurchaseOrder::createHistoryForPurchaseStepAndUser($purchase_order_id, $canceled_step, $user->id, $is_progress);
            }

        } else {

            $current_step = PurchaseOrder::currentStepForPurchaseOrder($purchase_order_id);

            $next_step = PurchaseOrder::nextStepForPurchaseOrderAfterCurrentStep($purchase_order_id, $current_step->id);
            $_POST['step'] = $next_step->id;

//criação de registro de histórico
            PurchaseOrder::createHistoryForPurchaseStepAndUser($purchase_order_id, $current_step, $user->id, $history_registry, $is_progress);

            if ($next_step->finish == true) {
// passo final precisa criar registro de histórico quando o penúltimo passo estiver sendo registrado
                PurchaseOrder::createHistoryForPurchaseStepAndUser($purchase_order_id, $next_step, $user->id, $is_progress);
                $_POST['finished'] = 1;
            }
        }

        $updating_purchase_order->update_attributes($_POST);

        $push_receivers = array();
        if (!$updating_purchase_order) {
            $this->session->set_flashdata('message', 'error:' . $this->lang->line('messages_edit_error'));
        } else {

            if ($is_progress == true) {
                $this->load->helper('notification');

                foreach ($next_step->members as $member) {
                    if ($member->email == "creator_email") {
                        $user = User::find($updating_purchase_order->user_id);
                    } else {
                        $user = User::getUserByEmail($member->email);
                    }

                    if ($user->push_active) {
                        array_push($push_receivers, $member->email);
                    }

                    $attributes = array('user_id' => $user->id, 'message' => "[Ordem de compra $updating_purchase_order->id] Uma atualização foi feita na Ordem de Compra", 'url' => base_url() . 'purchaseorders');
                    Notification::create($attributes);

                    $document = PurchaseOrder::purchasebody($updating_purchase_order->id);
                    $history = PurchaseOrder::purchasehistory($updating_purchase_order->id);

                    $actions = array();
                    foreach ($next_step->actions as $action) {
                        $action->title = $action->name;
                        $action->href = base_url() . 'mailaction/updatepurchaseorder/' . str_replace('@ownergy.com.br', '', $member->email) . '/' . $updating_purchase_order->id . '/' . intval(boolval($action->progress)).'/'.$next_step->id;
                        array_push($actions, $action);
                    }

                    send_bpm_notification($member->email,
                        "[Ordem de compra $updating_purchase_order->id]",
                        sprintf($this->lang->line('application_notification_purchase_order_updated_mail'), base_url().'purchaseorders'),
                        null,
                        base_url() . 'purchaseorders',
                        $actions,
                        $document,
                        $history);
                }

                Notification::sendPushNotification($push_receivers, "[Ordem de compra $updating_purchase_order->id] Uma atualização foi feita na Ordem de Compra", base_url() . 'purchaseorders');

            } else {
//Purchase Order is backing to the creator
                array_push($push_receivers, $this->user->email);

                $attributes = array('user_id' => $updating_purchase_order->user_id, 'message' => "[Ordem de compra $updating_purchase_order->id] Ordem de compra cancelada, verifique o histórico", 'url' => base_url() . 'purchaseorders');
                Notification::create($attributes);

                Notification::sendPushNotification($push_receivers, "[Ordem de compra $updating_purchase_order->id] Ordem de Compra cancelada, verifique o histórico", base_url() . 'purchaseorders');
            }

            echo "Ordem de compra atualizada com sucesso";
            exit;

        }
    }

    public function updateserviceorder($username, $service_order_id, $action_id, $step) {

        $this->theme_view = 'blank';

        $updating_service_order = ServiceOrder::find($service_order_id);
        $flow = json_decode($updating_service_order->flow);

        if ($updating_service_order->canceled == true || $updating_service_order->finished == true || $updating_service_order->step > $step){

            if ($updating_service_order->canceled == true){
                echo "Esta Ordem de Serviço está com status de cancelada";
                exit;
            }else if ($updating_service_order->finished == true){
                echo "Esta Ordem de Serviço está com status de finalizada";
                exit;
            }else if($updating_service_order->step > $step){
                echo "Esta Ordem de Serviço já teve esta etapa completada previamente";
                exit;
            }

        }

        $user = User::getUserByUsername($username);
        $is_progress = $action_id;

        $history_registry = new stdClass;

        if ($is_progress == false) {

            foreach ($flow->steps as $step) {
                if ($step->canceled == true) {
                    $canceled_step = $step;
                }
            }

            $_POST['step'] = $canceled_step->id;
            $_POST['canceled'] = 1;

            $current_step = ServiceOrder::currentStepForServiceOrder($service_order_id);

//criação de registro de histórico
            ServiceOrder::createHistoryForServiceStepAndUser($service_order_id, $current_step, $user->id, $history_registry, $is_progress);

            if ($_POST['canceled'] == 1) {
// passo final precisa criar registro de histórico quando o penúltimo passo estiver sendo registrado
                ServiceOrder::createHistoryForServiceStepAndUser($service_order_id, $canceled_step, $user->id, $is_progress);
            }

        } else {

            $current_step = ServiceOrder::currentStepForServiceOrder($service_order_id);

            $next_step = ServiceOrder::nextStepForServiceOrderAfterCurrentStep($service_order_id, $current_step->id);
            $_POST['step'] = $next_step->id;

//criação de registro de histórico
            ServiceOrder::createHistoryForServiceStepAndUser($service_order_id, $current_step, $user->id, $history_registry, $is_progress);

            if ($next_step->finish == true) {
// passo final precisa criar registro de histórico quando o penúltimo passo estiver sendo registrado
                ServiceOrder::createHistoryForServiceStepAndUser($service_order_id, $next_step, $user->id, $is_progress);
                $_POST['finished'] = 1;
            }
        }

        $updating_service_order->update_attributes($_POST);

        $push_receivers = array();
        if (!$updating_service_order) {
            $this->session->set_flashdata('message', 'error:' . $this->lang->line('messages_edit_error'));
        } else {

            if ($is_progress == true) {
                $this->load->helper('notification');

                foreach ($next_step->members as $member) {
                    if ($member->email == "creator_email") {
                        $user = User::find($updating_service_order->user_id);
                    } else {
                        $user = User::getUserByEmail($member->email);
                    }

                    if ($user->push_active) {
                        array_push($push_receivers, $member->email);
                    }

                    $attributes = array('user_id' => $user->id, 'message' => "[Ordem de serviço $updating_service_order->id] Uma atualização foi feita na Ordem de Serviço", 'url' => base_url() . 'serviceorders');
                    Notification::create($attributes);

                    $document = ServiceOrder::servicebody($updating_service_order->id);
                    $history = ServiceOrder::servicehistory($updating_service_order->id);

                    $actions = array();
                    foreach ($next_step->actions as $action) {
                        $action->title = $action->name;
                        $action->href = base_url() . 'mailaction/updateserviceorder/' . str_replace('@ownergy.com.br', '', $member->email) . '/' . $updating_service_order->id . '/' . intval(boolval($action->progress)).'/'.$next_step->id;
                        array_push($actions, $action);
                    }

                    send_bpm_notification($member->email,
                        "[Ordem de serviço $updating_service_order->id]",
                        sprintf($this->lang->line('application_notification_service_order_updated_mail'), base_url().'serviceorders'),
                        null,
                        base_url() . 'serviceorders',
                        $actions,
                        $document,
                        $history);
                }

                Notification::sendPushNotification($push_receivers, "[Ordem de serviço $updating_service_order->id] Uma atualização foi feita na Ordem de Serviço", base_url() . 'serviceorders');

            } else {
//Service Order is backing to the creator
                array_push($push_receivers, $this->user->email);

                $attributes = array('user_id' => $updating_service_order->user_id, 'message' => "[Ordem de serviço $updating_service_order->id] Ordem de serviço cancelada, verifique o histórico", 'url' => base_url() . 'serviceorders');
                Notification::create($attributes);

                Notification::sendPushNotification($push_receivers, "[Ordem de serviço $updating_service_order->id] Ordem de Serviço cancelada, verifique o histórico", base_url() . 'serviceorders');
            }

            echo "Ordem de serviço atualizada com sucesso";
            exit;

        }
    }

    public function updatetravelorder($username, $travel_order_id, $action_id, $step) {

        $this->theme_view = 'blank';

        $updating_travel_order = TravelOrder::find($travel_order_id);
        $flow = json_decode($updating_travel_order->flow);

        if ($updating_travel_order->canceled == true || $updating_travel_order->finished == true || $updating_travel_order->step > $step){

            if ($updating_travel_order->canceled == true){
                echo "Esta Ordem de Viagem está com status de cancelada";
                exit;
            }else if ($updating_travel_order->finished == true){
                echo "Esta Ordem de Viagem está com status de finalizada";
                exit;
            }else if($updating_travel_order->step > $step){
                echo "Esta Ordem de Viagem já teve esta etapa completada previamente";
                exit;
            }

        }

        $user = User::getUserByUsername($username);
        $is_progress = $action_id;

        $history_registry = new stdClass;

        if ($is_progress == false) {

            foreach ($flow->steps as $step) {
                if ($step->canceled == true) {
                    $canceled_step = $step;
                }
            }

            $_POST['step'] = $canceled_step->id;
            $_POST['canceled'] = 1;

            $current_step = TravelOrder::currentStepForTravelOrder($travel_order_id);

//criação de registro de histórico
            TravelOrder::createHistoryForTravelStepAndUser($travel_order_id, $current_step, $user->id, $history_registry, $is_progress);

            if ($_POST['canceled'] == 1) {
// passo final precisa criar registro de histórico quando o penúltimo passo estiver sendo registrado
                TravelOrder::createHistoryForTravelStepAndUser($travel_order_id, $canceled_step, $user->id, $is_progress);
            }

        } else {

            $current_step = TravelOrder::currentStepForTravelOrder($travel_order_id);

            $next_step = TravelOrder::nextStepForTravelOrderAfterCurrentStep($travel_order_id, $current_step->id);
            $_POST['step'] = $next_step->id;

//criação de registro de histórico
            TravelOrder::createHistoryForTravelStepAndUser($travel_order_id, $current_step, $user->id, $history_registry, $is_progress);

            if ($next_step->finish == true) {
// passo final precisa criar registro de histórico quando o penúltimo passo estiver sendo registrado
                TravelOrder::createHistoryForTravelStepAndUser($travel_order_id, $next_step, $user->id, $is_progress);
                $_POST['finished'] = 1;
            }
        }

        $updating_travel_order->update_attributes($_POST);

        $push_receivers = array();
        if (!$updating_travel_order) {
            $this->session->set_flashdata('message', 'error:' . $this->lang->line('messages_edit_error'));
        } else {

            if ($is_progress == true) {
                $this->load->helper('notification');

                foreach ($next_step->members as $member) {
                    if ($member->email == "creator_email") {
                        $user = User::find($updating_travel_order->user_id);
                    } else {
                        $user = User::getUserByEmail($member->email);
                    }

                    if ($user->push_active) {
                        array_push($push_receivers, $member->email);
                    }

                    $attributes = array('user_id' => $user->id, 'message' => "[Ordem de viagem $updating_travel_order->id] Uma atualização foi feita na Ordem de Viagem", 'url' => base_url() . 'travelorders');
                    Notification::create($attributes);

                    $document = TravelOrder::travelbody($updating_travel_order->id);
                    $history = TravelOrder::travelhistory($updating_travel_order->id);

                    $actions = array();
                    foreach ($next_step->actions as $action) {
                        $action->title = $action->name;
                        $action->href = base_url() . 'mailaction/updatetravelorder/' . str_replace('@ownergy.com.br', '', $member->email) . '/' . $updating_travel_order->id . '/' . intval(boolval($action->progress)).'/'.$next_step->id;
                        array_push($actions, $action);
                    }

                    send_bpm_notification($member->email,
                        "[Ordem de viagem $updating_travel_order->id]",
                        sprintf($this->lang->line('application_notification_travel_order_updated_mail'), base_url().'travelorders'),
                        null,
                        base_url() . 'travelorders',
                        $actions,
                        $document,
                        $history);
                }

                Notification::sendPushNotification($push_receivers, "[Ordem de viagem $updating_travel_order->id] Uma atualização foi feita na Ordem de Viagem", base_url() . 'travelorders');

            } else {
//Travel Order is backing to the creator
                array_push($push_receivers, $this->user->email);

                $attributes = array('user_id' => $updating_travel_order->user_id, 'message' => "[Ordem de viagem $updating_travel_order->id] Ordem de viagem cancelada, verifique o histórico", 'url' => base_url() . 'travelorders');
                Notification::create($attributes);

                Notification::sendPushNotification($push_receivers, "[Ordem de viagem $updating_travel_order->id] Ordem de Viagem cancelada, verifique o histórico", base_url() . 'travelorders');
            }

            echo "Ordem de viagem atualizada com sucesso";
            exit;

        }
    }
}