<?php

  include 'config_mysqli.php';

  if(isset($_POST['announcement'])){

    $faculty_user_id = $_POST['faculty_user_id'];

    $announcement = addslashes($_POST['announcement']);
    $link = addslashes($_POST['link']);
    
    $announcement_id = mt_rand(100000000,999999999);
    $announcement_status = 1;
    $date = date('Y-m-d');
    $time = date('H:i:s');

  //data for user log table
  $user_action   = 'Posted an announcement';
  $user_log_date = date('Y-m-d');
  $user_log_time = date('H:i:s');
  $zero          = 0;

    mysqli_query($con, "INSERT INTO `user_log`(`user_log_id`, `account_user_id`, `user_action`, `user_log_time`, `user_log_date`) 
    VALUES ('$zero','$faculty_user_id','$user_action','$user_log_time','$user_log_date')");

    mysqli_query($con, "INSERT INTO `announcements`(`announcement_id`, `announcement`, `link`, `date_posted`, `time_posted`, `announcement_status`) 
                        VALUES ('$announcement_id','$announcement','$link','$date','$time','$announcement_status')");

                        echo 1;
  }

?>