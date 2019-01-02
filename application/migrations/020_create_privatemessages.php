<?php defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Create_privatemessages extends CI_Migration
{
    public function up()
    {
        ## Create Table privatemessages
        $this->dbforge->add_field('`id` int(11) unsigned NOT NULL auto_increment');
        $this->dbforge->add_key('id', true);
        $this->dbforge->add_field('`status` varchar(150) NULL ');
        $this->dbforge->add_field('`sender` varchar(250) NULL ');
        $this->dbforge->add_field('`recipient` varchar(250) NULL ');
        $this->dbforge->add_field('`subject` varchar(255) NULL ');
        $this->dbforge->add_field('`message` text NULL ');
        $this->dbforge->add_field('`time` varchar(100) NULL ');
        $this->dbforge->add_field('`conversation` varchar(32) NULL ');
        $this->dbforge->add_field("`deleted` int(11) NULL DEFAULT '0'");
        $this->dbforge->add_field('`attachment` varchar(255) NULL ');
        $this->dbforge->add_field('`attachment_link` varchar(255) NULL ');
        $this->dbforge->add_field("`receiver_delete` int(11) NULL DEFAULT '0'");
        $this->dbforge->add_field("`marked` int(1) NULL DEFAULT '0'");
        $this->dbforge->add_field("`read` int(1) NULL DEFAULT '0'");
        $this->dbforge->create_table('privatemessages', true);
    }

    public function down()
    {
        ### Drop table privatemessages ##
        $this->dbforge->drop_table('privatemessages', true);
    }
}
