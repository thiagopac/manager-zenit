<?php

class Notification extends ActiveRecord\Model {
	static $table_name = 'notifications';
	
	static $belongs_to = array(
     array('user')
  );

    public static function get_notifications($user){
        $options = ['conditions' => ['user_id = ? ORDER BY created_at ASC', $user->id]];
        $notifications = Notification::all($options);

        return $notifications;
    }

    function sendPushNotification($email, $message) {
        $content = array(
            "en" => $message
        );

        $fields = array(
            'app_id' => "85f73cb6-8fa9-43fa-9be3-cecd49dbe2f1",
            'filters' => array("field" => "tag", "key" => "email", "relation" => "=", "value" => $email),
            'contents' => $content
        );

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json; charset=utf-8',
            'Authorization: Basic ZDVhMmUyZTItYjMyOC00NzdmLTlkMWItY2JmMDZiNjJiZTAx'
        ));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);

        $response = curl_exec($ch);
        curl_close($ch);

        return $response;
    }

    function addDeviceForPushNotification($user){

        $fields = array(
            'app_id' => "85f73cb6-8fa9-43fa-9be3-cecd49dbe2f1",
            'language' => "en",
            'device_type' => "5",
            'tags' => array("email" => $user->email, "zenit_id" => $user->id, "username" => $user->username)
        );

        $fields = json_encode($fields);
//        print("\nJSON sent:\n");
//        print($fields);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/players");
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);

        $response = curl_exec($ch);
        curl_close($ch);

        $return["allresponses"] = $response;
        $return = json_encode($return);

        return $return;
    }

}