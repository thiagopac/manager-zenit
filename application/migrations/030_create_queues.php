<?php defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Create_queues extends CI_Migration
{
    public function up()
    {
        ## Create Table queues
        $this->dbforge->add_field('`id` bigint(20) NOT NULL auto_increment');
        $this->dbforge->add_key('id', true);
        $this->dbforge->add_field('`name` varchar(250) NULL ');
        $this->dbforge->add_field('`description` varchar(250) NULL ');
        $this->dbforge->add_field("`inactive` tinyint(4) NULL DEFAULT '0'");
        $this->dbforge->create_table('queues', true);
    }

    public function down()
    {
        ### Drop table queues ##
        $this->dbforge->drop_table('queues', true);
    }
}
