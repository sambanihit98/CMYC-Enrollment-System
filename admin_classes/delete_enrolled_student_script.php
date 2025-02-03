
<?php

include 'config_mysqli.php';

$enrollment_id  = $_POST['enrollment_id'];
$fullname       = $_POST['fullname'];
$academic_year  = $_POST['academic_year'];
$academic_id    = $_POST['academic_id'];

//data for user log table
$faculty_user_id  = $_POST['faculty_user_id'];
$user_log_date    = date('Y-m-d');
$user_log_time    = date('H:i:s');
$zero             = 0;
$user_action      = 'Deleted <b>'.$fullname.' (Student)</b> enrollment information on academic year <b>'.$academic_year.'</b>';

mysqli_query($con, "INSERT INTO `user_log`(`user_log_id`, `account_user_id`, `user_action`, `user_log_time`, `user_log_date`) 
VALUES ('$zero','$faculty_user_id','$user_action','$user_log_time','$user_log_date')");

mysqli_query($con, "DELETE FROM manage_enrollment WHERE enrollment_id = '$enrollment_id'");
mysqli_query($con, "DELETE FROM grades_report WHERE enrollment_id = '$enrollment_id' AND academic_id = '$academic_id'");
mysqli_query($con, "DELETE FROM student_subject_load WHERE enrollment_id = '$enrollment_id' AND academic_id = '$academic_id'");

header("location:../registrar_manage_enrollment.php?deleted&fullname=$fullname&academic_year=$academic_year");

?>
