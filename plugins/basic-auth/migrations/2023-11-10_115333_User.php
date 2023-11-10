<?php

namespace Migration;

defined('FCPATH') or die('Direct script access denied');

/**
 * Migration Class
 *
 * This migration class represents the schema changes for the user table.
 */
class User extends Migration
{

    /**
     * Run the migration to apply changes to the database schema.
     */
    public function up()
    {
        // Add columns to the table
        $this->addColumn("id int unsigned AUTO_INCREMENT");
        $this->addColumn("column1 varchar(255) default null");
        $this->addColumn("column2 text default null");
        $this->addColumn("deleted tinyint(1) unsigned default 0");
        $this->addColumn("date_created datetime default null");
        $this->addColumn("date_updated datetime default null");
        $this->addColumn("date_deleted datetime default null");

        // Add primary and secondary keys
        $this->addPrimaryKey('id');
        $this->addKey('deleted');
        $this->addKey('date_created');
        $this->addKey('date_deleted');

        /** -------- more keys to use --------
         * $this->addfullTextKeys("column2");
         * $this->adduniqueKeys("deleted");
         * -----------------------------------
        */
        // Create the table
        $this->createTable("user");

        /**
         * ------------ To Seed Data ------------
         * $this->addData([
         * 		'username' => 'jhon', 
         * 		'email'    => 'email@email.com', 
         * 		'gender'   => 'male', 
         * 	]); 
         * 
         * $this->insert('user'); 
         * --------------------------------------
        */
    }


    /**
     * Reverse the migration to undo changes made to the database schema.
     */
    public function down()
    {
        // Drop the table
        $this->dropTable("user");
    }
}
