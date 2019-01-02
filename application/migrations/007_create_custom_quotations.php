<?php defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Create_custom_quotations extends CI_Migration
{
    public function up()
    {
        ## Create Table custom_quotations
        $this->dbforge->add_field('`id` int(10) NOT NULL auto_increment');
        $this->dbforge->add_key('id', true);
        $this->dbforge->add_field('`name` varchar(250) NULL ');
        $this->dbforge->add_field('`formcontent` longtext NULL ');
        $this->dbforge->add_field("`inactive` int(250) NULL DEFAULT '0'");
        $this->dbforge->add_field('`user_id` int(11) NULL ');
        $this->dbforge->add_field('`created` varchar(50) NULL ');
        $this->dbforge->create_table('custom_quotations', true);
    }

    public function down()
    {
        ### Drop table custom_quotations ##
        $this->dbforge->drop_table('custom_quotations', true);
    }
}
