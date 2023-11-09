<?php

/**
 * Sets the value and pass it to,
 *  The controller and View of Plugin. 
 */
function set_value(string|array $key, mixed $value = ''):bool
{
    global $USER_DATA;

    $called_from = debug_backtrace();
    $ikey         = array_search(__FUNCTION__, array_column($called_from, 'function'));
    $path        = get_plugin_dir(debug_backtrace()[$ikey]['file']). 'config.json';

    if(file_exists($path))
    {
        $json      = json_decode(file_get_contents($path));
        $plugin_id = $json->id;
        
        if(is_array($key))
        {   
            foreach($key as $k => $value) {

                $USER_DATA[$plugin_id][$k] = $value;
            }
        }else {

            $USER_DATA[$plugin_id][$key] = $value;
        }
        
        return true;
    }

    return false;
}


/**
 * Gets the value which was passed it,
 *   via controller and View of Plugin. 
 */
function get_value(string $key = ''):mixed
{
    global $USER_DATA;

    $called_from = debug_backtrace();
    $ikey         = array_search(__FUNCTION__, array_column($called_from, 'function'));
    $path        = get_plugin_dir(debug_backtrace()[$ikey]['file']). 'config.json';

    if(file_exists($path))
    {
        $json      = json_decode(file_get_contents($path));
        $plugin_id = $json->id;

        if(empty($key))
            return $USER_DATA[$plugin_id];

        return !empty($USER_DATA[$plugin_id][$key]) ? $USER_DATA[$plugin_id][$key] : null;
    }

    return null;
}

/**
 * Loads the app thingy and returns,
 *  the inputed files or plugins, if found.
 */
function APP($key = '')
{   
    global $APP;

    if(!empty($key))
    {
        return !empty($APP[$key]) ? $APP[$key] : null;
    } else {

        return $APP;
    }

    return null;
}


/**
 *  Shows what plugins are loaded in your current page.
 *      Good for debugging.
*/
function show_plugins()
{
    global $APP;
    
    $plugin_names = array_column($APP['plugins'], 'name');

    dd( $plugin_names ?? []);

}


/**
 * Splits the query string of the URL.
 */
function split_url($url)
{
    return explode("/", trim($url, '/'));
}


/**
 * Gets the value of a key from the URL configuration.
 */
function URL($key = '')
{
    global $APP;

    if (is_numeric($key) || !empty($key)) {
        if (!empty($APP['URL'][$key])) {
            return $APP['URL'][$key];
        }
    } else {
        return $APP['URL'];
    }

    return '';
}


/**
 * Gets all the folders from the plugin folder.
 */
function get_plugin_folders()
{
    $plugins_folder = 'plugins/';
    $res = [];
    $folders = scandir($plugins_folder);
    foreach ($folders as $folder) {
        if ($folder != '.' && $folder != '..' && is_dir($plugins_folder . $folder)) {
            $res[] = $folder;
        }
    }

    return $res;
}


/**
 * Loads all the plugins from the plugin folder and checks if they exist.
 */
function load_plugins($plugin_folders)
{
    global $APP;
    $loaded = false;

    foreach ($plugin_folders as $folder) {

        $file = 'plugins/' . $folder . '/config.json';
        if (file_exists($file)) {
            $json = json_decode(file_get_contents($file));

            if (is_object($json) && isset($json->id)) {
                if (!empty($json->active)) {

                    $file = 'plugins/' . $folder . '/plugin.php';
                    if (file_exists($file) && valid_route($json)) {
                        $json->index_file = $file;
                        $json->path = 'plugins/' . $folder . '/';
                        $json->http_path = ROOT . '/' . $json->path;

                        $APP['plugins'][] = $json;
                    }
                }
            }
        }
    }

    if (!empty($APP['plugins'])) {

        foreach ($APP['plugins'] as $json) {

            if (file_exists($json->index_file)) {
                require $json->index_file;
                $loaded = true;
            }
        }
    }

    return $loaded;
}


/**
 * Validates the route to check if the plugin has the route or not.
 */
