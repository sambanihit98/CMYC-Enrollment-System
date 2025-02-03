<?php

include '../admin_classes/config_mysqli.php';

if(isset($_POST['academic_id'])){

    $academic_id = $_POST['academic_id'];

    $faculty_user_id     = $_POST['faculty_user_id'];
    $academic_year_from  = $_POST['academic_year_from'];
    $academic_year_to    = $_POST['academic_year_to'];
    $academic_term       = $_POST['academic_term'];

    //data for user log table
  $user_action   = 'Deactivated academic year <b>'.$academic_year_from.' - '.$academic_year_to.' '.'('.$academic_term.')</b>';
  $user_log_date = date('Y-m-d');
  $user_log_time = date('H:i:s');
  $zero          = 0;
    
    mysqli_query($con, "INSERT INTO `user_log`(`user_log_id`, `account_user_id`, `user_action`, `user_log_time`, `user_log_date`) 
                            VALUES ('$zero','$faculty_user_id','$user_action','$user_log_time','$user_log_date')");

    mysqli_query($con, "UPDATE academic_year SET academic_status = 0 WHERE academic_id = '$academic_id'");

    header("location:../admin_academic.php?deactivated&academic_id=$academic_id");
}

?>