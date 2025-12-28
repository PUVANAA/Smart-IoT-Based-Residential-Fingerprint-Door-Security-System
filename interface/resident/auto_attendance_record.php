<?php

session_start();
include("../../database/to_connect.php");

date_default_timezone_set("Asia/Kuala_Lumpur");

$query_attend = "SELECT 
                    attendance.attend_date, 
                    attendance.attend_time, 
                    resident.num_phone, 
                    user.full_name 
                FROM attendance 
                INNER JOIN resident ON attendance.user_id = resident.user_id 
                INNER JOIN user ON resident.user_id = user.user_id 
                WHERE attendance.user_id = '".$_SESSION['residentID']."'
                ORDER BY attendance.attend_date DESC";

$result_attend = mysqli_query($conn, $query_attend);
                                            
if (mysqli_num_rows($result_attend) > 0){
    while($row_attend = mysqli_fetch_assoc($result_attend)) { 
        $resident_name = $row_attend["full_name"];
        $resident_num_phone = $row_attend["num_phone"];
        $attendance_date = $row_attend["attend_date"];
        $attendance_time = $row_attend["attend_time"];

        $formattedDate = date('d/m/Y', strtotime($attendance_date));
        $formattedTime = date('h:i A', strtotime($attendance_time));
?>

    <tr>
        <td id="text-center"><?php echo $formattedDate;?></td>
        <td id="text-center"><?php echo $formattedTime;?></td>
        <td><?php echo $resident_name;?></td>
        <td id="text-center"><?php echo $resident_num_phone;?></td>
    </tr>

<?php
    }
} else {
    echo '<tr>';
    echo '<td colspan="4" style="text-align: center">No data available in table</td>';
    echo '</tr>';
}
?>