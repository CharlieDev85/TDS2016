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

    public static function get_states_viewer(){
        global $db;
        $sql = "select distinct state_name from locations l ";
        $sql .= "inner join ltw on ltw.location_id = l.location_id ";
        $sql .= "inner join forecast_actual f on f.ltw_id = ltw.ltw_id";
        $result = $db->query($sql);
        $states_array = $db->fetch_all($result);
        return $states_array;
    }

    public static function get_counties_viewer($state){
        global $db;
        $sql = "select distinct county_name from locations l ";
        $sql .= "inner join ltw on ltw.location_id = l.location_id ";
        $sql .= "inner join forecast_actual f on f.ltw_id = ltw.ltw_id ";
        $sql .= "where l.state_name = '{$state}'";
//        echo $sql;
        $result = $db->query($sql);
        $counties_array = $db->fetch_all($result);
        return $counties_array;
    }

    public static function get_subcounties_viewer($state_selected, $county_selected){
        global $db;
        $sql = "select distinct subcounty_name from locations l ";
        $sql .= "inner join ltw on ltw.location_id = l.location_id ";
        $sql .= "inner join forecast_actual f on f.ltw_id = ltw.ltw_id ";
        $sql .= "where l.state_name = '{$state_selected}' and ";
        $sql .= "l.county_name = '{$county_selected}'";
        $result = $db->query($sql);
        $subcounties_array = $db->fetch_all($result);
        return $subcounties_array;
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

    public static function get_states_options_for_viewer($selected_state){
        $states = self::get_states_viewer();
        $options = "";
        foreach($states as $s)
        {
            if($selected_state == $s[0]){
                $options .=  ' <option value="' . $s[0] . '" selected> ' . $s[0] .  '</option>\n';
            }else {
                $options .=  ' <option value="' . $s[0] . '"> ' . $s[0] .  '</option>\n';
            }
        }
        return $options;
    }

    public static function get_counties_options_for_viewer($selected_state, $selected_county){
        $counties = self::get_counties_viewer($selected_state);
        $options = "";
        foreach($counties as $c){
            if($selected_county == $c[0]){
                $options .=  ' <option value="' . $c[0] . '" selected> ' . $c[0] .  '</option>\n';
            } else {
                $options .=  ' <option value="' . $c[0] . '"> ' . $c[0] .  '</option>\n';
            }
        }
        return $options;
    }

    public static function get_subcounties_options_for_viewer($selected_state, $selected_county, $selected_subcounty){
        $subcounties = self::get_subcounties_viewer($selected_state, $selected_county);
        $options = "";
        foreach($subcounties as $su){
            if($selected_subcounty == $su[0]){
                $options .=  ' <option value="' . $su[0] . '" selected> ' . $su[0] .  '</option>\n';
            } else {
                $options .=  ' <option value="' . $su[0] . '"> ' . $su[0] .  '</option>\n';
            }
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

    public static function get_years_for_viewers(){

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

    public static function save($file){
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
                $dev = $data[8]/$data[7];
                $sql = "insert into forecast_actual (LTW_id, forecast_num, actual_num, deviation_num) values (";
                $sql .= "{$ltw_id}, {$data[7]}, {$data[8]}, {$dev})";
                $db->query($sql);
            }else{
                $row_num ++;
            }
        }
    }
}