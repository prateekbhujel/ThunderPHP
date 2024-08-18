<?php

if(!empty($row))
{
	$postdata = $req->post();
	$postdata['id'] = $row->id;

	if($user->validate_update($postdata))
	{
		if(isset($postdata['password']) && empty($postdata['password']))
			unset($postdata['password']);

		$postdata['date_updated'] = date('Y-m-d H:i:s');
		unset($postdata['id']);

		$user->update($row->id, $postdata);

		message("record edited Successfully!");
		redirect($admin_route . '/' . $plugin_route . '/view/' . $row->id);
	}

	set_value('errors', $user->errors);

}else{

	message("Record not found!");
}