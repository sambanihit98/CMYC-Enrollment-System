<?php 
session_start();
include 'config_mysqli.php';
   
$student_id        = $_POST['student_id'];    
$new_firstname     = addslashes($_POST['new_firstname']);     
$new_middlename    = addslashes($_POST['new_middlename']);   
$new_lastname      = addslashes($_POST['new_lastname']);   
$new_name_extension= addslashes($_POST['new_name_extension']);  
$new_address       = addslashes($_POST['new_address']);  
$new_birthdate     = $_POST['new_birthdate'];  
$new_birthplace    = addslashes($_POST['new_birthplace']);  
$new_gender        = $_POST['new_gender'];  
$new_civil_status  = $_POST['new_civil_status'];  
$new_citizenship   = addslashes($_POST['new_citizenship']);  
$new_religion      = addslashes($_POST['new_religion']);   
$new_phone_number  = $_POST['new_phone_number'];  
$new_email         = addslashes($_POST['new_email']);    

$middle_initial = substr($new_middlename, 0, 1);

$fullname = $new_firstname." ".$middle_initial." ".$new_lastname;

//data for user log table
$faculty_user_id  = $_POST['faculty_user_id'];
$user_log_date    = date('Y-m-d');
$user_log_time    = date('H:i:s');
$zero             = 0; 
$user_action  = 'Updated <b>'.$fullname.' (Student)</b> personal information';

mysqli_query($con, "INSERT INTO `user_log`(`user_log_id`, `account_user_id`, `user_action`, `user_log_time`, `user_log_date`) 
        VALUES ('$zero','$faculty_user_id','$user_action','$user_log_time','$user_log_date')");

  //update student_info table
  mysqli_query($con, "UPDATE `student_info` SET `firstname`='$new_firstname',
                                                    `middlename`='$new_middlename',
                                                    `lastname`='$new_lastname',
                                                    `name_extension`='$new_name_extension',
                                                    `address`='$new_address',
                                                    `birthdate`='$new_birthdate',
                                                    `birthplace`='$new_birthplace',
                                                    `gender`='$new_gender',
                                                    `civil_status`='$new_civil_status',
                                                    `citizenship`='$new_citizenship',
                                                    `religion`='$new_religion',
                                                    `phone_number`='$new_phone_number',
                                                    `email`='$new_email' 
                                                  WHERE student_id = '$student_id'");

  //update manage_enrollment table
  mysqli_query($con, "UPDATE `manage_enrollment` SET `student_firstname`='$new_firstname',
                                                              `student_middlename`='$new_middlename',
                                                              `student_lastname`='$new_lastname',
                                                              `student_name_extension`='$new_name_extension' 
                                                            WHERE student_id = '$student_id'");
    
$_SESSION['fullname'] = $fullname;
        echo json_encode(array("statusCode"=>200));

 ?>