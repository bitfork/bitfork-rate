<?php

class m140321_112620_currency extends CDbMigration
{
	public function up()
	{
		$this->createTable('currency', array(
			'id' => 'pk',
			'name' => "varchar(50) NOT NULL",
			'symbol' => "varchar(10) NOT NULL",
			'is_active' => "tinyint(1) NOT NULL DEFAULT '1'",
			'create_date' => "datetime NOT NULL",
			'mod_date' => "datetime NOT NULL",
		));
		$this->insert('currency',  array(
			"id" => "1",
			"name" => "USD",
			"symbol" => "$",
			"is_active" => "1",
			"create_date" => date('Y-m-d H:i:s'),
			"mod_date" => date('Y-m-d H:i:s')
		));
		$this->insert('currency',  array(
			"id" => "2",
			"name" => "BTC",
			"symbol" => "BTC",
			"is_active" => "1",
			"create_date" => date('Y-m-d H:i:s'),
			"mod_date" => date('Y-m-d H:i:s')
		));

		$this->createTable('pair', array(
			'id' => 'pk',
			'id_currency' => "int(11) NOT NULL",
			'id_currency_from' => "int(11) NOT NULL",
			'is_active' => "tinyint(1) NOT NULL DEFAULT '1'",
			'create_date' => "datetime NOT NULL",
			'mod_date' => "datetime NOT NULL",
		));
		$this->insert('pair',  array(
			"id" => "1",
			"id_currency" => "1",
			"id_currency_from" => "2",
			"is_active" => "1",
			"create_date" => date('Y-m-d H:i:s'),
			"mod_date" => date('Y-m-d H:i:s')
		));

		$this->createTable('service_pair', array(
			'id' => 'pk',
			'id_service' => "int(11) NOT NULL",
			'id_pair' => "int(11) NOT NULL",
			'is_active' => "tinyint(1) NOT NULL DEFAULT '1'",
			'create_date' => "datetime NOT NULL",
			'mod_date' => "datetime NOT NULL",
		));
		$this->insert('service_pair',  array(
			"id" => "1",
			"id_service" => "1",
			"id_pair" => "1",
			"is_active" => "1",
			"create_date" => date('Y-m-d H:i:s'),
			"mod_date" => date('Y-m-d H:i:s')
		));
		$this->insert('service_pair',  array(
			"id" => "2",
			"id_service" => "2",
			"id_pair" => "1",
			"is_active" => "1",
			"create_date" => date('Y-m-d H:i:s'),
			"mod_date" => date('Y-m-d H:i:s')
		));

		$this->addColumn('rate_index','id_currency',"INT NOT NULL AFTER `index`");
		$this->addColumn('rate_index','id_currency_from',"INT NOT NULL AFTER `id_currency`");
		$this->addColumn('course','id_currency_from',"INT NOT NULL AFTER `id_currency`");
	}

	public function down()
	{
		echo "m140321_112620_currency does not support migration down.\n";
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