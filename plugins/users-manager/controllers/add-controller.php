<?php

$postdata = $req->post();

$csrf = csrf_verify($postdata);

if($csrf && $user->validate_insert($postdata))
{
	$postdata['password'] = password_hash($postdata['password'], PASSWORD_DEFAULT);

	$postdata['date_created'] = date('Y-m-d H:i:s');

	$user->insert($postdata);

	message_success("Record added successfully!");
	redirect($admin_route . '/' . $plugin_route . '/view/' . $user->insert_id);
}

if(!$csrf)
	$user->errors['email'] = "Form Expired!";

set_value('errors', $user->errors);

