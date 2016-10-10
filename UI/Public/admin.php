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
if ($get){
    $sel_state  = $_GET['state'];
    $sel_month  = $_GET['month'];
    $sel_year   = $_GET['year'];
    $get_result = Admin_Controller::selection_made($sel_state, $sel_month, $sel_year);
}
?>

<div id="content">

    <div  class="combos1">
        <form action="" method="get">
            <h2>Make a Selection</h2>

            <p>State:</p>
            <select name="state">
                <?php echo $states; ?>
            </select><br>

            <p>Month:</p>
            <select name="month">
                <?php echo $months; ?>
            </select><br>

            <p>Year:</p>
            <select name="year">
                <?php echo $years; ?>
            </select><br><br>

            <input type="submit" value="Search">
        </form>
    </div>
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
            <table>
                <tr>
                    <th>Type</th>
                    <th>Action</th>
                </tr>
                <tr>
                    <td>Forecast/Actual</td>
                    <td>Delete</td>
                </tr>
                <tr>
                    <td>Capacity</td>
                    <td>Update</td>
                </tr>
            </table>
        </div>';
}
?>





</div>
<?php
require_once("./layouts/footer.php");
?>
