<?php
/**
 * Created by PhpStorm.
 * User: carle
 * Date: 5/10/2016
 * Time: 10:02 PM
 */

require_once("/Datos/initialize.php");

echo "hello world";

$locations_result = $db->query("SELECT * FROM locations");
$num_of_rows = $db->num_rows($locations_result);
echo "numero de filas: " . $num_of_rows;

