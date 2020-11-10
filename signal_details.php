<?php
    include 'header.php';
    $id = "";
    if (isset($_GET['id'])) {
        $id = $_GET['id'];
    }else{
        $id = "NOT SET";
    }
?>
<div id="area">
<?php
   echo '<h3>->SIGNAL DETAILS: '. $id.'</h3>'
?>
    </div>
<!---BODY--->
    <table> 
        <tr>
            <th>BEZEICHNUNG</th>
            <th>WERT</th>
        </tr>      
        <?php
        //read settings from ini-file
	    $ini = parse_ini_file('./config/config.ini');
        
        $servername = "localhost";
        $username = $ini['db_user'];
        $password = $ini['db_password'];
        $dbname = "railway";

            // Create connection
            $conn = pg_connect("host=" . $servername . " dbname=" . $dbname . " user=" . $username . " password=" . $password)
            or die('Verbindungsaufbau fehlgeschlagen: ' . pg_last_error());


            $sql = "SELECT * FROM device_status WHERE id='$id'";
            echo $sql;
            $result = pg_query($sql) or die('Abfrage fehlgeschlagen: ' . pg_last_error());

            if (pg_num_rows($result) > 0) {
                // output data of each row
                while ($row = pg_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td>Signal Status Vorne</td>";
                switch ($row["signalstate_front"]){
                    case "OFF": $img="signal_"; break;
                    case "DRIVE": $img="signal_g"; break;
                    case "SLOW": $img="signal_gy"; break;
                    case "STOP": $img="signal_r"; break;
                    case "ERROR": $img="signal_ry"; break;
                    default: $img="signal_gry"; break;
                }
                echo '<td><img src="images/'. $img .'.png" width="43" height="64" alt="SignalImage"/></td>';
                echo "</tr>";
                echo "<tr>";
                switch ($row["signalstate_back"]){
                    case "OFF": $img="signal_"; break;
                    case "DRIVE": $img="signal_g"; break;
                    case "SLOW": $img="signal_gy"; break;
                    case "STOP": $img="signal_r"; break;
                    case "ERROR": $img="signal_ry"; break;
                    default: $img="signal_gry"; break;
                }
                echo "<td>Signal Status Hinten</td>";
                echo '<td><img src="images/'. $img .'.png" width="43" height="64" alt="SignalImage"/></td>';
                echo "</tr>";
                echo "<tr>";
                echo "<td>Batterie Spannung [V]</td>";
                echo "<td>".$row["voltage"]." V</td>";
                echo "</tr>";
                echo "<tr>";
                echo "<td>WiFi Signalstärke [dBm]</td>";
                echo "<td>".$row["wifi_strength"]." dBm</td>";
                echo "</tr>";
                echo "<tr>";
                echo "<td>Letztes Life Telegram</td>";
                echo "<td>".$row["life_telegram"]."</td>";
                echo "</tr>";
                echo "<tr>";
                echo "<td>Temperatur [°C]</td>";
                echo "<td>".$row["temperature"]." °C</td>";
                echo "</tr>";
                echo "<tr>";
                echo "<td>Sensor Status 1</td>";
                if ($row["sensor_1"] == TRUE){
                    echo '<td><p style="color:Green;">BELEGT</p></td>';
                }else{
                    echo '<td><p style="color:Red;">FREI</p></td>';
                }
                echo "</tr>";
                echo "<tr>";
                echo "<td>Sensor Status 2</td>";
                if ($row["sensor_2"] == TRUE){
                    echo '<td><p style="color:Green;">BELEGT</p></td>';
                }else{
                    echo '<td><p style="color:Red;">FREI</p></td>';
                }
                echo "</tr>";
            }
            } else {
                echo "0 results";
            }
            //$conn->close();
            pg_close();
        ?>
    </table>
         
<?php       
        include 'footer.php';
?>  

