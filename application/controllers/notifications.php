<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Notifications extends MY_Controller
{
    public function index()
    {
        ini_set('max_execution_time', 300); //5 minutes
        $this->theme_view = 'blank';

        $timestamp = time();
        $core_settings = Setting::first();
        $date = date('Y-m-d');
        $this->load->helper('file');
        $this->load->helper('notification');

        /* Check if cronjob option is enabled */
        if ($core_settings->notifications != '1') {
            log_message('error', '[notifications cronjob] Notifications cronjob link has been called but cronjob option is not enabled in settings.');
            show_error('Notifications cronjob link has been called but cronjob option is not enabled!', 403);
            return false;
        }

        // Log cronjob execution time
        $core_settings->last_notification = time();
        $core_settings->save();

        // Get expenses which require new invoice
        $reminders = Reminder::find('all', ['conditions' => ['done = ? AND email_notification = ? AND sent_at = ? ORDER BY `datetime` ASC', 0, 1, 0]]);
        $reminders_push = Reminder::find('all', ['conditions' => ['done = ? AND push_notification = ? AND push_sent_at = ? ORDER BY `datetime` ASC', 0, 1, 0]]);

        // Stop if expenses count is 0
        $reminders_count = count($reminders);
        $reminders_push_count = count($reminders_push);


        if ($reminders_count > 0) {
            log_message('error', '[notification cronjob] ' . $reminders_count . ' reminders to process...');

            foreach ($reminders as $reminder) {
                $now = new DateTime();
                $reminder_time = new DateTime($reminder->datetime);
                $diff = $now->diff($reminder_time);
                /* Continue if alarm time has not reached yet */
                if ($diff->invert == 0) {
                    continue;
                }
                $class = ucfirst($reminder->module);
                $module = $class::find_by_id($reminder->source_id);
                $user = User::find_by_id($reminder->user_id);

                if (reminder_notification($class, $user, $module, $reminder)) {
                    $reminder = Reminder::find_by_id($reminder->id);
                    $reminder->sent_at = $now;
                    $reminder->save();
                }
            }
        }

        if ($reminders_push_count > 0) {
            log_message('error', '[push notification cronjob] ' . $reminders_push_count . ' push reminders to process...');

            foreach ($reminders_push as $reminder) {

                $push_receivers = array();

                $now = new DateTime();
                $reminder_time = new DateTime($reminder->datetime);
                $diff = $now->diff($reminder_time);
                /* Continue if alarm time has not reached yet */
                if ($diff->invert == 0) {
                    continue;
                }
                $class = ucfirst($reminder->module);
                $module = $class::find_by_id($reminder->source_id);
                $user = User::find_by_id($reminder->user_id);

                if ($user->push_active == 1){
                    array_push($push_receivers, $user->email);

                    Notification::sendPushNotification($push_receivers, '[Lembrete] - '.$reminder->title, base_url());
                }


                $attributes = array('user_id' => $user->id, 'message' => '<b>[Lembrete]</b> - '.$reminder->title, 'url' => base_url());
                Notification::create($attributes);

                $reminder = Reminder::find_by_id($reminder->id);
                $reminder->push_sent_at = $now;
                $reminder->save();
            }

        }
        exit;
    }

    public function read($id = false)
    {
        $options = ['conditions' => ['id = ?', $id]];
        $notification = Notification::find($options);


//        $response = Notification::sendPushNotification(array("thiago.pires@ownergy.com.br"), "Você leu uma notificação");
//        $return["allresponses"] = $response;
//        $return = json_encode($return);
//
//        $data = json_decode($response, true);
//        var_dump($data);
//        $id = $data['id'];
//        var_dump($id);
//
//        var_dump("\n\nJSON received:\n");
//        var_dump($return);
//        var_dump("\n");

        $notification->status = "read";
        $notification->save();

    }

    public function read_all($type){

        if ($type == "user"){
            Notification::update_all([
                'set' => [
                    'status' => 'read'
                ],
                'conditions' => ['user_id = ? AND status = ?', $this->user->id, 'new']
            ]);
        }else{
            ClientNotification::update_all([
                'set' => [
                    'status' => 'read'
                ],
                'conditions' => ['client_id = ? AND status = ?', $this->client->id, 'new']
            ]);
        }



    }
}