function valid_route(object $json): bool
{
    if (!empty($json->routes->off) && is_array($json->routes->off)) {
        if (in_array(page(), $json->routes->off)) {
            return false;
        }
    }

    if (!empty($json->routes->on) && is_array($json->routes->on)) {
        if ($json->routes->on[0] == 'all') {
            return true;
        }

        if (in_array(page(), $json->routes->on)) {
            return true;
        }
    }

    return false;
}


/**
 * Adds an action with a function and sets the priority level.
 */
function add_action(string $hook, mixed $func, int $priority = 10): bool
{
    global $ACTIONS;

    while (!empty($ACTIONS[$hook][$priority])) {
        $priority++;
    }
    $ACTIONS[$hook][$priority] = $func;

    return true;
}


/**
 * Executes the actions prescribed to it.
 */
function do_action(string $hook, array $data = [])
{
    global $ACTIONS;

    if (!empty($ACTIONS[$hook])) {
        ksort($ACTIONS[$hook]);
        foreach ($ACTIONS[$hook] as $key => $func) {
            $func($data);
        }
    }
}


/**
 * Adds a filter for further processing.
 */
function add_filter(string $hook, mixed $func, int $priority = 10): bool
{
    global $FILTER;

    while (!empty($FILTER[$hook][$priority])) {
        $priority++;
    }
    $FILTER[$hook][$priority] = $func;

    return true;
}


/**
 * Executes the filter prescribed to it.
 */
function do_filter(string $hook, mixed $data = ''): mixed
{
    global $ACTIONS;

    if (!empty($ACTIONS[$hook])) {

        ksort($ACTIONS[$hook]);
        foreach ($ACTIONS[$hook] as $key => $func) {
            $data = $func($data);
        }
    }

     return $data;
}


/**
 * Displays debug data in a formatted manner.
 */
function dd($data)
{
    echo "<pre><div style='margin: 1px; background-color: #444; color: white; padding: 5px 10px'>";
    print_r($data);
    echo '</div></pre>';
}


/**
 * Grabs/checks what page we are on.
 */
function page()
{
    return URL(0);
}


/**
 * Redirects to the given URL.
 */
function redirect($url)
{
    header("Location: " . ROOT . '/' . $url);
    die;
}


/**
 * Returns the absolute path useful for requiring and including an file.
 */
function plugin_path(string $path = '')
{
    $called_from = debug_backtrace();
    $key = array_search(__FUNCTION__, array_column($called_from, 'function'));
    
    return get_plugin_dir(debug_backtrace()[$key]['file']) . $path;
}


/**
 * Returns the absolute HTTP path useful for images and css or more.
 */
function plugin_http_path(string $path = '')
{
    $called_from = debug_backtrace();
    $key = array_search(__FUNCTION__, array_column($called_from, 'function'));
    
    return ROOT. DS . get_plugin_dir(debug_backtrace()[$key]['file']) . $path;
}


/**
 * Gets the directory of the plugins regardless of the OS/Hosting.
 */
function get_plugin_dir(string $filepath): string
{
    $path = "";

    $basename = basename($filepath);
    $path = str_replace($basename, '', $filepath);

    if (strstr($path, DS . 'plugins' . DS)) {
        $parts = explode(DS . 'plugins' . DS, $path);
        $parts = explode(DS, $parts[1]);
        $path = 'plugins' . DS . $parts[0] . DS;
    }

    return $path;
}


/**
 * Check if the user has a specific permission.
 *
 * @param string $permission The permission to check.
 *
 * @return bool True if the user has the specified permission, false otherwise.
 */
function user_can($permission)
{
    global $APP;

    return true;
}


/**
 * Debug Die and Dump (ddd) function
 *
 * This function is used for debugging by displaying the value using var_dump and then terminating the script with die.
 *
 */
function ddd($value = '') {
    echo "<pre style='color: #0ff; background-color: #1d1d1d; font-size: 1.4em; width: 100%; white-space: pre-wrap; overflow: auto;'>";
    var_dump($value);
    echo '</pre>';
    die;
}



