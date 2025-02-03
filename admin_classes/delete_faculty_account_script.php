
<?php

include 'config_mysqli.php';

$account_user_id   = $_POST['account_user_id'];
$faculty_user_id   = $_POST['faculty_user_id'];
$account_position  = $_POST['account_position'];

$fullname = $_POST['fullname'];

//data for user log table
$user_action   = 'Deleted <b>'.$fullname.' '.'('.$account_position.')</b>'.' account';
$user_log_date = date('Y-m-d');
$user_log_time = date('H:i:s');
$zero          = 0;

mysqli_query($con, "INSERT INTO `user_log`(`user_log_id`, `account_user_id`, `user_action`, `user_log_time`, `user_log_date`) 
                    VALUES ('$zero','$faculty_user_id','$user_action','$user_log_time','$user_log_date')");


mysqli_query($con, "DELETE FROM faculty_account WHERE account_user_id = '$account_user_id'");

header("location:../admin_designation.php?deleted&name=$fullname");

?>






