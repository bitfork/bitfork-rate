<?php

class m140411_105459_link_project extends CDbMigration
{
	public function up()
	{
		$this->createTable('link_project', array(
			'id' => 'pk',
			'url' => "varchar(2048) NOT NULL",
			'email' => "varchar(2048) DEFAULT NULL",
			'is_active' => "tinyint(1) NOT NULL DEFAULT '1'",
			'create_date' => "datetime NOT NULL",
			'mod_date' => "datetime NOT NULL",
		));
	}

	public function down()
	{
		echo "m140411_105459_link_project does not support migration down.\n";
		return false;
	}

	/*
	// Use safeUp/safeDown to do migration with transaction
	public function safeUp()
	{
	}

	public function safeDown()
	{
	}
	*/
}