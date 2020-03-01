<?php

/**
 * Front controller
 *
 * PHP version 7.3
 */
mb_internal_encoding("UTF-8"); 

define('DS', DIRECTORY_SEPARATOR);
define('BASE_PATH', __DIR__ . DS);
define('START', (float) microtime(true));
define('ROOT', dirname(__DIR__));

session_start();

if(version_compare(PHP_VERSION, '7.2', '<'))
{ 
	throw new \Exception('ОШИБКА! Версия PHP должна быть 7.2 и больше.'); 
}

error_reporting(E_ALL); 

require ROOT.'/App/bootstrap.php';

$stopTime = (float) microtime(true);
$time = round($stopTime - START, 4);

echo '<div class="text-center">'.$time.'ms</div>';
