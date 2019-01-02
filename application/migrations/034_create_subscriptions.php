<?php defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Create_subscriptions extends CI_Migration
{
    public function up()
    {
        ## Create Table subscriptions
        $this->dbforge->add_field('`id` int(10) NOT NULL auto_increment');
        $this->dbforge->add_key('id', true);
        $this->dbforge->add_field('`reference` varchar(50) NULL ');
        $this->dbforge->add_field("`company_id` int(10) NULL DEFAULT '0'");
        $this->dbforge->add_field('`status` varchar(50) NULL ');
        $this->dbforge->add_field('`currency` varchar(20) NULL ');
        $this->dbforge->add_field('`issue_date` varchar(20) NULL ');
        $this->dbforge->add_field('`end_date` varchar(20) NULL ');
        $this->dbforge->add_field('`frequency` varchar(20) NULL ');
        $this->dbforge->add_field('`next_payment` varchar(20) NULL ');
        $this->dbforge->add_field('`terms` mediumtext NULL ');
        $this->dbforge->add_field('`discount` varchar(50) NULL ');
        $this->dbforge->add_field('`tax` varchar(250) NULL ');
        $this->dbforge->add_field('`second_tax` varchar(255) NULL ');
        $this->dbforge->add_field('`subscribed` varchar(50) NULL ');
        $this->dbforge->create_table('subscriptions', true);
    }

    public function down()
    {
        ### Drop table subscriptions ##
        $this->dbforge->drop_table('subscriptions', true);
    }
}
