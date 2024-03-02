<?php

/**
 * Plugin name: Basic Admin
 * Description: Provides an basic admin area, with very minimalist feature.
 * 
 * 
 **/

set_value([

	'plugin_route'	=>'admin',

]);

/** set user permissions for this plugin **/
add_filter('permissions',function($permissions){

	$permissions[] = 'view_admin_page';

	return $permissions;
});


/** run this before a form submit **/
add_action('before_controller',function(){

	$vars = get_value();

	if(false && page() == $vars['plugin_route'] && !user_can('view_admin_page'))
	{
		message('Access denied! Please Try on a different Login route.');
		redirect('login');
	}
});

/** run this after a form submit **/
add_action('controller',function(){

	do_action(plugin_id() . '_controller');

});


/** displays the view file **/
add_action('view',function(){

	$vars = get_value();

	require plugin_path('views/view.php');
});
