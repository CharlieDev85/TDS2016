<?php
/**
 * Created by PhpStorm.
 * User: carle
 * Date: 4/10/2016
 * Time: 10:21 PM
 */

ini_set('max_execution_time', 600); //300 seconds = 5 minutes

// Define the core paths
// Define them as absolute paths to make sure that require_once works as expected

// DIRECTORY_SEPARATOR is a PHP pre-defined constant
// (\ for Windows, / for Unix)
defined('DS') ? null : define('DS', DIRECTORY_SEPARATOR);

defined('SITE_ROOT') ? null : define('SITE_ROOT', DS.'wamp64'.DS.'www'.DS.'TDS2016');

defined('LIB_PATH') ? null : define('LIB_PATH', SITE_ROOT.DS.'Datos');
defined('LIB_LOGIC') ? null : define('LIB_LOGIC', SITE_ROOT.DS.'Logica');
defined('UI_CONTROLLERS') ? null : define('UI_CONTROLLERS', SITE_ROOT.DS.'UI'.DS.'Controladores');

// load config file first
require_once(LIB_PATH.DS.'config.php');

// load basic functions next so that everything after can use them
require_once(LIB_PATH.DS.'functions.php');

// load core objects
//require_once(LIB_PATH.DS.'session.php');
require_once(LIB_PATH.DS.'database.php');


// load database-related classes
require_once(LIB_LOGIC.DS.'beans.php');

//MVC related Clases
require_once(UI_CONTROLLERS.DS.'admin_controller.php');
