<?php
error_reporting(E_ALL);
ini_set('display_errors',1);
ini_set('date.timezone', 'Europe/Moscow');

// change the following paths if necessary
$yii=dirname(__FILE__).'/../framework/yii.php';

if ($_SERVER['HTTP_HOST']=='bitfork'){
	defined('YII_DEBUG') or define('YII_DEBUG',true);
	defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL',3);
} else {
	defined('YII_DEBUG') or define('YII_DEBUG',false);
}

$config=dirname(__FILE__).'/protected/config/main.php';
// specify how many levels of call stack should be shown in each log message

require_once($yii);


function error_handler($errno, $errstr, $errfile, $errline) {
	switch ($errno) {
		case E_NOTICE:
		case E_USER_NOTICE:
			$error = 'Notice';
			break;
		case E_WARNING:
		case E_USER_WARNING:
			$error = 'Warning';
			break;
		case E_ERROR:
		case E_USER_ERROR:
			$error = 'Fatal Error';
			break;
		default:
			$error = 'Unknown';
			break;
	}

	if (true) {
		echo '<b>' . $error . '</b>: ' . $errstr . ' in <b>' . $errfile . '</b> on line <b>' . $errline . '</b>';
	}

	if (false) {
		//$log->write('PHP ' . $error . ':  ' . $errstr . ' in ' . $errfile . ' on line ' . $errline);
	}

	return true;
}

// Error Handler
//set_error_handler('error_handler');





Yii::createWebApplication($config)->run();