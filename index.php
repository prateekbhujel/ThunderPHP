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
$APP['URL'] = split_url($_GET['url'] ?? 'home');
$USER_DATA  = [];

/*|-----------------------|
  |  Loading the Plugin   |
  |-----------------------| 
*/
 $PLUGINS = get_plugin_folders();

 $plugin_style ="font-family: tahoma; color: red; margin-top: 19%;";
 $plugin_msg   ="No Plugins Were Found! Please Load at least one plugin in the plugins folder.";
 if(!load_plugins($PLUGINS))
 	die("<center><h1 style='$plugin_style'>$plugin_msg</h1></center>");


$app = new \Core\App();
$app->index();