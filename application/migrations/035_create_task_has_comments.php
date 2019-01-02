<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Create_task_has_comments extends CI_Migration {

	public function up() {

		## Create Table task_has_comments
		$this->dbforge->add_field("`id` bigint(255) unsigned NOT NULL auto_increment");
		$this->dbforge->add_key("id",true);
		$this->dbforge->add_field("`user_id` int(11) NULL ");
		$this->dbforge->add_field("`client_id` int(11) NULL ");
		$this->dbforge->add_field("`message` text NULL ");
		$this->dbforge->add_field("`datetime` varchar(20) NULL ");
		$this->dbforge->add_field("`attachment` varchar(255) NULL ");
		$this->dbforge->add_field("`task_id` bigint(20) NULL ");
		$this->dbforge->add_field("`attachment_link` varchar(255) NULL ");
		$this->dbforge->create_table("task_has_comments", TRUE);

	 }

	public function down()	{
		### Drop table task_has_comments ##
		$this->dbforge->drop_table("task_has_comments", TRUE);

	}
}