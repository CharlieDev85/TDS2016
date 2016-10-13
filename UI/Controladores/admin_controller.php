<?php
/**
 * Created by PhpStorm.
 * User: carle
 * Date: 2/10/2016
 * Time: 3:33 PM
 */

class Admin_Controller
{
    private static $sql_forecast_actual =      "select l.state_name, LTW.week_id, w.month, w.year, f.forecast_num, f.actual_num 
                                from locations l 
                                inner join LTW on l.location_id = LTW.location_id 
                                inner join weeks w on w.week_id = LTW.week_id 
                                inner join forecast_actual f on f.LTW_id = LTW.LTW_id 
                                where l.state_name = '%state%' 
                                and w.month = %month% 
                                and w.year = %year%";

    private static $sql_capacity = "select l.state_name, w.month, w.year, c.capacity_num 
                                    FROM locations l 
                                    inner join ltw on l.location_id = ltw.location_id
                                    inner join weeks w on w.week_id = ltw.week_id
                                    inner join capacities c on c.LTW_id = ltw.LTW_id
                                    where l.state_name = '%state%' 
                                    and w.month = %month% 
                                    AND w.year = %year%";

    public static function selection_made($state, $month, $year)
    {
        $options = array();
        global $db;
        $criteria = array($state, $month, $year);
        $replace = array('%state%', '%month%', '%year%');

        $new_query_forecast_actual = str_replace($replace, $criteria, self::$sql_forecast_actual);
        $result_forecast_actual = $db->query($new_query_forecast_actual);
        $options['Forecast_Actual'] = $db->result_is_empty($result_forecast_actual)? 'upload' : 'delete';

        $new_query_capacity = str_replace($replace, $criteria, self::$sql_capacity);
        $result_capacity = $db->query($new_query_capacity);
        $options['Capacity'] = $db->result_is_empty($result_capacity) ? 'upload' : 'delete';

        return $options;

    }
}