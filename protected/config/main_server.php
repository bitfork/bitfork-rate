<?php
return CMap::mergeArray(
	// наследуемся от main.php
	require(dirname(__FILE__).'/main_common.php'),
	array(
    	'theme'=>'coin',
		'defaultController'=>'course',
		'components'=>array(
			// переопределяем компонент db
			'db'=>array(
				'connectionString' => 'mysql:host=localhost;dbname=bitfork_rate',
				'emulatePrepare' => true,
				'username' => 'bitfork_rate',
				'password' => '3CSwhQ7H',
				'charset' => 'utf8',
				'tablePrefix' => '',
				'schemaCachingDuration' => 86400,
			),
		),
	)
);