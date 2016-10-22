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

if(isset($_GET['state'])){
    $selected_state = $_GET['state'];
    $selected_county = $_GET['county'];
    $selected_subcounty = $_GET['subcounty'];
    $states = Location::get_states_options_for_viewer($selected_state);
    $counties = Location::get_counties_options_for_viewer($selected_state, $selected_county);
    $subcounties = Location::get_subcounties_options_for_viewer($selected_state, $selected_county, $selected_subcounty);
    $years = Week::get_years_for_viewer();
    $months = Week::get_months_for_viewer();
    $trades = Trade::get_trades_for_viewer();
}
if(isset($_GET['year']) && isset($_GET['month']) && isset($_GET['trade'])){
    $selected_year = $_GET['year'];
    $selected_trade = $_GET['trade'];
    $selected_month = $_GET['month'];
    $url = "view.php?state={$selected_state}&county={$selected_county}&subcounty={$selected_subcounty}&year={$selected_year}&month={$selected_month}&trade={$selected_trade}";
    redirect_to($url);
}


?>
<script type="text/javascript" src="js/dropdowns.js"></script>
<div class="content">
    <form action="viewer.php" method="get">
        <div class="combos2">
            <h3>Select a Location</h3>
            <p>State:</p>
            <select name="state" onchange="reloadFromState(this.form)">
                <option value="all">Select one...</option>
                <?php echo $states; ?>
            </select><br><br>

            <p>County:</p>
            <select name="county" onchange="reloadFromCounty(this.form)">
                <option value="all">Select one...</option>
                <?php echo $counties; ?>
            </select><br><br>

            <p>Sub-County:</p>
            <select name="subcounty" onchange="reloadFromSubcounty(this.form)">
                <option value="all">Select one...</option>
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

            <p>Month:</p>
            <select name="month">
                <option value="all">Select one...</option>
                <?php echo $months; ?>
            </select><br><br>

            <p>Trade:</p>
            <select name="trade">
                <option value="all">Select one...</option>
                <?php echo $trades; ?>
            </select><br><br>
            <input type="submit" value="Buscar">
        </div>
    </form>
</div>


<?php
require_once("./layouts/footer.php");
?>
