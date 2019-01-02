<?php defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Create_project_has_milestones extends CI_Migration
{
    public function up()
    {
        ## Create Table project_has_milestones
        $this->dbforge->add_field('`id` int(11) unsigned NOT NULL auto_increment');
        $this->dbforge->add_key('id', true);
        $this->dbforge->add_field("`project_id` int(11) NULL DEFAULT '0'");
        $this->dbforge->add_field('`name` varchar(255) NULL ');
        $this->dbforge->add_field('`description` longtext NULL ');
        $this->dbforge->add_field('`due_date` varchar(255) NULL ');
        $this->dbforge->add_field("`orderindex` int(11) NULL DEFAULT '0'");
        $this->dbforge->add_field('`start_date` varchar(255) NULL ');
        $this->dbforge->create_table('project_has_milestones', true);
    }

    public function down()
    {
        ### Drop table project_has_milestones ##
        $this->dbforge->drop_table('project_has_milestones', true);
    }
}
