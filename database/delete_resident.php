<?php
    session_start();

    include("to_connect.php");

    $residentID = $_GET['id'];
    $fingerID = $_GET['fingerID'];

    $query = "DELETE FROM user WHERE user_id = '$residentID'";
    $result = mysqli_query($conn, $query);

    if ($result) {

        $query_resident = "DELETE FROM resident WHERE user_id = '$residentID'";
		$result_resident = mysqli_query($conn, $query_resident);
		
		$query_attendance = "DELETE FROM attendance WHERE user_id = '$residentID'";
		$result_attendance = mysqli_query($conn, $query_attendance);

        $query_thumb_id= "UPDATE thumb_no SET thumb_id='$fingerID'";
        $result_thumb_id = mysqli_query ($conn, $query_thumb_id);
		
        header("Location: ../interface/admin/resident.php?success=trueDelete");
    } else {    
        echo "Error: " . $query . "<br>" . mysqli_error($conn);
    }

?>