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
        $reminders = Reminder::find('all', ['conditions' => ['done = ? AND email_notification = ? AND sent_at = ? ORDER BY `datetime` ASC', 0, 1, '']]);

        // Stop if expenses count is 0
        $reminders_count = count($reminders);
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
        exit;
    }
}
