<?php

/**
 * Plugin name : 
 * Description : 
 * 
 */

set_value([

	'plugin_route' => "my-plugin",
	'table'        => "my_table",

]);

/**
 *  Set user permissions for the 
 *  plugin.
 */
add_filter('permissions', function($permission) {

	$permissions[] = "my_permission";

	return $permission;
});

/**
 *  Runs after the forms Submit.
 */
add_action('controller', function() {
	
	$vars = get_value();

	require plugin_path('controllers/controller.php');
});

/**
 *  Display the view file.
 */
add_action('view', function() {

	$vars = get_value();

	require plugin_path('views/view.php');
});

/**
 *  For manipulating data after a 
 *  query operation.
 */
add_filter('after_query', function($data) {

	if(empty($data['result']))
		return $data;

	foreach ($data['result'] as $key => $row) {


	}
});

