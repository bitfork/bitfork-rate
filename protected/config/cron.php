<?php
if (isset($_SERVER['windir'])) {
	return require (dirname(__FILE__).'/cron_local.php');
} else {
	return require (dirname(__FILE__).'/cron_server.php');
}