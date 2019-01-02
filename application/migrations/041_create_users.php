<?php defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Create_users extends CI_Migration
{
    public function up()
    {
        ## Create Table users
        $this->dbforge->add_field('`id` int(11) NOT NULL auto_increment');
        $this->dbforge->add_key('id', true);
        $this->dbforge->add_field('`username` varchar(45) NULL ');
        $this->dbforge->add_field('`firstname` varchar(120) NULL ');
        $this->dbforge->add_field('`lastname` varchar(120) NULL ');
        $this->dbforge->add_field('`hashed_password` varchar(128) NULL ');
        $this->dbforge->add_field('`email` varchar(60) NULL ');
        $this->dbforge->add_field("`status` enum('active','inactive','deleted') NULL ");
        $this->dbforge->add_field("`admin` enum('0','1') NULL DEFAULT '0'");
        $this->dbforge->add_field('`created` timestamp NULL DEFAULT CURRENT_TIMESTAMP ');
        $this->dbforge->add_field("`userpic` varchar(250) NULL DEFAULT 'no-pic.png' ");
        $this->dbforge->add_field('`title` varchar(150) NULL ');
        $this->dbforge->add_field("`access` varchar(150) NOT NULL DEFAULT '1,2' ");
        $this->dbforge->add_field('`last_active` varchar(50) NULL ');
        $this->dbforge->add_field('`last_login` varchar(50) NULL ');
        $this->dbforge->add_field("`queue` bigint(20) NULL DEFAULT '0'");
        $this->dbforge->add_field('`token` varchar(255) NULL ');
        $this->dbforge->add_field('`language` varchar(255) NULL ');
        $this->dbforge->add_field('`signature` text NULL ');
        $this->dbforge->create_table('users', true);
    }

    public function down()
    {
        ### Drop table users ##
        $this->dbforge->drop_table('users', true);
    }
}
