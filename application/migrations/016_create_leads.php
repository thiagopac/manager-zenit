<?php defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Create_leads extends CI_Migration
{
    public function up()
    {
        ## Create Table leads
        $this->dbforge->add_field('`id` bigint(20) unsigned NOT NULL auto_increment');
        $this->dbforge->add_key('id', true);
        $this->dbforge->add_field("`status_id` bigint(20) NULL DEFAULT '0'");
        $this->dbforge->add_field('`source` varchar(250) NULL ');
        $this->dbforge->add_field('`name` varchar(250) NULL ');
        $this->dbforge->add_field('`position` varchar(250) NULL ');
        $this->dbforge->add_field('`address` varchar(250) NULL ');
        $this->dbforge->add_field('`city` varchar(250) NULL ');
        $this->dbforge->add_field('`state` varchar(250) NULL ');
        $this->dbforge->add_field('`country` varchar(250) NULL ');
        $this->dbforge->add_field('`zipcode` varchar(250) NULL ');
        $this->dbforge->add_field('`language` varchar(250) NULL ');
        $this->dbforge->add_field('`email` varchar(250) NULL ');
        $this->dbforge->add_field('`website` varchar(250) NULL ');
        $this->dbforge->add_field('`phone` varchar(250) NULL ');
        $this->dbforge->add_field('`mobile` varchar(250) NULL ');
        $this->dbforge->add_field('`company` varchar(250) NULL ');
        $this->dbforge->add_field('`tags` varchar(250) NULL ');
        $this->dbforge->add_field('`description` text NULL ');
        $this->dbforge->add_field('`first_contact` varchar(250) NULL ');
        $this->dbforge->add_field('`last_contact` varchar(250) NULL ');
        $this->dbforge->add_field('`valid_until` varchar(250) NULL ');
        $this->dbforge->add_field('`created` varchar(20) NULL ');
        $this->dbforge->add_field('`modified` varchar(20) NULL ');
        $this->dbforge->add_field("`private` varchar(20) NULL DEFAULT '0'");
        $this->dbforge->add_field('`custom` varchar(255) NULL ');
        $this->dbforge->add_field("`user_id` bigint(20) NULL DEFAULT '0'");
        $this->dbforge->add_field('`icon` varchar(255) NULL ');
        $this->dbforge->add_field("`order` float NULL DEFAULT '0'");
        $this->dbforge->create_table('leads', true);
    }

    public function down()
    {
        ### Drop table leads ##
        $this->dbforge->drop_table('leads', true);
    }
}
