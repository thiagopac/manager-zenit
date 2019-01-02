<?php defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Create_invoice_has_items extends CI_Migration
{
    public function up()
    {
        ## Create Table invoice_has_items
        $this->dbforge->add_field('`id` int(10) NOT NULL auto_increment');
        $this->dbforge->add_key('id', true);
        $this->dbforge->add_field("`invoice_id` int(11) NULL DEFAULT '0'");
        $this->dbforge->add_field("`item_id` int(11) NULL  DEFAULT '0'");
        $this->dbforge->add_field('`amount` char(11) NULL ');
        $this->dbforge->add_field('`description` mediumtext NULL ');
        $this->dbforge->add_field("`value` float NULL  DEFAULT '0'");
        $this->dbforge->add_field('`name` varchar(250) NULL ');
        $this->dbforge->add_field('`type` varchar(250) NULL ');
        $this->dbforge->add_field('`task_id` int(11) NULL ');
        $this->dbforge->create_table('invoice_has_items', true);
    }

    public function down()
    {
        ### Drop table invoice_has_items ##
        $this->dbforge->drop_table('invoice_has_items', true);
    }
}
