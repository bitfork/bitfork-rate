<?php
return CMap::mergeArray(
	require(dirname(__FILE__).'/console_common.php'),
	array(
		'components'=>array(
			// переопределяем компонент db
			'db'=>array(
				'class'=>'system.db.CDbConnection',
				'connectionString' => 'mysql:host=localhost;dbname=bittest',
				'emulatePrepare' => true,
				'username' => 'root',
				'password' => '',
				'charset' => 'utf8',
			),
		),
	)
);