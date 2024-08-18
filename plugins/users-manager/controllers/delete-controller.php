<?php

if(!empty($row))
{
	$postdata = $req->post();

	$csrf = csrf_verify($postdata);

	if($csrf)
	{
		$user->delete($row->id);

		message_success("Record deleted successfully!");
		redirect($admin_route . '/' . $plugin_route);
	}

	$user->errors['email'] = "Form Expired!";

	set_value('errors', $user->errors);

}else{

	message_fail("Record not found!");
}