    <?php
        include 'header.php';
    ?>
        <div id="area">
            <h3>->EINSTELLUNGEN</h3>
        </div>
         <!---BODY--->
        <?php
        
        ?>
        Add Device to Database <br>
	
        <form action="add_device.php" method="post">
            ID: <input type="text" name="id" /><br />
            TYPE: <input type="text" name="type" /><br />
            NUMBER: <input type= "text" name="number" /><br />
            NAME: <input type= "text" name="name" /><br />
            IP: <input type= "text" name="ip" /><br />
            ACTIVE: <input type= "text" name="active" /><br />
            <input type="Submit" value="Absenden" />
        </form>
        <br>
        Delete Devices from Table

        <form action="" method="post">
            <input type="Submit" name="delete" value="true" />
        </form>
<?php
	    //read settings from ini-file
	    $ini = parse_ini_file('./config/config.ini');
        
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

        //Delete Device
        if (isset($_POST['delete'])) {
            if ($_POST['delete'] == true){
                $sql = 'TRUNCATE TABLE devices';
                $conn->query($sql);
                $sql = 'TRUNCATE TABLE device_status';
                $conn->query($sql);
                echo 'Table is now Empty'."\n";
            }
        }
?>
    <?php       
        include 'footer.php';
    ?>  