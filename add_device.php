<?php
	//get data from formular
	$id = $_POST["id"];
	$type = $_POST["type"];
	$number = $_POST["number"];
	$name = $_POST["name"];
	$ip = $_POST["ip"];
	$active = $_POST["active"];

		
	//read settings from ini-file
	$ini = parse_ini_file('.\config\config.ini');
	
	//Database Connection
	$pdo = new PDO('mysql:host=localhost;dbname=railway', $ini['db_user'], $ini['db_password']); //username, password
 
	//Do SQL Command
	$statement = $pdo->prepare("UPDATE devices (id, type, number, name, ip, active) VALUES (?, ?, ?, ?, ?, ?)");
	$statement->execute(array($id, $type, $number, $name, $ip, $active));   
	
	echo "Added Device with ID=$id, TYPE=$type, NUMBER=$number, NAME=$name , IP=$ip, ACTIVE=$active to Database";



	

	//Warte eine Sekunde
	sleep(1);

	//Springe zurück zur vorigen Seite
	echo '<script language="javascript"> javascript:history.back() </script>'
?>