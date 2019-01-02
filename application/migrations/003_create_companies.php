<?php defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Create_companies extends CI_Migration
{
    public function up()
    {
        ## Create Table companies
        $this->dbforge->add_field('`id` int(11) NOT NULL auto_increment');
        $this->dbforge->add_key('id', true);
        $this->dbforge->add_field('`reference` int(11) NOT NULL ');
        $this->dbforge->add_field('`name` varchar(140) NULL ');
        $this->dbforge->add_field('`client_id` varchar(140) NULL ');
        $this->dbforge->add_field('`phone` varchar(25) NULL ');
        $this->dbforge->add_field('`mobile` varchar(25) NULL ');
        $this->dbforge->add_field('`address` varchar(150) NULL ');
        $this->dbforge->add_field('`zipcode` varchar(30) NOT NULL ');
        $this->dbforge->add_field('`city` varchar(45) NULL ');
        $this->dbforge->add_field("`inactive` tinyint(4) NULL DEFAULT '0'");
        $this->dbforge->add_field('`website` varchar(250) NULL ');
        $this->dbforge->add_field('`country` varchar(250) NULL ');
        $this->dbforge->add_field('`vat` varchar(250) NULL ');
        $this->dbforge->add_field('`note` longtext NULL ');
        $this->dbforge->add_field('`province` varchar(255) NULL ');
        $this->dbforge->add_field('`twitter` varchar(255) NOT NULL ');
        $this->dbforge->add_field('`skype` varchar(255) NOT NULL ');
        $this->dbforge->add_field('`linkedin` varchar(255) NOT NULL ');
        $this->dbforge->add_field('`facebook` varchar(255) NOT NULL ');
        $this->dbforge->add_field('`instagram` varchar(255) NOT NULL ');
        $this->dbforge->add_field('`googleplus` varchar(255) NOT NULL ');
        $this->dbforge->add_field('`youtube` varchar(255) NOT NULL ');
        $this->dbforge->add_field('`pinterest` varchar(255) NOT NULL ');
        $this->dbforge->add_field('`terms` text NULL ');
        $this->dbforge->create_table('companies', true);
    }

    public function down()
    {
        ### Drop table companies ##
        $this->dbforge->drop_table('companies', true);
    }
}
