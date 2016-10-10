<?php
/**
 * Created by PhpStorm.
 * User: carle
 * Date: 5/10/2016
 * Time: 9:56 PM
 */


/**
 * redirects to another location
 * @param $new_location
 */
function redirect_to($new_location){
    header("Location: " . $new_location);
    exit;
}