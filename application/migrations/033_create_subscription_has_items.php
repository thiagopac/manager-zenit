<?php defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Create_subscription_has_items extends CI_Migration
{
    public function up()
    {
        ## Create Table subscription_has_items
        $this->dbforge->add_field('`id` int(10) NOT NULL auto_increment');
        $this->dbforge->add_key('id', true);
        $this->dbforge->add_field('`subscription_id` int(11) NOT NULL ');
        $this->dbforge->add_field('`item_id` int(11) NOT NULL ');
        $this->dbforge->add_field("`amount` char(11) NULL DEFAULT '0'");
        $this->dbforge->add_field('`description` mediumtext NULL ');
        $this->dbforge->add_field("`value` float NULL DEFAULT '0'");
        $this->dbforge->add_field('`name` varchar(250) NULL ');
        $this->dbforge->add_field('`type` varchar(250) NULL ');
        $this->dbforge->create_table('subscription_has_items', true);
    }

    public function down()
    {
        ### Drop table subscription_has_items ##
        $this->dbforge->drop_table('subscription_has_items', true);
    }
}
