<?php

class User extends ActiveRecord\Model
{
    public static $has_many = [
         ['company_has_admins'],
         ['tickets'],
         ['project_has_workers'],
         ['companies', 'through' => 'company_has_admins'],
         ['projects', 'through' => 'project_has_workers'],
         ['project_has_tasks'],
         ['project_has_timesheets'],
         ['quotes'],
         ['quoterequests'],
    ];
    public static $belongs_to = [
     ['queue', 'primary_key' => 'queue'],
    ];

    public function get_userpic()
    {
        return get_user_pic($this->read_attribute('userpic'), $this->read_attribute('email'));
    }

    public $password = false;

    public function before_save()
    {
        if ($this->password) {
            $this->hashed_password = $this->hash_password($this->password);
        }
    }

    public function has_permission_to($module_name, $user)
    {
        $module = Module::find_by_link($module_name);
        $access = explode(',', $user->access);
        return in_array($module->id, $access);
    }

    public function getSalt()
    {
        $charset = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789/\\][{}\'";:?.>,<!@#$%^&*()-_=+|';
        $randStringLen = 32;

        $randString = '';
        for ($i = 0; $i < $randStringLen; $i++) {
            $randString .= $charset[mt_rand(0, strlen($charset) - 1)];
        }

        return $randString;
    }

    public function set_password($plaintext)
    {
        $this->hashed_password = $this->hash_password($plaintext);
    }

    private function hash_password($password)
    {
        $salt = bin2hex($this->getSalt());
        $hash = hash('sha256', $salt . $password);

        return $salt . $hash;
    }

    private function validate_password($password)
    {
        $salt = substr($this->hashed_password, 0, 64);
        $hash = substr($this->hashed_password, 64, 64);

        $password_hash = hash('sha256', $salt . $password);

        return $password_hash == $hash;
    }

    public static function validate_login($username, $password)
    {
        $user = User::find_by_username_and_status($username, 'active');
        $client = Client::find_by_email_and_inactive($username, 0);

        if ($user && $user->validate_password($password) && $user->status == 'active') {
            User::login($user->id, 'user_id');
            $update = User::find($user->id);
            $update->last_login = time();
            $update->save();
            return $user;
        } elseif ($client && $client->validate_password($password) && $client->inactive == '0') {
            User::login($client->id, 'client_id');
            $update = Client::find($client->id);
            $update->last_login = time();
            $update->save();
            return $client;
        } else {
            return false;
        }
    }

    public static function login($user_id, $type)
    {
        $CI = &get_instance();
        $CI->session->set_userdata($type, $user_id);
    }

    public static function logout()
    {
        $CI = &get_instance();
        $CI->session->sess_destroy();
    }
}
