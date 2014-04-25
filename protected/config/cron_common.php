<?php

// uncomment the following to define a path alias
YiiBase::setPathOfAlias('btc', realpath(__DIR__ . '/../extensions/btc'));
YiiBase::setPathOfAlias('sse', realpath(__DIR__ . '/../extensions/sse'));
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'bitfork',
	'language' => 'ru',

	'aliases'=>array(
		'ws'=>realpath(__DIR__ . '/../extensions/websocket/components'),
	),

	// preloading 'log' component
	'preload'=>array('log'),

	// autoloading model and component classes
	'import'=>CMap::mergeArray(
		require(dirname(__FILE__) . '/import.php'),
		array(
			'ext.websocket.*',
			'ext.websocket.components.*',
		)
	),

	'modules'=>array(
	),

	// application components
	'components'=>array(
		'user'=>array(
			// enable cookie-based authentication
			'allowAutoLogin'=>true,
		),
		// uncomment the following to enable URLs in path-format
		/*
		'urlManager'=>array(
			'urlFormat'=>'path',
			'rules'=>array(
				'<controller:\w+>/<id:\d+>'=>'<controller>/view',
				'<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
				'<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
			),
		),
		*/
		'db'=>array(
			'connectionString' => 'mysql:host=localhost;dbname=bitfork_rate',
			'emulatePrepare' => true,
			'username' => 'bitfork_rate',
			'password' => 'US3W6yem',
			'charset' => 'utf8',
			'schemaCachingDuration' => 86400,
		),
		'log'=>array(
			'class'=>'CLogRouter',
			'routes'=>array(
				array(
					'class'=>'CFileLogRoute',
					'levels'=>'error, warning',
				),
				array(
					'class'=>'CEmailLogRoute',
					'levels'=>'error, warning',
					'emails'=>'vol4444@yandex.ru',
				),
				// uncomment the following to show log messages on web pages
				/*
				array(
					'class'=>'CWebLogRoute',
				),
				*/
			),
		),
		'cache'=>array(
			'class'=>'system.caching.CFileCache', // используем кэш на файлах
			'keyPrefix'=>'3258a5f0',
			//return $this->hashKey ? md5($this->keyPrefix.$key) : $this->keyPrefix.$key;
			// например 3258a5f0http://www.tuning-proekt.ru
			//'class'=>'system.caching.CDummyCache',
		),
		'exchange' => array(
			'class' => '\btc\Service',
		),
		'websocket' => array(
			'class' => 'ws.Websocket',
			'eventDriver' => '',
			'websocket' => 'tcp://5.9.120.183:8002',
			'localsocket' => 'tcp://5.9.120.183:8003',
		),
	),

	// application-level parameters that can be accessed
	// using Yii::app()->params['paramName']
	'params'=>require(dirname(__FILE__) . '/params.php'),
);