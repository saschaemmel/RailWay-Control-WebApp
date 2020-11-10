<?php
    include 'header.php';
?>

<div id="area">
    <h3>->ÜBERSICHT</h3>
</div>
<!---BODY--->

<!---Place Table--->

<div class="divTable">

<?php
    //chek if setup-Mode is on
    $setup = false;
    if (isset($_GET['setup'])){
        if (true == $_GET['setup']){
            $setup = true;
        }
    }

	//read settings from ini-file
	$ini = parse_ini_file('./config/config.ini');
        
    $servername = "localhost";
    $username = $ini['db_user'];
    $password = $ini['db_password'];
    $dbname = "railway";
    $gridsize = $ini['gridsize'];
    $sizex = $ini['sizex'];
    $sizey = $ini['sizey'];

    // Create connection
    //$conn = new mysqli($servername, $username, $password, $dbname);
    $conn = pg_connect("host=" . $servername . " dbname=" . $dbname . " user=" . $username . " password=" . $password)
    or die('Verbindungsaufbau fehlgeschlagen: ' . pg_last_error());

    // Check connection 
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    } 

    // Go through all Collumns and Rows
    for ($posx = 1; $posx <= $sizex; $posx++) {
        echo('<div class="divTableColum">'."\n");
        for ($posy = 1; $posy <= $sizey; $posy++){

            // Build SQL Command
            $sql = "SELECT pic, angle FROM scheme WHERE posx = $posx AND posy = $posy";
            //$result = $conn->query($sql);
            $result = pg_query($sql) or die('Abfrage fehlgeschlagen: ' . pg_last_error());

            //$row = $result->fetch_assoc();
            $row = pg_fetch_assoc($result);

            // Link to Config-Window in Setup-Mode
            if(true == $setup){
                //if ($result->num_rows > 0) {
                    echo('<div class="divTableCell" style="width:'.$gridsize.'px; height:'.$gridsize.'px;">
                            <a href="/RailWay/overview.php?setup=true&posx='.$posx.'&posy='.$posy.'">
                                <img src="images/' .$row["pic"]. '.png" width="'.$gridsize.'" height="'.$gridsize.'" alt="X!" style="transform:rotate('.$row["angle"].'deg);"/>
                            </a>
                        </div>'."\n");
                //}
                //else{
                //    echo('<div class="divTableCell" style="width:'.$gridsize.'px; height:'.$gridsize.'px;">
                //            <a href="/RailWay/overview.php?setup=true&posx='.$posx.'&posy='.$posy.'">
                //                <img src="images/schiene_leer.png" width="'.$gridsize.'" height="'.$gridsize.'" alt="Image not Found!"/>
                //            </a>
                //        </div>'."\n");
                //}//if else
            }
            else{
                //if ($result->num_rows > 0) {
                    echo('<div class="divTableCell" style="width:'.$gridsize.'px; height:'.$gridsize.'px;">
                            <img src="images/' .$row["pic"]. '.png" width="'.$gridsize.'" height="'.$gridsize.'" alt="#" style="transform:rotate('.$row["angle"].'deg);"/>
                        </div>'."\n");
                //}else{
                //    echo('<div class="divTableCell" style="width:'.$gridsize.'px; height:'.$gridsize.'px;">
                //            <img src="images/schiene_leer.png" width="'.$gridsize.'" height="'.$gridsize.'" alt="Image not Found!"/>
                //        </div>'."\n");
                //}//if else
            }
        }//for
        echo('</div>'."\n");
    }

    // Close SQL Connection
    //$conn->close();
    pg_close();
    ?>
</div>

<?php
    //Update Field
    if (isset($_POST['aktion']) and $_POST['aktion']=='speichern') {
        
        $signal = "schiene_leer";
        if (isset($_POST['signal'])) {
            $signal = $_POST['signal'];
        }
        $rotation = "0";
        if (isset($_POST['rotation'])) {
            $rotation = $_POST['rotation'];
        }
    
        $area = "0";
        if (isset($_POST['area'])) {
            $area = $_POST['area'];
        }

        $sigid = "0";
        if (isset($_POST['sigid'])) {
            $sigid = $_POST['sigid'];
        }

        // Create connection
       $conn = new mysqli($servername, $username, $password, $dbname);
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        } 

        $sql = 'UPDATE scheme SET id="'.$sigid.'", area="'.$area.'", pic="'.$signal.'", angle="'.$rotation.'", flipx="0", flipy="0" 
            WHERE posx="'.$_GET['posx'].'" AND posy="'.$_GET['posy'].'"';
        
        if ($conn->query($sql) === TRUE) {
            echo "Record updated successfully";
        } else {
            echo "Error updating record: " . $conn->error;
    }
$conn->close();
}

?>
<div class="OverviewSettings">

<?php
    //Settingsbox in Setup-Mode
    if(isset($_GET['posx']) and isset($_GET['posy'])) {
        echo('<form method="post">'."\n"); //action=""
        //SIGNAL
        echo('<div class="OverviewSettingsColum">'."\n");
        echo('Signal (X: '.$_GET['posx'].' Y: '.$_GET['posy'].' ): <p></p>'."\n");
        echo('<li> '."\n");
            echo('<label>'."\n");
                echo('<input type="radio" name="signal" value="schiene_leer">'."\n");
                echo('<img src="images/schiene_leer.png" width="'.$gridsize.'" height="'.$gridsize.'" alt="Image not Found!"/>'."\n");
            echo('</label>'."\n");
        echo('</li>'."\n");
        echo('<li> '."\n");
            echo('<label>'."\n");
                echo('<input type="radio" name="signal" value="schiene_gerade">'."\n");
                echo('<img src="images/schiene_gerade.png" width="'.$gridsize.'" height="'.$gridsize.'" alt="Image not Found!"/>'."\n");
            echo('</label>'."\n");
        echo('</li>'."\n");
        echo('<li>  '."\n");
            echo('<label>'."\n");
                echo('<input type="radio" name="signal" value="schiene_45">'."\n");
                echo('<img src="images/schiene_45.png" width="'.$gridsize.'" height="'.$gridsize.'" alt="Image not Found!"/>'."\n");
            echo('</label>'."\n");
        echo('</li>'."\n");
        echo('<li>  '."\n");
            echo('<label>'."\n");
                echo('<input type="radio" name="signal" value="schiene_ecke">'."\n");
                echo('<img src="images/schiene_ecke.png" width="'.$gridsize.'" height="'.$gridsize.'" alt="Image not Found!"/>'."\n");
            echo('</label>'."\n");
        echo('</li>'."\n");
		echo('<li>  '."\n");
            echo('<label>'."\n");
                echo('<input type="radio" name="signal" value="schiene_ecke_flip">'."\n");
                echo('<img src="images/schiene_ecke_flip.png" width="'.$gridsize.'" height="'.$gridsize.'" alt="Image not Found!"/>'."\n");
            echo('</label>'."\n");
        echo('</li>'."\n");
		echo('<li>  '."\n");
            echo('<label>'."\n");
                echo('<input type="radio" name="signal" value="schiene_weiche">'."\n");
                echo('<img src="images/schiene_weiche.png" width="'.$gridsize.'" height="'.$gridsize.'" alt="Image not Found!"/>'."\n");
            echo('</label>'."\n");
        echo('</li>'."\n");
		echo('<li>  '."\n");
            echo('<label>'."\n");
                echo('<input type="radio" name="signal" value="schiene_weiche_flip">'."\n");
                echo('<img src="images/schiene_weiche_flip.png" width="'.$gridsize.'" height="'.$gridsize.'" alt="Image not Found!"/>'."\n");
            echo('</label>'."\n");
        echo('</li>'."\n");
		echo('<li>  '."\n");
            echo('<label>'."\n");
                echo('<input type="radio" name="signal" value="schiene_dreifachweiche">'."\n");
                echo('<img src="images/schiene_dreifachweiche.png" width="'.$gridsize.'" height="'.$gridsize.'" alt="Image not Found!"/>'."\n");
            echo('</label>'."\n");
        echo('</li>'."\n");
        echo('</div>'."\n");
        echo('<div class="OverviewSettingsColum">'."\n");
        //ROTATION
        echo('Drehung: <p></p>'."\n");
        echo('<li> '."\n");
            echo('<label>'."\n");
                echo('<input type="radio" name="rotation" value="0">'."\n");
                echo('0°'."\n");
            echo('</label>'."\n");
        echo('</li>'."\n");
        echo('<li> '."\n");
            echo('<label>'."\n");
                echo('<input type="radio" name="rotation" value="90">'."\n");
                echo('90°'."\n");
            echo('</label>'."\n");
        echo('</li>'."\n");
        echo('<li>  '."\n");
            echo('<label>'."\n");
                echo('<input type="radio" name="rotation" value="180">'."\n");
                echo('180°'."\n");
            echo('</label>'."\n");
        echo('<li>  '."\n");
            echo('<label>'."\n");
                echo('<input type="radio" name="rotation" value="270">'."\n");
                echo('270°'."\n");
            echo('</label>'."\n");
        echo('</li>'."\n");
        echo('</div>'."\n");
        echo('<div class="OverviewSettingsColum">'."\n");
        //AREA
        echo('Bereich: <p></p>');
        echo('<li>  '."\n");
            echo('<label>'."\n");
                echo('<input type="number" name="area" min="0" max="999">'."\n");
            echo('</label>'."\n");
        echo('<li>  '."\n");
        echo('Signal ID: <p></p>');
        echo('<li>  '."\n");
            echo('<label>'."\n");
                echo('<input type="number" name="sigid" min="0" max="9999999999">'."\n");
            echo('</label>'."\n");
        echo('</li>  '."\n");
        echo('</div>'."\n");
        echo('<div class="OverviewSettingsColum">'."\n");
        echo('Übernehmen: <p></p>');
            echo('<input type="hidden" name="aktion" value="speichern">'."\n");
            echo('<input type="submit" value="speichern">'."\n");
        echo('</div>'."\n");
        echo('</form>'."\n");
        echo('</div>'."\n");
    }
    ?>
</div>

<?php       
    include 'footer.php';
?>  
