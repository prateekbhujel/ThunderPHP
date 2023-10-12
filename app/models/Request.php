<?php

namespace Core;

defined('ROOT') or die('Direct script access denied');
 
/**
 *  Request Class is whenever we submit the form and recieve information from the url this is where we will deal with that information 
 */
class Request
{
	
	function __construct()
	{
		dd("This is an Request class.");
	}
}