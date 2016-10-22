<?php
/**
 * Created by PhpStorm.
 * User: carle
 * Date: 21/10/2016
 * Time: 11:27 PM
 */
require_once("../../Datos/initialize.php");

$state = $_GET['state'];
$county = $_GET['county'];
$subcounty = $_GET['subcounty'];
$year = $_GET['year'];
$month_id = $_GET['month'];
$month = Week::$months[$month_id];
$trade = $_GET['trade'];
$all = 'all';

if($state==$all || $county==$all || $subcounty==$all || $year==$all || $month == $all || $trade==$all){
    redirect_to("viewer.php?state=all&county=all&subcounty=all");
}
$sql = "select w.week_date1, w.week_date2, c.capacity_num, f.forecast_num, f.actual_num ";
$sql .= "from locations l ";
$sql .= "inner join ltw on ltw.location_id = l.location_id ";
$sql .= "inner join weeks w on w.week_id = ltw.week_id ";
$sql .= "inner join trades t on t.trade_id = ltw.trade_id ";
$sql .= "inner join capacities c on c.ltw_id = ltw.ltw_id ";
$sql .= "inner join forecast_actual f on f.ltw_id = ltw.ltw_id ";
$sql .= "where l.state_name = '{$state}' and ";
$sql .= "l.county_name = '{$county}' and ";
$sql .= "l.subcounty_name = '$subcounty' and ";
$sql .= "w.year = '{$year}' and ";
$sql .= "w.month = '{$month_id}' and ";
$sql .= "t.trade_name = '$trade' ";
$sql .= "group by w.week_date1, w.week_date2 ";
$result = $db->query($sql);
$array = array();
while($row = $db->fetch_array_assoc($result)){
    $array[] = $row;
}
//var_dump($array);

require_once("./layouts/header.php");
require_once("./layouts/menu.php");
?>
<div class="content">
    <div class="combos2">
        <br>
        <h3>Current Selection:</h3><br><br>
        <p>State: <?php echo $state; ?></p>
        <p>County: <?php echo $county; ?></p>
        <p>Subcounty: <?php echo $subcounty; ?></p>
        <p>Year: <?php echo $year; ?></p>
        <p>Month: <?php echo $month; ?></p>
        <p>Trade: <?php echo $trade; ?></p>
    </div>

    <div class="combos2">
        <br>
        <h3>Capacity Plan:</h3><br><br>
        <table>
            <tr>
                <th>From - To</th>
                <th>Capacity</th>
                <th>Forecast</th>
                <th>Surplus/Deficit</th>
                <th>Actual</th>
            </tr>
            <?php
                foreach($array as $row){
                    echo "<tr>";

                        echo "<td>";
                            echo $row['week_date1'] . ' - ' . $row['week_date2'];
                        echo "</td>\n";

                        echo "<td>";
                            echo intval($row['capacity_num']);;
                        echo "</td>\n";

                        echo "<td>";
                            echo intval($row['forecast_num']);;
                        echo "</td>\n";

                        echo "<td>";
                            echo intval($row['capacity_num'] - $row['forecast_num']);;
                        echo "</td>\n";

                        echo "<td>";
                            echo intval($row['actual_num']);;
                        echo "</td>\n";

                    echo "</tr>\n";
                }
            ?>
        </table>
        <br><br>
        <a href="javascript:history.back(1)"> &lt&lt back </a>
    </div>
</div>

<?php
require_once("./layouts/footer.php");
?>
