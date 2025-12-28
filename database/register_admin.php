<?php
    session_start();

    include("to_connect.php");

    extract($_POST);

    // Check if passwords match
    if ($psw != $pswRepeat) {
        header("Location: ../interface/register.php?error=invalidPswConfirm");
    } else {
        
        $encryptedPsw = password_hash($psw, PASSWORD_DEFAULT);

        // Insert user data into the user table
        $insertQuery = "INSERT INTO user (full_name, username, psw, user_type)
                        VALUES ('$fullName', '$username', '$encryptedPsw', 'Admin')";

        if (mysqli_query($conn, $insertQuery)) {
            
            header("Location: ../interface/register.php?success=true");
            
        } else {
            // If insertion into user table fails, display error message
            echo "Error inserting into user table: " . mysqli_error($conn);
        }
    }
?>
