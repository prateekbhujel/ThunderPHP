<?php

namespace Model;

defined('ROOT') or die("Direct script access denied");

/**
 * User Model
 */
class User extends Model
{
	protected $table = 'users';

	protected $allowedColumns = [
			'email',
			'password',
			'date_created',
	];

	protected $allowedUpdatedColumns = [
			'email',
			'password',
			'date_updated',
	];


	
	function __construct()
	{
		dd("<span style='color: aqua'>This is from the User Class (inside the plugin).</span>");
	}
}