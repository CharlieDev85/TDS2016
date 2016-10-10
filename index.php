<?php
/**
 * Created by PhpStorm.
 * User: carle
 * Date: 5/10/2016
 * Time: 10:02 PM
 */

require_once("/Datos/initialize.php");

$checked_locations = $db->check_table(Location::$table_name, file('./Datos/locationscsv.csv'), implode(", ", Location::$fields));
$checked_trades = $db->check_table(Trade::$table_name, file('./Datos/tradescsv.csv'), implode(", ",Trade::$fields));
$checked_channels = $db->check_table(Channel::$table_name, file('./Datos/channelscsv.csv'), implode(", ",Channel::$fields));
$checked_weeks = $db->check_table(Week::$table_name, file('./Datos/weekscsv.csv'), implode(", ",Week::$fields));
if($checked_locations && $checked_trades && $checked_channels && $checked_weeks){
    echo "checks ok". "<br><br><br>";
} else {
    echo "something went wrong with the checkings" . "<br><br><br>";
}

echo "hello world <br>";

$url = "UI/public/";
redirect_to($url);
