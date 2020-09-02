<?php

class ServiceOrder extends ActiveRecord\Model{
    static $table_name = 'service_order';

    public static $belongs_to = array(
        array('user', 'foreign_key' => 'user_id'),
    );

    public static function progressStepsIdsForServiceOrder($service_order_id){

        $service_order = ServiceOrder::find($service_order_id);

        $flow = json_decode($service_order->flow);

        foreach ($flow->conditions as $condition) {

            $property_name = $condition->property;
            $property_value = $service_order->$property_name;
            $operator = $condition->operator;
            $target = $condition->target;

//            var_dump($property_value);
//            var_dump($operator);
//            $target = floatval($target);
//            var_dump($target);

//            var_dump($condition->operator);
//            var_dump($condition->progress_order);

//            var_dump($flow->conditions);

            $comparisons_made = array();

            switch ($operator) {
                case "<":
                    if ($property_value < $target && !in_array("<", $comparisons_made)){
                        array_push($comparisons_made, "<");
//                        var_dump($condition->progress_order);
                        return $condition->progress_order;
                    }
                    break;
                case "<=":
                    if ($property_value <= $target && !in_array("<=", $comparisons_made)){
//                        var_dump($condition->progress_order);
                        return $condition->progress_order;
                    }
                    break;
                case ">":
                    if ($property_value > $target && !in_array(">", $comparisons_made)){
                        array_push($comparisons_made, ">");
//                        var_dump($condition->progress_order);
                        return $condition->progress_order;
                    }
                    break;
                case ">=":
                    if ($property_value >= $target && !in_array(">=", $comparisons_made)){
                        array_push($comparisons_made, ">=");
                        return $condition->progress_order;
                    }
                    break;
                case "!=":
                    if ($property_value != $target && !in_array("!=", $comparisons_made)){
                        array_push($comparisons_made, "!=");
                        return $condition->progress_order;
                    }
                    break;
                case "==":
                    if ($property_value == $target && !in_array("==", $comparisons_made)){
                        array_push($comparisons_made, "==");
                        return $condition->progress_order;
                    }
                    break;
            }

        }

    }

    public static function progressStepsForServiceOrder($service_order_id){

        $service_order = ServiceOrder::find($service_order_id);
        $flow = json_decode($service_order->flow);
        $current_history = json_decode($service_order->history);

        $progress_step_ids = ServiceOrder::progressStepsIdsForServiceOrder($service_order_id);

//        var_dump($progress_step_ids);

        $steps = array();
        $timeline = array();

        foreach ($progress_step_ids as $step_id){

            foreach ($flow->steps as $step){

                if ($step_id == $step->id){
                    array_push($steps, $step);
                }

            }
        }


        foreach ($steps as $flow_step) {
            foreach ($current_history->steps as $history_step) {

                if ($flow_step->id == $history_step->id){
                    $flow_step->completed = true;
                }
            }

            array_push($timeline, $flow_step);
        }

//        var_dump($steps);
//        exit;

        return $steps;

    }

    public static function getServiceOrderStepWithId($service_id = false, $step_id){

        $service_order = ServiceOrder::find($service_id);
        $flow = json_decode($service_order->flow);
        $desired_step = false;

        foreach ($flow->steps as $step){
            if ($step_id == $step->id){
                $desired_step = $step;
                return $desired_step;
            }
        }

        return $desired_step;
    }

    public static function currentStepForServiceOrder($service_order_id){

        $service_order = ServiceOrder::find($service_order_id);
        $flow = json_decode($service_order->flow);
        $current = false;

        foreach ($flow->steps as $step){
            if ($service_order->step == $step->id){
                $current = $step;
                return $current;
            }
        }

        return $current;
    }

    public static function nextStepForServiceOrderAfterCurrentStep($service_order_id, $current_step_id){

        $service_order = ServiceOrder::find($service_order_id);
        $flow = json_decode($service_order->flow);
        $next_step_id = null;
        $next_step = null;
        $next = false;

        $progress_step_ids = ServiceOrder::progressStepsIdsForServiceOrder($service_order_id);

        foreach ($progress_step_ids as $step_id){

            if ($next == true){
                $next_step_id = $step_id;
                foreach ($flow->steps as $step){
                    if ($next_step_id == $step->id){
                        $next_step = $step;
                        return $next_step;
                    }
                }
            }

            if ($step_id == $current_step_id){
                $next = true;
            }
        }

        return null;
    }

    public static function createHistoryForServiceStepAndUser($service_id = false, $step = false, $user_id, $reply = false, $is_progress = false){

        $service_order = ServiceOrder::find($service_id);

        $empty_history = new stdClass();
        $empty_history->steps = array();

        $current_history = json_decode($service_order->history) != null ? json_decode($service_order->history) : $empty_history;


        $new_object = new stdClass();
        $new_object->id = $step->id;
        $new_object->name = $step->name;
        $new_object->user_id = $user_id;
        $new_object->completed = true;
        $new_object->date = date('Y-m-d H:i:s');

        if ($reply){
            $new_object->history_files = $reply->history_files;
            $new_object->history_data = $reply->history_data;
        }

        foreach ($step->actions as $action){
            if ($action->progress == $is_progress){
                $new_object->message = $action->message;
            }
        }

        array_push($current_history->steps, $new_object);

        $current_history = json_encode($current_history);
        $service_order->history = $current_history;

        $service_order->save();
    }

