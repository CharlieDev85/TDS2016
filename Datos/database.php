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
        }
    }

    //checks if Locations has info
    public function locations_table_is_empty(){
        $locations_result = $this->query("SELECT * FROM locations");
        $num_of_rows = $this->num_rows($locations_result);
        if($num_of_rows == 0){
            return true;
        } else {
            return false;
        }
    }

    public function fill_locations_table($file_locations)
    {
        $first_row = true;
        foreach ($file_locations as $location) {
            if(!$first_row){
                $location_exploded = explode(';', $location);
                $insert_query = "INSERT INTO locations (state_name, county_name, subcounty_name) ";
                $insert_query .= "values (";
                $insert_query .= "'{$location_exploded[0]}', '{$location_exploded[1]}', '{$location_exploded[2]}')";
                $this->query($insert_query);
            } else {
                $first_row = false;
            }
        }

    }

    public function escape_value($string) {
        $escaped_string = mysqli_real_escape_string($this->connection, $string);
        return $escaped_string;
    }

    // "database neutral" functions

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

//revisar tabla locations
//next step:
// I can get properties using implode
//if (table_is_empty(Location::$table_name)){fill_it}

if($db->locations_table_is_empty()){
    $db->fill_locations_table(file('./Datos/locationscsv.csv'));
}
