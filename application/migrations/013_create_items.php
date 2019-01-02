<?php defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Create_items extends CI_Migration
{
    public function up()
    {
        ## Create Table items
        $this->dbforge->add_field('`id` int(11) NOT NULL auto_increment');
        $this->dbforge->add_key('id', true);
        $this->dbforge->add_field('`name` varchar(45) NULL ');
        $this->dbforge->add_field("`value` float NULL DEFAULT '0'");
        $this->dbforge->add_field('`type` varchar(45) NULL ');
        $this->dbforge->add_field("`inactive` tinyint(4) NULL DEFAULT '0'");
        $this->dbforge->add_field('`description` varchar(255) NULL ');
        $this->dbforge->create_table('items', true);
    }

    public function down()
    {
        ### Drop table items ##
        $this->dbforge->drop_table('items', true);
    }
}
