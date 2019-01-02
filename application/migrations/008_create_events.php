<?php defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Create_events extends CI_Migration
{
    public function up()
    {
        ## Create Table events
        $this->dbforge->add_field('`id` bigint(20) NOT NULL auto_increment');
        $this->dbforge->add_key('id', true);
        $this->dbforge->add_field('`title` varchar(255) NULL ');
        $this->dbforge->add_field('`description` text NULL ');
        $this->dbforge->add_field('`allday` varchar(30) NULL ');
        $this->dbforge->add_field('`url` varchar(255) NULL ');
        $this->dbforge->add_field('`classname` varchar(255) NULL ');
        $this->dbforge->add_field('`start` varchar(255) NULL ');
        $this->dbforge->add_field('`end` varchar(255) NULL ');
        $this->dbforge->add_field('`user_id` bigint(20) NULL DEFAULT 0');
        $this->dbforge->add_field('`access` varchar(255) NULL ');
        $this->dbforge->add_field('`reminder` varchar(255) NULL ');
        $this->dbforge->create_table('events', true);
    }

    public function down()
    {
        ### Drop table events ##
        $this->dbforge->drop_table('events', true);
    }
}
