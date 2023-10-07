<?php

$ACTIONS = [];
function add_action($action_name,$func){
	global $ACTIONS;

	$ACTIONS[$action_name] = $func;
} 

function do_action($action_name){
	global $ACTIONS;

	if(!empty($ACTIONS[$action_name]))
		$ACTIONS[$action_name]();
}

function add_filter($filter_name,$func){
	global $ACTIONS;

	$ACTIONS[$filter_name] = $func;
} 

function do_filter($filter_name,$data){
	global $ACTIONS;

	if(!empty($ACTIONS[$filter_name]))
		return $ACTIONS[$filter_name]($data);

	return $data;
}

load_plugins();
function load_plugins()
{
	$folder = 'plugins/';
	$files = glob($folder.'*.php');

	if(is_array($files))
	{
		foreach ($files as $file) {
			// code...
			if(file_exists($file))
			{
				require_once $file;
			}
		}
	}
		
}