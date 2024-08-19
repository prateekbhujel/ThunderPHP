<?php

/**
 * Plugin name: Basic Authentication.
 * 
 * Description: Lets user login and signup.
 * 
 **/

set_value([

	'login_page'			=>'login',
	'signup_page'			=>'signup',
	'logout_page'			=>'logout',
	'forgot_page'			=>'forgot',
	'admin_plugin_route'	=>'admin',
	'tables'				=>	[
									'users_table' => 'users',			
								],

]);

/** Check if all required tables exist **/
$db = new \Core\Database();
$tables = get_value()['tables'];

if (!$db->table_exists($tables)) {
    $missingCount = count($db->missing_tables);
    $pluginId = plugin_id();

    if ($missingCount === 1) {
        ddd("Missing database table in {$pluginId} plugin: " . implode(", ", $db->missing_tables));
    } else {
        ddd("Missing database tables in {$pluginId} plugin: " . implode(", ", $db->missing_tables));
    }
}


/** run this after a form submit **/
add_action('controller',function(){

	$vars = get_value();
	$req  = new \Core\Request;
	$ses  = new \Core\Session;

	if($req->posted() && page() == $vars['login_page'])
	{
		require plugin_path('controllers/LoginController.php');
	}else
	if($req->posted() && page() == $vars['signup_page'])
	{
		require plugin_path('controllers/SignupController.php');
	}else
	if(page() == $vars['logout_page'])
	{
		require plugin_path('controllers/LogoutController.php');
	}
});

/** adding Menu to the links **/
add_filter('header-footer_before_menu_links', function($links){

	$ses  = new \Core\Session();
	$vars = get_value();

	$link 				= (object)[];
	$link->id 			= 0;
	$link->title 		= 'Login';
	$link->slug 		= 'login';
	$link->icon 		= '';
	$link->permission 	= 'not_logged_in';
	$links[] 			= $link;

	$link 				= (object)[];
	$link->id 			= 0;
	$link->title 		= 'Signup';
	$link->slug 		= 'signup';
	$link->icon 		= '';
	$link->permission 	= 'not_logged_in';
	$links[] 			= $link;

	$link				= (object)[];
	$link->id 			= 0;
	$link->title 		= 'Admin';
	$link->slug 		= $vars['admin_plugin_route'];
	$link->icon 		= '';
	$link->permission 	= 'logged_in';
	$links[]			= $link;
	
	$link 				= (object)[];
	$link->id 			= 0;
	$link->title 		= 'Hi, ' . $ses->user('first_name');
	$link->slug 		= 'profile/' . $ses->user('id');
	$link->icon 		= '';
	$link->permission 	= 'logged_in';
	$links[] 			= $link;

	$link				= (object)[];
	$link->id 			= 0;
	$link->title 		= 'Logout';
	$link->slug 		= 'logout';
	$link->icon 		= '';
	$link->permission 	= 'logged_in';
	$links[]			= $link;

	return $links;
});


/** displays the view file **/
add_action('view',function(){

	$vars = get_value();

	if(page() == $vars['login_page'])
	{
		require plugin_path('views/login.php');
	}else
	if(page() == $vars['signup_page'])
	{
		$errors = $vars['errors'] ?? [];
		require plugin_path('views/signup.php');
	}

});


/** for manipulating data after a query operation **/
add_filter('after_query',function($data){

	
	if(empty($data['result']))
		return $data;

	foreach ($data['result'] as $key => $row) {
		


	}

	return $data;
});


