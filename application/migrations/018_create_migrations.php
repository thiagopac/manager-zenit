<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Create_migrations extends CI_Migration {

	public function up() {

		## Create Table migrations
		$this->dbforge->add_field("`version` int(3) NOT NULL ");
		$this->dbforge->create_table("migrations", TRUE);

	 }

	public function down()	{
		### Drop table migrations ##
		$this->dbforge->drop_table("migrations", TRUE);

	}
}