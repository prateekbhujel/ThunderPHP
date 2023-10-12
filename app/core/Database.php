<?php

namespace Core;

use \PDO;
use \PDOException;

/**
 * Database Class
 * Manages database connections and queries.
 */
class Database
{
    private static $query_id = '';

    /**
     * Establish a database connection.
     *
     * @return \PDO The PDO database connection.
     */
    private function connect()
    {
        $VARS['DB_NAME']     = DB_NAME;
        $VARS['DB_USER']     = DB_USER;
        $VARS['DB_PASSWORD'] = DB_PASSWORD;
        $VARS['DB_HOST']     = DB_HOST;
        $VARS['DB_DRIVER']   = DB_DRIVER;

        // Apply filters before connecting to the database.
        $VARS = do_filter('before_db_connect', $VARS);

        $string = "$VARS[DB_DRIVER]:hostname=$VARS[DB_HOST];dbname=$VARS[DB_NAME]";

        try 
        {
            $con = new \PDO($string, $VARS['DB_USER'], $VARS['DB_PASSWORD']);
            $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        } catch (PDOException $e) {

            // Handle database connection error gracefully.
            dd("FAILED TO CONNECT TO DATABASE WITH ERROR: " . $e->getMessage());
            die;
        }

        return $con;
    }

    // The get_row function retrieves a single result from a query.
    public function get_row(string $query, array $data = [], string $data_type = 'object')
    {
        $result = $this->query($query, $data, $data_type);

        if (is_array($result) && count($result) > 0)
        {
            return $result[0];
        }

        return false;
    }

    /**
     * Execute a database query.
     *
     * @param string $query     The SQL query.
     * @param array  $data      The data to bind to the query.
     * @param string $data_type The type of data to retrieve (e.g., 'object', 'array').
     * @return mixed The result of the query.
     */
    public function query(string $query, array $data = [], string $data_type = 'object')
    {
        // Apply filters before executing the query.
        $query = do_filter('before_query_query', $query);
        $data  = do_filter('after_query_data', $data);

        $con   = $this->connect();
        $stm   = $con->prepare($query);

        $result = $stm->execute($data);
        if ($result)
        {
            if ($data_type == 'object')
            {
                $rows = $stm->fetchAll(PDO::FETCH_OBJ);
            }
            else
            {
                $rows = $stm->fetchAll(PDO::FETCH_ASSOC);
            }

            $arr = [];
            $arr['query']  = $query;
            $arr['data']   = $data;
            $arr['result'] = $rows ?? [];
            $arr['query_id'] = self::$query_id;
            self::$query_id = '';

            // Apply filters after executing the query and processing the result.
            $result = do_filter('after_query', $arr);

            if (is_array($result) && count($result) > 0)
            {
                return $result;
            }
        }

        return false;
    }
}
