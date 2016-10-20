<?php
/**
 * Created by PhpStorm.
 * User: carle
 * Date: 2/10/2016
 * Time: 3:33 PM
 */

class Admin_Controller
{
    private static $sql_forecast_actual =      "select LTW.ltw_id, l.state_name, LTW.week_id, w.month, w.year, f.forecast_num, f.actual_num 
                                from locations l 
                                inner join LTW on l.location_id = LTW.location_id 
                                inner join weeks w on w.week_id = LTW.week_id 
                                inner join forecast_actual f on f.LTW_id = LTW.LTW_id 
                                where l.state_name = '%state%' 
                                and w.month = %month% 
                                and w.year = %year%";

    private static $sql_capacity = "select LTW.ltw_id, l.state_name, w.month, w.year, c.capacity_num 
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

        return self::get_elements($options, $state, $month, $year);

    }

    public static function get_elements($options, $state, $month, $year){
        $elements = array();
        $element_forecast_actual = "<a href='admin.php?delete=true&type=forecast_actual&state={$state}&month={$month}&year={$year}'>delete</a>";
        $element_capacity = "<a href='admin.php?delete=true&type=capacity&state={$state}&month={$month}&year={$year}'>delete</a>";

        if($options['Forecast_Actual'] == 'upload'){
            $element_forecast_actual = '<form action="admin.php" enctype="multipart/form-data" method="POST">
                  <input type="hidden" name="MAX_FILE_SIZE" value="2000000" />
                  <input type="file" name="file_upload_forecast_actual"><br><br>
                  <input type="submit" value="Save" name="submit_forecast_actual">                  
                </form>';
        }
        if($options['Capacity'] == 'upload'){
            $element_capacity = '<form action="admin.php" enctype="multipart/form-data" method="POST">
                  <input type="hidden" name="MAX_FILE_SIZE" value="2000000" />
                  <input type="file" name="file_upload_capacity"><br><br>
                  <input type="submit" value="Save" name="submit_capacity">                  
                </form>';
        }

        $elements['Forecast_Actual'] = $element_forecast_actual;
        $elements['Capacity'] = $element_capacity;
        return $elements;
    }

    public static function delete($delete, $state, $month, $year){
        switch($delete){
            case "forecast_actual":
                $res = self::delete_forecast_actual($state, $month, $year);
                break;
            case "capacity":
                $res = self::delete_capacity($state, $month, $year);
                break;
            default:
                $res = false;
        }
        return $res;
    }

    public static function delete_forecast_actual($state, $month, $year){
        global $db;
        $sql = "delete from forecast_actual where ltw_id in (select ltw_id from LTW ";
        $sql .= "inner join locations l on l.location_id = LTW.location_id ";
        $sql .= "inner join weeks w on w.week_id = LTW.week_id ";
        $sql .= "where l.state_name = '{$state}' ";
        $sql .= "and w.month = {$month} ";
        $sql .= "and w.year = {$year})";
        return $db->query($sql);
    }

    public static function delete_capacity($state, $month, $year){
        global $db;
        $sql = "delete from capacities where LTW_id in (select LTW.ltw_id
                FROM ltw 
                inner join locations l on l.location_id = ltw.location_id
                inner join weeks w on w.week_id = ltw.week_id
                where l.state_name = '{$state}' 
                and w.month = {$month} 
                AND w.year = {$year})";
        return $db->query($sql);
    }

    public static function upload_capacity($file){
        $tmp_file = $file['file_upload_capacity']['tmp_name'];
        if(file_exists($tmp_file)){
            echo "submit capacity submited";
        } else {
            echo "file was not selected";
        }
        unset($_FILES);
    }
}