<?php defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Create_ticket_has_articles extends CI_Migration
{
    public function up()
    {
        ## Create Table ticket_has_articles
        $this->dbforge->add_field('`id` bigint(20) NOT NULL auto_increment');
        $this->dbforge->add_key('id', true);
        $this->dbforge->add_field("`ticket_id` int(11) NULL DEFAULT '0'");
        $this->dbforge->add_field('`from` varchar(250) NOT NULL ');
        $this->dbforge->add_field('`reply_to` varchar(250) NULL ');
        $this->dbforge->add_field('`to` varchar(250) NULL ');
        $this->dbforge->add_field('`cc` varchar(250) NULL ');
        $this->dbforge->add_field('`subject` varchar(250) NULL ');
        $this->dbforge->add_field('`message` text NULL ');
        $this->dbforge->add_field('`datetime` varchar(250) NULL ');
        $this->dbforge->add_field("`internal` int(10) NULL DEFAULT '1' ");
        $this->dbforge->add_field("`user_id` bigint(20) NULL DEFAULT '0'");
        $this->dbforge->add_field("`note` int(1) NULL DEFAULT '0'");
        $this->dbforge->add_field('`raw` longtext NULL ');
        $this->dbforge->create_table('ticket_has_articles', true);
    }

    public function down()
    {
        ### Drop table ticket_has_articles ##
        $this->dbforge->drop_table('ticket_has_articles', true);
    }
}
