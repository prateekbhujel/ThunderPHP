<?php

spl_autoload_register(function($classname) 
{
	$parts = explode("\\", $classname);
	$classname = array_pop($parts);

	$path = 'app'.DS.'models'.DS.ucfirst($classname).'.php';
	if(file_exists($path))
	{
		require_once $path;

	}else 
	{
		$called_from = debug_backtrace();
	    $key = array_search(__FUNCTION__, array_column($called_from, 'function'));
	    
	    $dir = get_plugin_dir(debug_backtrace()[$key]['file']);

		$path = $dir . 'models'. DS .ucfirst($classname) . '.php';

		if(file_exists($path))
		{
			require_once $path;
		}
	}

});

require 'functions.php';
require 'Database.php';
require 'Model.php';
require 'App.php';

