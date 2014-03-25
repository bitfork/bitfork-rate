<?php

class m140325_063632_currency_pair extends CDbMigration
{
	public function up()
	{
		$this->addColumn('currency','round',"INT NOT NULL DEFAULT '8' AFTER `symbol`");

		$this->insert('currency',  array(
			"id" => "3",
			"name" => "LTC",
			"symbol" => "LTC",
			"round" => "8",
			"is_active" => "1",
			"create_date" => date('Y-m-d H:i:s'),
			"mod_date" => date('Y-m-d H:i:s')
		));
		$this->insert('currency',  array(
			"id" => "4",
			"name" => "VTC",
			"symbol" => "VTC",
			"round" => "8",
			"is_active" => "1",
			"create_date" => date('Y-m-d H:i:s'),
			"mod_date" => date('Y-m-d H:i:s')
		));
		$this->insert('currency',  array(
			"id" => "5",
			"name" => "DOGE",
			"symbol" => "DOGE",
			"round" => "8",
			"is_active" => "1",
			"create_date" => date('Y-m-d H:i:s'),
			"mod_date" => date('Y-m-d H:i:s')
		));

		$this->update('currency', array('round' => '2'), 'id=1');

		$this->insert('pair',  array(
			"id" => "2",
			"id_currency" => "2",
			"id_currency_from" => "3",
			"is_active" => "1",
			"create_date" => date('Y-m-d H:i:s'),
			"mod_date" => date('Y-m-d H:i:s')
		));
		$this->insert('pair',  array(
			"id" => "3",
			"id_currency" => "2",
			"id_currency_from" => "4",
			"is_active" => "1",
			"create_date" => date('Y-m-d H:i:s'),
			"mod_date" => date('Y-m-d H:i:s')
		));
		$this->insert('pair',  array(
			"id" => "4",
			"id_currency" => "2",
			"id_currency_from" => "5",
			"is_active" => "1",
			"create_date" => date('Y-m-d H:i:s'),
			"mod_date" => date('Y-m-d H:i:s')
		));

		$this->insert('service',  array(
			"id" => "3",
			"name" => "btcchina",
			"is_active" => "0",
			"create_date" => date('Y-m-d H:i:s'),
			"mod_date" => date('Y-m-d H:i:s')
		));
		$this->insert('service',  array(
			"id" => "4",
			"name" => "vircurex",
			"is_active" => "1",
			"create_date" => date('Y-m-d H:i:s'),
			"mod_date" => date('Y-m-d H:i:s')
		));
		$this->insert('service',  array(
			"id" => "5",
			"name" => "cryptsy",
			"is_active" => "1",
			"create_date" => date('Y-m-d H:i:s'),
			"mod_date" => date('Y-m-d H:i:s')
		));
		$this->insert('service',  array(
			"id" => "6",
			"name" => "bter",
			"is_active" => "1",
			"create_date" => date('Y-m-d H:i:s'),
			"mod_date" => date('Y-m-d H:i:s')
		));

		$this->insert('service_pair',  array(
			"id" => "3",
			"id_service" => "4",
			"id_pair" => "2",
			"is_active" => "1",
			"create_date" => date('Y-m-d H:i:s'),
			"mod_date" => date('Y-m-d H:i:s')
		));
		$this->insert('service_pair',  array(
			"id" => "4",
			"id_service" => "4",
			"id_pair" => "3",
			"is_active" => "1",
			"create_date" => date('Y-m-d H:i:s'),
			"mod_date" => date('Y-m-d H:i:s')
		));
		$this->insert('service_pair',  array(
			"id" => "5",
			"id_service" => "4",
			"id_pair" => "4",
			"is_active" => "1",
			"create_date" => date('Y-m-d H:i:s'),
			"mod_date" => date('Y-m-d H:i:s')
		));
		$this->insert('service_pair',  array(
			"id" => "6",
			"id_service" => "5",
			"id_pair" => "2",
			"is_active" => "1",
			"create_date" => date('Y-m-d H:i:s'),
			"mod_date" => date('Y-m-d H:i:s')
		));
		$this->insert('service_pair',  array(
			"id" => "7",
			"id_service" => "5",
			"id_pair" => "3",
			"is_active" => "1",
			"create_date" => date('Y-m-d H:i:s'),
			"mod_date" => date('Y-m-d H:i:s')
		));
		$this->insert('service_pair',  array(
			"id" => "8",
			"id_service" => "5",
			"id_pair" => "4",
			"is_active" => "1",
			"create_date" => date('Y-m-d H:i:s'),
			"mod_date" => date('Y-m-d H:i:s')
		));
		$this->insert('service_pair',  array(
			"id" => "9",
			"id_service" => "6",
			"id_pair" => "2",
			"is_active" => "1",
			"create_date" => date('Y-m-d H:i:s'),
			"mod_date" => date('Y-m-d H:i:s')
		));
		$this->insert('service_pair',  array(
			"id" => "10",
			"id_service" => "6",
			"id_pair" => "3",
			"is_active" => "1",
			"create_date" => date('Y-m-d H:i:s'),
			"mod_date" => date('Y-m-d H:i:s')
		));
		$this->insert('service_pair',  array(
			"id" => "11",
			"id_service" => "6",
			"id_pair" => "4",
			"is_active" => "1",
			"create_date" => date('Y-m-d H:i:s'),
			"mod_date" => date('Y-m-d H:i:s')
		));
	}

	public function down()
	{
		echo "m140325_063632_currency_pair does not support migration down.\n";
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