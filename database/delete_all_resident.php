<?php
    session_start();

    include("to_connect.php");

    $query = "DELETE FROM resident";

    // Use mysqli_multi_query to execute multiple queries
    $result = mysqli_query($conn, $query);

    if ($result) {

        $query_user = "DELETE FROM user WHERE user_type='Resident'";
        $result_user = mysqli_query ($conn, $query_user);

        $query_thumb_no = "UPDATE thumb_no SET val_value='3'";
        $result_thumb_no = mysqli_query ($conn, $query_thumb_no);

        $query_attendance = "DELETE FROM attendance";
        $result_attendance = mysqli_query ($conn, $query_attendance);

        header("Location: ../interface/admin/resident.php?success=trueDeleteAll");
    } else {    
        echo "Error: " . $query . "<br>" . mysqli_error($conn);
    }

?>