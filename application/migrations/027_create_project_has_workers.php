<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Create_project_has_workers extends CI_Migration {

	public function up() {

		## Create Table project_has_workers
		$this->dbforge->add_field("`id` int(10) NOT NULL auto_increment");
		$this->dbforge->add_key("id",true);
		$this->dbforge->add_field("`project_id` int(10) NULL ");
		$this->dbforge->add_field("`user_id` int(10) NULL ");
		$this->dbforge->create_table("project_has_workers", TRUE);

	 }

	public function down()	{
		### Drop table project_has_workers ##
		$this->dbforge->drop_table("project_has_workers", TRUE);

	}
}