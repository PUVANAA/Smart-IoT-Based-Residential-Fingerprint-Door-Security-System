<?php
    session_start();

    include("to_connect.php");

    $attendanceID = $_GET['id'];

    $query = "DELETE FROM attendance WHERE attend_id = '$attendanceID'";

    // Use mysqli_multi_query to execute multiple queries
    $result = mysqli_query($conn, $query);

    if ($result) {
        header("Location: ../interface/admin/report.php?success=trueDelete");
    } else {    
        echo "Error: " . $query . "<br>" . mysqli_error($conn);
    }

?>