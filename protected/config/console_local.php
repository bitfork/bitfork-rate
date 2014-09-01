<?php
return CMap::mergeArray(
	require(dirname(__FILE__).'/console_common.php'),
	array(
		'components'=>array(
			// переопределяем компонент db
			'db'=>array(
				'class'=>'system.db.CDbConnection',
				'connectionString' => 'mysql:host=localhost;dbname=bitfork',
				'emulatePrepare' => true,
				'username' => 'root',
				'password' => '',
				'charset' => 'utf8',
				'initSQLs'=>array("SET time_zone = '+00:00'"),
			),
		),
	)
);