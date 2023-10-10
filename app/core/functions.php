<?php


/** Splits the query string of the url **/
function split_url($url)
{

	return explode("/", trim($url, '/'));
}


/** Splits the gets the key from URL **/
function URL($key = '')
{
	global $APP;

	if(is_numeric($key) || !empty($key))
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


/** Gets all the folder from plugin folder**/
function get_plugin_folders()
{
	$plugins_folder = 'plugins/';
	$res     = [];
	$folders = scandir($plugins_folder);
	foreach ($folders as $folder) {
		if($folder != '.' && $folder != '..' && is_dir($plugins_folder . $folder))
			$res[] = $folder;
	}

	return $res;
}


/** Loads all the plugins from the plugin folder and checks that exists. **/
function load_plugins($plugin_folders)
{
	global $APP;
	$loaded = false;
	
	foreach($plugin_folders as $folder) {
		
		$file = 'plugins/' . $folder . '/config.json';
		if(file_exists($file))
		{
			$json = json_decode(file_get_contents($file));

			if(is_object($json) && isset($json->id))
			{	
				if(!empty($json->active))
				{
				
					$file = 'plugins/' . $folder . '/plugin.php';
					if(file_exists($file) && valid_route($json))
					{
						$json->index_file = $file;
						$json->path 	  = 'plugins/' . $folder . '/';
						$json->http_path  = ROOT . '/' . $json->path;

						$APP['plugins'][]   = $json;				
					}
				}
			}
		}
	}

	if(!empty($APP['plugins'])){
	
		foreach($APP['plugins'] as $json) {

			if(file_exists($json->index_file))
			{
				require $json->index_file;
				$loaded = true;
			}

		}
	}

	return $loaded;
}

/** Validates the route either the plugins has route or not,
 * 	 if none we dont include it. **/
function valid_route(object $json): bool
{
    if (!empty($json->routes->off) && is_array($json->routes->off)) // Added closing parenthesis here
    {
        if (in_array(page(), $json->routes->off))
            return false;
    }

    if (!empty($json->routes->on) && is_array($json->routes->on)) // Added closing parenthesis here
    {
        if ($json->routes->on[0] == 'all')
            return true;

        if (in_array(page(), $json->routes->on))
            return true;
    }

    return false;
}



/* This function adds the action prescribed to it with function and sets the priority level. */
function add_action(string $hook, mixed $func, int $priority = 10): bool
{

	global $ACTIONS;

	while(!empty($ACTIONS[$hook][$priority])) {
		$priority++;
	}
	$ACTIONS[$hook][$priority] = $func;

	return true;
}


/* This function does the action prescribed to it .*/
function do_action(string $hook, array $data = [])
{
	global $ACTIONS;

	if(!empty($ACTIONS[$hook]))
	{
		ksort($ACTIONS[$hook]);
		foreach($ACTIONS[$hook] as $key => $func) {
			$func($data);
		}
	}
}


/* This function adds the filter prescribed to it. */
function add_filter()
{
	
}


/* This function does the filter prescribed to it .*/
function do_filter()
{

}


/** Show the debugged data in a nice format **/
function dd($data)
{
	echo"<pre><div style='margin: 1px; background-color: #444; color: white; padding: 5px 10px'>";
	print_r($data);
	echo'</div></pre>';
}


/** Grabs/ Checks what page we are on **/
function page()
{
	return URL(0);	
}


/** Redirects to the given url **/
function redirect($url)
{
	header("Location: ". ROOT . '/' . $url);
	die;
}