/**
 * Get the previous value associated with the specified key after a page reload.
 *
 * @param string $key The key for which to retrieve the previous value.
 * @param string $default The default value to return if the previous value is not found.
 * @param string $type The request type ('post' or 'get').
 *
 * @return string The previous value associated with the specified key, or the default value if not found.
 */
function old_value(string $key, string $default = '', string $type = 'post'): string
{
    $array = '_POST';
    if ($type == 'get') {
        $array = '_GET';
    }

    if (!empty($$array[$key])) {
        return $$array[$key];
    }

    return $default;
}



/**
 * Generate the 'selected' attribute for an HTML select element.
 *
 * @param string $key The key to compare against the value.
 * @param string $value The value to compare.
 * @param string $default The default value to compare.
 * @param string $type The request type ('post' or 'get').
 *
 * @return string The 'selected' attribute if the condition is met, or an empty string if not.
 */
function old_select(string $key, string $value, string $default = '', string $type = 'post'): string
{
    $array = '_POST';
    if ($type == 'get') {
        $array = '_GET';
    }

    if (!empty($$array[$key])) {
        if ($$array[$key] == $value) {
            return ' selected ';
        }
    } else {
        if ($default == $value) {
            return ' selected ';
        }
    }

    return '';
}



/**
 * Generate the 'checked' attribute for an HTML input element of type 'checkbox'.
 *
 * @param string $key The key to compare against the value.
 * @param string $value The value to compare.
 * @param string $default The default value to compare.
 * @param string $type The request type ('post' or 'get').
 *
 * @return string The 'checked' attribute if the condition is met, or an empty string if not.
 */
function old_checked(string $key, string $value, string $default = '', string $type = 'post'): string
{
    $array = '_POST';
    if ($type == 'get') {
        $array = '_GET';
    }

    if (!empty($$array[$key])) {
        if ($$array[$key] == $value) {
            return ' checked ';
        }
    } else {
        if ($default == $value) {
            return ' checked ';
        }
    }

    return '';
}


/**
 * Generate a CSRF token and store it in the session.
 *
 * @param string $sesKey The session key for storing the CSRF token.
 * @param int $hours The number of hours the token is valid.
 *
 * @return string An HTML input element with the CSRF token.
 */
function csrf(string $sesKey = 'csrf', int $hours = 1): string
{
    $key = '';
    $ses = new \Core\Session;
    $key = hash('sha256', time() . rand(0, 99));
    $expires = time() + ((60 * 60) * $hours);

    $ses->set($sesKey, [
        'key' => $key,
        'expires' => $expires
    ]);

    return "<input type='hidden' value='$key' name='$sesKey' />";
}



/**
 * Verify the CSRF token from the submitted form data.
 *
 * @param array $post The form data to check for the CSRF token.
 * @param string $sesKey The session key for the CSRF token.
 *
 * @return mixed Return true if the CSRF token is valid, false if not found or expired.
 */
function csrf_verify(array $post, string $sesKey = 'csrf'): mixed
{
    if (empty($post[$sesKey])) {
        return false;
    }

    $ses = new \Core\Session;
    $data = $ses->get($sesKey);

    if (is_array($data)) {
        if ($data['key'] !== $post[$sesKey]) {
            return false;
        }

        if ($data['expires'] > time()) {
            return true;
        }

        $ses->pop($sesKey);
    }

    return false;
}


function get_image(string $path = '', string $type = 'post')
{
    if(file_exists($path))
        return ROOT. DS . $path;
    

    if($type == "post")
        return ROOT . DS . 'assets'. DS .'images'. DS .'no_image.jpg';

    if($type == "male")
        return ROOT . DS . 'assets'. DS . 'images'. DS .'user_male.jpg';    

    if($type == "female")
        return ROOT . DS . 'assets' . DS . 'images' . DS . 'user_female.jpg';

    
    return ROOT . DS . 'assets'. DS . 'images'. DS . 'no_image.jpg';


}