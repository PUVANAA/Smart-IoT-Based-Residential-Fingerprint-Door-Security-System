<?php
    session_start();

    include("to_connect.php");

    extract($_POST);

    $default_psw = "abc12345";

    $encryptedPsw = password_hash($default_psw, PASSWORD_DEFAULT);

    // Insert user data into the user table
    $insertQuery = "INSERT INTO user (full_name, username, psw, user_type)
                    VALUES ('$fullName', '$ic_num', '$encryptedPsw', 'Resident')";

    if (mysqli_query($conn, $insertQuery)) {

        // If insertion successful, retrieve the user_id of the inserted user
        $userId = mysqli_insert_id($conn);

        $insertQueryResident = "INSERT INTO resident (user_id, fingerprint_id, num_phone)
                                    VALUES ('$userId', '$fingerID', '$numPhone')";

        if (mysqli_query($conn, $insertQueryResident)) {
            $query_thumb_val= "UPDATE thumb_no SET thumb_id='$fingerID', button_add='1'";
            $result_thumb_val = mysqli_query ($conn, $query_thumb_val);

            header("Location: ../interface/admin/resident.php?success=true");
        } else {
            echo "Error inserting into resident table: " . mysqli_error($conn);
        }

    } else {
        // If insertion into user table fails, display error message
        header("Location: ../interface/admin/resident.php?error=wrong");
    }

?>
