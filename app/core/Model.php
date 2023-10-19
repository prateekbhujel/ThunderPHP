<?php

namespace Model;

use \Core\Database;

defined('ROOT') or die('Direct script access denied');
 
/**
 * Model Class
 *
 * This class handles database operations, providing methods for retrieving, inserting, updating, and deleting records.
 * It extends the Database class to leverage database connectivity.
 */
class Model extends Database
{
    public $order            = 'desc'; // The default ordering direction.
    public $order_column     = 'id';   // The default ordering column.
   	public $primary_key		 = 'id';   //Primary key of the table
    public $limit            = 10;     // The default number of records to retrieve.
    public $offset           = 10;     // The offset for pagination.
    public $errors           = [];     // Stores validation errors for user input.

    /**
     * Retrieve records from the database based on WHERE conditions.
     *
     * @param array $where_array     Associative array for WHERE conditions.
     * @param array $where_not_array Associative array for WHERE NOT conditions.
     * @param string $data_type      Data type to return (e.g., 'object', 'array').
     *
     * @return array|bool An array of records or false if no records match the criteria.
     */
    public function where(array $where_array = [], array $where_not_array = [], string $data_type = 'object'): array|bool
    {
        $query = "SELECT * FROM $this->table WHERE ";

        if (!empty($where_array)) {
            foreach ($where_array as $key => $value) {
                $query .= $key . '= :' . $key . ' AND ';
            }
        }

        if (!empty($where_not_array)) {
            foreach ($where_not_array as $key => $value) {
                $query .= $key . '!= :' . $key . ' AND ';
            }
        }

        $query = trim($query, 'AND ');
        $query .= " ORDER BY $this->order_column $this->order LIMIT $this->limit OFFSET $this->offset";

        $data = array_merge($where_array, $where_not_array);

        return $this->query($query, $data);
    }

    /**
     * Retrieve the first record based on WHERE conditions.
     *
     * @param array $where_array     Associative array for WHERE conditions.
     * @param array $where_not_array Associative array for WHERE NOT conditions.
     * @param string $data_type      Data type to return (e.g., 'object', 'array').
     *
     * @return array|bool The first matching record or false if none found.
     */
    public function first(array $where_array = [], array $where_not_array = [], string $data_type = 'object'): array|bool
    {
        $rows = $this->where($where_array, $where_not_array, $data_type);
        if (!empty($rows)) {
            return $rows[0];
        }
        return false;
    }

    /**
     * Retrieve all records from the table.
     *
     * @param string $data_type Data type to return (e.g., 'object', 'array').
     *
     * @return array|bool An array of records or false if none found.
     */
    public function getAll(string $data_type = 'object'): array|bool
    {
        $query = "SELECT * FROM $this->table ORDER BY $this->order_column $this->order LIMIT $this->limit OFFSET $this->offset";
        return $this->query($query, [], $data_type);
    }

    /**
     * Insert a new record into the table.
     *
     * @param array $data Associative array of data to be inserted.
     */
    public function insert(array $data)
    {
    	if(!empty($this->allowedColumns))
    	{
    		foreach($data as $key => $value) {
    			if(!in_array($key, $this->allowedColumns))
    				unset($data[$key]);
    		}
    	}
    	
    	if(!empty($data))
    	{
    		$keys = array_keys($data);
    		$query = "INSERT INTO $this->table (".implode(",", $keys).") VALUES (:".implode(',:',$keys)."))";
			
			return $this->query($query);
		}

		return false;
    }

    /**
     * Update an existing record in the table.
     *
     * @param string|int $id The ID of the record to update.
     * @param array $data    Associative array of data to be updated.
     */
    public function update(string|int $my_id, array $data)
    {
        if(!empty($this->allowedUpdateColumns))
    	{
    		foreach($data as $key => $value) {
    			if(!in_array($key, $this->allowedUpdateColumns))
    				unset($data[$key]);
    		}
    	}
    	
    	if(!empty($data))
    	{
	    	$query  = "UPDATE $this->table ";
    		
    		foreach ($data as $key => $value) {
	    		$query .= $key .'= :' .$key.',';
    		}
			$query  = trim($query,",");
			$data['my_id'] = $my_id;

			$query .= "WHERE $this->primary_key = :my_id";
			return $this->query($query);
		}

		return false;
    }

    /**
     * Delete a record from the table.
     *
     * @param string|int $id The ID of the record to delete.
     */
    public function delete(string|int $my_id)
    {

	    	$query  = "DELETE FROM $this->table ";
			$query .= "WHERE $this->primary_key = :my_id LIMIT 1";

			return $this->query($query);
    }
}
