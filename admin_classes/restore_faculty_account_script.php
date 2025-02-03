<?php

include '../admin_classes/config_mysqli.php';

if(isset($_POST['account_user_id'])){

	$account_user_id  = $_POST['account_user_id'];
	$faculty_user_id  = $_POST['faculty_user_id'];
	$fullname         = $_POST['fullname'];
	$account_position = $_POST['account_position'];

	//data for user log table
  $user_action = 'Restored <b>'.$fullname.' ('.$account_position.')</b> account';
  $user_log_date = date('Y-m-d');
  $user_log_time = date('H:i:s');
  $zero          = 0;
    

    mysqli_query($con, "INSERT INTO `user_log`(`user_log_id`, `account_user_id`, `user_action`, `user_log_time`, `user_log_date`) 
    VALUES ('$zero','$faculty_user_id','$user_action','$user_log_time','$user_log_date')");

    mysqli_query($con, "UPDATE faculty_account SET account_status = 1 WHERE account_user_id = '$account_user_id'");

    header("location:../admin_designation.php?restored&name=$fullname&account_position=$account_position");
}

?>