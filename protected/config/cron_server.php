<?php
return CMap::mergeArray(
	// наследуемся от main.php
	require(dirname(__FILE__).'/cron_common.php'),
	array(
	)
);