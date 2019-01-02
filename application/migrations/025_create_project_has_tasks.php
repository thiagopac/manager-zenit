<?php defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Create_project_has_tasks extends CI_Migration
{
    public function up()
    {
        ## Create Table project_has_tasks
        $this->dbforge->add_field('`id` int(10) NOT NULL auto_increment');
        $this->dbforge->add_key('id', true);
        $this->dbforge->add_field('`project_id` int(10) NULL ');
        $this->dbforge->add_field('`name` varchar(250) NULL ');
        $this->dbforge->add_field('`user_id` int(10) NULL ');
        $this->dbforge->add_field('`status` varchar(50) NULL ');
        $this->dbforge->add_field('`public` int(10) NULL ');
        $this->dbforge->add_field('`datetime` int(11) NULL ');
        $this->dbforge->add_field('`due_date` varchar(250) NULL ');
        $this->dbforge->add_field('`description` text NULL ');
        $this->dbforge->add_field('`start_date` varchar(250) NULL ');
        $this->dbforge->add_field("`value` float NULL DEFAULT '0'");
        $this->dbforge->add_field("`priority` smallint(6) NULL DEFAULT '0'");
        $this->dbforge->add_field('`time` int(11) NULL ');
        $this->dbforge->add_field("`client_id` int(30) NULL DEFAULT '0'");
        $this->dbforge->add_field("`created_by_client` int(30) NULL DEFAULT '0'");
        $this->dbforge->add_field("`tracking` int(11) NULL DEFAULT '0'");
        $this->dbforge->add_field("`time_spent` int(11) NULL DEFAULT '0'");
        $this->dbforge->add_field("`milestone_id` int(11) NULL DEFAULT '0'");
        $this->dbforge->add_field("`invoice_id` int(60) NULL DEFAULT '0'");
        $this->dbforge->add_field("`milestone_order` int(11) NULL DEFAULT '0'");
        $this->dbforge->add_field("`task_order` int(11) NULL DEFAULT '0'");
        $this->dbforge->add_field("`progress` int(11) NULL DEFAULT '0'");
        $this->dbforge->add_field('`created_at` varchar(50) NULL ');
        $this->dbforge->create_table('project_has_tasks', true);
    }

    public function down()
    {
        ### Drop table project_has_tasks ##
        $this->dbforge->drop_table('project_has_tasks', true);
    }
}
