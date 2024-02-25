<?php

/**
 * Plugin name: 404
 * Description: This displays on view incase of the url is invalid or doesn't actually exists.
 * 
 * 
 **/


/** displays the view file **/
add_action('view',function()
{
	require plugin_path('views/view.php');
});


