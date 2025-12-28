<?php 
   //include file to_connect
   include "database/to_connect.php";
   
   date_default_timezone_set("Asia/Kuala_Lumpur");
    $current_date = date('Y-m-d');
    $current_time = date('H:i:s');
	
	//Read data from ESP32
	$user_id = $_GET["thumb_id"];
	
	//Update data to database (in table )
	mysqli_query($conn, "update thumb_no set thumb_id='$user_id'");
	
	$query_obtain_val = "SELECT val_value FROM thumb_no";
    $result_obtain_val = mysqli_query($conn, $query_obtain_val);
    if (!$result_obtain_val) {
        die("Query execution failed: " . mysqli_error($conn));
    }
    $row_val= mysqli_fetch_assoc($result_obtain_val);
    $val_value = $row_val["val_value"];
	
	if ($val_value == '2') {
		$query_obtain_exist_finger_id = "SELECT user_id FROM resident WHERE fingerprint_id = '$user_id'";
		$result_obtain_exist_finger_id = mysqli_query($conn, $query_obtain_exist_finger_id);
	   
	    if ($row_finger_id = mysqli_fetch_assoc($result_obtain_exist_finger_id)) {
		   $resident_id = $row_finger_id["user_id"];
		   
		    $query_insert = "INSERT INTO attendance (user_id, attend_date, attend_time) 
								VALUES ('$resident_id', '$current_date', '$current_time')";
			if (!mysqli_query($conn, $query_insert)) {
				die('Error inserting attendance: ' . mysqli_error($conn));
			}
	    }
	}
	
	//echo "hi";
?>
