<?php

class m140508_055030_archive extends CDbMigration
{
	public function up()
	{
		$this->createTable('rate_index_archive', array(
			'id' => 'pk',
			'period' => "int(11) NOT NULL",
			'servises' => "text NOT NULL",
			'services_hash' => "varchar(32) NOT NULL",
			'index' => "double NOT NULL",
			'id_currency' => "int(11) NOT NULL",
			'id_currency_from' => "int(11) NOT NULL",
			'change_state' => "int(11) NOT NULL DEFAULT '0'",
			'change_percent' => "float NOT NULL DEFAULT '0'",
			'data' => "text NOT NULL",
			'is_active' => "tinyint(1) NOT NULL DEFAULT '1'",
			'create_date' => "datetime NOT NULL",
			'mod_date' => "datetime NOT NULL",
		));
		$this->createIndex('period', 'rate_index_archive', 'period');
		$this->createIndex('id_currency', 'rate_index_archive', 'id_currency');
		$this->createIndex('id_currency_from', 'rate_index_archive', 'id_currency_from');
		$this->createTable('course_archive', array(
			'id' => 'pk',
			'id_service' => "int(11) NOT NULL",
			'id_currency' => "int(11) NOT NULL",
			'id_currency_from' => "int(11) NOT NULL",
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
			'change_state' => "int(11) NOT NULL DEFAULT '0'",
			'change_percent' => "float NOT NULL DEFAULT '0'",
			'is_active' => "tinyint(1) NOT NULL DEFAULT '1'",
			'create_date' => "datetime NOT NULL",
			'mod_date' => "datetime NOT NULL",
		));
		$this->createIndex('id_service', 'course_archive', 'id_service');
		$this->createIndex('id_currency', 'course_archive', 'id_currency');
		$this->createIndex('id_currency_from', 'course_archive', 'id_currency_from');
	}

	public function down()
	{
		echo "m140508_055030_archive does not support migration down.\n";
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