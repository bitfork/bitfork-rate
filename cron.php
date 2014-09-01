<?php
ini_set('memory_limit','128M');

if (isset($_SERVER['windir'])) {
	defined('YII_DEBUG') or define('YII_DEBUG',true);
	require_once(dirname(__FILE__).'/../framework/yii.php');
} else {
	defined('YII_DEBUG') or define('YII_DEBUG',false);
	require_once(dirname(__FILE__).'/../private/framework/yii.php');
}

// файл конфигурации будет отдельный
$configFile=dirname(__FILE__).'/protected/config/cron.php';

define('SERVER_ROOT', dirname(__FILE__));

// создаем и запускаем экземпляр приложения
Yii::createConsoleApplication($configFile)->run();
