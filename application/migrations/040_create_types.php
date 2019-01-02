<?php defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Create_types extends CI_Migration
{
    public function up()
    {
        ## Create Table types
        $this->dbforge->add_field('`id` bigint(20) NOT NULL auto_increment');
        $this->dbforge->add_key('id', true);
        $this->dbforge->add_field('`name` varchar(250) NULL ');
        $this->dbforge->add_field('`description` varchar(250) NULL ');
        $this->dbforge->add_field("`inactive` tinyint(4) NULL DEFAULT '0'");
        $this->dbforge->create_table('types', true);
    }

    public function down()
    {
        ### Drop table types ##
        $this->dbforge->drop_table('types', true);
    }
}
