<?php defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Create_messages extends CI_Migration
{
    public function up()
    {
        ## Create Table messages
        $this->dbforge->add_field('`id` int(11) NOT NULL auto_increment');
        $this->dbforge->add_key('id', true);
        $this->dbforge->add_field("`project_id` int(11) NULL DEFAULT '0'");
        $this->dbforge->add_field("`media_id` int(11) NULL DEFAULT '0'");
        $this->dbforge->add_field('`from` varchar(120) NULL ');
        $this->dbforge->add_field('`text` text NULL ');
        $this->dbforge->add_field('`datetime` varchar(50) NULL ');
        $this->dbforge->create_table('messages', true);
    }

    public function down()
    {
        ### Drop table messages ##
        $this->dbforge->drop_table('messages', true);
    }
}
