<?php

class m140603_112423_currency_intermediate extends CDbMigration
{
	public function up()
	{
		$this->addColumn('pair','id_currency_intermed',"INT NULL DEFAULT NULL AFTER `id_currency_from`");
	}

	public function down()
	{
		echo "m140603_112423_currency_intermediate does not support migration down.\n";
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