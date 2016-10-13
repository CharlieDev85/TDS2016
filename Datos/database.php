<?php
/**
 * Created by PhpStorm.
 * User: carle
 * Date: 4/10/2016
 * Time: 10:20 PM
 */

require_once(LIB_PATH.DS."config.php");


class MySQLDatabase{

    private $connection;

    function __construct() {
        $this->open_connection();
    }

    public function open_connection() {
        $this->connection = mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
        if(mysqli_connect_errno()) {
            die("Database connection failed: " .
                mysqli_connect_error() .
                " (" . mysqli_connect_errno() . ")"
            );
        }
    }

    public function close_connection() {
        if(isset($this->connection)) {
            mysqli_close($this->connection);
            unset($this->connection);
        }
    }

    public function query($sql) {
//        echo '<br><br>' . $sql . '<br><br>';
        $result = mysqli_query($this->connection, $sql);
        $this->confirm_query($result);
        return $result;
    }

    private function confirm_query($result) {
        if (!$result) {
            die("Database query failed.");
            return false;
        }
        return true;
    }

    public function prepare_values($values_array){
        $first_value = true;
        $values_prepared = "";
        foreach($values_array as $value){
            if($first_value){
                $values_prepared .= "'{$value}'";
                $first_value = false;
            } else {
                $values_prepared .= ", '$value'";
            }
        }
        return $values_prepared;
    }

    //check if a table is empty
    public function table_is_empty($table_name){
        $sql = 'SELECT * FROM ' . $table_name;
        $result = $this->query($sql);
        return $this->result_is_empty($result);
    }

    public function result_is_empty($result){
        $num_of_rows = $this->num_rows($result);
        if($num_of_rows == 0){
            return true;
        }
        return false;
    }


    //It'll fill the table from csv if table is empty
    public function check_table($table_name, $csv_file, $imploded_fields)
    {
        $empty = $this->table_is_empty($table_name);
        if($empty)
        {
            $first_row = true;
            foreach ($csv_file as $row)
            {
                if(!$first_row)
                {
                    $row_exploded = explode(';', $row);
                    $values = $this->prepare_values($row_exploded);
                    $insert_query = "INSERT INTO {$table_name} ({$imploded_fields}) ";
                    $insert_query .= "values (";
                    $insert_query .= "{$values})";
                    $query_ok = $this->query($insert_query);
                    if (!$query_ok)
                    {
                        return false;
                    }
                } else
                    {
                    $first_row = false;
                    }
            }
            return true;
        }
        return true;
    }


    public function escape_value($string) {
        $escaped_string = mysqli_real_escape_string($this->connection, $string);
        return $escaped_string;
    }

    // "database neutral" functions

    public function fetch_all($result_set) {
        return mysqli_fetch_all($result_set, MYSQLI_NUM);
    }

    public function fetch_array($result_set) {
        return mysqli_fetch_array($result_set);
    }

    public function fetch_array_assoc($result_set) {
        return mysqli_fetch_assoc($result_set);
    }

    public function num_rows($result_set) {
        return mysqli_num_rows($result_set);
    }

    public function insert_id() {
        // get the last id inserted over the current db connection
        return mysqli_insert_id($this->connection);
    }

    public function affected_rows() {
        return mysqli_affected_rows($this->connection);
    }
}

$database = new MySQLDatabase();
$db = $database;


