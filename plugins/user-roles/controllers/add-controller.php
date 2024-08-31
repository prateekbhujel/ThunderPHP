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
	if(user_can('add_user'))
	{
		$postdata['password'] = password_hash($postdata['password'], PASSWORD_DEFAULT);

		$postdata['date_created'] = date('Y-m-d H:i:s');

		$user->insert($postdata);

		message_success("Record added successfully!");
		redirect($admin_route . '/' . $plugin_route . '/view/' . $user->insert_id);
	}
}

if(!$csrf)
	$user->errors['email'] = "Form Expired!";

set_value('errors', array_merge($user->errors, $req->upload_errors));


