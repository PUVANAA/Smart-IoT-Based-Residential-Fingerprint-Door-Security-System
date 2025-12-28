<?php
    session_start();

    include("to_connect.php");

    extract($_POST);

    $query_user= "UPDATE user SET full_name='$fullName', username='$ic_num' WHERE user_id = '$residentID'";
    $result_user = mysqli_query ($conn, $query_user);

    if ( $result_user ) {

        $query_resident= "UPDATE resident SET num_phone='$numPhone' WHERE user_id = '$residentID'";
        $result_resident = mysqli_query ($conn, $query_resident);

        header("Location: ../interface/admin/resident.php?success=trueUpdate");
    } else {
        echo "Error: " . $query . "<br>" . mysqli_error($conn);
    }

?>