<?php defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Create_clients extends CI_Migration
{
    public function up()
    {
        ## Create Table clients
        $this->dbforge->add_field('`id` int(11) NOT NULL auto_increment');
        $this->dbforge->add_key('id', true);
        $this->dbforge->add_field('`company_id` int(140) NULL ');
        $this->dbforge->add_field('`firstname` varchar(100) NULL ');
        $this->dbforge->add_field('`lastname` varchar(100) NULL ');
        $this->dbforge->add_field('`email` varchar(180) NULL ');
        $this->dbforge->add_field('`phone` varchar(25) NULL ');
        $this->dbforge->add_field('`mobile` varchar(25) NULL ');
        $this->dbforge->add_field('`address` varchar(150) NULL ');
        $this->dbforge->add_field('`zipcode` varchar(30) NULL ');
        $this->dbforge->add_field("`userpic` varchar(150) NULL DEFAULT 'no-pic.png' ");
        $this->dbforge->add_field('`city` varchar(45) NULL ');
        $this->dbforge->add_field('`hashed_password` varchar(255) NULL ');
        $this->dbforge->add_field("`inactive` tinyint(4) NULL DEFAULT '0'");
        $this->dbforge->add_field("`access` varchar(150) NULL DEFAULT '0'");
        $this->dbforge->add_field('`last_active` varchar(50) NULL ');
        $this->dbforge->add_field('`last_login` varchar(50) NULL ');
        $this->dbforge->add_field('`twitter` varchar(255) NULL ');
        $this->dbforge->add_field('`skype` varchar(255) NULL ');
        $this->dbforge->add_field('`linkedin` varchar(255) NULL ');
        $this->dbforge->add_field('`facebook` varchar(255) NULL ');
        $this->dbforge->add_field('`instagram` varchar(255) NULL ');
        $this->dbforge->add_field('`googleplus` varchar(255) NULL ');
        $this->dbforge->add_field('`youtube` varchar(255) NULL ');
        $this->dbforge->add_field('`pinterest` varchar(255) NULL ');
        $this->dbforge->add_field('`token` varchar(255) NULL ');
        $this->dbforge->add_field('`language` varchar(255) NULL ');
        $this->dbforge->add_field('`signature` text NULL ');
        $this->dbforge->create_table('clients', true);
    }

    public function down()
    {
        ### Drop table clients ##
        $this->dbforge->drop_table('clients', true);
    }
}
