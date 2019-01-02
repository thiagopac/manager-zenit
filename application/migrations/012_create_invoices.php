<?php defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Create_invoices extends CI_Migration
{
    public function up()
    {
        ## Create Table invoices
        $this->dbforge->add_field('`id` int(11) NOT NULL auto_increment');
        $this->dbforge->add_key('id', true);
        $this->dbforge->add_field("`sum` float NOT NULL DEFAULT '0'");
        $this->dbforge->add_field("`estimate_sent` varchar(255) NOT NULL DEFAULT '0'");
        $this->dbforge->add_field("`estimate_status` varchar(255) NOT NULL DEFAULT '0'");
        $this->dbforge->add_field("`project_id` int(11) NULL DEFAULT '0'");
        $this->dbforge->add_field("`reference` int(11) NULL  DEFAULT '0'");
        $this->dbforge->add_field("`company_id` int(11) NULL DEFAULT '0'");
        $this->dbforge->add_field('`status` varchar(50) NULL ');
        $this->dbforge->add_field('`currency` varchar(20) NULL ');
        $this->dbforge->add_field('`issue_date` varchar(20) NULL ');
        $this->dbforge->add_field('`due_date` varchar(20) NULL ');
        $this->dbforge->add_field('`sent_date` varchar(20) NULL ');
        $this->dbforge->add_field('`paid_date` varchar(20) NULL ');
        $this->dbforge->add_field('`terms` mediumtext NULL ');
        $this->dbforge->add_field('`discount` varchar(50) NULL ');
        $this->dbforge->add_field('`subscription_id` varchar(50) NULL ');
        $this->dbforge->add_field('`tax` varchar(255) NULL ');
        $this->dbforge->add_field('`second_tax` varchar(5) NULL ');
        $this->dbforge->add_field("`estimate` int(11) NULL DEFAULT '0'");
        $this->dbforge->add_field('`estimate_accepted_date` varchar(255) NULL ');
        $this->dbforge->add_field("`paid` float NULL  DEFAULT '0'");
        $this->dbforge->add_field('`outstanding` float NULL ');
        $this->dbforge->add_field("`estimate_reference` int(10) NULL  DEFAULT '0'");
        $this->dbforge->add_field('`po_number` varchar(250) NULL ');
        $this->dbforge->create_table('invoices', true);
    }

    public function down()
    {
        ### Drop table invoices ##
        $this->dbforge->drop_table('invoices', true);
    }
}
