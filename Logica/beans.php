<?php
/**
 * Created by PhpStorm.
 * User: carle
 * Date: 4/10/2016
 * Time: 9:58 PM
 */

class Location
{
    public static $table_name = "locations";
    public static $fields = array("state_name", "county_name", "subcounty_name");

    public $location_id;
    public $state_name;
    public $county_name;
    public $subcounty_name;

    public static function get_states()
    {
        global $db;
        $sql = "SELECT DISTINCT state_name FROM locations";
        $result = $db->query($sql);
        $states_array = $db->fetch_all($result);
        return $states_array;
    }

    public static function get_states_options()
    {
        $states = self::get_states();
        $options = "";
        foreach($states as $s)
        {
            $options .=  ' <option value="' . $s[0] . '"> ' . $s[0] .  '</option>\n';
        }
        return $options;
    }

    public static function get_id($location){
        global $db;
        $sql = "SELECT distinct location_id FROM locations ";
        $sql .= "where state_name = '{$location->state_name}' ";
        $sql .= "and county_name = '{$location->county_name}' ";
        $sql .= "and subcounty_name like '{$location->subcounty_name}%'";
        $id_result = $db->query($sql);
        $id = $db->fetch_array($id_result);
        return $id[0];
    }
}

class Week {
    public static $table_name = "weeks";
    public static $fields   = array("week_num", "week_date1", "week_date2", "month", "year");
    private static $months   = array(1 => 'Jan', 2 => 'Feb', 3 => 'Mar', 4 => 'Apr',
                                    5 => 'May', 6 => 'Jun', 7 => 'Jul', 8 => 'Aug',
                                    9 => 'Sep', 10 => 'Oct', 11 => 'Nov', 12 => 'Dec');
    private static $years = array(2016 => '2016', 2017 => '2017');
    public $week_id;
    public $week_num;
    public $week_date1;
    public $week_date2;
    public $month;
    public $year;

    public static function get_months(){
        return self::$months;
    }


    public static function get_years(){
        return self::$years;
    }


    public static function get_options($field){
        $options = "";
        switch($field){
            case "months":
                $array = self::get_months();
                break;
            case "years":
                $array = self::get_years();
                break;
            default:
                return false;
        }
        foreach($array as $key => $value){
            $options .= "<option value='$key'>$value</option>>\n";
        }
        return $options;

    }

    public static function get_id($week, $month, $year){
        global $db;
        $sql = "select distinct week_id from weeks ";
        $sql .= "where week_num = {$week} and ";
//        $sql .= "weeks.month = {$month} and ";
        $sql .= "weeks.year = {$year}";
//        echo $sql;
        $id_result = $db->query($sql);
        $id = $db->fetch_array($id_result);
        return $id[0];
    }
}

class Trade {
    public static $table_name = "trades";
    public static $fields= array("trade_name");
    public $trade_id;
    public $trade_name;

    public static function get_id($trade_name){
        global $db;
        $sql = "select distinct trade_id ";
        $sql .= "from trades where trade_name like '{$trade_name}%'";
        $id_result = $db->query($sql);
        $id = $db->fetch_array($id_result);
        return $id[0];
    }
}

class Channel {
    public static $table_name = "channels";
    public static $fields= array("channel_name");
    public $channel_id;
    public $channel_name;
}

class LTW {
    public static $table_name = "LTW";
    public static $fields= array("location_id", "week_id", "trade_id");
    public $LTW_id;
    public $location;
    public $week;
    public $trade;

    private static $sql_filler = 'insert into LTW (location_id, week_id, trade_id)
                            select l.location_id, w.week_id, t.trade_id
                            from locations l, weeks w, trades t';


    public static function check_table(){
        global $db;
        $empty = $db->table_is_empty(self::$table_name);
        if($empty){
            $db->query(self::$sql_filler);
        }
    }

    public static function get_id($location_id, $week_id, $trade_id){
        global $db;
        $sql = "select distinct ltw_id from ltw ";
        $sql .= "where location_id = {$location_id} ";
        $sql .= "and week_id = {$week_id} ";
        $sql .= "and trade_id = {$trade_id}";
        $id_result = $db->query($sql);
        $id = $db->fetch_array($id_result);
        return $id[0];
    }
}

class Capacity {
    public static $table_name = "capacities";
    public static $fields= array("LTW_id", "capacity_num");
    public $capacity_id;
    public $LTW;
    public $capacity_num;

//    public static function save($file){
////        var_dump($file);
//        global $db;
//        $rows_inserted = 0;
//        $handle = fopen($file, "r");
//        $row_num = 1;
//        while($data = fgetcsv($handle, 1000, ";", '"', "\\")){
//            if($row_num != 1){
//                $complement_sql = "";
//                $max = sizeof($data);
//                for($i=0; $i<$max; $i++){
//                    //todo
//                }
//                $sql = "insert into capacities (LTW_id, capacity_num) values ()";
//                $sql .= $complement_sql;
//                $db->query($sql);
//                $rows_inserted ++;
//            } else {
//                $row_num ++;
//            }
//        }
//    }

    public static function save2($file){
        global $db;
        $handle = fopen($file, "r");
        $row_num = 1;
        while($data = fgetcsv($handle, 1000, ";", '"', "\\")){
            if ($row_num != 1){
                $location = new Location;
                $location->state_name = $data[0];
                $location->county_name = $data[1];
                $location->subcounty_name = $data[2];
                $location_id = Location::get_id($location);
                $week_id = Week::get_id($data[4], $data[5], $data[6]);
                $trade_id = Trade::get_id($data[3]);
                $ltw_id = LTW::get_id($location_id, $week_id, $trade_id);
                $sql = "insert into capacities (LTW_id, capacity_num) values (";
                $sql .= "{$ltw_id}, {$data[7]})";
                $db->query($sql);
            }else{
                $row_num ++;
            }

        }
    }
}

class ForecastActual {
    public static $table_name = "Forecast_Actual";
    public static $fields= array("LTW_id", "channel_id", "forecast_num", "actual_num", "deviation_perc");
    public $forecast_actual_id;
    public $LTW;
    public $channel;
    public $forecast_num;
    public $actual_num;
    public $deviation_perc;
}