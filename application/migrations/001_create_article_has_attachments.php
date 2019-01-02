<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Create_article_has_attachments extends CI_Migration {

	public function up() {

		## Create Table article_has_attachments
		$this->dbforge->add_field("`id` bigint(20) NOT NULL auto_increment");
		$this->dbforge->add_key("id",true);
		$this->dbforge->add_field("`article_id` bigint(20) NULL ");
		$this->dbforge->add_field("`filename` varchar(250) NULL ");
		$this->dbforge->add_field("`savename` varchar(250) NULL ");
		$this->dbforge->create_table("article_has_attachments", TRUE);

	 }

	public function down()	{
		### Drop table article_has_attachments ##
		$this->dbforge->drop_table("article_has_attachments", TRUE);

	}
}