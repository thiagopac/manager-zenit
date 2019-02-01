<?php

class Notification extends ActiveRecord\Model {
	static $table_name = 'notifications';
	
	static $belongs_to = array(
     array('user')
  );

    public static function get_notifications($user){
        $options = ['conditions' => ['user_id = ? ORDER BY created_at DESC', $user->id]];
        $notifications = Notification::all($options);

        return $notifications;
    }

}