<?php
    include 'header.php';
    //error_reporting(E_ALL);
    //ini_set('display_errors', 1);
?>
    <div id="area">
        <h3>->SIGNALE</h3>
    </div>

    <!---BODY--->
    <table> 
        <tr>
            <th>ID</th>
            <th>TYP</th>
            <th>NUMMER</th>
            <th>NAME</th>
            <th>IP</th>
            <th>ACTIVE</th>
            <th>EDIT</th>
        </tr>
        
        <!---Get Device List from SQL--->
        <?php

	//read settings from ini-file
	$ini = parse_ini_file('./config/config.ini');
        
        $servername = "localhost";
        $username = $ini['db_user'];
        $password = $ini['db_password'];
        $dbname = "railway";

        // Create connection
        //$conn = new mysqli($servername, $username, $password, $dbname);
        $conn = pg_connect("host=" . $servername . " dbname=" . $dbname . " user=" . $username . " password=" . $password)
        or die('Verbindungsaufbau fehlgeschlagen: ' . pg_last_error());

        //Delete Device
        if (isset($_POST['delete'])) {
            $sql = 'DELETE FROM devices WHERE ID="' . $_POST['delete'] . '"';
            $conn->query($sql);
            $sql = 'DELETE FROM device_status WHERE ID="' . $_POST['delete'] . '"';
            $conn->query($sql);
            echo 'Delete device ' . $_POST['delete'] . 'successfull'."\n";
        }

        $sql = "SELECT id, type, number, name, ip, active FROM devices";
        $result = pg_query($sql) or die('Abfrage fehlgeschlagen: ' . pg_last_error());

        if (pg_num_rows($result) > 0) {
            
            // output data of each row
            while ($row = pg_fetch_assoc($result)) {
            echo "<tr>";
                echo '<td><a href="/signal_details.php?id='.$row["id"].'">'.$row["id"].'</a></td>';
                $type = "";
                switch ($row["type"]){
                    case 0: $type = "Lichtsignal"; break;
                    case 1: $type = "Weiche"; break;
                    case 2: $type = "Schranke"; break;
                    default: $type = "UNBEKANNT";
                }
                echo "<td>".$type."</td>";
                echo "<td>".$row["number"]."</td>";
                echo "<td>".$row["name"]."</td>";
                echo "<td>".$row["ip"]."</td>";
                if ( t == $row["active"] ) {
                    echo "<td>".'<p style="color:Green;">ACTIVE</p>'."</td>";
                }else{
                    echo "<td>".'<p style="color:RED;">INACTIVE</p>'."</td>";
                }
                echo '<td><form action="" method="post"><input type="submit" name="edit" value=""/>';
                echo '<input type="checkbox" name="delete" value="'.$row["id"].'"/></form></td>';
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