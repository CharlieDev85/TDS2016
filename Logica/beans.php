<?php
/**
 * Created by PhpStorm.
 * User: carle
 * Date: 4/10/2016
 * Time: 9:58 PM
 */

class Location {
    protected static $table_name = "locations";
    public $location_id;
    public $state_name;
    public $county_name;
    public $subcounty_name;
}

class Weeks {
    protected static $table_name = "weeks";
    public $week_id;
    public $week_date1;
    public $week_date2;
    public $week_num;
}

class Trade {
    protected static $table_name = "trades";
    public $trade_id;
    public $trade_name;
}

class Channel {
    protected static $table_name = "channels";
    public $channel_id;
    public $channel_name;
}

class LTW {
    protected static $table_name = "LTW";
    public $LTW_id;
    public $location;
    public $week;
    public $trade;
}

class Capacity {
    protected static $table_name = "capacities";
    public $capacity_id;
    public $LTW;
    public $capacity_num;
}

class ForecastActual {
    protected static $table_name = "Forecast_Actual";
    public $forecast_actual_id;
    public $LTW;
    public $channel;
    public $forecast_num;
    public $actual_num;
    public $deviation_perc;
}