<?php

namespace Migration;

defined('FCPATH') or die("Direct script access denied");

/**
 * Role_permissions class
 */
class Role_permissions extends Migration
{
	public function up()
	{
		$this->addColumn('id int unsigned auto_increment');
		$this->addColumn('role_id int default 0');
		$this->addColumn('permission varchar(101) null');
		$this->addColumn('disabled tinyint(1) unsigned default 0');

		$this->addPrimaryKey('id');
		$this->addKey('disabled');

		$this->createTable('role_permissions');

		$this->addData([
		 	'role_id'		=> 1,
		 	'permission' 	=> 'all',
		 	'disabled' 		=> 0,
		]);
		$this->insert('role_permissions');
	}

	public function down()
	{
		$this->dropTable('role_permissions');
	}
}