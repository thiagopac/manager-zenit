<?php

class PurchaseOrder extends ActiveRecord\Model{
    static $table_name = 'purchase_order';

    public static $belongs_to = array(
        array('user', 'foreign_key' => 'user_id'),
    );

    public static function progressStepsIdsForPurchaseOrder($id = false, $purchase_order_id){

        $bpm_flow = BpmFlow::find($id);
        $purchase_order = PurchaseOrder::find($purchase_order_id);
        $flow = json_decode($bpm_flow->flow);

        foreach ($flow->conditions as $condition) {

            $property_name = $condition->property;
            $property_value = $purchase_order->$property_name;
            $operator = $condition->operator;
            $target = $condition->target;

            switch ($operator) {
                case "<":
                    if ($property_value < $target){
                        array_push($comparisons_made, "<");
                        return $condition->progress_order;
                    }
                    break;
                case "<=":
                    if ($property_value <= $target){
                        array_push($comparisons_made, "<=");
                        return $condition->progress_order;
                    }
                    break;
                case ">":
                    if ($property_value > $target){
                        array_push($comparisons_made, ">");
                        return $condition->progress_order;
                    }
                    break;
                case ">=":
                    if ($property_value >= $target){
                        array_push($comparisons_made, ">=");
                        return $condition->progress_order;
                    }
                    break;
                case "!=":
                    if ($property_value != $target){
                        array_push($comparisons_made, "!=");
                        return $condition->progress_order;
                    }
                    break;
                case "==":
                    if ($property_value == $target){
                        array_push($comparisons_made, "==");
                        return $condition->progress_order;
                    }
                    break;
            }

        }

    }

    public static function progressStepsForPurchaseOrder($bpm_flow_id = false, $purchase_order_id){

        $bpm_flow = BpmFlow::find($bpm_flow_id);
        $flow = json_decode($bpm_flow->flow);
        $purchase_order = PurchaseOrder::find($purchase_order_id);
        $current_history = json_decode($purchase_order->history);

        $progress_step_ids = PurchaseOrder::progressStepsIdsForPurchaseOrder($bpm_flow_id, $purchase_order_id);

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

        return $steps;

    }

    public static function getStepWithId($bpm_flow_id = false, $step_id){

        $bpm_flow = BpmFlow::find($bpm_flow_id);
        $flow = json_decode($bpm_flow->flow);
        $desired_step = false;

        foreach ($flow->steps as $step){
            if ($step_id == $step->id){
                $desired_step = $step;
                return $desired_step;
            }
        }

        return $desired_step;
    }

    public static function currentStepForPurchaseOrder($bpm_flow_id = false, $purchase_order_id){

        $bpm_flow = BpmFlow::find($bpm_flow_id);
        $flow = json_decode($bpm_flow->flow);
        $purchase_order = PurchaseOrder::find($purchase_order_id);
        $current = false;

        foreach ($flow->steps as $step){
            if ($purchase_order->step == $step->id){
                $current = $step;
                return $current;
            }
        }

        return $current;
    }

    public static function nextStepForPurchaseOrderAfterCurrentStep($bpm_flow_id = false, $purchase_order_id, $current_step_id){

        $bpm_flow = BpmFlow::find($bpm_flow_id);
        $flow = json_decode($bpm_flow->flow);
        $next_step_id = null;
        $next_step = null;
        $next = false;

        $progress_step_ids = PurchaseOrder::progressStepsIdsForPurchaseOrder($bpm_flow_id, $purchase_order_id);

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

    public static function createHistoryForBpmPurchaseStepAndUser($bpm_flow_id = false, $purchase_id = false, $step = false, $user_id, $reply = false, $is_progress = false){

        $purchase_order = PurchaseOrder::find($purchase_id);

        $empty_history = new stdClass();
        $empty_history->steps = array();

        $current_history = json_decode($purchase_order->history) != null ? json_decode($purchase_order->history) : $empty_history;


        $new_object = new stdClass();
        $new_object->id = $step->id;
        $new_object->name = $step->name;
        $new_object->user_id = $user_id;
        $new_object->completed = true;
        $new_object->date = date('Y-m-d H:i:s');

        if ($reply){
            $new_object->history_text = $reply->history_text;
            $new_object->history_files = $reply->history_files;
        }

        foreach ($step->actions as $action){
            if ($action->progress == $is_progress){
                $new_object->message = $action->message;
            }
        }

        array_push($current_history->steps, $new_object);

        $current_history = json_encode($current_history);
        $purchase_order->history = $current_history;

        $purchase_order->save();
    }

    public static function getHistoryForPurchase($purchase_id){
        $purchase_order = PurchaseOrder::find($purchase_id);
        $current_history = json_decode($purchase_order->history);

        return $current_history;
    }

}
