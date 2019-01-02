<?php defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Create_project_has_timesheets extends CI_Migration
{
    public function up()
    {
        ## Create Table project_has_timesheets
        $this->dbforge->add_field('`id` bigint(20) unsigned NOT NULL auto_increment');
        $this->dbforge->add_key('id', true);
        $this->dbforge->add_field("`project_id` int(11) NULL DEFAULT '0'");
        $this->dbforge->add_field("`user_id` int(11) NULL DEFAULT '0'");
        $this->dbforge->add_field("`time` varchar(250) NULL DEFAULT '0'");
        $this->dbforge->add_field("`task_id` int(11) NULL DEFAULT '0'");
        $this->dbforge->add_field("`client_id` int(11) NULL DEFAULT '0'");
        $this->dbforge->add_field("`start` varchar(250) NULL DEFAULT '0'");
        $this->dbforge->add_field("`end` varchar(250) NULL DEFAULT '0'");
        $this->dbforge->add_field("`invoice_id` int(11) NULL DEFAULT '0'");
        $this->dbforge->add_field('`description` text NULL ');
        $this->dbforge->create_table('project_has_timesheets', true);
    }

    public function down()
    {
        ### Drop table project_has_timesheets ##
        $this->dbforge->drop_table('project_has_timesheets', true);
    }
}
