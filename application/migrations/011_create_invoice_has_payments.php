<?php defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Create_invoice_has_payments extends CI_Migration
{
    public function up()
    {
        ## Create Table invoice_has_payments
        $this->dbforge->add_field('`id` bigint(20) NOT NULL auto_increment');
        $this->dbforge->add_key('id', true);
        $this->dbforge->add_field("`invoice_id` bigint(20) NULL DEFAULT '0'");
        $this->dbforge->add_field('`reference` varchar(255) NULL ');
        $this->dbforge->add_field("`amount` float NULL  DEFAULT '0'");
        $this->dbforge->add_field('`date` varchar(20) NULL ');
        $this->dbforge->add_field('`type` varchar(255) NULL ');
        $this->dbforge->add_field('`notes` text NULL ');
        $this->dbforge->add_field("`user_id` bigint(20) NULL DEFAULT '0'");
        $this->dbforge->create_table('invoice_has_payments', true);
    }

    public function down()
    {
        ### Drop table invoice_has_payments ##
        $this->dbforge->drop_table('invoice_has_payments', true);
    }
}
