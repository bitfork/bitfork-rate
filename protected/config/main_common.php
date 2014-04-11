<?php

YiiBase::setPathOfAlias('btc', realpath(__DIR__ . '/../extensions/btc'));
YiiBase::setPathOfAlias('sse', realpath(__DIR__ . '/../extensions/sse'));
YiiBase::setPathOfAlias('rest', realpath(__DIR__ . '/../extensions/yii-rest-api/library/rest'));

return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'bitfork',
	'language' => 'en',

	// preloading 'log' component
	'preload'=>array('log','restService'),

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
		'api',
	),

	// application components
	'components'=>array(
		'restService' => array(
			'class' => '\rest\MyRestService',
			'enable' => isset($_SERVER['REQUEST_URI']) && (strpos($_SERVER['REQUEST_URI'], '/api/') !== false), //for example
			'authAdapterConfig' => array(
				'class' => '\rest\service\auth\adapters\NoAuth',
			)
		),
		'clientScript'=>array(
			'coreScriptPosition'=>CClientScript::POS_END,
			'scriptMap' => array(
				'jquery.js'=>false,
				'jquery.min.js'=>false,
			),
			'packages'=>array(
				'app' => array(
					'baseUrl'=>'/themes/coin/assets',
					'js'=>array(
						'js/css3-mediaqueries.js',
						'js/jquery.placeholder-enhanced/jquery.placeholder-enhanced.min.js',
						'js/fancyBox/source/jquery.fancybox.pack.js',
						'js/fancyBox/source/helpers/jquery.fancybox-media.js',
						'js/fancyBox/lib/jquery.mousewheel-3.0.6.pack.js',
						'js/jquery-ui-1.10.4.custom/js/jquery-ui-1.10.4.custom.min.js',
						'js/ScrollToFixed/jquery-scrolltofixed-min.js',
						'js/bitforkrate.js',
					),
				),
				'chart' => array(
					'baseUrl'=>'/themes/coin/assets/js/highstock',
					'js'=>array('highstock.js', 'modules/exporting.js'),
				),
			),
		),
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
       	'request'=>array(
			'class'=>'DLanguageHttpRequest',
        ),
		// uncomment the following to enable URLs in path-format
		'urlManager'=>array(
			'class'=>'DLanguageUrlManager',
			'showScriptName'=>false,
			'urlFormat'=>'path',
			'rules'=>CMap::mergeArray(
				require(dirname(__FILE__) . '/api_rules.php'),
				array(
					'/'=>'course/index',
					'<controller:\w+>/<id:\d+>'=>'<controller>/view',
					'<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
					'<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
				)
			),
		),
		'db'=>array(
			'connectionString' => 'mysql:host=localhost;dbname=bitfork_rate',
			'emulatePrepare' => true,
			'username' => 'bitfork_rate',
			'password' => 'US3W6yem',
			'charset' => 'utf8',
			'tablePrefix' => '',
			'schemaCachingDuration' => 86400,
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
			),
		),
		'cache'=>array(
			'class'=>'system.caching.CFileCache', // используем кэш на файлах
			'keyPrefix'=>'3258a5f0',
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