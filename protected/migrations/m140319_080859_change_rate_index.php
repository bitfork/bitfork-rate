<?php

class m140319_080859_change_rate_index extends CDbMigration
{
	public function up()
	{
		$this->addColumn('rate_index','change_state',"INT NOT NULL DEFAULT '0' AFTER `index`");
		$this->addColumn('rate_index','change_percent',"FLOAT NOT NULL DEFAULT '0' AFTER `change_state`");
	}

	public function down()
	{
		echo "m140319_080859_change_rate_index does not support migration down.\n";
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