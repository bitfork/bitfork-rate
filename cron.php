<?php
ini_set('memory_limit','128M');
ini_set('date.timezone', 'Europe/Moscow');

defined('YII_DEBUG') or define('YII_DEBUG',false);

// подключаем файл инициализации Yii
//require_once(dirname(__FILE__).'/../framework/yii.php');
require_once(dirname(__FILE__).'/../framework/yii.php');

// файл конфигурации будет отдельный
$configFile=dirname(__FILE__).'/protected/config/cron.php';

define('SERVER_ROOT', dirname(__FILE__));

// создаем и запускаем экземпляр приложения
Yii::createConsoleApplication($configFile)->run();
