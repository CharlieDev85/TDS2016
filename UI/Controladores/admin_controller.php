<?php
/**
 * Created by PhpStorm.
 * User: carle
 * Date: 2/10/2016
 * Time: 3:33 PM
 */

class Admin_Controller
{
    private static $sql_for_act =      "select l.state_name, LTW.week_id, w.month, w.year, f.forecast_num, f.actual_num from locations l 
                                inner join LTW on l.location_id = LTW.location_id 
                                inner join weeks w on w.week_id = LTW.week_id 
                                inner join forecast_actual f on f.LTW_id = LTW.LTW_id 
                                where l.state_name = '%state%' 
                                and w.month = %month% 
                                and w.year = %year%";

    public static function selection_made($state, $month, $year)
    {
        global $db;
        $criteria = array($state, $month, $year);
        $replace = array('%state%', '%month%', '%year%');
        $new_query = str_replace($replace, $criteria, self::$sql_for_act);

    }
}