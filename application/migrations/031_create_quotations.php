<?php defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Create_quotations extends CI_Migration
{
    public function up()
    {
        ## Create Table quotations
        $this->dbforge->add_field('`id` int(11) NOT NULL auto_increment');
        $this->dbforge->add_key('id', true);
        $this->dbforge->add_field('`q1` varchar(50) NULL ');
        $this->dbforge->add_field('`q2` varchar(50) NULL ');
        $this->dbforge->add_field('`q3` varchar(50) NULL ');
        $this->dbforge->add_field('`q4` varchar(150) NULL ');
        $this->dbforge->add_field('`q5` text NULL ');
        $this->dbforge->add_field('`q6` varchar(50) NULL ');
        $this->dbforge->add_field("`company` varchar(150) NULL DEFAULT '-' ");
        $this->dbforge->add_field('`fullname` varchar(150) NULL ');
        $this->dbforge->add_field('`email` varchar(150) NULL ');
        $this->dbforge->add_field('`phone` varchar(150) NULL ');
        $this->dbforge->add_field('`address` varchar(150) NULL ');
        $this->dbforge->add_field('`city` varchar(150) NULL ');
        $this->dbforge->add_field('`zip` varchar(150) NULL ');
        $this->dbforge->add_field('`country` varchar(150) NULL ');
        $this->dbforge->add_field('`comment` text NULL ');
        $this->dbforge->add_field('`date` varchar(50) NULL ');
        $this->dbforge->add_field('`status` varchar(150) NULL ');
        $this->dbforge->add_field("`user_id` int(50) NULL DEFAULT '0'");
        $this->dbforge->add_field('`replied` varchar(50) NULL ');
        $this->dbforge->create_table('quotations', true);
    }

    public function down()
    {
        ### Drop table quotations ##
        $this->dbforge->drop_table('quotations', true);
    }
}