    public static function getHistoryForService($service_id){
        $service_order = ServiceOrder::find($service_id);
        $current_history = json_decode($service_order->history);

        return $current_history;
    }

    public static function servicehistory($service_order_id){

        $core_settings = Setting::first();
        $service_order = ServiceOrder::find($service_order_id);
        $history = json_decode($service_order->history);

        $content = '<div style="text-align:center !important; color: #b6b6b6; font-size: 18px">Histórico da Ordem de Serviço</div>';
        $content.= '<div style="text-align: left !important; font-size:14px !important;">';
        foreach ($history->steps as $reg){
            $content.= '<p>';
            $content.= '<span style="font-weight: 700; color: #555;">'.$reg->name.':</span> <span style="font-weight: 300; color: #555;">'.$reg->message.'</span><br />';
            $content.= '<small><span style="color: #555;"> Feito por: '.'<span style="font-weight: 700; color: #555">'.User::find($reg->user_id)->firstname.' '.User::find($reg->user_id)->lastname.'</span></span>';
            $content.= ' em <b><span style="color: #555">'.date($core_settings->date_format."</span></b> à\s <b><\s\p\a\\n \s\\t\y\l\\e='\c\o\l\o\\r:#555'>".$core_settings->date_time_format, human_to_unix($reg->date)).'</span></b></small><br />';
            if ($reg->history_data != null){
                foreach ($reg->history_data as $history_reg){
                    if ($history_reg->className == "form-control mask-money"){
                        $history_reg->value = $core_settings->money_symbol.''.display_money($history_reg->value);
                    }else if ($history_reg->className == "form-control mask-date"){
                        $history_reg->value = date($core_settings->date_format, human_to_unix($history_reg->value.' 00:00'));
                    }
                    $content .= '<small><b><span style="color: #555;">'.$history_reg->label.': </span></b><span style="color: #555;">'.$history_reg->value.'</span></small><br />';
                }
            }
            if ($reg->history_files != null){
                $content.='<small><b><span style="color: #555;">Anexos: </span></b></small>';
                foreach ($reg->history_files as $idx=>$file){
                    $index = $idx+1;
                    $content.='<small><span style="color: #555;"><a href="'.base_url().'files/serviceorders/'.$file.'" target="_blank">Anexo '.$index.'</a></span></small>';
                    $content.= '<span style="color: #555;"><small> (.'.explode('.', $file)[1].') </small></span>';
                }
            }
            $content.= '</p>';
        }

        $content.= '</div>';

        return $content;
    }

    public static function servicebody($service_order_id = false){

        $core_settings = Setting::first();
        $service_order = ServiceOrder::find($service_order_id);
        $flow = json_decode($service_order->flow);
        $form = $flow->steps[0]->form;
        $response = json_decode($service_order->response);

        $content = '<div style="text-align:center !important; color: #b6b6b6; font-size: 18px">Dados da Ordem de Serviço</div>';
        $content.= '<br />';
        $content.= '<table border="1" cellpadding="6" style="border: 1px #ddd;border-collapse: collapse;">';
        $content.= '<thead style="background:#ececec">
                        <th style="width: 30%; color: #555;">Campo</th>
                        <th style="color: #555">Preenchimento</th>
                    </thead>';


        foreach ($form as $field){
            $fieldname = $field->name;
            $content.= '<tr style="text-align:left !important;">';

            if ($response->$fieldname != null){
                if (!is_array($response->$fieldname)){
                    $content.= '<td style="color: #555"><strong>'.htmlspecialchars_decode(stripslashes(($field->label))).'</strong></td>';
                    if ($field->className == 'form-control mask-money'){
                        $content.= '<td style="color: #555">';
                        $content.= $core_settings->money_symbol.' '.display_money($response->$fieldname);
                        $content.= '</td>';

                    }
                    else if ($field->className == 'form-control mask-date'){
                        $content.= '<td style="color: #555">';
                        $content.= date($core_settings->date_format, human_to_unix($response->$fieldname.' 00:00'));
                        $content.= '</td>';
                    }else{
                        $content.= '<td style="color: #555">';
                        $content.= $response->$fieldname;
                        $content.= '</td>';
                    }
                }else{
                    $content.='<td style="color: #555"><strong>'.$field->label.'</strong></td>';
                    $content.='<td style="color: #555">';
                        foreach ($response->$fieldname as $idx=>$field){
                            $index = $idx + 1;
                            $content.='<a href="'.base_url().'files/serviceorders/'.$field.'" target="_blank">Anexo '.$index.'</a>';
                            $content.= '<small> (.'.explode('.', $field)[1].') </small>';
                        }

                    $content.='</td>';
                }
            }

            $content.= '</tr>';
        }

        $content.= '</table>';

        return $content;
    }

}
