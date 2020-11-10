
<?php
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

    $id = 10;

  // Go through all Collumns and Rows
    for ($posx = 1; $posx <= $sizex; $posx++) {
        for ($posy = 1; $posy <= $sizey; $posy++){
            // Build SQL Command
            $sql = "INSERT INTO scheme (id, area, pic, angle, flipx, flipy, posx, posy)
            VALUES ('$id', '0', 'schiene_weiche', '0', 'FALSE', 'FALSE', '$posx', '$posy')";

            $time = microtime(true) - $_SERVER["REQUEST_TIME_FLOAT"]; 
            echo "$time - Do SQL Command:  $sql <br>";

            //$result = pg_query($sql) or die('Abfrage fehlgeschlagen: ' . pg_last_error());
            $id++;
        }
    }//for


// Speicher freigeben
pg_free_result($result);

// Verbindung schließen
pg_close($dbconn);
?>
