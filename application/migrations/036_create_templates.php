<?php defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Create_templates extends CI_Migration
{
    public function up()
    {
        ## Create Table templates
        $this->dbforge->add_field('`id` int(11) NOT NULL auto_increment');
        $this->dbforge->add_key('id', true);
        $this->dbforge->add_field('`type` varchar(250) NOT NULL ');
        $this->dbforge->add_field('`name` varchar(250) NOT NULL ');
        $this->dbforge->add_field('`text` text NULL ');
        $this->dbforge->add_field('`updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP');
        $this->dbforge->create_table('templates', true);
    }

    public function down()
    {
        ### Drop table templates ##
        $this->dbforge->drop_table('templates', true);
    }
}
