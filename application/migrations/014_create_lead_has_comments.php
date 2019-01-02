<?php defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Create_lead_has_comments extends CI_Migration
{
    public function up()
    {
        ## Create Table lead_has_comments
        $this->dbforge->add_field('`id` bigint(20) unsigned NOT NULL auto_increment');
        $this->dbforge->add_key('id', true);
        $this->dbforge->add_field('`attachment` varchar(250) NULL ');
        $this->dbforge->add_field('`attachment_link` varchar(250) NULL ');
        $this->dbforge->add_field('`datetime` varchar(250) NULL ');
        $this->dbforge->add_field('`message` text NULL ');
        $this->dbforge->add_field("`user_id` bigint(20) NULL DEFAULT '0'");
        $this->dbforge->add_field("`lead_id` bigint(20) NULL DEFAULT '0'");
        $this->dbforge->create_table('lead_has_comments', true);
    }

    public function down()
    {
        ### Drop table lead_has_comments ##
        $this->dbforge->drop_table('lead_has_comments', true);
    }
}
