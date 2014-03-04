<?php
return CMap::mergeArray(
	// наследуемся от main.php
	require(dirname(__FILE__).'/main_common.php'),
	array(
    	'theme'=>'coin',
		'defaultController'=>'course',
	)
);