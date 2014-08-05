<?php
if (isset($_SERVER['windir'])) {
	$yiic=dirname(__FILE__).'/../../framework/yiic.php';
} else {
	$yiic=dirname(__FILE__).'/../../private/framework/yiic.php';
}

$config=dirname(__FILE__).'/config/console.php';

require_once($yiic);
