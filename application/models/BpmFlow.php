<?php

class BpmFlow extends ActiveRecord\Model {

    public static $table_name = 'bpm_flow';

    public static $belongs_to = array(
        array('module', 'foreign_key' => 'module_id'),
    );

    public static $has_many = array(
    );

    public static function isViewer($id = false, $email = false){

        $is_viewer = false;

        $bpm_flow = BpmFlow::find($id);
        $flow = json_decode($bpm_flow->flow);

        foreach ($flow->viewers as $idx => $viewer){
            if ($viewer->email == $email){
                $is_viewer = true;
            }
        }

        return $is_viewer;
    }

    public static function stepsUserIs($id = false, $email = false){

        $steps = array();

        $bpm_flow = BpmFlow::find($id);
        $flow = json_decode($bpm_flow->flow);

        foreach ($flow->steps as $idx => $step){
            foreach ($step->members as $member){
                if ($member->email == $email){
                    array_push($steps, $idx);
                }else if ($member->name == 'creator_name'){
//                    array_push($steps, $idx);
                    array_push($steps, null);
                }
            }
        }

        return $steps !== null ? $steps : null;
    }

    public static function actionsForUserInStep($object = false, $email = false, $desired_step = false, $creator = false){

        $actions = array();

        $flow = json_decode($object->flow);
        $got_action = false;

        foreach ($flow->steps as $idx => $step){
            if ($step->id == $desired_step){
                foreach ($step->members as $member){
                    if ($member->email == $email && $got_action == false){
                        $actions = $step->actions;
                        $got_action = true;
                    }else if($member->email == 'creator_email' && $got_action == false){

                        if ($creator->email == $email){
                            $actions = $step->actions;
                        }else{
                            $actions = null;
                        }

                        $got_action = true;
                    }
                }

            }
        }

        return $actions;
    }

}
