<?php

if(!empty($row))
{
	$postdata = $req->post();
	$postdata['id'] = $row->id;

	$csrf = csrf_verify($postdata);

	if($csrf && $user->validate_update($postdata))
	{
		if(isset($postdata['password']) && empty($postdata['password'])){
			unset($postdata['password']);
		}else
		{
			$postdata['password'] = password_hash($postdata['password'], PASSWORD_DEFAULT);
		}

		$postdata['date_updated'] = date('Y-m-d H:i:s');
		unset($postdata['id']);

		$user->update($row->id, $postdata);

		message_success("Record edited successfully!");
		redirect($admin_route . '/' . $plugin_route . '/view/' . $row->id);
	}

	if(!$csrf)
		$user->errors['email'] = "Form Expired!";

	set_value('errors', $user->errors);

}else{

	message_fail("Record not found!");
}