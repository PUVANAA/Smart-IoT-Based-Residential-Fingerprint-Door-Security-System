<?php

//Connect to database
$conn = mysqli_connect("localhost", "root", "", "p30_attendance_doorlock");

//if connection failed then display this error
if (mysqli_connect_errno())
{
    echo "Failed to connect to MYSQL: ". mysqli_connect_error();
}

?>