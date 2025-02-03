
<?php

include '../admin_classes/config_mysqli.php';

$faculty_user_id = $_POST['faculty_user_id'];
$curriculum_id = $_POST['curriculum_id'];

//data for user log table
$faculty_user_id  = $_POST['faculty_user_id'];
$user_log_date    = date('Y-m-d');
$user_log_time    = date('H:i:s');
$zero             = 0;

$query = mysqli_query($con, "SELECT * FROM manage_curriculum 
                            JOIN manage_program ON manage_curriculum.program_id = manage_program.program_id
                            WHERE curriculum_id = '$curriculum_id'");

while($row = mysqli_fetch_array($query)){

    $department_id     = $row['department_id'];
    $program_code      = $row['program_code'];
    $curriculum_year   = $row['curriculum_year'];
    $hyphen            = " - ";
    $curriculum        = $program_code.$hyphen.$curriculum_year;

    //user log
    $user_action       = 'Deleted <b>'.$curriculum.'</b> curriculum';

    mysqli_query($con, "INSERT INTO `user_log`(`user_log_id`, `account_user_id`, `user_action`, `user_log_time`, `user_log_date`) 
    VALUES ('$zero','$faculty_user_id','$user_action','$user_log_time','$user_log_date')");

    mysqli_query($con, "DELETE FROM manage_curriculum WHERE curriculum_id = '$curriculum_id'");

    header("location:../registrar_manage_curriculum.php?department&department_id=$department_id&deleted&curriculum=$curriculum");

}

?>
