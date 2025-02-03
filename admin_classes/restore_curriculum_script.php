<?php

include '../admin_classes/config_mysqli.php';

if(isset($_POST['curriculum_id'])){

    $curriculum_id    = $_POST['curriculum_id'];
    $program_code     = $_POST['program_code'];
    $curriculum_year  = $_POST['curriculum_year'];

    $hyphen = " - ";
    $curriculum = $program_code.$hyphen.$curriculum_year;

    //data for user log table
    $faculty_user_id  = $_POST['faculty_user_id'];
    $user_action      = 'Restored <b>'.$curriculum.'</b> curriculum';
    $user_log_date    = date('Y-m-d');
    $user_log_time    = date('H:i:s');
    $zero             = 0;  
    
    $query = mysqli_query($con, "SELECT * FROM manage_curriculum WHERE curriculum_id = '$curriculum_id'");
    while($row = mysqli_fetch_array($query)){
        $department_id  = $row['department_id'];
        $program_id     = $row['program_id'];

        mysqli_query($con, "INSERT INTO `user_log`(`user_log_id`, `account_user_id`, `user_action`, `user_log_time`, `user_log_date`) 
                            VALUES ('$zero','$faculty_user_id','$user_action','$user_log_time','$user_log_date')");

        mysqli_query($con, "UPDATE manage_curriculum SET curriculum_status = 0 WHERE curriculum_id = '$curriculum_id'");

        header("location:../registrar_manage_curriculum.php?department&department_id=$department_id&curriculum=$curriculum&restored");
    }

    
}

?>