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
}

class Trade {
    public static $table_name = "trades";
    public static $fields= array("trade_name");
    public $trade_id;
    public $trade_name;
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
}

class Capacity {
    public static $table_name = "capacities";
    public static $fields= array("LTW_id", "capacity_num");
    public $capacity_id;
    public $LTW;
    public $capacity_num;
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