<?php

$postdata = $req->post();
$filedata = $req->files();

$files_ok = true;
if(!empty($filedata))
{
	$postdata['image'] = $req->upload_files('image');

	if(!empty($req->upload_errors))
		$files_ok = false;
}

$csrf = csrf_verify($postdata);

if($csrf && $files_ok && $user->validate_insert($postdata))
{
	if(user_can('add_role'))
	{
		$postdata['password'] = password_hash($postdata['password'], PASSWORD_DEFAULT);

		$postdata['date_created'] = date('Y-m-d H:i:s');

		$user->insert($postdata);
		/** Save user roles. **/
	    $user_id = $user->insert_id;
		if(user_can('edit_role'))
	    {
	        $roledata = [];
	        foreach ($postdata as $key => $role_id)
	        {
	            if (!strstr($key , "checkbox_"))
	                continue;

	            $roledata[] = $role_id;
	        }
	        /** Disable all all roles. **/
	        $user_roles_map->query('UPDATE ' . $vars['optional_tables']['roles_map_table'] . ' SET disabled = 1 WHERE user_id :user_id', ['user_id' => $user_id]);

	        /** Save to database. **/
	        foreach ($roledata as $role_id)
	        {
                $row = $user_roles_map->first(['role_id' => $role_id, 'user_id' => $user_id]);
                $user_roles_map->insert([
                    'role_id' => $role_id,
                    'user_id'   => $user_id,
                    'disabled'  => 0
                ]);
            }
	    }
		message_success("Record added successfully!");
		redirect($admin_route . '/' . $plugin_route . '/view/' . $user->insert_id);
	}
}

if(!$csrf)
	$user->errors['email'] = "Form Expired!";

set_value('errors', array_merge($user->errors, $req->upload_errors));


