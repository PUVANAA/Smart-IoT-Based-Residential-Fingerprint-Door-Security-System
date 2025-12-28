<?php
include '../../database/to_connect.php'; // Ensure you have your database connection file included

if(isset($_POST['val_value'])) {
    $val_value = $_POST['val_value'];

    // Update the database
    $query = "UPDATE thumb_no SET val_value='$val_value'";
    
    if(mysqli_query($conn, $query)) {
        echo 'success';
    } else {
        echo 'error';
    }
}
?>
