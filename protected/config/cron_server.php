<?php
return CMap::mergeArray(
	// наследуемся от main.php
	require(dirname(__FILE__).'/cron_common.php'),
	array(
		'components'=>array(
			// переопределяем компонент db
			'db'=>array(
				'connectionString' => 'mysql:host=localhost;dbname=bitfork_rate',
				'emulatePrepare' => true,
				'username' => 'root',
				'password' => '',
				'charset' => 'utf8',
				'schemaCachingDuration' => 86400,
			),
		),
	)
);