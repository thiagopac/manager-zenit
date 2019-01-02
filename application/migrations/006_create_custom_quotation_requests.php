<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Create_custom_quotation_requests extends CI_Migration {

	public function up() {

		## Create Table custom_quotation_requests
		$this->dbforge->add_field("`id` int(10) NOT NULL auto_increment");
		$this->dbforge->add_key("id",true);
		$this->dbforge->add_field("`form` longtext NULL ");
		$this->dbforge->add_field("`custom_quotation_id` int(11) NULL ");
		$this->dbforge->add_field("`date` varchar(50) NULL ");
		$this->dbforge->add_field("`status` varchar(50) NULL ");
		$this->dbforge->add_field("`user_id` int(10) NULL ");
		$this->dbforge->create_table("custom_quotation_requests", TRUE);

	 }

	public function down()	{
		### Drop table custom_quotation_requests ##
		$this->dbforge->drop_table("custom_quotation_requests", TRUE);

	}
}