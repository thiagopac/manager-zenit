<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Create_modules extends CI_Migration {

	public function up() {

		## Create Table modules
		$this->dbforge->add_field("`id` int(10) NOT NULL auto_increment");
		$this->dbforge->add_key("id",true);
		$this->dbforge->add_field("`name` varchar(250) NULL ");
		$this->dbforge->add_field("`link` varchar(250) NULL ");
		$this->dbforge->add_field("`type` varchar(250) NULL ");
		$this->dbforge->add_field("`icon` varchar(150) NULL ");
		$this->dbforge->add_field("`sort` int(10) NULL ");
		$this->dbforge->create_table("modules", TRUE);

	 }

	public function down()	{
		### Drop table modules ##
		$this->dbforge->drop_table("modules", TRUE);

	}
}