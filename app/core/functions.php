<?php

function split_url()
{
	$url = 'home';
	return explode("/", $url);
}

function URL($key = '')
{
	if(!empty($key))
	{
		if(!empty($APP['URL'][$key]))
		{
			return $APP['URL'][$key];
		}
	} else {
		return $APP['URL'];
	}

	return '';
}