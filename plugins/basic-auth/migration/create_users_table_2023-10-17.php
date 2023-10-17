<?php

namespace Migration;

/**
 *  User Migration
 */
class User extends migration
{
	
	public function up()
	{
		$this->addColumn('id INT(11) UNSIGNED AUTO_INCREMENT');
		$this->addColumn('column1 VARCHAR(100) DEFAULT NULL');
		$this->addColumn('column2 VARCHAR(100) DEFAULT NULL');
		$this->addColumn('deleted TINYINT(1) DEFAULT 0');
		$this->addColumn('date_created DATETIME DEFAULT NULL');
		$this->addColumn('date_updated DATETIME DEFAULT NULL');
		$this->addColumn('date_deleted DATETIME DEFAULT NULL');

		$this->addPrimaryKey('id');
		$this->addKey('deleted');
		$this->addKey('date_created');

		$this->createTable('users');
	}

	
	public function down()
	{
		$this->drop('users');
	}
}