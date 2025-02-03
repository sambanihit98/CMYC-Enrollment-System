<?php 

  include 'config_mysqli.php';
    
  $random_id = rand(501,999); //PATTERN

  $faculty_user_id    = $_POST['faculty_user_id']; 
  $account_firstname  = ucwords($_POST['account_firstname']); 
  $account_lastname   = ucwords($_POST['account_lastname']); 
  $account_position   = $_POST['account_position']; 

  $account_status = 1;

  //PASSWORD
  $account_password = "cmyces";

  //ACC USER ID PATTERN
  $random = rand(100,500); 
  $day = date('d');
  $year = date('Y');
  $account_user_id = "$day-$year-$random";

  //data for user log table
  $user_action   = 'Added <b>'.$account_firstname.' '.$account_lastname.' '.'('.$account_position.')</b>'.' as authorized user';
  $user_log_date = date('Y-m-d');
  $user_log_time = date('H:i:s');
  $zero          = 0;

    $query1 = mysqli_query($con, "SELECT * FROM faculty_account WHERE account_user_id = '$account_user_id'");

    $query2 = mysqli_query($con, "SELECT * FROM faculty_account WHERE account_firstname = '$account_firstname' 
                                                                AND account_lastname = '$account_lastname'");

      if(mysqli_num_rows($query1)>0){
        echo json_encode(array("statusCode"=>201));
      }else if(mysqli_num_rows($query2)>0){
        echo json_encode(array("statusCode"=>202));
      }else{
        mysqli_query($con, "INSERT INTO `faculty_account`(`account_user_id`, `account_firstname`, `account_lastname`, `account_password`, `account_position`, `account_status`) 
                            VALUES ('$account_user_id','$account_firstname','$account_lastname','$account_password','$account_position','$account_status')");

        mysqli_query($con, "INSERT INTO `user_log`(`user_log_id`, `account_user_id`, `user_action`, `user_log_time`, `user_log_date`) 
                            VALUES ('$zero','$faculty_user_id','$user_action','$user_log_time','$user_log_date')");
        echo json_encode(array("statusCode"=>203));
      }



 ?>