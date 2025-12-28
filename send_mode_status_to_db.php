<?php 
   //include file to_connect
   include "database/to_connect.php";
	
	//Read data from ESP32
	$mode_status = $_GET["val_value"];
	
	//Update data to database (in table tb_pox)
	mysqli_query($conn, "update thumb_no set val_value='$mode_status'");
	
	//echo "hi";
?>
