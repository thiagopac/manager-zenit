<?php defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Create_tickets extends CI_Migration
{
    public function up()
    {
        ## Create Table tickets
        $this->dbforge->add_field('`id` bigint(20) NOT NULL auto_increment');
        $this->dbforge->add_key('id', true);
        $this->dbforge->add_field('`from` varchar(250) NULL ');
        $this->dbforge->add_field('`reference` varchar(250) NULL ');
        $this->dbforge->add_field("`type_id` smallint(6) NULL DEFAULT '1' ");
        $this->dbforge->add_field('`lock` smallint(6) NULL ');
        $this->dbforge->add_field('`subject` varchar(250) NULL ');
        $this->dbforge->add_field('`text` text NULL ');
        $this->dbforge->add_field('`status` varchar(50) NULL ');
        $this->dbforge->add_field("`client_id` int(11) NULL DEFAULT '0'");
        $this->dbforge->add_field("`company_id` int(11) NULL DEFAULT '0'");
        $this->dbforge->add_field("`user_id` int(11) NULL DEFAULT '0'");
        $this->dbforge->add_field("`escalation_time` int(11) NULL DEFAULT '0'");
        $this->dbforge->add_field('`priority` varchar(50) NULL ');
        $this->dbforge->add_field("`created` int(11) NULL DEFAULT '0'");
        $this->dbforge->add_field("`queue_id` int(11) NULL DEFAULT '0'");
        $this->dbforge->add_field("`updated` tinyint(4) NULL DEFAULT '0'");
        $this->dbforge->add_field("`project_id` bigint(20) NULL DEFAULT '0'");
        $this->dbforge->add_field('`raw` longtext NULL ');
        $this->dbforge->create_table('tickets', true);
    }

    public function down()
    {
        ### Drop table tickets ##
        $this->dbforge->drop_table('tickets', true);
    }
}
