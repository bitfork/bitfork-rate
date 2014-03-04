<?php
return CMap::mergeArray(
	// наследуемся от main.php
	require(dirname(__FILE__).'/cron_common.php'),
	array(
		'language' => 'en',

		'components'=>array(
			// переопределяем компонент db
			'db'=>array(
				'class'=>'system.db.CDbConnection',
				'connectionString' => 'mysql:host=localhost;dbname=bitfork',
				'emulatePrepare' => true,
				'username' => 'root',
				'password' => '',
				'charset' => 'utf8',
			),
		),
		'params'=>array(
			'local'=>true, // на локалке для подстановки ip для запуска консольных команд
		),
	)
);