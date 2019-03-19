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

    function sendPushNotification($emails, $message, $url) {


        $settings = Setting::first();

        if ($settings->push_active == 0){ return; }

        $content = array(
            "en" => $message
        );

        $fields = array(
            'app_id' => "$settings->push_app_id",
            'include_external_user_ids' => $emails,
            'contents' => $content,
            'web_url' => $url
        );

        $fields = json_encode($fields);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json; charset=utf-8',
            'Authorization: Basic '.$settings->push_rest_api_key.''
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

}