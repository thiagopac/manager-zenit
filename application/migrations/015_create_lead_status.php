<?php defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Create_lead_status extends CI_Migration
{
    public function up()
    {
        ## Create Table lead_status
        $this->dbforge->add_field('`id` bigint(20) unsigned NOT NULL auto_increment');
        $this->dbforge->add_key('id', true);
        $this->dbforge->add_field('`name` varchar(250) NULL ');
        $this->dbforge->add_field('`description` text NULL ');
        $this->dbforge->add_field("`order` float NULL DEFAULT '0'");
        $this->dbforge->add_field("`offset` bigint(200) NULL DEFAULT '0'");
        $this->dbforge->add_field("`limit` bigint(200) NULL DEFAULT '50' ");
        $this->dbforge->add_field("`color` varchar(100) NULL DEFAULT '#5071ab' ");
        $this->dbforge->create_table('lead_status', true);
    }

    public function down()
    {
        ### Drop table lead_status ##
        $this->dbforge->drop_table('lead_status', true);
    }
}
