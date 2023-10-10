<?php

/** Splits the query string of the url **/
function split_url($url)
{

	return explode("/", trim($url, '/'));
}

/** Splits the gets the key from URL **/
function URL($key = '')
{
	global $APP;

	if(!empty($key))
	{
		if(!empty($APP['URL'][$key]))
		{
			return $APP['URL'][$key];
		}
	} else {
		return $APP['URL'];
	}

	return '';
}

/** Gets all the folder from plugin folder**/
function get_plugin_folders()
{
	$plugins_folder = 'plugins/';
	$res     = [];
	$folders = scandir($plugins_folder);
	foreach ($folders as $folder) {
		if($folder != '.' && $folder != '..' && is_dir($plugins_folder . $folder))
			$res[] = $folder;
	}

	return $res;
}

/** Loads all the plugins from the plugin folder and checks that exists. **/
function load_plugins($plugin_folders)
{
	$found = false;

	foreach($plugin_folders as $folder) {

		$found = true;

	}

	return $found;
}