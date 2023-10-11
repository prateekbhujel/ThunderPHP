<?php

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
function add_filter()
{
    // Your filter implementation goes here
}

/**
 * Executes the filter prescribed to it.
 */
function do_filter()
{
    // Your filter execution logic goes here
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
 * Returns the absolute path useful for CSS and more.
 */
function plugin_dir()
{
    $called_from = debug_backtrace();
    $key = array_search(__FUNCTION__, array_column($called_from, 'function'));
    
    return get_plugin_dir(debug_backtrace()[$key]['file']);
}

/**
 * Returns the absolute HTTP path useful for images and more.
 */
function plugin_http_dir()
{
    $called_from = debug_backtrace();
    $key = array_search(__FUNCTION__, array_column($called_from, 'function'));
    
    return ROOT. DS . get_plugin_dir(debug_backtrace()[$key]['file']);
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
        $path = 'plugins' . DS . $parts[1];
    }
    return $path;
}
