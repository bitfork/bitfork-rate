<?php

YiiBase::setPathOfAlias('btc', realpath(__DIR__ . '/../extensions/btc'));
YiiBase::setPathOfAlias('sse', realpath(__DIR__ . '/../extensions/sse'));

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'bitfork',
	'language' => 'en',

	// preloading 'log' component
	'preload'=>array('log'),

	// autoloading model and component classes
	'import'=>require(dirname(__FILE__) . '/import.php'),

	'modules'=>array(
		'user' => array(
			// названия таблиц взяты по умолчанию, их можно изменить# encrypting method (php hash function)
			'hash' => 'md5',
			// send activation email
			'sendActivationMail' => false,
			// allow access for non-activated users
			'loginNotActiv' => true,
			// activate user on registration (only sendActivationMail = false)
			'activeAfterRegister' => true,
			// automatically login from registration
			'autoLogin' => true,
			// registration path
			//'registrationUrl' => array('/shop/default/registration'),
			'registrationUrl' => array('/user/registration'),
			// recovery password path
			'recoveryUrl' => array('/user/recovery'),
			// login form path
			'loginUrl' => array('/user/login'),
			// page after login
			//'returnUrl' => array('/user/profile'),
			'returnUrl' => array('/site/index'),
			// page after logout
			'returnLogoutUrl' => array('/user/login'),
			'tableUsers' => 'users',
			'tableProfiles' => 'users_profiles',
			'tableProfileFields' => 'users_profiles_fields',
			'captcha' => array('registration'=>false),
		),
		'rights',
	),

	// application components
	'components'=>array(
		'clientScript'=>array(
			'scriptMap' => array(
				'jquery.js'=>'/themes/coin/assets/plugins/jquery-1.8.3.min.js',
				'jquery.min.js'=>'/themes/coin/assets/plugins/jquery-1.8.3.min.js',
			)
		),
		/*'user'=>array(
			// enable cookie-based authentication
			'allowAutoLogin'=>true,
		),*/
		'user'=>array(
			// enable cookie-based authentication
			'allowAutoLogin'=>true,
			'class' => 'RWebUser',
			'loginUrl' => array('/user/login'),
		),
		'authManager'=>array(
			'class'=>'RDbAuthManager',
			'defaultRoles' => array('Guest') // дефолтная роль
		),
		// uncomment the following to enable URLs in path-format
		'urlManager'=>array(
			'showScriptName'=>false,
			'urlFormat'=>'path',
			'rules'=>array(
				'<controller:\w+>/<id:\d+>'=>'<controller>/view',
				'<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
				'<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
			),
		),
		'db'=>array(
			'connectionString' => 'mysql:host=localhost;dbname=bitfork_rate',
			'emulatePrepare' => true,
			'username' => 'bitfork_rate',
			'password' => 'US3W6yem',
			'charset' => 'utf8',
		),
		'errorHandler'=>array(
			// use 'site/error' action to display errors
			'errorAction'=>'site/error',
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
		'session' => array (
			'autoStart' => true,
		),
	),

	// application-level parameters that can be accessed
	// using Yii::app()->params['paramName']
	'params'=>require(dirname(__FILE__) . '/params.php'),
);