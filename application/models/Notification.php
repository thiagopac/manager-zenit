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

    function sendPushNotification() {
        $content      = array(
            "en" => 'English Message'
        );

        $fields = array(
            'app_id' => "85f73cb6-8fa9-43fa-9be3-cecd49dbe2f1",
            'included_segments' => array(
                'All'
            ),
            'data' => array(
                "foo" => "bar"
            ),
            'contents' => $content
        );

        $fields = json_encode($fields);
        print("\nJSON sent:\n");
        print($fields);

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

//    $response = sendPushNotification();
//    $return["allresponses"] = $response;
//    $return = json_encode($return);
//
//    $data = json_decode($response, true);
//    print_r($data);
//    $id = $data['id'];
//    print_r($id);
//
//    print("\n\nJSON received:\n");
//    print($return);
//    print("\n");

}