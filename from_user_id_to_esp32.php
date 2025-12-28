<?php 
   //include file to_connect
   include "database/to_connect.php";

   $sql = mysqli_query($conn, "SELECT * FROM thumb_no");
   $data = mysqli_fetch_array($sql);
   $val_read = $data['thumb_id'];
   
   // response to nodemcu
   echo $val_read; // 0/1
?>