<?php defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Create_company_has_admins extends CI_Migration
{
    public function up()
    {
        ## Create Table company_has_admins
        $this->dbforge->add_field('`id` int(10) NOT NULL auto_increment');
        $this->dbforge->add_key('id', true);
        $this->dbforge->add_field('`company_id` int(10) NULL ');
        $this->dbforge->add_field('`user_id` int(10) NULL ');
        $this->dbforge->add_field('`access` varchar(255) NULL ');
        $this->dbforge->create_table('company_has_admins', true);
    }

    public function down()
    {
        ### Drop table company_has_admins ##
        $this->dbforge->drop_table('company_has_admins', true);
    }
}
