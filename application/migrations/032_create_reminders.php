<?php defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Create_reminders extends CI_Migration
{
    public function up()
    {
        ## Create Table reminders
        $this->dbforge->add_field('`id` bigint(20) unsigned NOT NULL auto_increment');
        $this->dbforge->add_key('id', true);
        $this->dbforge->add_field('`module` varchar(250) NULL ');
        $this->dbforge->add_field("`source_id` bigint(20) NULL DEFAULT '0'");
        $this->dbforge->add_field('`title` varchar(250) NULL ');
        $this->dbforge->add_field('`body` text NULL ');
        $this->dbforge->add_field("`email_notification` int(1) NULL DEFAULT '0'");
        $this->dbforge->add_field("`done` int(1) NULL DEFAULT '0'");
        $this->dbforge->add_field('`datetime` varchar(50) NULL ');
        $this->dbforge->add_field('`sent_at` varchar(50) NULL ');
        $this->dbforge->add_field("`user_id` int(20) NULL DEFAULT '0'");
        $this->dbforge->create_table('reminders', true);
    }

    public function down()
    {
        ### Drop table reminders ##
        $this->dbforge->drop_table('reminders', true);
    }
}
