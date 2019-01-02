<?php defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Create_project_has_activities extends CI_Migration
{
    public function up()
    {
        ## Create Table project_has_activities
        $this->dbforge->add_field('`id` bigint(20) NOT NULL auto_increment');
        $this->dbforge->add_key('id', true);
        $this->dbforge->add_field("`project_id` bigint(20) NULL DEFAULT '0'");
        $this->dbforge->add_field("`user_id` bigint(20) NULL DEFAULT '0'");
        $this->dbforge->add_field("`client_id` bigint(20) NULL DEFAULT '0'");
        $this->dbforge->add_field('`datetime` varchar(250) NULL ');
        $this->dbforge->add_field('`subject` varchar(250) NULL ');
        $this->dbforge->add_field('`message` text NULL ');
        $this->dbforge->add_field('`type` varchar(250) NULL ');
        $this->dbforge->create_table('project_has_activities', true);
    }

    public function down()
    {
        ### Drop table project_has_activities ##
        $this->dbforge->drop_table('project_has_activities', true);
    }
}
