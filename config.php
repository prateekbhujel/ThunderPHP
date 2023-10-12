<?php

define('DEBUG', true);

define('APP_NAME', 'ThunderPHP App');
define('APP_DESCRIPTION', 'This is best website !');

if($_SERVER['SERVER_NAME'] == 'localhost')
{
	/** Database Name **/
	define('DB_NAME', 'thunderphp_db');
	
	/** Database Username **/
	define('DB_USER', 'root');

	/** Database Password **/
	define('DB_PASSWORD', '');

	/** Database Hostname **/
	define('DB_HOST', 'localhost');

	/** Database Driver **/
	define('DB_DRIVER', 'mysql');

	/* Setting up the ROOT value */
	define('ROOT', 'http://localhost/thunderphp');

} else 
{
	/** Database Name **/
	define('DB_NAME', 'thunderphp_db');
	
	/** Database Username **/
	define('DB_USER', 'root');

	/** Database Password **/
	define('DB_PASSWORD', '');

	/** Database Hostname **/
	define('DB_HOST', 'localhost');

	/** Database Driver **/
	define('DB_DRIVER', 'mysql');
	
	/* Setting up the ROOT value */
	define('ROOT', 'https://www.yourwebsite.com');

}


