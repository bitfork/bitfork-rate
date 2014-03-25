<?php
return array(
	array('api/<controller>/index', 'pattern' => 'api/<controller:(index)>/<from:\w+>/<to:\w+>/<period:\d+>', 'verb' => 'GET', 'parsingOnly' => true),
	array('api/<controller>/<action>', 'pattern' => 'api/<controller:(index)>/<action:\w+>/<from:\w+>/<to:\w+>/<period:\d+>', 'verb' => 'GET', 'parsingOnly' => true),

	array('api/<controller>/index', 'pattern' => 'api/<controller>', 'verb' => 'GET', 'parsingOnly' => true),
	array('api/<controller>/create', 'pattern' => 'api/<controller>', 'verb' => 'POST', 'parsingOnly' => true),
	array('api/<controller>/view', 'pattern' => 'api/<controller>/<id:\d+>', 'verb' => 'GET', 'parsingOnly' => true),
	array('api/<controller>/update', 'pattern' => 'api/<controller>/<id:\d+>', 'verb' => 'PUT', 'parsingOnly' => true),
	array('api/<controller>/delete', 'pattern' => 'api/<controller>/<id:\d+>', 'verb' => 'DELETE', 'parsingOnly' => true),
);