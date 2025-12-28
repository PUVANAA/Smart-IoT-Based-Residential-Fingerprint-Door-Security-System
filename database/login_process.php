<?php

//start session
session_start();

//to connect db
include("to_connect.php");

extract($_POST);

$query = "SELECT * FROM user WHERE username = '$username'";

//to run sql query in db
$result = mysqli_query($conn, $query) or trigger_error(mysqli_error($conn));
$rows = mysqli_fetch_array($result);

if($rows) {
    if (password_verify($password, $rows['psw'])) {
        if ($rows['user_type'] == 'Admin') {
            $_SESSION['username'] = $username;
            $_SESSION['adminID'] =$rows['user_id'];
            header("location: ../interface/admin/index.php");
            exit();
        } elseif ($rows['user_type'] == 'Resident') {
            $_SESSION['username'] = $username;
            $_SESSION['residentID'] =$rows['user_id'];
            header("location: ../interface/resident/index.php");
            exit();
        }
        
    } else {
        header("Location: ../interface/login.php?error=wrongPsw");
    }
} else {
    header("Location: ../interface/login.php?error=wrongUsername");
}

?>