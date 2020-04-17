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
                }
            }
        }

        return $steps;
    }

    public static function actionsForUserInStep($id = false, $email = false, $desired_step = false){

        $actions = array();

        $bpm_flow = BpmFlow::find($id);
        $flow = json_decode($bpm_flow->flow);

        foreach ($flow->steps as $idx => $step){
            if ($step->id == $desired_step){
                foreach ($step->members as $member){
                    if ($member->email == $email){
                        $actions = $step->actions;
                    }
                }

            }
        }

        return $actions;
    }

}
