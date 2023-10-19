<?php

// Start a new session
session_start();

// Define the minimum required PHP version
$minPHPVersion = '8.0';

// Check if the PHP version is below the minimum required
if (phpversion() < $minPHPVersion) {
    die("You need a minimum of PHP version $minPHPVersion to run this app.");
}

// Define directory separator and root path
define('DS', DIRECTORY_SEPARATOR);
define('ROOTPATH', __DIR__ . DS);

// Include configuration and initialization files
require 'config.php';
require 'app' . DS . 'core' . DS . 'init.php';

// Enable or disable error display based on the DEBUG constant
DEBUG ? ini_set('display_errors', 1) : ini_set('display_errors', 0);

// Initialize arrays and variables
$ACTIONS = [];
$FILTERS = [];
$APP['URL'] = split_url($_GET['url'] ?? 'home');
$APP['permissions'] = [];
$USER_DATA = [];

/*|-----------------------|
  |  Loading the Plugin   |
  |-----------------------| 
*/

// Get a list of plugin folders
$PLUGINS = get_plugin_folders();

// Style and message for no plugins found
$plugin_style = "font-family: tahoma; color: red; margin-top: 19%;";
$plugin_msg = "No Plugins Were Found! Please Load at least one plugin in the plugins folder.";

// Check if any plugins were loaded, otherwise display a message
if (!load_plugins($PLUGINS)) {
    die("<center><h1 style='$plugin_style'>$plugin_msg</h1></center>");
}

// Apply filters to user permissions
$APP['permissions'] = do_filter('user_permissions', $APP['permissions']);

/*|-----------------------|
  |  Loads The App        |
  |-----------------------| 
*/

// Create a new instance of the App class and run the index method
$app = new \Core\App();
$app->index();
