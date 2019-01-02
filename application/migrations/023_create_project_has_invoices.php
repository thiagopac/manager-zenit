<?php defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Create_project_has_invoices extends CI_Migration
{
    public function up()
    {
        ## Create Table project_has_invoices
        $this->dbforge->add_field('`id` bigint(20) NOT NULL auto_increment');
        $this->dbforge->add_key('id', true);
        $this->dbforge->add_field('`project_id` bigint(20) NOT NULL ');
        $this->dbforge->add_field('`invoice_id` bigint(20) NOT NULL ');
        $this->dbforge->create_table('project_has_invoices', true);
    }

    public function down()
    {
        ### Drop table project_has_invoices ##
        $this->dbforge->drop_table('project_has_invoices', true);
    }
}
