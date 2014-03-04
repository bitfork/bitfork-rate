<?php
return CMap::mergeArray(
	// наследуемся от main.php
	require(dirname(__FILE__).'/main_common.php'),
	array(
    	'theme'=>'coin',
		'defaultController'=>'course',

		'modules'=>array(
			'gii'=>array(
				'class'=>'system.gii.GiiModule',
				'password'=>'1',
				// If removed, Gii defaults to localhost only. Edit carefully to taste.
				'ipFilters'=>array('127.0.0.1'),
			),
		),

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