<?php

session_start();

$minPHPVersion = '8.0';
if(phpversion() < $minPHPVersion)
	die("You need a minimum of PHP version $minPHPVersion to run this app.");

define('DS', DIRECTORY_SEPARATOR);
define('ROOTPATH', __DIR__.DS);

require 'config.php';
require 'app'. DS .'core'. DS .'init.php';

DEBUG ? ini_set('display_errors', 1) : ini_set('display_errors', 0);

$ACTIONS    = [];
$FILTERS    = [];
$APP['URL'] = split_url();

$app = new \Core\App();
$app->index();