<?php

namespace Core;

/**
 * App class
 */
class App
{
	public function index()
	{
		echo "everything is working";
		echo "<pre>";
		print_r(URL());
	}
}