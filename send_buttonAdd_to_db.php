<?php 
   //include file to_connect
   include "database/to_connect.php";
	
	//Read data from ESP32
	$button_add = $_GET["button_add"];
	
	//Update data to database (in table )
	mysqli_query($conn, "update thumb_no set button_add='$button_add'");
	
	//echo "hi";
?>
