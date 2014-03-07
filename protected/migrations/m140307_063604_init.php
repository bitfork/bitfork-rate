<?php

class m140307_063604_init extends CDbMigration
{
	public function up()
	{
		$this->createTable('service', array(
			'id' => 'pk',
			'name' => "varchar(512) NOT NULL",
			'is_active' => "tinyint(1) NOT NULL DEFAULT '1'",
			'create_date' => "datetime NOT NULL",
			'mod_date' => "datetime NOT NULL",
		));
		$this->insert('service',  array(
			"id" => "1",
			"name" => "btce",
			"is_active" => "1",
			"create_date" => date('Y-m-d H:i:s'),
			"mod_date" => date('Y-m-d H:i:s')
		));
		$this->insert('service',  array(
			"id" => "2",
			"name" => "bitstamp",
			"is_active" => "1",
			"create_date" => date('Y-m-d H:i:s'),
			"mod_date" => date('Y-m-d H:i:s')
		));

		$this->createTable('course', array(
			'id' => 'pk',
			'id_service' => "int(11) NOT NULL",
			'id_currency' => "int(11) NOT NULL",
			'high' => "double NOT NULL",
			'low' => "double NOT NULL",
			'avg' => "double DEFAULT NULL",
			'vol' => "double DEFAULT NULL",
			'vol_cur' => "double DEFAULT NULL",
			'last' => "double DEFAULT NULL",
			'buy' => "double DEFAULT NULL",
			'sell' => "double DEFAULT NULL",
			'updated' => "datetime DEFAULT NULL",
			'server_time' => "datetime DEFAULT NULL",
			'is_active' => "tinyint(1) NOT NULL DEFAULT '1'",
			'create_date' => "datetime NOT NULL",
			'mod_date' => "datetime NOT NULL",
		));

		$this->createTable('rate_index', array(
			'id' => 'pk',
			'period' => "int(11) NOT NULL",
			'servises' => "text NOT NULL",
			'services_hash' => "varchar(32) NOT NULL",
			'index' => "double NOT NULL",
			'data' => "text NOT NULL",
			'is_active' => "tinyint(1) NOT NULL DEFAULT '1'",
			'create_date' => "datetime NOT NULL",
			'mod_date' => "datetime NOT NULL",
		));
	}

	public function down()
	{
		echo "m140307_063604_init does not support migration down.\n";
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