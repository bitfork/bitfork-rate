<?php
error_reporting(E_ALL);
ini_set('display_errors',1);
ini_set('date.timezone', 'Europe/Moscow');
//date_default_timezone_set("UTC");

// change the following paths if necessary
$yii=dirname(__FILE__).'/../framework/yii.php';
//$yii=dirname(__FILE__).'/../framework/yii.php';

if ($_SERVER['HTTP_HOST']=='bitfork'){
	defined('YII_DEBUG') or define('YII_DEBUG',true);
} else {
	defined('YII_DEBUG') or define('YII_DEBUG',false);
	//define('YII_ENABLE_ERROR_HANDLER', false);
	//define('YII_ENABLE_EXCEPTION_HANDLER', false);
}

$config=dirname(__FILE__).'/protected/config/main.php';
// specify how many levels of call stack should be shown in each log message
defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL',3);

require_once($yii);
Yii::createWebApplication($config)->run();