<?php

include 'config_mysqli.php';

if(isset($_POST['account_user_id'])){

  $faculty_user_id   = $_POST['faculty_user_id'];
  $firstname         = $_POST['firstname'];
  $lastname          = $_POST['lastname'];
  $password          = $_POST['password'];
  $account_user_id   = $_POST['account_user_id'];

  //data for user log table
  $user_action   = 'Account has been updated';
  $user_log_date = date('Y-m-d');
  $user_log_time = date('H:i:s');
  $zero          = 0;

  mysqli_query($con, "INSERT INTO `user_log`(`user_log_id`, `account_user_id`, `user_action`, `user_log_time`, `user_log_date`) 
                            VALUES ('$zero','$faculty_user_id','$user_action','$user_log_time','$user_log_date')");

  mysqli_query($con, "UPDATE faculty_account SET account_firstname = '$firstname', 
                                                  account_lastname = '$lastname', 
                                                  account_password = '$password' 
                                              WHERE account_user_id = '$account_user_id'");

  echo json_encode(array("statusCode"=>200));
}
   
  
?>