<?php

	$user = new \BasicAuth\User;

	if(csrf_verify($req->post()))
	{
		$postData = $req->post();
		$row = $user->first(['email'=>$postData['email']]);

		if($row)
		{
			if(password_verify($postData['password'], $row->password))
			{
				$ses->auth($row);
				redirect('home');
			}
		}
		
			message_fail('Wrong email or password');

	}else
	{
			message_fail('Form Expired. Please refresh.');
	}