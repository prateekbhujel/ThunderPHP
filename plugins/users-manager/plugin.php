<?php
/**
 * Plugin name: users-manager
 * Description: A way for admin to manage users.
 * 
 * 
**/
set_value([
	'admin_route'			=>'admin',
	'plugin_route'			=>'users',
	'tables'				=> [
		'users_table'     	=> 'users', 			// will contains users details here.
	],
	'optional_tables'		=> [
		'roles_table' 	  	=> 'user_roles', 		// users roles are here [One user can have an multiple roles].
		'permissions_table' => 'role_permissions',	// contains all the permissions of the User.
		'roles_map_table' 	=> 'user_roles_map', 	// users assigned roles [which users mapped which roles].
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

/** set user permissions for this plugin **/
add_filter('permissions',function($permissions)
{
	$permissions[] = 'all';
	$permissions[] = 'view_users';
	$permissions[] = 'view_user_details';
	$permissions[] = 'add_user';
	$permissions[] = 'edit_user';
	$permissions[] = 'delete_user';

	return $permissions;
});

/** add to admin links **/
add_filter('basic-admin_before_admin_links',function($links)
{
	if(user_can('view_users'))
	{
		$vars        = get_value();
		$obj         = (object)[];
		$obj->title  = 'Users';
		$obj->link   = ROOT . '/' . $vars['admin_route'] . '/' .$vars['plugin_route'];
		$obj->icon   = 'fas fa-people-group';
		$obj->parent = 0;
		$links[]  	 = $obj;
	}
		return $links;
});

/** run this after a form submit **/
add_action('controller',function(){
	$req = new \Core\Request;
	$vars = get_value();
	$admin_route = $vars['admin_route'];
	$plugin_route = $vars['plugin_route'];

	if(URL(1) == $vars['plugin_route'] && $req->posted())
	{
		$ses 	= new \Core\Session();
		$user 	= new \UsersManager\User();
		$id = URL(3) ?? null;
		if($id)
			$row = $user->first(['id'=>$id]);

		if(URL(2) == 'add')
		{
			require plugin_path('controllers/add-controller.php');
		}else
		if(URL(2) == 'edit')
		{
			require plugin_path('controllers/edit-controller.php');
		}else
		if(URL(2) == 'delete')
		{
			require plugin_path('controllers/delete-controller.php');
		}
	}
});


/** displays the view file **/
add_action('basic-admin_main_content',function(){

	$ses = new \Core\Session;
	$vars = get_value();
	
	$admin_route = $vars['admin_route'];
	$plugin_route = $vars['plugin_route'];
	$user = new \UsersManager\User;
	
	$errors = $vars['errors'] ?? [];

	if(URL(1) == $vars['plugin_route'])
	{

		$id = URL(3) ?? null;
		
		if($id)
			$row = $user->first(['id'=>$id]);

		if(URL(2) == 'add')
		{
			require plugin_path('views/add.php');

		}else
		if(URL(2) == 'edit')
		{
			
			require plugin_path('views/edit.php');

		}else
		if(URL(2) == 'delete')
		{

			require plugin_path('views/delete.php');

		}else
		if(URL(2) == 'view')
		{

			require plugin_path('views/view.php');

		}else
		{

			$user->limit = 30;
			$rows = $user->getAll();
			require plugin_path('views/list.php');

		}
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


