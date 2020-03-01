<?php

return [
	'csrf' => [
		'size' => 50,
		'time' => 600,
		'name' => 'csrf',
	],
	'name' => 'Mini Core',
	'view' => [
		'path' => ROOT.'/App/Views/',
		'cachePath' => ROOT.'/cache/blade/',
	],
	'debug' => true
];
