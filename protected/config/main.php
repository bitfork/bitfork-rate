<?php
if ($_SERVER['HTTP_HOST']=='bitfork'){
	return require (dirname(__FILE__).'/main_local.php');
} else {
	return require (dirname(__FILE__).'/main_server.php');
}