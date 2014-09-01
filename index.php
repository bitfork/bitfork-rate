<?php
error_reporting(E_ALL);
ini_set('display_errors',1);

if ($_SERVER['HTTP_HOST']=='bitfork'){
	defined('YII_DEBUG') or define('YII_DEBUG',true);
	$yii=dirname(__FILE__).'/../framework/yii.php';
} else {
	defined('YII_DEBUG') or define('YII_DEBUG',false);
	$yii=dirname(__FILE__).'/../private/framework/yii.php';
}

$config=dirname(__FILE__).'/protected/config/main.php';
// specify how many levels of call stack should be shown in each log message
defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL',3);

require_once($yii);
Yii::createWebApplication($config)->run();