<?php defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Create_project_has_files extends CI_Migration
{
    public function up()
    {
        ## Create Table project_has_files
        $this->dbforge->add_field('`id` int(10) NOT NULL auto_increment');
        $this->dbforge->add_key('id', true);
        $this->dbforge->add_field("`project_id` int(10) NULL DEFAULT '0'");
        $this->dbforge->add_field("`user_id` int(10) NULL DEFAULT '0'");
        $this->dbforge->add_field("`client_id` int(10) NULL DEFAULT '0'");
        $this->dbforge->add_field('`type` varchar(80) NULL ');
        $this->dbforge->add_field('`name` varchar(120) NULL ');
        $this->dbforge->add_field('`filename` varchar(150) NULL ');
        $this->dbforge->add_field('`description` text NULL ');
        $this->dbforge->add_field('`savename` varchar(200) NULL ');
        $this->dbforge->add_field('`phase` varchar(100) NULL ');
        $this->dbforge->add_field('`date` varchar(50) NULL ');
        $this->dbforge->add_field("`download_counter` int(10) NULL DEFAULT '0'");
        $this->dbforge->create_table('project_has_files', true);
    }

    public function down()
    {
        ### Drop table project_has_files ##
        $this->dbforge->drop_table('project_has_files', true);
    }
}
