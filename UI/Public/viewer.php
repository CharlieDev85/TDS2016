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

$selected_state = $_GET['state'];
$selected_county = $_GET['county'];
$selected_subcounty = $_GET['subcounty'];
$states = Location::get_states_options_for_viewer($selected_state);
$counties = Location::get_counties_options_for_viewer($selected_state, $selected_county);
$subcounties = Location::get_subcounties_options_for_viewer($selected_state, $selected_county, $selected_subcounty);
$years = Week::get_years_for_viewer();
//var_dump($states);
//var_dump($counties);
?>
<script type="text/javascript" src="js/dropdowns.js"></script>
<div class="content">
    <form action="viewer.php" method="post">
        <div class="combos2">
            <h3>Select a Location</h3>
            <p>State:</p>
            <select name="state" onchange="reloadFromState(this.form)">
                <option value="all">Select one...</option>
                <?php echo $states; ?>
            </select><br><br>

            <p>County:</p>
            <select name="county" onchange="reloadFromCounty(this.form)">
                <option value="all">all</option>
                <?php echo $counties; ?>
            </select><br><br>

            <p>Sub-County:</p>
            <select name="subcounty" onchange="reloadFromSubcounty(this.form)">
                <option value="all">all</option>
                <?php echo $subcounties; ?>
            </select><br><br>

        </div>

        <div class="combos2">
            <h3>Select Year and Trade</h3>
            <p>Year:</p>
            <select name="year">
                <option value="all">Select one...</option>
                <?php echo $years; ?>
            </select><br><br>
        </div>
    </form>
</div>


<?php
require_once("./layouts/footer.php");
?>
