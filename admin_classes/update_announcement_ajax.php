<?php 
  session_start();
  include 'config_mysqli.php';
    
    $faculty_user_id  = $_POST['faculty_user_id'];
    $announcement_id  = $_POST['announcement_id'];
    $announcement     = addslashes($_POST['announcement']);
    $link             = addslashes($_POST['link']);

     //data for user log table
  $user_action   = 'Updated an announcement';
  $user_log_date = date('Y-m-d');
  $user_log_time = date('H:i:s');
  $zero          = 0;

  mysqli_query($con, "INSERT INTO `user_log`(`user_log_id`, `account_user_id`, `user_action`, `user_log_time`, `user_log_date`) 
  VALUES ('$zero','$faculty_user_id','$user_action','$user_log_time','$user_log_date')");

  mysqli_query($con, "UPDATE announcements SET announcement = '$announcement', link = '$link' WHERE announcement_id = '$announcement_id'");
    
  echo 1;

 ?>