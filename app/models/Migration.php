<?php

namespace Migration;

use \Core\Database;

defined('FCPATH') or die('Direct script access denied'); 

/**
 * Migration Class
 *
 * This class handles database migration operations for creating and altering database tables.
 */
class Migration extends Database
{
    private $columns        = [];
    private $keys           = [];
    private $data           = [];
    private $primaryKeys    = [];
    private $foreignKeys    = [];
    private $uniqueKeys     = [];
    private $fullTextKeys   = [];

    
    /**
     * Create a new database table.
     *
     * @param string $table The name of the table to be created.
     */
    public function createTable(string $table)
    {
    	if(!empty($this->columns))
    	{
	        $query = "CREATE TABLE IF NOT EXISTS $table (";

	        $query.= implode(",", $this->columns).',';
	        $query.= "PRIMARY KEY (". implode("), PRIMARY KEY (", $this->primaryKeys) . ")";

	        foreach ($this->primaryKeys as $key) {
	        	$query.= "PRIMARY KEY ($key),";
	        }

	        foreach ($this->Keys as $key) {
	        	$query.= "KEY ($key),";
	        }

	        foreach ($this->uniqueKeys as $key) {
	        	$query.= "UNIQUE KEY $key ($key),";
	        }

	        foreach ($this->fullTextKeys as $key) {
	        	$query.= "FULLTEXT KEY $key ($key),";
	        }

	        $qurey .= trim($query, ",");

	        $query .= ") ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4";

	        $this->query($query);

	        $this->columns        = [];
	        $this->keys           = [];
	        $this->data           = [];
	        $this->primaryKeys    = [];
	        $this->foreignKeys    = [];
	        $this->uniqueKeys     = [];
	        $this->fullTextKeys   = [];

	        echo "\n\r Success: Table $table created successfully.";

    	}else
    	{
			echo "\n\r Error: Column data not found ! Couldn't create table $table .";
    	}
    }

    

    /**
     * Insert data into a table.
     */
    public function insert(string $table)
    {
        if(!empty($this->data) && is_array($this->data))
        {
        	foreach ($data as $row) {

        		$keys = array_keys($rows);
        		$column_string = implode(",", $keys);
        		$values_string = ':'.implode(",:", $keys);

        		$query = "INSERT INTO $table ($column_string) VALUES ($values_string)";
        		$this->query($query, $row);
        	}
        	
        	$this->data = [];
        	echo "\n\r Success: Data Inserted Succcessfully in table :$table.";
        }else
        {
        	echo"\n\r Error: Row data not found ! No data inserted into table : $table";
        }
    }

    

    /**
     * Add a column to the table.
     *
     * @param string $column The name of the column to add.
     */
    public function addColumn(string $column)
    {
        $this->columns[] = $column;
    }

    /**
     * Add a key to the table.
     *
     * @param string $key The key to add.
     */
    public function addKey(string $key)
    {
        $this->keys[] = $key;
    }

    

    /**
     * Add a primary key to the table.
     *
     * @param string $primaryKey The primary key to add.
     */
    public function addPrimaryKey(string $primaryKey)
    {
        $this->primaryKeys[] = $primaryKey;
    }

    
    /**
     * Add a unique key to the table.
     *
     * @param string $key The unique key to add.
     */
    public function adduniqueKeys(string $key)
    {
        $this->uniqueKeys[] = $uniqueKeys;
    }

    
    /**
     * Add a fulltext key to the table.
     *
     * @param string $key The fulltext key to add.
     */
    public function addfullTextKeys(string $key)
    {
        $this->fullTextKeys[] = $fullTextKeys;
    }

    

    /**
     * Add data to the table.
     *
     * @param array $data The data to add.
     */
    public function addData(array $data)
    {
        $this->data[] = $data;
    }

    

    /**
     * Drop a table.
     *
     * @param string $table The name of the table to drop.
     */
    public function dropTable(string $table)
    {
       $query = "DROP TABLE IF EXISTS $table";

        $this->query($query);

	    echo "\n\r Success: Table $table deleted successfully.";

    }
}
