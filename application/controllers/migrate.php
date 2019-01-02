<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class migrate extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function now($install = false, $pc = false, $redirect = false)
    {
        $this->load->library('migration');

        if (!$this->migration->latest()) {
            show_error($this->migration->error_string());
            return false;
        }
        echo 'Database has been migrated successfully!<br>';

        if ($install) {
            $this->install($pc);
        }
        $protocol = ($_SERVER['HTTPS'] == '' || $_SERVER['HTTPS'] == 'off') ? 'http://' : 'https://';
        $uri = explode('migrate/now/install', $_SERVER['REQUEST_URI']);
        $domain = $protocol . $_SERVER['HTTP_HOST'] . $uri[0];
        echo '<a href="' . $domain . '">Go to login</a>';
        if ($redirect) {
            redirect('login');
        }
    }

    public function install($pc)
    {
        if (!file_exists('./INSTALL_TRUE')) {
            echo 'INSTALL_TRUE file does not exist!<br>';
            return false;
        }
        log_message('error', 'Installation script has been started!');

        /* Set Installer Settings */
        $version = trim(file_get_contents('./application/version.txt'));
        $protocol = ($_SERVER['HTTPS'] == '' || $_SERVER['HTTPS'] == 'off') ? 'http://' : 'https://';
        $uri = explode('migrate/now/install', $_SERVER['REQUEST_URI']);
        $domain = $protocol . $_SERVER['HTTP_HOST'] . $uri[0];

        /* Insert all modules --> */
        $modules = "INSERT INTO `modules` (`id`, `name`, `link`, `type`, `icon`, `sort`)
                    VALUES
                        (1,'Dashboard','dashboard','main','icon dripicons-meter',1),
                        (2,'Messages','messages','main','icon dripicons-message',2),
                        (3,'Projects','projects','main','icon dripicons-rocket',3),
                        (4,'Clients','clients','main','icon dripicons-user',4),
                        (5,'Invoices','invoices','main','icon dripicons-document',5),
                        (6,'Items','items','main','icon dripicons-shopping-bag',7),
                        (7,'Quotations','quotations','main','icon dripicons-blog',8),
                        (8,'Subscriptions','subscriptions','main','icon dripicons-retweet',6),
                        (9,'Settings','settings','main','icon dripicons-toggles',20),
                        (10,'QuickAccess','quickaccess','widget','',50),
                        (11,'User Online','useronline','widget','',51),
                        (12,'Estimates','estimates','main','icon dripicons-document-edit',5),
                        (13,'Expenses','expenses','main','icon dripicons-cart',5),
                        (20,'Calendar','calendar','main','icon dripicons-calendar',8),
                        (33,'Reports','reports','main','icon dripicons-graph-pie',8),
                        (101,'Projects','cprojects','client','icon dripicons-rocket',2),
                        (102,'Invoices','cinvoices','client','icon dripicons-document',3),
                        (103,'Messages','cmessages','client','icon dripicons-message',1),
                        (104,'Subscriptions','csubscriptions','client','icon dripicons-retweet',4),
                        (105,'Tickets','tickets','main','icon dripicons-ticket',8),
                        (106,'Tickets','ctickets','client','icon dripicons-ticket',4),
                        (107,'Estimates','cestimates','client','icon dripicons-document-edit',3),
                        (108,'Leads','leads','main','icon dripicons-phone',4);";

        $check_modules = $this->db->query('SELECT * from `modules`');
        if ($check_modules->num_rows > 0) {
            $message = 'Inserting modules has been skipped since ' . $check_modules->num_rows . ' modules already in Database...';
            log_message('error', 'Install Script: ' . $message);
            echo $message . '<br>';
        } else {
            if (!$this->db->query($modules)) {
                $message = 'Error while writing modules to database!';
                log_message('error', 'Install Script: ' . $message);
                echo $message . '<br>';
                return false;
            }
        }
        /* <-- END Insert all modules */

        /* Insert queues --> */
        $queues = "INSERT INTO `queues` (`id`, `name`, `description`, `inactive`) 
                    VALUES 
                    (1, 'Service', 'First service queue', 0), 
                    (2, 'Second Level', 'Second Level Queue', 0)";

        $check_queues = $this->db->query('SELECT * from `queues`');
        if ($check_queues->num_rows > 0) {
            $message = 'Inserting queues has been skipped since ' . $check_queues->num_rows . ' queues already in Database...';
            log_message('error', 'Install Script: ' . $message);
        } else {
            $this->db->query($queues);
        }
        /* <-- END Insert all queues */

        /* Insert types --> */
        $types = "INSERT INTO `types` (`id`, `name`, `description`, `inactive`) 
                  VALUES 
                  (1, 'Service Request', 'Service Requests', 0)";

        $check_types = $this->db->query('SELECT * from `types`');
        if ($check_types->num_rows > 0) {
            $message = 'Inserting types has been skipped since ' . $check_types->num_rows . ' types already in Database...';
            log_message('error', 'Install Script: ' . $message);
        } else {
            $this->db->query($types);
        }
        /* <-- END Insert all types */

        /* Insert Core Settings --> */
        $core = "INSERT INTO core (`id`, `version`, `domain`, `email`, `company`, `tax`, `currency`, `autobackup`, 
                `cronjob`, `last_cronjob`, `last_autobackup`, `invoice_terms`, `company_reference`, `project_reference`, 
                `invoice_reference`, `subscription_reference`, `ticket_reference`, `estimate_reference`, `date_format`, `date_time_format`, `invoice_mail_subject`, 
                `pw_reset_mail_subject`, `pw_reset_link_mail_subject`, `credentials_mail_subject`, `notification_mail_subject`, 
                `language`, `invoice_address`, `invoice_city`, `invoice_contact`, `invoice_tel`, `subscription_mail_subject`, `logo`, 
                `template`, `paypal`, `paypal_currency`, `paypal_account`, `invoice_logo`, `pc`) 
                VALUES (1, '$version', '$domain', 'local@localhost', 'My Company', 0, 'USD', '1', '1', 0, 0, 
                'Thank you for your business. We do expect payment within {due_date}, so please process this invoice within that time.', 
                '41001', '51001', '31001', '61001', 10000, 20000, 
                'Y/m/d', 'g:i A', 'New Invoice', 'Password Reset', 'Password Reset', 'Login Details', 'Notification', 'english', 
                '', '', '', '', 'New Subscription', 'assets/blueline/images/FC2_logo_light.png', 'blueline', 0, 'USD', 
                '', 'assets/blueline/images/FC2_logo_dark.png', '$pc');";

        $check_core = $this->db->query('SELECT * from `core`');
        if ($check_core->num_rows > 0) {
            $message = 'Inserting core has been skipped since ' . $check_core->num_rows . ' entries are already in Database...';
            log_message('error', 'Install Script: ' . $message);
            echo $message . '<br>';
        } else {
            if (!$this->db->query($core)) {
                $message = 'Error while writing core to database!';
                log_message('error', 'Install Script: ' . $message);
                echo $message . '<br>';
                return false;
            }
        }
        /* <-- End Insert Core Settings */

        /* Insert Admin User --> */
        $all_module_ids = $this->db->query("SELECT `id` from `modules` where type != 'client'");
        $access_ids = '';
        foreach ($all_module_ids->result() as $row) {
            $access_ids .= $row->id . ',';
        }
        $access_ids = rtrim($access_ids, ',');

        $user = "INSERT INTO `users` (`username`, `firstname`, `lastname`, `hashed_password`, `email`, `status`, `admin`, `userpic`, `title`, `access`, `last_active`, `last_login`) 
        VALUES('Admin', 'John', 'Doe', '785ea3511702420413df674029fe58d69692b3a0a571c0ba30177c7808db69ea22a8596b1cc5777403d4374dafaa708445a9926d6ead9a262e37cb0d78db1fe5', 'local@localhost', 'active', '1', 'no-pic.png', 'Administrator', '$access_ids', '', '')";

        $check_user = $this->db->query('SELECT * from `users`');
        if ($check_user->num_rows > 0) {
            $message = 'Inserting user has been skipped since ' . $check_user->num_rows . ' user is already in Database...';
            log_message('error', 'Install Script: ' . $message);
            echo $message . '<br>';
        } else {
            if (!$this->db->query($user)) {
                $message = 'Error while writing user to database!<br>';
                log_message('error', 'Install Script: ' . $message);
                echo $message . '<br>';
                return false;
            }
        }
        /* <-- End insert Admin User */

        @unlink('./INSTALL_TRUE');
    }
}
