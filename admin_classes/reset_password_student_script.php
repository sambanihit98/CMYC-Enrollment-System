
<?php

include 'config_mysqli.php';

$faculty_user_id = $_POST['faculty_user_id'];
$fullname        = $_POST['fullname'];
$student_id      = $_POST['student_id'];

//data for user log table
$user_log_date    = date('Y-m-d');
$user_log_time    = date('H:i:s');
$zero             = 0;  
$user_action      = 'Reset password back to default on <b>'.$fullname.' (Student)</b> account';

mysqli_query($con, "INSERT INTO `user_log`(`user_log_id`, `account_user_id`, `user_action`, `user_log_time`, `user_log_date`) 
            VALUES ('$zero','$faculty_user_id','$user_action','$user_log_time','$user_log_date')");

mysqli_query($con, "UPDATE student_info SET password = 'cmycstudent' WHERE student_id = '$student_id'");

header("location:../registrar_student_record.php?password_reset");

?>






