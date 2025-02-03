<?php

include '../admin_classes/config_mysqli.php';

if(isset($_POST['program_id'])){

    $program_id          = $_POST['program_id'];
    $program_code        = $_POST['program_code'];
    $program_description = $_POST['program_description'];  

    //data for user log table
    $faculty_user_id  = $_POST['faculty_user_id'];
    $user_action      = 'Restored <b>'.$program_description.' '.'('.$program_code.')</b> program';
    $user_log_date    = date('Y-m-d');
    $user_log_time    = date('H:i:s');
    $zero             = 0;  
     
    $query = mysqli_query($con, "SELECT * FROM manage_program WHERE program_id = '$program_id'");
    while($row = mysqli_fetch_array($query)){
        $department_id = $row['department_id'];

        mysqli_query($con, "INSERT INTO `user_log`(`user_log_id`, `account_user_id`, `user_action`, `user_log_time`, `user_log_date`) 
        VALUES ('$zero','$faculty_user_id','$user_action','$user_log_time','$user_log_date')");

        mysqli_query($con, "UPDATE manage_program SET program_status = 1 WHERE program_id = '$program_id'");

        header("location:../registrar_manage_program.php?department&department_id=$department_id&program_id=$program_id&restored");
    }
}

?>