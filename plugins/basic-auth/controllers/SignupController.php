<?php

	$user = new \BasicAuth\User;

	if($csrf = csrf_verify($req->post()) && $user->validate_insert($req->post()))
	{
		$postData = $req->post();
		$postData['date_created'] = date("Y-m-d H:i:s");
		$postData['password'] = password_hash($postData['password'], PASSWORD_DEFAULT);

		$user->insert($postData);

		message("Signup Complete! Please Login to continue.");
		redirect($vars['login_page']);
	}else
	{
		if(!$csrf)
			$user->errors['email'] = 'Form Expired. Please refresh.';

		set_value('errors', $user->errors);
	}