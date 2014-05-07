<?php

class m140507_064414_course_change extends CDbMigration
{
	public function up()
	{
		$this->addColumn('course','change_state',"INT NOT NULL DEFAULT '0' AFTER `server_time`");
		$this->addColumn('course','change_percent',"FLOAT NOT NULL DEFAULT '0' AFTER `change_state`");
	}

	public function down()
	{
		echo "m140507_064414_course_change does not support migration down.\n";
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