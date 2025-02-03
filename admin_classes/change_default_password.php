<?php

include 'config_mysqli.php';

if(isset($_POST['account_user_id'])){

  $new_password      = $_POST['new_password'];
  $confirm_password  = $_POST['confirm_password'];
  $account_position  = $_POST['account_position'];
  $account_user_id   = $_POST['account_user_id'];

  mysqli_query($con, "UPDATE faculty_account SET account_password = '$new_password' WHERE account_user_id = '$account_user_id'");

  echo json_encode(array("statusCode"=>200));
}
   
  
?>