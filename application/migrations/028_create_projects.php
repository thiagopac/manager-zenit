<?php defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Create_projects extends CI_Migration
{
    public function up()
    {
        ## Create Table projects
        $this->dbforge->add_field('`id` int(11) NOT NULL auto_increment');
        $this->dbforge->add_key('id', true);
        $this->dbforge->add_field("`reference` int(11) NULL DEFAULT '0'");
        $this->dbforge->add_field('`name` varchar(65) NULL ');
        $this->dbforge->add_field('`description` text NULL ');
        $this->dbforge->add_field('`start` varchar(20) NULL ');
        $this->dbforge->add_field('`end` varchar(20) NULL ');
        $this->dbforge->add_field('`progress` decimal(3,0) NULL ');
        $this->dbforge->add_field('`phases` varchar(150) NULL ');
        $this->dbforge->add_field("`tracking` int(11) NULL DEFAULT '0'");
        $this->dbforge->add_field("`time_spent` int(11) NULL DEFAULT '0'");
        $this->dbforge->add_field("`datetime` int(11) NULL DEFAULT '0'");
        $this->dbforge->add_field("`sticky` enum('1','0') NULL DEFAULT '0'");
        $this->dbforge->add_field('`category` varchar(150) NULL ');
        $this->dbforge->add_field("`company_id` int(11) NULL DEFAULT '0'");
        $this->dbforge->add_field('`note` longtext NULL ');
        $this->dbforge->add_field("`progress_calc` tinyint(4) NULL DEFAULT '0'");
        $this->dbforge->add_field("`hide_tasks` int(1) NULL DEFAULT '0'");
        $this->dbforge->add_field("`enable_client_tasks` int(1) NULL DEFAULT '0'");
        $this->dbforge->create_table('projects', true);
    }

    public function down()
    {
        ### Drop table projects ##
        $this->dbforge->drop_table('projects', true);
    }
}
