<?php
return CMap::mergeArray(
	require(dirname(__FILE__).'/console_common.php'),
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