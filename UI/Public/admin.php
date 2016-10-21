<?php
/**
 * Created by PhpStorm.
 * User: carle
 * Date: 8/10/2016
 * Time: 7:45 PM
 */



require_once("../../Datos/initialize.php");
require_once("./layouts/header.php");
require_once("./layouts/menu.php");
$states = Location::get_states_options();
$months = Week::get_options("months");
$years = Week::get_options("years");
$get = isset($_GET['state'])? true : false;
$delete = isset($_GET['delete'])? $_GET['type']: false;

$content = '<div  class="combos1">
        <form action="" method="get">
            <h2>Make a Selection</h2>

            <p>State:</p>
            <select name="state">
                '.$states.'
            </select><br>

            <p>Month:</p>
            <select name="month">
                '.$months.'
            </select><br>

            <p>Year:</p>
            <select name="year">
                '.$years.'
            </select><br><br>

            <input type="submit" value="Search">
        </form>
    </div>';

if(isset($_POST['submit_forecast_actual'])){
    echo "submit_forecast_actual_submited";
    $forecast_actual_posted = Admin_Controller::upload_forecast_actual($_FILES);
}
if(isset($_POST['submit_capacity'])){
    $capacity_posted = Admin_Controller::upload_capacity($_FILES);
}
if ($get){
    $sel_state  = $_GET['state'];
    $sel_month  = $_GET['month'];
    $sel_year   = $_GET['year'];

    if($delete){

        $data_deleted = Admin_Controller::delete($delete, $sel_state, $sel_month, $sel_year);
    }

    $get_result = Admin_Controller::selection_made($sel_state, $sel_month, $sel_year);
}
?>

<div id="content">
    <?php
    if(!$get){
        echo $content;
    }
    ?>
<?php
if($get){
//    echo $get_result;
    echo '<div class="combos1">
            <h2>Current Selection</h2>
            <ul>
                <li>State: '. $sel_state .' </li><br><br>
                <li>Month: '. $sel_month .'</li><br><br>
                <li>Year: '. $sel_year .'</li><br><br>
            </ul>
        </div>
        
        <div class="combos1">
            <h2>Options</h2>
            <table class="responstable" border = "1">
                <tr>
                    <th>Type</th>
                    <th>Action</th>
                </tr>
                <tr>
                    <td>Forecast/Actual</td>
                    <td>' . $get_result['Forecast_Actual'] . '</td>
                </tr>
                <tr>
                    <td>Capacity</td>
                    <td>' . $get_result['Capacity'] . '</td>
                </tr>
            </table>
            <a href="admin.php"> <<< back</a>
        </div>';
}
?>





</div>
<?php
require_once("./layouts/footer.php");
?>
