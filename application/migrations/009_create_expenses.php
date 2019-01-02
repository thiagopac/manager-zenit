<?php defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Create_expenses extends CI_Migration
{
    public function up()
    {
        ## Create Table expenses
        $this->dbforge->add_field('`id` bigint(20) unsigned NOT NULL auto_increment');
        $this->dbforge->add_key('id', true);
        $this->dbforge->add_field('`description` varchar(255) NULL ');
        $this->dbforge->add_field('`type` varchar(255) NULL ');
        $this->dbforge->add_field('`category` varchar(255) NULL ');
        $this->dbforge->add_field('`date` varchar(255) NULL ');
        $this->dbforge->add_field('`currency` varchar(255) NULL ');
        $this->dbforge->add_field("`value` float(20,2) NULL DEFAULT '0.00' ");
        $this->dbforge->add_field('`vat` varchar(255) NULL ');
        $this->dbforge->add_field('`reference` varchar(255) NULL ');
        $this->dbforge->add_field("`project_id` bigint(20) NULL DEFAULT '0'");
        $this->dbforge->add_field('`rebill` int(20) NULL  DEFAULT 0');
        $this->dbforge->add_field("`invoice_id` bigint(20) NULL DEFAULT '0'");
        $this->dbforge->add_field('`attachment` varchar(255) NULL ');
        $this->dbforge->add_field('`attachment_description` varchar(255) NULL ');
        $this->dbforge->add_field('`recurring` varchar(255) NULL ');
        $this->dbforge->add_field('`recurring_until` varchar(255) NULL ');
        $this->dbforge->add_field("`user_id` int(20) NULL DEFAULT '0'");
        $this->dbforge->add_field("`expense_id` int(20) NULL DEFAULT '0'");
        $this->dbforge->add_field('`next_payment` varchar(255) NULL ');
        $this->dbforge->add_field('`status` varchar(255) NULL ');
        $this->dbforge->create_table('expenses', true);
    }

    public function down()
    {
        ### Drop table expenses ##
        $this->dbforge->drop_table('expenses', true);
    }
}
