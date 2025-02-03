<?php

include '../admin_classes/config_mysqli.php';

if(isset($_POST['department_id'])){

    $department_id          = $_POST['department_id'];
    $department_code        = $_POST['department_code'];
    $department_description = $_POST['department_description'];

    //data for user log table
    $faculty_user_id  = $_POST['faculty_user_id'];
    $user_action      = 'Deactivated <b>'.$department_description.' '.'('.$department_code.')</b>'.' department';
    $user_log_date    = date('Y-m-d');
    $user_log_time    = date('H:i:s');
    $zero             = 0;  
    
    mysqli_query($con, "INSERT INTO `user_log`(`user_log_id`, `account_user_id`, `user_action`, `user_log_time`, `user_log_date`) 
    VALUES ('$zero','$faculty_user_id','$user_action','$user_log_time','$user_log_date')");

    mysqli_query($con, "UPDATE manage_department SET department_status = 0 WHERE department_id = '$department_id'");

    header("location:../registrar_manage_department.php?deactivated&department_id=$department_id");
}

?>