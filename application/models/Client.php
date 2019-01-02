<?php

class Client extends ActiveRecord\Model
{
    public $password = false;

    public function before_save()
    {
        if ($this->password) {
            $this->hashed_password = $this->hash_password($this->password);
        }
    }

    public function get_userpic()
    {
        return get_user_pic($this->read_attribute('userpic'), $this->read_attribute('email'));
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

    public function validate_password($password)
    {
        $salt = substr($this->hashed_password, 0, 64);
        $hash = substr($this->hashed_password, 64, 64);

        $password_hash = hash('sha256', $salt . $password);

        return $password_hash == $hash;
    }

    public function has_permission_to($module_name, $client)
    {
        $module = Module::find_by_link($module_name);
        $access = explode(',', $client->access);
        return in_array($module->id, $access);
    }

    public static $has_many = [
    ['projects'],
    ['invoices']
    ];

    public static $belongs_to = [
    ['company']
    ];
}
