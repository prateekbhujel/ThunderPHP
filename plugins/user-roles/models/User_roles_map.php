<?php

namespace UserRoles;

use \Model\Model; 

defined('ROOT') or die("Direct script access denied");
/**
 * User_roles_map class
 */
class User_roles_map extends Model
{
	protected $table = 'user_roles_map';
	public $primary_key = 'id';

	protected $allowedColumns = [
		'role_id',
		'user_id',
		'disabled',
	];

	protected $allowedUpdateColumns = [
		'role_id',
		'user_id',
		'disabled',
	];
}