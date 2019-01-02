<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Create_pw_reset extends CI_Migration {

	public function up() {

		## Create Table pw_reset
		$this->dbforge->add_field("`id` int(10) NOT NULL auto_increment");
		$this->dbforge->add_key("id",true);
		$this->dbforge->add_field("`email` varchar(250) NULL ");
		$this->dbforge->add_field("`timestamp` varchar(250) NULL ");
		$this->dbforge->add_field("`token` varchar(250) NULL ");
		$this->dbforge->add_field("`user` tinyint(4) NULL ");
		$this->dbforge->create_table("pw_reset", TRUE);

	 }

	public function down()	{
		### Drop table pw_reset ##
		$this->dbforge->drop_table("pw_reset", TRUE);

	}
}