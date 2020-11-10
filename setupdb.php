<?php
echo("Start Setup");
	//read settings from ini-file
	$ini = parse_ini_file('.\config\config.ini');
        
    $servername = "localhost";
    $username = $ini['db_user'];
    $password = $ini['db_password'];
    $dbname = "railway";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

// Empty the DB
//$sql = "TRUNCATE TABLE scheme";
//echo($sql);

if ($conn->query($sql) === TRUE) {
    echo "New record created successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

for ($posx = 15; $posx <= 25; $posx++) {
    echo('<div class="divTableColum">'."\n");
    for ($posy = 1; $posy <= 50; $posy++){

        $sql = "INSERT INTO scheme (id, posx, posy, area, pic, angle, flipx, flipy)
        VALUES ('1', $posx, $posy, '1', 'schiene_leer', '0', 'false', 'false')";

        if ($conn->query($sql) === TRUE) {
            echo "New record created successfully";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
}

$conn->close();
?>